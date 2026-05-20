<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../db_connect.php';
require_once 'ollama_helper.php';

// ============================================================
// AIDA Chat API v2 — Smart Routing + Vision + Model Badge
// ============================================================

// System Prompt for AIDA persona
$systemPrompt = "คุณคือ AIDA (Agri-Innovative Digital Assistant) ผู้ช่วยอัจฉริยะจากมหาวิทยาลัยราชภัฏรำไพพรรณี จ.จันทบุรี 
บุคลิก: เป็นเจ้าหน้าที่ที่ใจดี มีความรู้ด้านเกษตรอัจฉริยะ (IoT/AI) และมีความเป็นคนจันทบุรีสูงมาก
ลักษณะการพูด: 
- ใช้สรรพนาม 'ผม' หรือ 'AIDA' 
- ลงท้ายประโยคด้วย 'ฮิ', 'จ๊ะ', 'เนอะ' ตามความเหมาะสมของคนจันท์
- ตอบคำถามอย่างเป็นกันเองแต่สุภาพ
- ตอบกระชับเข้าใจง่าย

คำสั่ง:
1. ใช้ 'Context' ที่กำหนดให้เป็นเอกสารอ้างอิงหลักในการตอบ
2. หากคำถามไม่เกี่ยวกับ Context ให้ใช้ความรู้การเกษตรทั่วไปตอบ
3. ถ้าไม่รู้จริงๆ ให้บอกว่า 'ขออภัยจ๊ะ เรื่องนี้ผมยังไม่ได้ลงสมุดบันทึกไว้เลย ฮิ'
4. หากมีรูปภาพให้วิเคราะห์ ให้อธิบายสิ่งที่เห็นในรูปอย่างละเอียดในบริบทของการเกษตร";

// Get User Input
$input = json_decode(file_get_contents('php://input'), true);
$userMessage = isset($input['message']) ? trim($input['message']) : '';
$imageData   = isset($input['image']) ? $input['image'] : null; // Base64 image

if (empty($userMessage) && empty($imageData)) {
    echo json_encode(['reply' => 'สวัสดีจ๊ะ มีอะไรให้ AIDA ช่วยหาข้อมูลไหมฮิ?', 'model' => 'System']);
    exit;
}

