<?php
require_once 'auth_check.php';
require_once '../db_connect.php';
checkAdminAuth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title_th = $_POST['title_th'];
    $title_en = $_POST['title_en'];
    $title_cn = $_POST['title_cn'];
    $subtitle = $_POST['subtitle'];
    $description = $_POST['description'];
    $icon = $_POST['icon'];
    
    // Updated Fields
    $date_start = $_POST['date_start'];
    $date_end = $_POST['date_end'];
    $activity_time = $_POST['activity_time'];
    $location = $_POST['location'];
    $link_url = $_POST['link_url'];
    
    // Handle Image Upload
    $image_path = isset($_POST['current_image']) ? $_POST['current_image'] : 'assets/images/default.png';
    // Handle Document Upload
    $document_path = isset($_POST['current_document']) ? $_POST['current_document'] : '';

    // Check Image Upload
    if (isset($_FILES['image_upload']) && $_FILES['image_upload']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../assets/images/activities/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        
        $file_ext = strtolower(pathinfo($_FILES['image_upload']['name'], PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        if (in_array($file_ext, $allowed_ext)) {
            $filename = uniqid('act_') . '.' . $file_ext;
            $target_file = $upload_dir . $filename;
            if (move_uploaded_file($_FILES['image_upload']['tmp_name'], $target_file)) {
                $image_path = 'assets/images/activities/' . $filename;
            }
        }
    }

    // Check Document Upload
    if (isset($_FILES['doc_upload']) && $_FILES['doc_upload']['error'] === UPLOAD_ERR_OK) {
        $doc_upload_dir = '../assets/docs/activities/';
        if (!is_dir($doc_upload_dir)) mkdir($doc_upload_dir, 0777, true);
        
        $file_ext = strtolower(pathinfo($_FILES['doc_upload']['name'], PATHINFO_EXTENSION));
        $allowed_ext = ['pdf', 'doc', 'docx']; // Add more if needed
        
        if (in_array($file_ext, $allowed_ext)) {
            $filename = uniqid('doc_') . '_' . basename($_FILES['doc_upload']['name']); // Keep original name partly for reference
            $target_file = $doc_upload_dir . $filename;
            if (move_uploaded_file($_FILES['doc_upload']['tmp_name'], $target_file)) {
                $document_path = 'assets/docs/activities/' . $filename;
            }
        }
    }

    $data = [
        'title_th' => $title_th,
        'title_en' => $title_en,
        'title_cn' => $title_cn,
        'subtitle_th' => $subtitle,
        'description_th' => $description,
        'icon' => $icon,
        'image' => $image_path,
        'date_start' => $date_start,
        'date_end' => $date_end,
        'activity_time' => $activity_time,
        'location' => $location,
        'link_url' => $link_url,
        'document_path' => $document_path // New field
    ];

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $db_activities->update($_POST['id'], $data);
    } else {
        $db_activities->insert($data);
    }
    header('Location: manage_activities.php');
    exit;
}

if (isset($_GET['delete'])) {
    $db_activities->delete($_GET['delete']);
    header('Location: manage_activities.php');
    exit;
}

$activities = $db_activities->all();
usort($activities, function($a, $b) { return $b['id'] - $a['id']; });

