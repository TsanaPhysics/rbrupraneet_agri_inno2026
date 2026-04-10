<?php
// db_connect.php - Switch to JSON Database
require_once 'includes/json_db.php';

// Initialize JSON "Tables"
$db_admins = new JSONDB('admins');
$db_kb = new JSONDB('knowledge_base'); // Legacy Q&A
$db_notebook = new JSONDB('notebook_sources'); // New NotebookLM-style Sources
$db_activities = new JSONDB('activities');
$db_team = new JSONDB('team_members');
?>
