<?php
require_once 'auth_check.php';
require_once '../db_connect.php';
checkAdminAuth();

// --- 🔑 AI API KEYS (Remove these before pushing to public repo!) ---
$GOOGLE_API_KEY = ""; // Replace with your Google AI API Key
$OPENAI_API_KEY = ""; // Replace with your OpenAI API Key
$GROQ_API_KEY   = ""; // Replace with your Groq API Key

// --- 🔍 Auto-Detect Installed Ollama Models ---
function getLocalOllamaModels() {
    $models = [];
    // Try to execute ollama list
    $output = shell_exec('ollama list 2>&1');
    if ($output) {
        $lines = explode("\n", $output);
        foreach ($lines as $line) {
            // Parse lines like: "llama3:latest   field   size   time"
            $parts = preg_split('/\s+/', trim($line));
            if (count($parts) > 0 && $parts[0] !== 'NAME') {
                $name = $parts[0];
                // Clean tag "latest" if preferred, or keep it. usually "model:tag"
                $models[$name] = true;
            }
        }
    }
    return $models;
}

$installed_ollama = getLocalOllamaModels();

// --- 🤖 AI Model Definitions ---
$AI_MODELS = [
    // Google
    'gemini-1.5-flash-latest' => ['name' => 'Gemini 1.5 Flash', 'type'=>'cloud', 'provider'=>'google'],
    'gemini-1.5-pro-latest'   => ['name' => 'Gemini 1.5 Pro',   'type'=>'cloud', 'provider'=>'google'],

    // Local (Check installation)
    'llama3.2:3b' => ['name' => 'Llama 3.2 3B', 'type'=>'local', 'provider'=>'ollama'],
    'deepseek-r1' => ['name' => 'DeepSeek R1',  'type'=>'local', 'provider'=>'ollama'],
    'qwen'        => ['name' => 'Qwen 2.5',     'type'=>'local', 'provider'=>'ollama'],
    'mistral'     => ['name' => 'Mistral',      'type'=>'local', 'provider'=>'ollama'],
    'gemma:2b'    => ['name' => 'Gemma 2B',     'type'=>'local', 'provider'=>'ollama'],

    // Cloud Others
    'llama3-70b-8192' => ['name' => 'Llama3 70B (Groq)', 'type'=>'cloud', 'provider'=>'groq'],
    'gpt-4o'          => ['name' => 'GPT-4o (OpenAI)',   'type'=>'cloud', 'provider'=>'openai'],
];

// --- 🛠️ AI Engine ---
function callAI($modelKey, $prompt, $options = []) {
    global $AI_MODELS, $GOOGLE_API_KEY, $OPENAI_API_KEY, $GROQ_API_KEY;
    
    // Safety
    if (!isset($AI_MODELS[$modelKey])) $modelKey = 'gemini-1.5-flash-latest';
    $config = $AI_MODELS[$modelKey];
    $provider = $config['provider'];

    // Google
    if ($provider === 'google') {
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$modelKey}:generateContent?key=" . $GOOGLE_API_KEY;
        $payload = [ "contents" => [ [ "parts" => [ ["text" => $prompt] ] ] ] ];
        if (isset($options['inline_data'])) $payload['contents'][0]['parts'][] = ["inline_data" => $options['inline_data']];
        return curlPost($url, $payload);
    } 
    
    // Ollama
    elseif ($provider === 'ollama') {
        $url = "http://127.0.0.1:11434/api/generate";
        $payload = [ "model" => $modelKey, "prompt" => $prompt, "stream" => false ];
        if(isset($options['inline_data'])) return ['status'=>'error','message'=>'Ollama does not support media input yet.'];
        return curlPost($url, $payload, [], 'ollama');
    }

    // Groq
    elseif ($provider === 'groq') {
        if(empty($GROQ_API_KEY)) return ['status'=>'error','message'=>'Groq API Key missing.'];
        return callOpenAICompat("https://api.groq.com/openai/v1/chat/completions", $GROQ_API_KEY, $modelKey, $prompt);
    }

    // OpenAI
    elseif ($provider === 'openai') {
        if(empty($OPENAI_API_KEY)) return ['status'=>'error','message'=>'OpenAI API Key missing.'];
        return callOpenAICompat("https://api.openai.com/v1/chat/completions", $OPENAI_API_KEY, $modelKey, $prompt);
    }

    return ['status' => 'error', 'message' => 'Unknown Provider'];
}

function callOpenAICompat($url, $key, $model, $prompt) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        "model" => $model,
        "messages" => [ ["role" => "user", "content" => $prompt] ]
    ]));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer $key", "Content-Type: application/json"]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $res = curl_exec($ch); curl_close($ch);
    $data = json_decode($res, true);
    if(isset($data['choices'][0]['message']['content'])) return ['status'=>'success', 'content'=>$data['choices'][0]['message']['content']];
    return ['status'=>'error', 'message'=>'API Error: ' . ($data['error']['message'] ?? json_encode($data))];
}

