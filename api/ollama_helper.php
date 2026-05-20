<?php
/**
 * OllamaHelper - Advanced Communication Bridge with Local Ollama API
 * Supports: Text Chat, Vision (Image Analysis), Smart Model Routing
 * Models: Gemma 4, Gemma 3, DeepSeek-R1, Qwen 3 VL, Llama 3.2
 */
class OllamaHelper {
    private $apiUrl;
    private $model;
    private $timeout;

    // Available models registry
    const MODELS = [
        'gemma4:e2b'        => ['name' => 'Gemma 4 E2B',        'type' => 'multimodal', 'vision' => true],
        'gemma3:4b'         => ['name' => 'Gemma 3 4B',         'type' => 'chat',       'vision' => true],
        'deepseek-r1:latest'=> ['name' => 'DeepSeek-R1',        'type' => 'reasoning',  'vision' => false],
        'qwen3-vl:4b'       => ['name' => 'Qwen 3 VL 4B',      'type' => 'vision',     'vision' => true],
        'llama3.2:3b'       => ['name' => 'Llama 3.2 3B',       'type' => 'fast',       'vision' => false],
    ];

    public function __construct($model = 'gemma4:e2b', $apiUrl = 'http://localhost:11434/api/chat') {
        $this->apiUrl = $apiUrl;
        $this->model = $model;
        $this->timeout = 180;
    }

    /**
     * Change the model on the fly
     */
    public function setModel($modelName) {
        $this->model = $modelName;
    }

    /**
     * Get current model info
     */
    public function getModelInfo() {
        return self::MODELS[$this->model] ?? ['name' => $this->model, 'type' => 'unknown', 'vision' => false];
    }

    /**
     * Check if current model supports vision
     */
    public function supportsVision() {
        $info = $this->getModelInfo();
        return $info['vision'] ?? false;
    }

    /**
     * List available models from Ollama
     */
    public static function listModels() {
        $ch = curl_init('http://localhost:11434/api/tags');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            $data = json_decode($response, true);
            return array_map(function($m) {
                return [
                    'name' => $m['name'],
                    'size' => round($m['size'] / (1024*1024*1024), 1) . ' GB',
                    'family' => $m['details']['family'] ?? 'unknown'
                ];
            }, $data['models'] ?? []);
        }
        return [];
    }

    /**
     * Generate a text response using the Chat API
     */
    public function generate($userPrompt, $systemPrompt = "") {
        $messages = [];
        if (!empty($systemPrompt)) {
            $messages[] = ['role' => 'system', 'content' => $systemPrompt];
        }
        $messages[] = ['role' => 'user', 'content' => $userPrompt];

        return $this->sendRequest($messages);
    }

    /**
     * Generate a response with an image (Vision)
     * @param string $userPrompt Text prompt
     * @param string $imageBase64 Base64-encoded image data (without data URI prefix)
     * @param string $systemPrompt System prompt
     */
    public function generateWithImage($userPrompt, $imageBase64, $systemPrompt = "") {
        $messages = [];
        if (!empty($systemPrompt)) {
            $messages[] = ['role' => 'system', 'content' => $systemPrompt];
        }
        $messages[] = [
            'role' => 'user',
            'content' => $userPrompt,
            'images' => [$imageBase64]
        ];

        return $this->sendRequest($messages);
    }

    /**
     * Send request to Ollama API
     */
    private function sendRequest($messages) {
        $data = [
            'model' => $this->model,
            'messages' => $messages,
            'stream' => false
        ];

        $ch = curl_init($this->apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Expect: ' // Disable 100-continue header
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            return "ขออภัยจ๊ะ ไม่สามารถเชื่อมต่อ AI ได้ (Connection Error) ฮิ";
        }

        if ($httpCode === 200) {
            $result = json_decode($response, true);
            $content = $result['message']['content'] ?? '';
            
            // Clean thinking tags from DeepSeek-R1 output
            if (strpos($this->model, 'deepseek') !== false) {
                $content = preg_replace('/<think>.*?<\/think>/s', '', $content);
                $content = trim($content);
            }
            
            return !empty($content) ? $content : 'ขออภัยจ๊ะ ฉันไม่ได้รับคำตอบกลับมา ฮิ';
        }

        return "ขออภัยจ๊ะ (Error $httpCode) ดูเหมือนระบบ AI จะยังไม่พร้อมทำงานนะเนอะ ฮิ";
    }

    /**
     * Check Ollama server health
     */
    public static function healthCheck() {
        $ch = curl_init('http://localhost:11434/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $httpCode === 200;
    }
}
?>
