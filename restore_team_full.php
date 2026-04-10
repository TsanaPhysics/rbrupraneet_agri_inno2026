<?php
require_once 'db_connect.php';

// Update to match original responsible.php exactly
$updates = [
    1 => ['name' => 'ผศ.ดร.ชีวะ ทัศนา', 'role' => 'ประธาน'],
    2 => ['name' => 'ผศ.ดร.จิรภัทร จันทมาลี', 'role' => 'กรรมการ'],
    3 => ['name' => 'ผศ.ดร.วิกันยา ประทุมยศ', 'role' => 'กรรมการ'],
    4 => ['name' => 'ผศ.นที ยงยุทธ', 'role' => 'กรรมการ']
];

foreach ($updates as $id => $data) {
    $db_team->update($id, $data);
}

echo "Team updated to match original data exactly.\n";
print_r($db_team->all());
?>
