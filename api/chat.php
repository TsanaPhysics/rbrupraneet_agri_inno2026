<?php
header('Content-Type: application/json');
require_once '../db_connect.php';

// Get User Input
$input = json_decode(file_get_contents('php://input'), true);
$userMessage = isset($input['message']) ? $input['message'] : ''; // Keep original case for now

if (empty($userMessage)) {
    echo json_encode(['reply' => 'สวัสดีครับ มีอะไรให้ผมช่วยไหมครับ?']);
    exit;
}

try {
    // 1. Fetch all sources from Notebook DB
    /* 
       Note: In a production environment with Large Language Models (LLM), 
       we would generate Vector Embeddings for these sources and store them in a Vector DB.
       Then we would embed the user query and perform a Cosine Similarity Search.
       
       Since we are on a pure PHP environment without Python/TensorFlow/OpenAI API keys provided,
       we will implement a "Keyword Scoring RAG" (Retrieval-Augmented Generation Lite).
    */

    $sources = $db_notebook->all();
    
    // Split user query into keywords (Basic tokenization for Thai/English)
    // Remove common stop words? For now, just simple split by space.
    $keywords = explode(' ', strtolower($userMessage));
    $keywords = array_filter($keywords, function($k) { return mb_strlen($k) > 2; }); // Filter very short words
    
    $bestScore = 0;
    $bestSource = null;

    foreach ($sources as $source) {
        $score = 0;
        $contentLower = strtolower($source['content']);
        $titleLower = strtolower($source['title']);
        $tags = isset($source['tags']) ? $source['tags'] : [];

        foreach ($keywords as $word) {
            // Priority 1: Match in Title (Weight 3x)
            if (strpos($titleLower, $word) !== false) $score += 3;
            
            // Priority 2: Match in Tags (Weight 2x)
             foreach($tags as $tag) {
                 if (strpos(strtolower($tag), $word) !== false) $score += 2;
             }

            // Priority 3: Match in Content (Weight 1x)
            // Enhanced: Count occurrences?
            $count = substr_count($contentLower, $word);
            $score += $count;
        }

        if ($score > $bestScore) {
            $bestScore = $score;
            $bestSource = $source;
        }
    }

    // 2. Fallback to Legacy Q&A if no good match in Notebook
    if ($bestScore < 2) { // Threshold
         $kb_entries = $db_kb->all();
         foreach ($kb_entries as $entry) {
            $kws = json_decode($entry['keywords'], true);
            if ($kws) {
                foreach ($kws as $kw) {
                    if (strpos(strtolower($userMessage), strtolower($kw)) !== false) {
                        // Found legacy match
                        echo json_encode(['reply' => $entry['answer_th']]); // Default TH
                        exit;
                    }
                }
            }
         }
    }

    if ($bestSource) {
        // We found a source note!
        // "Simulation" of an LLM: Returung the context.
        // Ideally, we would pass $bestSource['content'] + $userMessage to an API (like GPT-4).
        // Since we don't have that, we return the relevant segment or full text cleanly.
        
        $response = "จากข้อมูลในสมุดบันทึกเรื่อง \"" . $bestSource['title'] . "\":\n\n";
        $response .= $bestSource['content'];
        
        // Truncate if too long? NotebookLM usually gives summary.
        // For now, return full content as these are likely "notes".
        
    } else {
        $response = "ขออภัยครับ ผมไม่มีข้อมูลเกี่ยวกับเรื่องนี้ในคลังความรู้ของผม";
    }

    echo json_encode(['reply' => $response]);

} catch (Exception $e) {
    echo json_encode(['reply' => 'Error accessing brain.']);
}
?>
