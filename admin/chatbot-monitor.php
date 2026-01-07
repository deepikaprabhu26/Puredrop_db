<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<div class="sidebar">
    <div class="sidebar-header">
        <h2>Pure Drop</h2>
    </div>
    <ul class="nav-links">
        <li>
            <a href="dashboard.php" class="<?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
                Dashboard Overview
            </a>
        </li>
        <li>
            <a href="user-records.php" class="<?php echo ($current_page == 'user-records.php') ? 'active' : ''; ?>">
                User Records
            </a>
        </li>
        <li>
            <a href="tank-management.php" class="<?php echo ($current_page == 'tank-management.php') ? 'active' : ''; ?>">
                Tank Management
            </a>
        </li>
        <li>
            <a href="chatbot-monitor.php" class="<?php echo ($current_page == 'chatbot-monitor.php') ? 'active' : ''; ?>">
                Chatbot Monitor
            </a>
        </li>
        <li>
            <a href="water-analytics.php" class="<?php echo ($current_page == 'water-analytics.php') ? 'active' : ''; ?>">
                Water Analytics
            </a>
        </li>
        <li class="logout-link">
            <a href="logout.php">Logout</a>
        </li>
    </ul>
</div>
<?php 
include '../config.php'; 
if(!isset($_SESSION['admin'])) { header("Location: login.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chatbot Monitor | Pure Drop </title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body { display: flex; margin: 0; background: #0f172a; color: white; font-family: 'Segoe UI', sans-serif; }
        .sidebar { width: 260px; background: #1e293b; height: 100vh; position: fixed; border-right: 1px solid #334155; }
        .main-content { margin-left: 260px; flex-grow: 1; padding: 40px; box-sizing: border-box; }
        .data-container { background: #1e293b; border-radius: 15px; padding: 30px; border: 1px solid #334155; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { text-align: left; color: #0ea5e9; padding: 12px; border-bottom: 2px solid #334155; }
        td { padding: 12px; border-bottom: 1px solid #334155; color: #cbd5e1; font-size: 0.85rem; }
        .badge-answered { background: rgba(52, 211, 153, 0.1); color: #34d399; padding: 4px 8px; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="sidebar">
    <h2> Pure Drop</h2>
    <ul class="nav-links">
        <li><a href="dashboard.php" class="active">Dashboard Overview</a></li>
        <li><a href="user-records.php">User Records</a></li>
        <li><a href="tank-management.php">Tank Management</a></li>
        <li><a href="chatbot-monitor.php">Chatbot Monitor</a></li>
        <li><a href="water-analytics.php">Water Analytics</a></li>
        <li><a href="logout.php" style="color: #f87171;">Logout</a></li>
    </ul>
</div>
    <div class="main-content">
        <h1 style="margin-bottom: 30px;">Chatbot Interaction Monitor</h1>
        <div class="data-container">
            <table>
                <thead>
                    <tr><th>User</th><th>Question</th><th>Response</th><th>Status</th><th>Time</th></tr>
                </thead>
                <tbody>
                    <?php
                    $res = $conn->query("SELECT * FROM chatbot_queries ORDER BY timestamp DESC");
                    while($row = $res->fetch_assoc()){
                        echo "<tr>
                            <td>{$row['username']}</td>
                            <td>{$row['question']}</td>
                            <td>{$row['response']}</td>
                            <td><span class='badge-answered'>{$row['status']}</span></td>
                            <td>{$row['timestamp']}</td>
                        </tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>