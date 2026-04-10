<?php
require_once 'db_connect.php';
echo "DB Team Count: " . $db_team->count() . "\n";
print_r($db_team->all());
?>
