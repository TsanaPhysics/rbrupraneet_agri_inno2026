<?php
require_once 'db_connect.php';

// Correct Names and Roles based on Web Search + User Feedback
$updates = [
    // Existing members (IDs 1-4)
    5 => [
        'name' => 'นายไชยวัฒน์ ปาเชนทร์',
        'role' => 'ผู้ร่วมโครงการ (ครูโรงเรียนประณีตฯ)',
        'department' => 'โรงเรียนประณีตวิทยาคม'
    ],
    6 => [
        'name' => 'ผอ.สุรภา เอื้อนไธสง', 
        'role' => 'ที่ปรึกษาโครงการ / ผู้อำนวยการ',
        'department' => 'โรงเรียนประณีตวิทยาคม'
    ]
];

foreach ($updates as $id => $data) {
    if($db_team->find($id)) {
        $db_team->update($id, $data);
    }
}
// Double check images matches correct person now
// ID 5 (Chaiwat) -> assets/images/team/chaiwat.png
// ID 6 (Surapa) -> assets/images/team/surapa.png

echo "Team Roles Corrected:\n";
print_r($db_team->all());
?>
