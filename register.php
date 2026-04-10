<?php
// register.php - handle registration form submission (MySQL version)
require_once __DIR__ . '/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $school = trim($_POST['school'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $activity_id = intval($_POST['activity_id'] ?? 0);

    if ($name === '' || $email === '' || $activity_id === 0) {
        die('กรุณากรอกข้อมูลให้ครบถ้วน');
    }

    try {
        // Check if student exists
        $stmt = $pdo->prepare("SELECT id FROM students WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $student_id = $stmt->fetchColumn();

        if (!$student_id) {
            // Insert new student
            $stmt = $pdo->prepare("INSERT INTO students (name, school, email) VALUES (:name, :school, :email)");
            $stmt->execute([':name' => $name, ':school' => $school, ':email' => $email]);
            $student_id = $pdo->lastInsertId();
        }

        // Insert registration (ignore duplicate)
        // Note: MySQL doesn't support "INSERT OR IGNORE" exactly like SQLite in all versions, 
        // but we can use INSERT IGNORE or ON DUPLICATE KEY UPDATE.
        // Or check first. Let's check first for better portability.
        
        $stmt = $pdo->prepare("SELECT id FROM registrations WHERE student_id = :sid AND activity_id = :aid");
        $stmt->execute([':sid' => $student_id, ':aid' => $activity_id]);
        
        if (!$stmt->fetch()) {
            $stmt = $pdo->prepare("INSERT INTO registrations (student_id, activity_id) VALUES (:sid, :aid)");
            $stmt->execute([':sid' => $student_id, ':aid' => $activity_id]);
        }

        // Fetch activity title for display
        $stmt = $pdo->prepare("SELECT title FROM activities WHERE id = :id");
        $stmt->execute([':id' => $activity_id]);
        $activity_title = $stmt->fetchColumn();

        // Success Page
        echo '<!DOCTYPE html><html lang="th"><head><meta charset="UTF-8"><title>ลงทะเบียนสำเร็จ</title>';
        echo '<link rel="stylesheet" href="css/main.css">';
        echo '<style>body { display: flex; justify-content: center; align-items: center; height: 100vh; background: var(--bg-secondary); text-align: center; }</style>';
        echo '</head><body>';
        echo '<div style="background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">';
        echo '<h2 style="color: var(--primary-color);">ขอบคุณสำหรับการลงทะเบียน!</h2>';
        echo '<p>ชื่อ: <strong>' . htmlspecialchars($name) . '</strong></p>';
        echo '<p>กิจกรรม: <strong>' . htmlspecialchars($activity_title) . '</strong></p>';
        echo '<p>คุณจะได้รับใบเกียรติบัตรทางอีเมลหลังจากกิจกรรมเสร็จสิ้น</p>';
        echo '<a href="index.php" class="btn-primary" style="display: inline-block; margin-top: 20px; text-decoration: none; padding: 10px 20px; background: #667eea; color: white; border-radius: 8px;">กลับสู่หน้าแรก</a>';
        echo '</div>';
        echo '</body></html>';

    } catch (PDOException $e) {
        die("เกิดข้อผิดพลาด: " . $e->getMessage());
    }

} else {
    header('Location: index.php');
    exit;
}
?>
