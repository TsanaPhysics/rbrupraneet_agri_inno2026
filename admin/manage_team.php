<?php
require_once 'auth_check.php';
require_once '../db_connect.php';
checkAdminAuth();

// Handle Image Upload Helper
function handleUpload($file) {
    if ($file['error'] !== UPLOAD_ERR_OK) return false;
    
    $target_dir = "../assets/images/team/";
    if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
    
    $file_ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    
    if (!in_array($file_ext, $allowed)) return false;

    $new_name = uniqid("team_") . "." . $file_ext;
    $target_file = $target_dir . $new_name;
    
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return "assets/images/team/" . $new_name;
    }
    return false;
}

// Handle AJAX Reorder
if (isset($_POST['action']) && $_POST['action'] === 'reorder') {
    // Return JSON header
    header('Content-Type: application/json');
    
    $order = $_POST['order']; // Array of IDs
    if (is_array($order)) {
        foreach ($order as $index => $id) {
            $db_team->update($id, ['order_index' => $index]);
        }
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
    }
    exit;
}

// Handle Form Submit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['action'])) {
    $name = $_POST['name'];
    $role = $_POST['role'];
    $department = $_POST['department'];
    
    $image = $_POST['current_image'];
    if (isset($_FILES['image_upload']) && $_FILES['image_upload']['error'] === UPLOAD_ERR_OK) {
        $uploaded = handleUpload($_FILES['image_upload']);
        if ($uploaded) $image = $uploaded;
    }

    $data = [
        'name' => $name,
        'role' => $role,
        'department' => $department,
        'image' => $image
    ];

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $db_team->update($_POST['id'], $data);
    } else {
        // New entry gets last order
        $data['order_index'] = 9999; 
        $db_team->insert($data);
    }
    header('Location: manage_team.php');
    exit;
}

// Handle Delete
if (isset($_GET['delete'])) {
    $db_team->delete($_GET['delete']);
    header('Location: manage_team.php');
    exit;
}

// Fetch and Sort
$team = $db_team->all();
usort($team, function($a, $b) {
    $oa = isset($a['order_index']) ? $a['order_index'] : 9999;
    $ob = isset($b['order_index']) ? $b['order_index'] : 9999;
    
    if ($oa == $ob) return $a['id'] - $b['id'];
    return $oa - $ob;
});

