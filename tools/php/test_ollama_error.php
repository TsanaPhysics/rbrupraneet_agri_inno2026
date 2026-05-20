<?php
require_once '../../api/ollama_helper.php';

$ollama = new OllamaHelper('gemma3:4b');
$prompt = "สวัสดีจ้ะ";
$system = "คุณคือไอด้าผู้ช่วยอัจฉริยะด้านการเกษตรและสิ่งแวดล้อม";

echo "Testing Gemma 3...\n";
$response = $ollama->generate($prompt, $system);
echo "Response: " . $response . "\n";
