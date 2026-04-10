<?php
require_once 'db_connect.php';

// Create Admin User
$username = 'admin';
$password = 'aidar2026';
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Check if admin exists
$existing = $db_admins->where('username', $username);

if (empty($existing)) {
    $db_admins->insert([
        'username' => $username,
        'password' => $hashed_password
    ]);
    echo "Admin user created.\n";
} else {
    // Update password
    $admin_id = $existing[0]['id'];
    $db_admins->update($admin_id, ['password' => $hashed_password]);
    echo "Admin user updated.\n";
}

// Seed Activities with Rich Data
$activities = $db_activities->all();
if (empty($activities)) {
    $db_activities->insert([
        'title_th' => 'Climate Data Hacking Workshop',
        'title_en' => 'Climate Data Hacking Workshop',
        'title_cn' => '气候数据分析研讨会',
        'subtitle_th' => 'ถอดรหัสสภาพอากาศด้วย Python',
        'description_th' => 'เรียนรู้การเขียนโค้ดพื้นฐานเพื่อวิเคราะห์ข้อมูลสภาพอากาศจริง ค้นหาแนวโน้มความเสี่ยงต่าง ๆ เช่น ภาวะฝนทิ้งช่วง',
        'icon' => '🌦️',
        'image' => 'assets/images/activities/activity_climate_data.png'
    ]);
    $db_activities->insert([
        'title_th' => 'Deep Dive Lab CNN Training Workshop',
        'title_en' => 'Deep Dive Lab CNN Training Workshop',
        'title_cn' => '深度学习 CNN 训练研讨会',
        'subtitle_th' => 'ฝึกสอนโมเดล AI สำหรับวิเคราะห์โรคพืช',
        'description_th' => 'ดำดิ่งสู่โลกของ Computer Vision โดยฝึกสอนโมเดล Convolutional Neural Network (CNN) เพื่อจำแนกภาพถ่ายใบพืช',
        'icon' => '🧠',
        'image' => 'assets/images/activities/activity_ai_training.png'
    ]);
    $db_activities->insert([
        'title_th' => 'AI-IoT Prototyping Workshop',
        'title_en' => 'AI-IoT Prototyping Workshop',
        'title_cn' => 'AI-IoT 原型制作研讨会',
        'subtitle_th' => 'สร้างต้นแบบระบบเกษตรอัจฉริยะ',
        'description_th' => 'เชื่อมโลกซอฟต์แวร์ (AI) เข้ากับโลกฮาร์ดแวร์ (IoT) เรียนรู้การติดตั้งเซ็นเซอร์วัดความชื้นดิน',
        'icon' => '⚙️',
        'image' => 'assets/images/activities/activity_iot_workshop.png'
    ]);
    $db_activities->insert([
        'title_th' => 'RBRU-Praneet Tech Showcase',
        'title_en' => 'RBRU-Praneet Tech Showcase',
        'title_cn' => 'RBRU-Praneet 科技展示会',
        'subtitle_th' => 'นำเสนอต้นแบบนวัตกรรมเกษตรดิจิทัล',
        'description_th' => 'เวทีปล่อยของให้นักเรียนได้นำเสนอต้นแบบนวัตกรรมเกษตรดิจิทัลสู้โลกรวน',
        'icon' => '🏆',
        'image' => 'assets/images/activities/activity_showcase.png'
    ]);
    echo "Rich activities seeded.\n";
}

// Seed Team
$db_team = new JSONDB('team_members'); // New Table
if ($db_team->count() == 0) {
    $db_team->insert([
        'name' => 'ผู้ช่วยศาสตราจารย์ ดร.ชีวะ ทัศนา',
        'role' => 'หัวหน้าโครงการ',
        'department' => 'คณะวิทยาศาสตร์และเทคโนโลยี',
        'image' => 'assets/images/team/chewa.png'
    ]);
    $db_team->insert([
        'name' => 'ผู้ช่วยศาสตราจารย์ ดร.จิรภัทร จันทมาลี',
        'role' => 'ผู้ร่วมโครงการ',
        'department' => 'คณะวิทยาศาสตร์และเทคโนโลยี',
        'image' => 'assets/images/team/jiraphat.png'
    ]);
    $db_team->insert([
        'name' => 'ผู้ช่วยศาสตราจารย์ ดร.วิกันยา ประทุมยศ',
        'role' => 'ผู้ร่วมโครงการ',
        'department' => 'คณะเทคโนโลยีการเกษตร',
        'image' => 'assets/images/team/wikanya.png'
    ]);
    echo "Team seeded.\n";
}

echo "Setup Complete.";
?>