$edit_entry = null;
if (isset($_GET['edit'])) {
    $found = $db_activities->find($_GET['edit']);
    if($found) $edit_entry = $found;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Activities</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <a href="index.php" class="btn btn-secondary mb-3">&larr; Back</a>
        <h2>Manage Activities</h2>
        
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <?php if($edit_entry): ?>
                        <input type="hidden" name="id" value="<?php echo $edit_entry['id']; ?>">
                        <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($edit_entry['image']); ?>">
                        <input type="hidden" name="current_document" value="<?php echo isset($edit_entry['document_path']) ? htmlspecialchars($edit_entry['document_path']) : ''; ?>">
                    <?php endif; ?>
                    
                    <h5 class="text-primary mb-3">1. Language Support</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Title (Thai)</label>
                            <div class="input-group">
                                <input type="text" id="title_th" name="title_th" class="form-control" required value="<?php echo $edit_entry ? htmlspecialchars($edit_entry['title_th']) : ''; ?>">
                                <button type="button" class="btn btn-info text-white" onclick="autoTranslate()">
                                    <i class="bi bi-translate"></i> AI Translate
                                </button>
                                <button type="button" class="btn btn-secondary" onclick="autoEmoji()">
                                    <i class="bi bi-emoji-smile"></i> Auto Emoji
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Title (English)</label>
                            <input type="text" id="title_en" name="title_en" class="form-control" value="<?php echo $edit_entry ? htmlspecialchars($edit_entry['title_en']) : ''; ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Title (Chinese)</label>
                            <input type="text" id="title_cn" name="title_cn" class="form-control" value="<?php echo $edit_entry ? htmlspecialchars($edit_entry['title_cn']) : ''; ?>">
                        </div>
                    </div>

                    <h5 class="text-primary mb-3 text-border-top pt-3">2. Activity Details</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Subtitle (Short Description)</label>
                            <input type="text" name="subtitle" class="form-control" value="<?php echo $edit_entry && isset($edit_entry['subtitle_th']) ? htmlspecialchars($edit_entry['subtitle_th']) : ''; ?>">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Icon (Emoji)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white" id="icon-preview"><?php echo $edit_entry && isset($edit_entry['icon']) ? $edit_entry['icon'] : '📅'; ?></span>
                                <input type="text" id="icon_input" name="icon" class="form-control" value="<?php echo $edit_entry && isset($edit_entry['icon']) ? htmlspecialchars($edit_entry['icon']) : '📅'; ?>" oninput="updateIconPreview(this.value)">
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Date Range</label>
                            <div class="input-group">
                                <span class="input-group-text">Start</span>
                                <input type="date" name="date_start" class="form-control" value="<?php echo $edit_entry && isset($edit_entry['date_start']) ? htmlspecialchars($edit_entry['date_start']) : ''; ?>">
                                <span class="input-group-text">End</span>
                                <input type="date" name="date_end" class="form-control" value="<?php echo $edit_entry && isset($edit_entry['date_end']) ? htmlspecialchars($edit_entry['date_end']) : ''; ?>">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Time</label>
                            <input type="text" name="activity_time" class="form-control" placeholder="e.g. 09:00 - 16:30" value="<?php echo $edit_entry && isset($edit_entry['activity_time']) ? htmlspecialchars($edit_entry['activity_time']) : ''; ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Location</label>
                            <input type="text" name="location" class="form-control" placeholder="Room/Building" value="<?php echo $edit_entry && isset($edit_entry['location']) ? htmlspecialchars($edit_entry['location']) : ''; ?>">
                        </div>
                    </div>

                    <h5 class="text-primary mb-3 text-border-top pt-3">3. Media & Links</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Background Image</label>
                            <input type="file" name="image_upload" class="form-control" accept="image/*">
                            <?php if($edit_entry && !empty($edit_entry['image'])): ?>
                                <div class="mt-2 text-muted small">Current: <?php echo basename($edit_entry['image']); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Document (PDF)</label>
                            <input type="file" name="doc_upload" class="form-control" accept=".pdf,.doc,.docx">
                            <?php if($edit_entry && !empty($edit_entry['document_path'])): ?>
                                <div class="mt-2 text-primary small">
                                    <i class="bi bi-file-earmark-text"></i> Current: 
                                    <a href="../<?php echo htmlspecialchars($edit_entry['document_path']); ?>" target="_blank">View File</a>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-12">
                             <label class="form-label">External Link (Registration/Details)</label>
                            <input type="url" name="link_url" class="form-control" placeholder="https://..." value="<?php echo $edit_entry && isset($edit_entry['link_url']) ? htmlspecialchars($edit_entry['link_url']) : ''; ?>">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Full Description</label>
                            <textarea name="description" class="form-control" rows="4"><?php echo $edit_entry && isset($edit_entry['description_th']) ? htmlspecialchars($edit_entry['description_th']) : ''; ?></textarea>
                        </div>
                    </div>
                    
                    <hr>
                    <div class="d-flex justify-content-between">
                        <?php if($edit_entry): ?>
                             <a href="manage_activities.php" class="btn btn-outline-secondary">Cancel</a>
                        <?php else: ?>
                            <div></div>
                        <?php endif; ?>
                        <button type="submit" class="btn btn-primary px-5"><?php echo $edit_entry ? 'Save Changes' : 'Create Activity'; ?></button>
                    </div>
                </form>
            </div>
        </div>

        <table class="table table-hover bg-white shadow-sm align-middle">
            <thead class="table-light">
                <tr>
                    <th width="5%">ID</th>
                    <th width="10%">Image</th>
                    <th width="30%">Activity</th>
                    <th width="20%">Date/Time</th>
                    <th width="15%">Info</th>
                    <th width="15%">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($activities as $row): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td>
                        <?php if(isset($row['image']) && $row['image']): ?>
                             <img src="../<?php echo htmlspecialchars($row['image']); ?>" width="50" height="50" style="object-fit: cover; border-radius: 4px;">
                        <?php else: ?>
                            <span class="text-muted small">No img</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="fw-bold"><?php echo htmlspecialchars($row['title_th']); ?></div>
                        <small class="text-muted"><?php echo isset($row['subtitle_th']) ? htmlspecialchars($row['subtitle_th']) : ''; ?></small>
                    </td>
                    <td>
                        <?php 
                            $d_start = isset($row['date_start']) ? $row['date_start'] : '';
                            $d_end = isset($row['date_end']) ? $row['date_end'] : '';
                            if($d_start) {
                                echo $d_start;
                                echo ($d_end && $d_end != $d_start) ? ' - ' . $d_end : '';
                            } else {
                                echo '-';
                            }
                        ?><br>
                        <small class="text-muted"><?php echo isset($row['activity_time']) ? $row['activity_time'] : ''; ?></small>
                    </td>
                    <td>
                        <?php if(isset($row['location']) && $row['location']) echo '📍 '.htmlspecialchars($row['location']) . '<br>'; ?>
                        <?php if(isset($row['link_url']) && $row['link_url']) echo '<a href="'.$row['link_url'].'" target="_blank"><i class="bi bi-link"></i> Link</a> '; ?>
                        <?php if(isset($row['document_path']) && $row['document_path']) echo '<a href="../'.$row['document_path'].'" target="_blank"><i class="bi bi-file-pdf"></i> PDF</a>'; ?>
                    </td>
                    <td>
                        <a href="?edit=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                        <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Confirm delete?')"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        function updateIconPreview(val) {
            document.getElementById('icon-preview').innerText = val;
        }

        function autoEmoji() {
            const text = document.getElementById('title_th').value.toLowerCase();
            const iconInput = document.getElementById('icon_input');
            let emoji = '📅';

            if(text.includes('ai') || text.includes('ปัญญาประดิษฐ์')) emoji = '🧠';
            else if(text.includes('iot') || text.includes('sensor')) emoji = '📡';
            else if(text.includes('data') || text.includes('ข้อมูล')) emoji = '📊';
            else if(text.includes('plant') || text.includes('พืช')) emoji = '🌱';
            else if(text.includes('code') || text.includes('เขียนโปรแกรม')) emoji = '💻';
            else if(text.includes('workshop') || text.includes('อบรม')) emoji = '🛠️';
            else if(text.includes('showcase') || text.includes('ประกวด')) emoji = '🏆';
            else if(text.includes('climate') || text.includes('อากาศ')) emoji = '🌦️';
            
            iconInput.value = emoji;
            updateIconPreview(emoji);
        }

        async function autoTranslate() {
            const thText = document.getElementById('title_th').value;
             const enInput = document.getElementById('title_en');
            const cnInput = document.getElementById('title_cn');
            const btn = document.querySelector('button[onclick="autoTranslate()"]');

            if (!thText) {
                alert('Please enter Thai text first.');
                return;
            }

            const originalBtnText = btn.innerHTML;
            btn.innerHTML = '<span class="loading-spinner"></span> Translating...';
            btn.disabled = true;

            try {
                const resEn = await fetch(`https://api.mymemory.translated.net/get?q=${encodeURIComponent(thText)}&langpair=th|en`);
                const dataEn = await resEn.json();
                if (dataEn.responseData.translatedText) enInput.value = dataEn.responseData.translatedText;

                const resCn = await fetch(`https://api.mymemory.translated.net/get?q=${encodeURIComponent(thText)}&langpair=th|zh-CN`);
                const dataCn = await resCn.json();
                if (dataCn.responseData.translatedText) cnInput.value = dataCn.responseData.translatedText;
                
                // Also trigger auto emoji if empty
                if(document.getElementById('icon_input').value === '📅' || document.getElementById('icon_input').value === '') {
                    autoEmoji();
                }

            } catch (error) {
                alert('Translation failed.');
            } finally {
                btn.innerHTML = originalBtnText;
                btn.disabled = false;
            }
        }
    </script>
</body>
</html>