function curlPost($url, $data, $headers=[], $type='google') {
    $ch = curl_init($url); curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge(['Content-Type: application/json'], $headers));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); curl_setopt($ch, CURLOPT_TIMEOUT, 120);
    $res = curl_exec($ch); $err = curl_error($ch); curl_close($ch);

    if ($err) return ['status'=>'error','message'=>"Connection Error: $err"];
    $json = json_decode($res, true);

    if ($type === 'ollama') {
        if (isset($json['response'])) return ['status'=>'success', 'content'=>$json['response']];
        if (strpos(($json['error']??''), 'not found')!==false) return ['status'=>'error', 'message'=>"Model is downloading or not installed. Please wait."];
        return ['status'=>'error', 'message'=>"Ollama Error: ".($json['error']??'Unknown')];
    }
    if (isset($json['candidates'][0]['content']['parts'][0]['text'])) return ['status'=>'success', 'content'=>$json['candidates'][0]['content']['parts'][0]['text']];
    return ['status'=>'error', 'message'=>"API Error: ".($json['error']['message']??'Unknown')];
}

// --- Request Handlers ---
if (isset($_GET['action'])) {
    header('Content-Type: application/json');
    if ($_GET['action'] === 'fetch_url') { echo json_encode(['status'=>'success', 'content'=>fetchUrlContent($_GET['url']??'')]); }
    else if ($_GET['action'] === 'fetch_youtube') { echo json_encode(['status'=>'success', 'data'=>getYoutubeInfo($_GET['url']??'')]); }
    else if ($_GET['action'] === 'deep_search') {
        echo json_encode(callAI($_GET['model']??'', "Write a comprehensive article regarding '{$_GET['topic']}'. Format: Markdown."));
    }
    else if ($_GET['action'] === 'transcribe_media') {
        $path = '../'.($_POST['file_path']??'');
        if(!file_exists($path)) { echo json_encode(['status'=>'error']); exit; }
        $mime = mime_content_type($path); $b64 = base64_encode(file_get_contents($path));
        echo json_encode(callAI($_POST['model']??'', "Transcribe/summarize this media.", ['inline_data'=>['mime_type'=>$mime, 'data'=>$b64]]));
    }
    exit;
}

