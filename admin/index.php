<?php
require_once 'auth_check.php';
checkAdminAuth();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        .sidebar {
            height: 100vh;
            background: #1e293b;
            color: white;
            padding-top: 20px;
        }
        .sidebar a {
            color: #cbd5e1;
            text-decoration: none;
            display: block;
            padding: 10px 20px;
        }
        .sidebar a:hover, .sidebar a.active {
            background: #334155;
            color: white;
        }
        .content {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <div class="sidebar col-md-2">
            <h4 class="text-center mb-4">Admin Panel</h4>
            <a href="index.php" class="active"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="manage_notebook.php"><i class="bi bi-journal-text"></i> NotebookLM (AI Brain)</a>
            <a href="manage_activities.php"><i class="bi bi-calendar-event"></i> Activities</a>
            <a href="manage_team.php"><i class="bi bi-people"></i> Team Members</a>
             <a href="manage_kb.php"><i class="bi bi-chat-dots"></i> Simple Q&A (Legacy)</a>
            <a href="logout.php" class="text-danger mt-5"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>
        <div class="content col-md-10">
            <h2>Welcome, <?php echo $_SESSION['admin_user']; ?>!</h2>
            <div class="row mt-4">
                 <div class="col-md-6">
                    <div class="card bg-primary text-white mb-3">
                        <div class="card-body">
                            <h3><i class="bi bi-journal-check"></i> NotebookLM System</h3>
                            <p>Manage the AI's "Brain". Upload notes, articles, or text for the AI to learn from.</p>
                            <a href="manage_notebook.php" class="btn btn-light">Manage Knowledge Warehouse</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white mb-3">
                        <div class="card-body">
                            <h5>Activities</h5>
                            <p>Manage Events</p>
                            <a href="manage_activities.php" class="btn btn-light btn-sm">Manage</a>
                        </div>
                    </div>
                </div>
                 <div class="col-md-3">
                    <div class="card bg-info text-white mb-3">
                        <div class="card-body">
                            <h5>Team Members</h5>
                            <p>Manage Team</p>
                            <a href="manage_team.php" class="btn btn-light btn-sm">Manage</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
