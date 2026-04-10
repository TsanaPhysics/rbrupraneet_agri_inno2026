<?php
require_once 'db_connect.php';

// 1. Update Existing Roles
$updates = [
    1 => ['role' => 'หัวหน้าโครงการ'],
    2 => ['role' => 'ผู้ร่วมโครงการ'],
    3 => ['role' => 'ผู้ร่วมโครงการ'],
    4 => ['role' => 'ผู้ร่วมโครงการ']
];

foreach ($updates as $id => $data) {
    // Check if exists first to avoid error
    if($db_team->find($id)) {
        $db_team->update($id, $data);
    }
}

// 2. Add Missing Director (Chaiwat) if not exists
// Assuming image path assets/images/team/chaiwat.png exists
$chaiwat = $db_team->where('image', 'assets/images/team/chaiwat.png');
if (empty($chaiwat)) {
    $db_team->insert([
        'name' => 'นายชัยวัฒน์ (ผอ.โรงเรียนประณีตฯ)', // Placeholder Name
        'role' => 'ที่ปรึกษาโครงการ',
        'department' => 'โรงเรียนประณีตวิทยาคม',
        'image' => 'assets/images/team/chaiwat.png'
    ]);
}

// 3. Add Missing Teacher (Surapa) if not exists
// Assuming image path assets/images/team/surapa.png exists
$surapa = $db_team->where('image', 'assets/images/team/surapa.png');
if (empty($surapa)) {
    $db_team->insert([
        'name' => 'ครูสุรภา (ครูโรงเรียนประณีตฯ)', // Placeholder Name
        'role' => 'ผู้ร่วมโครงการ (ฝ่ายโรงเรียน)',
        'department' => 'โรงเรียนประณีตวิทยาคม',
        'image' => 'assets/images/team/surapa.png'
    ]);
}

echo "Team Updated:\n";
print_r($db_team->all());
?>
