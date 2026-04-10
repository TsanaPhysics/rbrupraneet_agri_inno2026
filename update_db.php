<?php
require_once 'db_connect.php';

try {
    $sql = file_get_contents('database_update.sql');
    $pdo->exec($sql);
    echo "Database updated successfully via SQL file.";
} catch (PDOException $e) {
    echo "Error updating database: " . $e->getMessage();
}
?>
