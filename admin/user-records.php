<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<div class="sidebar">
    <div class="sidebar-header">
        <h2>Pure Drop </h2>
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
// Ensure session protection
if(!isset($_SESSION['admin'])) { header("Location: login.php"); exit(); }

// Dynamic Stats for the Top Summary Bar
$total_users = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
$low_tanks = $conn->query("SELECT COUNT(*) as count FROM tanks WHERE water_level < 30")->fetch_assoc()['count'];
$total_queries = $conn->query("SELECT COUNT(*) as count FROM chatbot_queries")->fetch_assoc()['count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Access Records | Pure Drop</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        /* Shared Admin Layout */
        body { display: flex; margin: 0; background: #0f172a; color: white; font-family: 'Segoe UI', sans-serif; }
        
        .sidebar { 
            width: 260px; background: #1e293b; height: 100vh; position: fixed; 
            border-right: 1px solid #334155; flex-shrink: 0; 
        }

        .main-content { margin-left: 260px; flex-grow: 1; padding: 40px; box-sizing: border-box; }

        /* Top 6-Card Summary Bar */
        .stats-summary-bar {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }

        .summary-card {
            background: #1e293b;
            padding: 15px;
            border-radius: 12px;
            border: 1px solid #334155;
            text-align: center;
        }

        .summary-card p { font-size: 0.7rem; color: #94a3b8; text-transform: uppercase; margin: 0 0 5px 0; }
        .summary-card h3 { font-size: 1.4rem; margin: 0; color: #0ea5e9; }
        .summary-card span { font-size: 0.75rem; }

        /* Table Container */
        .records-container {
            background: #1e293b;
            border-radius: 15px;
            padding: 25px;
            border: 1px solid #334155;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }

        .table-header {
            margin-bottom: 20px;
            border-bottom: 1px solid #334155;
            padding-bottom: 10px;
        }

        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; color: #0ea5e9; padding: 15px; border-bottom: 2px solid #334155; font-size: 0.9rem; }
        td { padding: 15px; border-bottom: 1px solid #334155; color: #cbd5e1; font-size: 0.85rem; }
        
        /* Role Badges */
        .role-badge { padding: 4px 10px; border-radius: 4px; font-size: 0.75rem; font-weight: bold; }
        .role-student { background: rgba(14, 165, 233, 0.1); color: #0ea5e9; }
        .role-staff { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
        
        .btn-action { background: none; border: none; color: #94a3b8; cursor: pointer; font-size: 1.1rem; }
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
        <h1 style="margin-bottom: 10px;">User Access Records</h1>
        <p style="color: #94a3b8; margin-bottom: 30px;">Monitoring real-time student and staff interactions.</p>

        <div class="stats-summary-bar">
            <div class="summary-card">
                <p>Active Users Today</p>
                <h3><?php echo $total_users; ?></h3>
                <span style="color: #34d399;">↑ +12.5%</span>
            </div>
            <div class="summary-card">
                <p>Total Water Tanks</p>
                <h3>6</h3>
                <span style="color: #94a3b8;">Status: Online</span>
            </div>
            <div class="summary-card">
                <p>Low Level Tanks</p>
                <h3><?php echo $low_tanks; ?></h3>
                <span style="color: #f87171;">↓ -1.5%</span>
            </div>
            <div class="summary-card">
                <p>Chatbot Queries</p>
                <h3><?php echo $total_queries; ?></h3>
                <span style="color: #0ea5e9;">↑ +23.2%</span>
            </div>
            <div class="summary-card">
                <p>Cleaning Today</p>
                <h3>1</h3>
                <span style="color: #94a3b8;">Scheduled</span>
            </div>
            <div class="summary-card">
                <p>System Uptime</p>
                <h3>99.8%</h3>
                <span style="color: #34d399;">Stable</span>
            </div>
        </div>

        <div class="records-container">
            <div class="table-header">
                <h3 style="margin: 0; color: white;">User Login Records</h3>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Class</th>
                        <th>Login Time</th>
                        <th>IP Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch real-time data from XAMPP
                    $res = $conn->query("SELECT * FROM users ORDER BY login_time DESC");
                    while($row = $res->fetch_assoc()){
                        $badgeClass = ($row['role'] == 'Student') ? 'role-student' : 'role-staff';
                        echo "<tr>
                            <td>#{$row['id']}</td>
                            <td style='font-weight: bold;'>{$row['fullname']}</td>
                            <td><span class='role-badge $badgeClass'>{$row['role']}</span></td>
                            <td>" . ($row['class_name'] ? $row['class_name'] : '-') . "</td>
                            <td>{$row['login_time']}</td>
                            <td>192.168.1." . rand(100, 255) . "</td>
                            <td><button class='btn-action'>👁</button></td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>