$edit_entry = null;
if (isset($_GET['edit'])) {
    $found = $db_team->find($_GET['edit']);
    if($found) $edit_entry = $found;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Team - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <!-- Use specific stable version -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
    <style>
        .drag-handler-cell {
            cursor: grab;
            color: #adb5bd;
            transition: color 0.2s;
        }
        .drag-handler-cell:hover {
            color: #495057;
            background-color: #f8f9fa;
        }
        .drag-handler-cell:active {
            cursor: grabbing;
        }
        tr.sortable-ghost {
            opacity: 0.5;
            background-color: #e9ecef !important;
        }
        tr.sortable-drag {
            background-color: #fff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><a href="index.php" class="text-decoration-none text-dark"><i class="bi bi-arrow-left-circle me-2"></i></a> Manage Team Members</h2>
            <div id="saveStatus" class="badge bg-success" style="opacity: 0; transition: opacity 0.5s;">Saved!</div>
        </div>
        
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-body p-4 bg-white rounded">
                <form method="POST" enctype="multipart/form-data">
                    <?php if($edit_entry): ?>
                        <input type="hidden" name="id" value="<?php echo $edit_entry['id']; ?>">
                        <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($edit_entry['image']); ?>">
                    <?php else: ?>
                        <input type="hidden" name="current_image" value="assets/images/placeholder_user.png">
                    <?php endif; ?>
                    
                    <h5 class="text-primary mb-3"><i class="bi bi-person-plus-fill me-2"></i><?php echo $edit_entry ? 'Edit Member' : 'Add New Member'; ?></h5>
                    <div class="row g-3">
                        <div class="col-md-5">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" required placeholder="e.g. Dr. John Doe" value="<?php echo $edit_entry ? htmlspecialchars($edit_entry['name']) : ''; ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Role</label>
                            <input type="text" name="role" class="form-control" required placeholder="e.g. Director" value="<?php echo $edit_entry ? htmlspecialchars($edit_entry['role']) : ''; ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Department</label>
                            <input type="text" name="department" class="form-control" required placeholder="e.g. Science" value="<?php echo $edit_entry ? htmlspecialchars($edit_entry['department']) : ''; ?>">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Profile Image</label>
                            <div class="input-group">
                                <input type="file" name="image_upload" class="form-control" accept="image/*">
                                <?php if($edit_entry && !empty($edit_entry['image'])): ?>
                                    <span class="input-group-text bg-white">
                                        <img src="../<?php echo htmlspecialchars($edit_entry['image']); ?>" style="height: 24px; width: 24px; object-fit: cover; border-radius: 50%;">
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 text-end">
                         <?php if($edit_entry): ?>
                             <a href="manage_team.php" class="btn btn-outline-secondary me-2">Cancel</a>
                        <?php endif; ?>
                        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-2"></i><?php echo $edit_entry ? 'Save Changes' : 'Add Member'; ?></button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="teamTable">
                        <thead class="table-light">
                            <tr>
                                <th width="5%" class="text-center"><i class="bi bi-arrows-move"></i></th>
                                <th width="10%">Image</th>
                                <th width="30%">Name</th>
                                <th width="25%">Role</th>
                                <th width="20%">Department</th>
                                <th width="10%" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="sortable-list">
                            <?php foreach($team as $row): ?>
                            <tr data-id="<?php echo $row['id']; ?>">
                                <td class="text-center drag-handler-cell" title="Drag to reorder">
                                    <i class="bi bi-grip-vertical fs-5"></i>
                                </td>
                                <td>
                                    <img src="../<?php echo isset($row['image']) ? htmlspecialchars($row['image']) : ''; ?>" width="45" height="45" class="rounded-circle border" style="object-fit: cover;" onerror="this.src='../assets/images/placeholder_user.png'">
                                </td>
                                <td class="fw-bold text-dark"><?php echo htmlspecialchars($row['name']); ?></td>
                                <td class="text-primary"><?php echo htmlspecialchars($row['role']); ?></td>
                                <td class="text-muted small"><?php echo htmlspecialchars($row['department']); ?></td>
                                <td class="text-end">
                                    <a href="?edit=<?php echo $row['id']; ?>" class="btn btn-sm btn-light text-warning border"><i class="bi bi-pencil-fill"></i></a>
                                    <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-light text-danger border ms-1" onclick="return confirm('Confirm delete?')"><i class="bi bi-trash-fill"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const el = document.getElementById('sortable-list');
            const statusBadge = document.getElementById('saveStatus');

            function showStatus() {
                statusBadge.style.opacity = '1';
                setTimeout(() => {
                    statusBadge.style.opacity = '0';
                }, 2000);
            }

            Sortable.create(el, {
                handle: '.drag-handler-cell', // Class selector for handler
                animation: 200,
                ghostClass: 'sortable-ghost',
                dragClass: 'sortable-drag',
                onEnd: function (evt) {
                    const rows = el.querySelectorAll('tr');
                    const order = Array.from(rows).map(row => row.getAttribute('data-id'));
                    
                    // Use URLSearchParams for cleaner body construction
                    const params = new URLSearchParams();
                    params.append('action', 'reorder');
                    order.forEach(id => params.append('order[]', id));

                    fetch('manage_team.php', {
                        method: 'POST',
                        body: params
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.status === 'success') {
                            showStatus();
                        } else {
                            console.error('Server error', data);
                            alert('Failed to save order');
                        }
                    })
                    .catch(error => {
                        console.error('Fetch error:', error);
                        alert('Network error, could not save order.');
                    });
                }
            });
        });
    </script>
</body>
</html>