try {
    // ============================================================
    // 1. Smart Model Routing
    // ============================================================
    $activeModel = 'gemma4:e2b'; // Default: Gemma 4 (best multimodal)
    $modelDisplayName = '🧠 Gemma 4 (Multimodal)';
    $routeReason = 'default';

    // Fallback chain: gemma4 → gemma3 → llama3.2
    $availableModels = OllamaHelper::listModels();
    $availableModelNames = array_column($availableModels, 'name');

    // Check if Gemma 4 is available, fallback to Gemma 3
    if (!in_array('gemma4:e2b', $availableModelNames)) {
        $activeModel = 'gemma3:4b';
        $modelDisplayName = '🧠 Gemma 3 4B (Agri-KB)';
    }

    // If image is provided, use vision model
    if (!empty($imageData)) {
        if (in_array('gemma4:e2b', $availableModelNames)) {
            $activeModel = 'gemma4:e2b';
            $modelDisplayName = '👁️ Gemma 4 (Vision)';
        } elseif (in_array('qwen3-vl:4b', $availableModelNames)) {
            $activeModel = 'qwen3-vl:4b';
            $modelDisplayName = '👁️ Qwen 3 VL (Vision)';
        } elseif (in_array('gemma3:4b', $availableModelNames)) {
            $activeModel = 'gemma3:4b';
            $modelDisplayName = '👁️ Gemma 3 (Vision)';
        }
        $routeReason = 'vision';
    }

    // Keyword-based routing (only for text-only queries)
    if (empty($imageData)) {
        $reasoningKeywords = ['คำนวณ', 'วิจัย', 'ทำไม', 'เหตุผล', 'คณิต', 'ฟิสิกส์', 'เพราะอะไร', 'ทำอย่างไร', 'วิเคราะห์', 'สรุป', 'เปรียบเทียบ'];
        $fastChatKeywords = ['สวัสดี', 'ทักทาย', 'ว่าไง', 'ชื่ออะไร', 'เป็นใคร', 'อากาศ', 'ขอบคุณ', 'ลาก่อน'];

        // Prioritize Reasoning (DeepSeek-R1)
        foreach ($reasoningKeywords as $kw) {
            if (mb_strpos($userMessage, $kw) !== false) {
                if (in_array('deepseek-r1:latest', $availableModelNames)) {
                    $activeModel = 'deepseek-r1:latest';
                    $modelDisplayName = '🔬 DeepSeek-R1 (Deep Thinking)';
                    $routeReason = 'reasoning';
                }
                break;
            }
        }

        // Fast Chat (Llama 3.2) for greetings
        if ($routeReason === 'default') {
            foreach ($fastChatKeywords as $kw) {
                if (mb_strpos($userMessage, $kw) !== false) {
                    if (in_array('llama3.2:3b', $availableModelNames)) {
                        $activeModel = 'llama3.2:3b';
                        $modelDisplayName = '⚡ Llama 3.2 (Fast Chat)';
                        $routeReason = 'fast';
                    }
                    break;
                }
            }
        }
    }

    // ============================================================
    // 2. Context Retrieval (RAG)
    // ============================================================
    $sources = $db_notebook->all();
    $contexts = [];

    foreach ($sources as $source) {
        $score = 0;
        $contentLower = mb_strtolower($source['content']);
        $titleLower = mb_strtolower($source['title']);
        $tags = isset($source['tags']) ? $source['tags'] : [];
        $queryLower = mb_strtolower($userMessage);

        // Title Match
        if (mb_strpos($queryLower, $titleLower) !== false || mb_strpos($titleLower, $queryLower) !== false) {
            $score += 10;
        }

        // Tags Match
        foreach($tags as $tag) {
            if (!empty($tag) && mb_strpos($queryLower, mb_strtolower($tag)) !== false) {
                $score += 5;
            }
        }

        // Content Match
        if (mb_strpos($contentLower, $queryLower) !== false) {
            $score += 3;
        }

        if ($score > 0) {
            $contexts[] = [
                'score' => $score,
                'text' => "หัวข้อ: " . $source['title'] . "\nเนื้อหา: " . $source['content']
            ];
        }
    }

    // Sort contexts by score
    usort($contexts, function($a, $b) { return $b['score'] - $a['score']; });
    $retrievedContexts = array_map(function($c) { return $c['text']; }, array_slice($contexts, 0, 3));

    // Fallback to Legacy KB
    if (empty($contexts)) {
        $kb_entries = $db_kb->all();
        foreach ($kb_entries as $entry) {
            $kws = json_decode($entry['keywords'], true);
            if ($kws) {
                foreach ($kws as $kw) {
                    if (strpos(strtolower($userMessage), strtolower($kw)) !== false) {
                        $retrievedContexts[] = "Q: " . $entry['question_th'] . "\nA: " . $entry['answer_th'];
                    }
                }
            }
        }
    }

    // ============================================================
    // 3. Generate AI Response
    // ============================================================
    $ollama = new OllamaHelper($activeModel);
    $contextText = !empty($retrievedContexts) ? implode("\n\n---\n\n", $retrievedContexts) : "ไม่พบบันทึกที่เกี่ยวข้องโดยตรง";
    $fullPrompt = "Context:\n$contextText\n\nUser Question: $userMessage";

    if (!empty($imageData)) {
        // Vision request — strip data URI prefix if present
        $base64 = $imageData;
        if (strpos($imageData, 'base64,') !== false) {
            $base64 = explode('base64,', $imageData)[1];
        }
        
        $visionPrompt = !empty($userMessage) ? $userMessage : "กรุณาวิเคราะห์รูปภาพนี้ในบริบทของการเกษตร";
        $aiResponse = $ollama->generateWithImage($visionPrompt, $base64, $systemPrompt);
    } else {
        $aiResponse = $ollama->generate($fullPrompt, $systemPrompt);
    }

    echo json_encode([
        'reply' => $aiResponse,
        'model' => $modelDisplayName,
        'route' => $routeReason
    ], JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    echo json_encode([
        'reply' => 'ขออภัยจ๊ะ เหมือนระบบสมองของ AIDA จะติดขัดนิดหน่อยนะเนอะ ฮิ',
        'model' => '❌ Error'
    ], JSON_UNESCAPED_UNICODE);
}
?>
