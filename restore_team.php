<?php
require_once 'db_connect.php';

// Check if Natee exists
$natee = $db_team->where('name', 'ผศ.นที ยงยุทธ');

if (empty($natee)) {
    $db_team->insert([
        'name' => 'ผศ.นที ยงยุทธ',
        'role' => 'ผู้ร่วมโครงการ', // Or กรรมการ
        'department' => 'คณะครุศาสตร์',
        'image' => 'assets/images/team/natee.png'
    ]);
    echo "Added Natee to team.\n";
} else {
    echo "Natee already exists.\n";
}

echo "Current Team:\n";
print_r($db_team->all());
?>