// Helpers
function fetchUrlContent($url) {
    if(!$url) return ''; $ch = curl_init($url); curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); curl_setopt($ch, CURLOPT_USERAGENT, 'Bot');
    $h = curl_exec($ch); curl_close($ch);
    return $h ? preg_replace('/\s+/', ' ', strip_tags(preg_replace('/<(script|style)\b[^>]*>.*?<\/\1>/is', "", $h))) : false;
}
function getYoutubeInfo($url) {
    preg_match('%(?:youtube\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $m);
    $id = $m[1]??null; if(!$id) return false;
    $d = json_decode(@file_get_contents("https://www.youtube.com/oembed?url=https://www.youtube.com/watch?v=$id&format=json"), true);
    return ['id'=>$id, 'title'=>$d['title']??'Video', 'thumbnail'=>"https://img.youtube.com/vi/$id/hqdefault.jpg"];
}

// POST Save
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title']; $content = $_POST['content']; $type = 'note'; $media_path = '';
    $tags = array_map('trim', explode(',', $_POST['tags'] ?? ''));

    if (isset($_FILES['file_upload']) && $_FILES['file_upload']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['file_upload']; $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['txt', 'md', 'json', 'csv', 'py', 'php', 'js', 'html'])) {
            $content = ($content ? "$content\n\n" : "") . file_get_contents($file['tmp_name']); $title = $title ?: $file['name'];
        } else if (in_array($ext, ['mp3', 'wav', 'mp4', 'm4a', 'mov'])) {
            $dir = "../assets/notebook_media/"; if (!is_dir($dir)) mkdir($dir, 0777, true);
            $fname = uniqid('media_') . '.' . $ext;
            if (move_uploaded_file($file['tmp_name'], $dir . $fname)) {
                $media_path = "assets/notebook_media/$fname"; $type = in_array($ext, ['mp3', 'wav', 'm4a']) ? 'audio' : 'video';
                $title = $title ?: $file['name']; $content = "[$type: $fname]\n\n$content";
            }
        }
    }
    if (!empty($_POST['youtube_url'])) { $type = 'youtube'; $media_path = $_POST['youtube_url']; }
    $data = ['title'=>$title, 'content'=>$content, 'tags'=>$tags, 'type'=>$type];
    if ($media_path) $data['media_path'] = $media_path;
    if (!empty($_POST['id'])) $db_notebook->update($_POST['id'], $data); else $db_notebook->insert($data);
    header('Location: manage_notebook.php'); exit;
}
if (isset($_GET['delete'])) { $db_notebook->delete($_GET['delete']); header('Location: manage_notebook.php'); exit; }
$sources = $db_notebook->all(); usort($sources, function($a, $b) { return $b['id'] - $a['id']; }); // Sort by newest
$edit_entry = isset($_GET['edit']) ? $db_notebook->find($_GET['edit']) : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NotebookLM Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { background: #fff; height: 100vh; border-right: 1px solid #ddd; padding: 20px; position: fixed; width: 300px; overflow-y: auto; }
        .main-content { margin-left: 300px; padding: 40px; }
        .source-card { border: 1px solid #eee; border-radius: 8px; padding: 12px; margin-bottom: 8px; background: white; cursor: pointer; transition:0.2s; }
        .source-card:hover { background-color:#f1f3f4; }
        .source-card.active { border-left: 4px solid #0d6efd; background-color: #e8f0fe; }
        .status-dot { height: 8px; width: 8px; border-radius: 50%; display: inline-block; margin-right: 5px; }
        .status-ready { background-color: #198754; }
        .status-dl { background-color: #ffc107; }
    </style>
</head>
<body>
<div class="sidebar">
    <h5 class="mb-4 text-primary"><i class="bi bi-journal-album"></i> Notebook Admin</h5>
    <div class="list-group">
        <?php foreach($sources as $s): ?>
            <div class="source-card <?php echo (($edit_entry['id']??0) == $s['id']) ? 'active' : ''; ?>" onclick="window.location='?edit=<?php echo $s['id']; ?>'">
                <div class="fw-bold text-truncate"><?php echo htmlspecialchars($s['title']); ?></div>
                <div class="small text-muted text-truncate"><?php echo $s['tags'] ? implode(',', $s['tags']) : 'No tags'; ?></div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="mt-4 pt-3 border-top"><a href="index.php" class="text-decoration-none">← Back to Site</a></div>
</div>
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><?php echo $edit_entry ? 'Edit' : 'Create'; ?> Entry</h3>
        
        <!-- Smart Selector -->
        <select id="model_select" class="form-select form-select-sm" style="width:auto; min-width:220px;">
            <?php foreach($AI_MODELS as $key => $mod): ?>
                <?php 
                    $label = $mod['name'];
                    $disabled = '';
                    $style = '';
                    
                    if ($mod['type'] === 'local') {
                        // Check exact match or partial match (e.g. gemma:2b vs gemma)
                        $is_installed = false;
                        foreach($installed_ollama as $iname => $v) {
                            if (strpos($iname, $key) !== false || strpos($key, $iname) !== false) {
                                $is_installed = true; break;
                            }
                        }
                        
                        if ($is_installed) {
                            $label = "✅ " . $label . " (Ready)";
                        } else {
                            $label = "⏳ " . $label . " (Downloading...)";
                            $style = "color:#999; font-style:italic;";
                            // Optional: Disable if you want to prevent clicking
                            // $disabled = 'disabled'; 
                        }
                    }
                ?>
                <option value="<?php echo $key; ?>" style="<?php echo $style; ?>" <?php echo $disabled; ?>><?php echo $label; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Toolbar -->
    <div class="btn-group mb-3">
        <button class="btn btn-outline-secondary" onclick="show('upload')"><i class="bi bi-upload"></i> Upload</button>
        <button class="btn btn-outline-danger" onclick="show('youtube')"><i class="bi bi-youtube"></i> YouTube</button>
        <button class="btn btn-outline-success" onclick="show('link')"><i class="bi bi-globe"></i> Link</button>
        <button class="btn btn-outline-warning text-dark" onclick="show('search')"><i class="bi bi-stars"></i> Deep Search</button>
    </div>

    <!-- Panels -->
    <div id="panel-upload" class="card p-3 mb-3 source-panel" style="display:none; border-top:3px solid #6c757d">
        <h6>Upload File</h6> <input type="file" id="file_in" class="form-control" onchange="handleFile(this)">
    </div>
    <div id="panel-youtube" class="card p-3 mb-3 source-panel" style="display:none; border-top:3px solid #dc3545">
        <h6>YouTube</h6> <div class="input-group"><input type="text" id="yt_in" class="form-control" placeholder="URL"><button class="btn btn-danger" onclick="addYT()">Add</button></div>
    </div>
    <div id="panel-link" class="card p-3 mb-3 source-panel" style="display:none; border-top:3px solid #198754">
        <h6>Web Import</h6> <div class="input-group"><input type="text" id="link_in" class="form-control" placeholder="URL"><button class="btn btn-success" onclick="addLink()">Fetch</button></div>
    </div>
    <div id="panel-search" class="card p-3 mb-3 source-panel" style="display:none; border-top:3px solid #ffc107; background:#fffbf0">
        <h6>AI Deep Search</h6> 
        <div class="input-group"><input type="text" id="topic_in" class="form-control" placeholder="Enter topic for AI generation..."><button class="btn btn-warning" onclick="doSearch()">Generate</button></div>
        <div class="small text-muted mt-1">*Selected model will be used. 'Downloading' models may fail until finished.</div>
    </div>

    <form method="POST" enctype="multipart/form-data">
        <?php if($edit_entry): ?><input type="hidden" name="id" value="<?php echo $edit_entry['id']; ?>"><?php endif; ?>
        <input type="file" name="file_upload" id="real_file" style="display:none">
        <input type="hidden" name="youtube_url" id="real_yt" value="<?php echo $edit_entry['media_path'] ?? ''; ?>">

        <?php if(!empty($edit_entry['media_path']??'')): ?>
            <div class="card mb-3 bg-light">
                 <div class="card-body d-flex justify-content-between align-items-center py-2">
                    <span class="text-truncate"><i class="bi bi-paperclip"></i> Media Attached: <?php echo basename($edit_entry['media_path']); ?></span>
                    <button type="button" class="btn btn-sm btn-primary" onclick="doTranscribe('<?php echo $edit_entry['media_path']; ?>')">Transcribe</button>
                 </div>
            </div>
        <?php endif; ?>

        <input type="text" name="title" id="title_in" class="form-control fs-4 fw-bold mb-3" placeholder="Entry Title" value="<?php echo htmlspecialchars($edit_entry['title']??''); ?>" required>
        <textarea name="content" id="content_in" class="form-control" style="min-height:400px; font-family:monospace;" placeholder="Content area..." required><?php echo htmlspecialchars($edit_entry['content']??''); ?></textarea>
        
        <div class="d-flex justify-content-end gap-2 mt-3">
             <?php if($edit_entry): ?><a href="?delete=<?php echo $edit_entry['id']; ?>" class="btn btn-link text-danger" onclick="return confirm('Delete?')">Delete</a><?php endif; ?>
             <button class="btn btn-dark px-4">Save Entry</button>
        </div>
    </form>
</div>
<script>
function show(n){document.querySelectorAll('.source-panel').forEach(e=>e.style.display='none');document.getElementById('panel-'+n).style.display='block';}
function getModel(){return document.getElementById('model_select').value;}
// Check model status
function checkModel() {
    const sel = document.getElementById('model_select');
    const txt = sel.options[sel.selectedIndex].text;
    if(txt.includes('Downloading')) {
        alert('This model is still downloading on the server. Please wait or use Gemini/Llama3.2');
        return false;
    }
    return true;
}

async function doSearch(){
    if(!checkModel()) return;
    const t=document.getElementById('topic_in').value; if(!t)return;
    const btn=document.querySelector('#panel-search button'); btn.disabled=true; btn.innerText='Thinking...';
    try{
        const r=await fetch(`manage_notebook.php?action=deep_search&topic=${encodeURIComponent(t)}&model=${getModel()}`);
        const d=await r.json();
        if(d.status==='success'){
            document.getElementById('content_in').value += `\n\n## AI Search: ${t}\n` + d.content;
            if(!document.getElementById('title_in').value) document.getElementById('title_in').value=t; show('none');
        } else alert(d.message);
    }catch(e){alert('Error')}finally{btn.disabled=false;btn.innerText='Generate';}
}
async function doTranscribe(p){
    if(!checkModel()) return;
    if(!confirm('Transcribe using active model?'))return;
    try{
        const fd=new FormData(); fd.append('file_path',p); fd.append('model',getModel());
        const r=await fetch('manage_notebook.php?action=transcribe_media',{method:'POST',body:fd});
        const d=await r.json();
        if(d.status==='success'){ document.getElementById('content_in').value+="\n\n## Transcript\n"+d.content; alert('Done'); }
        else alert(d.message);
    }catch(e){alert('Error')}
}
// Utils
function handleFile(i){ const f=i.files[0]; const dt=new DataTransfer(); dt.items.add(f); document.getElementById('real_file').files=dt.files; document.getElementById('title_in').value=f.name; alert('File Set'); show('none'); }
async function addYT(){ const u=document.getElementById('yt_in').value; const r=await fetch(`manage_notebook.php?action=fetch_youtube&url=${encodeURIComponent(u)}`); const d=await r.json(); document.getElementById('content_in').value+=`[YouTube: ${d.data.title}]\n${u}`; document.getElementById('real_yt').value=u; show('none'); }
async function addLink(){ const u=document.getElementById('link_in').value; const r=await fetch(`manage_notebook.php?action=fetch_url&url=${encodeURIComponent(u)}`); const d=await r.json(); document.getElementById('content_in').value+=d.content; show('none'); }
</script>
</body>
</html>
