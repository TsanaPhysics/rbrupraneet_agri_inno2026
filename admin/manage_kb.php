<?php
require_once 'auth_check.php';
require_once '../db_connect.php';
checkAdminAuth();

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $keywords = $_POST['keywords']; // string e.g. ["a","b"]
    $answer_th = $_POST['answer_th'];
    $answer_en = $_POST['answer_en'];
    $answer_cn = $_POST['answer_cn'];

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        // Update
        $db_kb->update($_POST['id'], [
            'keywords' => $keywords,
            'answer_th' => $answer_th,
            'answer_en' => $answer_en,
            'answer_cn' => $answer_cn
        ]);
    } else {
        // Create
        $db_kb->insert([
            'keywords' => $keywords,
            'answer_th' => $answer_th,
            'answer_en' => $answer_en,
            'answer_cn' => $answer_cn
        ]);
    }
    header('Location: manage_kb.php');
    exit;
}

// Handle Delete
if (isset($_GET['delete'])) {
    $db_kb->delete($_GET['delete']);
    header('Location: manage_kb.php');
    exit;
}

// Fetch Data
$kb_entries = $db_kb->all();
// Sort by ID desc?
usort($kb_entries, function($a, $b) {
    return $b['id'] - $a['id'];
});

// Edit Mode
$edit_entry = null;
if (isset($_GET['edit'])) {
    $found = $db_kb->find($_GET['edit']);
    if($found) $edit_entry = $found;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Knowledge Base</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        .loading-spinner {
            display: inline-block;
            width: 1rem;
            height: 1rem;
            border: 0.15em solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            animation: spinner-border .75s linear infinite;
        }
        @keyframes spinner-border {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <a href="index.php" class="btn btn-secondary mb-3">&larr; Back</a>
        <h2>Manage AI Knowledge Base (RAG - JSON DB)</h2>
        
        <div class="card mb-4">
            <div class="card-body">
                <form method="POST">
                    <?php if($edit_entry): ?>
                        <input type="hidden" name="id" value="<?php echo $edit_entry['id']; ?>">
                    <?php endif; ?>
                    
                    <div class="mb-3">
                        <label class="form-label">Keywords (JSON Array e.g., ["hello", "hi"])</label>
                        <input type="text" name="keywords" class="form-control" required 
                               value='<?php echo $edit_entry ? htmlspecialchars($edit_entry['keywords']) : '[]'; ?>'>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Answer (Thai)</label>
                            <div class="input-group">
                                <textarea id="answer_th" name="answer_th" class="form-control" rows="3" required><?php echo $edit_entry ? htmlspecialchars($edit_entry['answer_th']) : ''; ?></textarea>
                                <button type="button" class="btn btn-info text-white" onclick="autoTranslate()">
                                    <i class="bi bi-translate"></i> AI Translate
                                </button>
                            </div>
                            <small class="text-muted">Click "AI Translate" to auto-generate English and Chinese answers.</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Answer (English)</label>
                            <textarea id="answer_en" name="answer_en" class="form-control" rows="3"><?php echo $edit_entry ? htmlspecialchars($edit_entry['answer_en']) : ''; ?></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Answer (Chinese)</label>
                            <textarea id="answer_cn" name="answer_cn" class="form-control" rows="3"><?php echo $edit_entry ? htmlspecialchars($edit_entry['answer_cn']) : ''; ?></textarea>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary"><?php echo $edit_entry ? 'Update' : 'Add New'; ?></button>
                    <?php if($edit_entry): ?>
                        <a href="manage_kb.php" class="btn btn-outline-secondary">Cancel</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <table class="table table-bordered bg-white">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Keywords</th>
                    <th>TH Answer</th>
                    <th>EN Answer</th>
                    <th>CN Answer</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($kb_entries as $row): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><small><?php echo htmlspecialchars($row['keywords']); ?></small></td>
                    <td><?php echo mb_strimwidth($row['answer_th'], 0, 50, "..."); ?></td>
                    <td><?php echo mb_strimwidth($row['answer_en'], 0, 50, "..."); ?></td>
                    <td><?php echo mb_strimwidth($row['answer_cn'], 0, 50, "..."); ?></td>
                    <td>
                        <a href="?edit=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        async function autoTranslate() {
            const thText = document.getElementById('answer_th').value;
            const enInput = document.getElementById('answer_en');
            const cnInput = document.getElementById('answer_cn');
            const btn = document.querySelector('button[onclick="autoTranslate()"]');

            if (!thText) {
                alert('Please enter Thai text first.');
                return;
            }

            // UI Loading State
            const originalBtnText = btn.innerHTML;
            btn.innerHTML = '<span class="loading-spinner"></span> Translating...';
            btn.disabled = true;

            try {
                // 1. Translate TH -> EN
                const resEn = await fetch(`https://api.mymemory.translated.net/get?q=${encodeURIComponent(thText)}&langpair=th|en`);
                const dataEn = await resEn.json();
                
                if (dataEn.responseData.translatedText) {
                    enInput.value = dataEn.responseData.translatedText;
                }

                // 2. Translate TH -> CN (Simplified) 'zh-CN'
                const resCn = await fetch(`https://api.mymemory.translated.net/get?q=${encodeURIComponent(thText)}&langpair=th|zh-CN`);
                const dataCn = await resCn.json();

                if (dataCn.responseData.translatedText) {
                    cnInput.value = dataCn.responseData.translatedText;
                }

            } catch (error) {
                console.error('Translation error:', error);
                alert('Translation failed. Please try again or enter manually.');
            } finally {
                // Restore Button
                btn.innerHTML = originalBtnText;
                btn.disabled = false;
            }
        }
    </script>
</body>
</html>
