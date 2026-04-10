<?php
// admin.php - Admin dashboard for managing registrations (MySQL version)
require_once __DIR__ . '/db_connect.php';

// Simple password protection
$adminPassword = 'admin123';
if (!isset($_GET['pwd']) || $_GET['pwd'] !== $adminPassword) {
    echo '<!DOCTYPE html><html lang="th"><head><meta charset="UTF-8"><title>Admin Login</title></head><body>';
    echo '<h2>Admin Access Required</h2>';
    echo '<form method="GET"><input type="password" name="pwd" placeholder="Password" required /> <button type="submit">Enter</button></form>';
    echo '</body></html>';
    exit;
}

// Handle actions
if (isset($_GET['action'], $_GET['id'])) {
    $regId = intval($_GET['id']);
    if ($_GET['action'] === 'complete') {
        $stmt = $pdo->prepare("UPDATE registrations SET completed = 1 WHERE id = :id");
        $stmt->execute([':id' => $regId]);
        header('Location: admin.php?pwd=' . $adminPassword);
        exit;
    } elseif ($_GET['action'] === 'certificate') {
        header('Location: generate_certificate.php?id=' . $regId . '&pwd=' . $adminPassword);
        exit;
    }
}

// Fetch registrations
try {
    $sql = "SELECT r.id, s.name, s.email, a.title, r.completed, r.registration_date 
            FROM registrations r 
            JOIN students s ON r.student_id = s.id 
            JOIN activities a ON r.activity_id = a.id 
            ORDER BY r.registration_date DESC";
    $stmt = $pdo->query($sql);
    $registrations = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}

echo '<!DOCTYPE html><html lang="th"><head><meta charset="UTF-8"><title>Admin Dashboard</title>';
echo '<link rel="stylesheet" href="css/main.css">'; // Import main CSS
echo '<style>
    body { background: var(--bg-secondary); padding: 20px; }
    .admin-container { max-width: 1200px; margin: 0 auto; background: white; padding: 30px; border-radius: 20px; box-shadow: var(--shadow-lg); }
    h2 { color: var(--primary-color); margin-bottom: 20px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th { background: var(--bg-secondary); padding: 15px; text-align: left; font-weight: 600; color: var(--primary-dark); }
    td { padding: 15px; border-bottom: 1px solid var(--border-color); }
    tr:hover { background: rgba(74, 144, 226, 0.05); }
    .btn-action { display: inline-block; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 0.9em; margin-right: 5px; transition: all 0.2s; }
    .btn-complete { background: #10b981; color: white; }
    .btn-cert { background: #3b82f6; color: white; }
    .btn-complete:hover { background: #059669; }
    .btn-cert:hover { background: #2563eb; }
    .badge { padding: 4px 8px; border-radius: 4px; font-size: 0.85em; font-weight: 600; }
    .badge-pending { background: #fef3c7; color: #92400e; }
    .badge-completed { background: #d1fae5; color: #065f46; }
</style>';
echo '</head><body>';

echo '<div class="admin-container">';
echo '<h2>Admin Dashboard - Registrations</h2>';
echo '<div style="margin-bottom: 20px;">';
echo '<a href="participant_list.php" target="_blank" class="btn btn-secondary" style="margin-right: 10px;">View Public Participant List</a>';
echo '<a href="index.php" class="btn btn-primary">Back to Site</a>';
echo '</div>';

if (empty($registrations)) {
    echo '<p>No registrations found.</p>';
} else {
    echo '<table>';
    echo '<tr><th>ID</th><th>Date</th><th>Name</th><th>Email</th><th>Activity</th><th>Status</th><th>Actions</th></tr>';
    foreach ($registrations as $row) {
        $status = $row['completed'] ? '<span class="badge badge-completed">Completed</span>' : '<span class="badge badge-pending">Pending</span>';
        $actions = '';
        if (!$row['completed']) {
            $actions .= '<a href="?pwd=' . $adminPassword . '&action=complete&id=' . $row['id'] . '" class="btn-action btn-complete">Mark Completed</a>';
        }
        $actions .= '<a href="?pwd=' . $adminPassword . '&action=certificate&id=' . $row['id'] . '" class="btn-action btn-cert" target="_blank">Generate Certificate</a>';
        
        echo '<tr>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . date('d/m/Y H:i', strtotime($row['registration_date'])) . '</td>';
        echo '<td>' . htmlspecialchars($row['name']) . '</td>';
        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
        echo '<td>' . htmlspecialchars($row['title']) . '</td>';
        echo '<td>' . $status . '</td>';
        echo '<td>' . $actions . '</td>';
        echo '</tr>';
    }
    echo '</table>';
}
echo '</div>'; // End container
echo '</body></html>';
?>
