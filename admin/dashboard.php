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

// Fetch dynamic statistics for the top 6-card bar
$user_res = $conn->query("SELECT COUNT(*) as c FROM users");
$u_count = $user_res->fetch_assoc()['c'];

$low_res = $conn->query("SELECT COUNT(*) as c FROM tanks WHERE water_level < 30");
$low_tanks = $low_res->fetch_assoc()['c'];

$query_res = $conn->query("SELECT COUNT(*) as c FROM chatbot_queries");
$q_count = $query_res->fetch_assoc()['c'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | Pure Drop</title>
    <link rel="stylesheet" href="../style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    <h1 style="margin-bottom: 30px;">Admin Dashboard Overview</h1>

    <div class="stats-grid">
        <div class="stat-card"><p>Active Users</p><h3><?php echo $u_count; ?></h3></div>
        <div class="stat-card"><p>Total Tanks</p><h3>6</h3></div>
        <div class="stat-card"><p>Low Level</p><h3><?php echo $low_tanks; ?></h3></div>
        <div class="stat-card"><p>Chat Queries</p><h3><?php echo $q_count; ?></h3></div>
        <div class="stat-card"><p>Cleaning Today</p><h3>1</h3></div>
        <div class="stat-card"><p>System Uptime</p><h3>99.8%</h3></div>
    </div>

    <div class="row">
        <div class="box">
            <h3>Water Levels Overview</h3>
            <canvas id="levelChart" height="220"></canvas>
        </div>
        <div class="box">
            <h3>Daily Water Usage (Liters)</h3>
            <canvas id="usageChart" height="220"></canvas>
        </div>
    </div>

    <div class="row">
        <div class="box" style="flex: 1.5;">
            <h3>Recent User Activity</h3>
            <table>
                <thead>
                    <tr><th>Name</th><th>Role</th><th>Class</th><th>Login Time</th></tr>
                </thead>
                <tbody>
                    <?php
                    $users = $conn->query("SELECT * FROM users ORDER BY login_time DESC LIMIT 5");
                    while($u = $users->fetch_assoc()){
                        echo "<tr>
                            <td>{$u['fullname']}</td>
                            <td>{$u['role']}</td>
                            <td>{$u['class_name']}</td>
                            <td>{$u['login_time']}</td>
                        </tr>";
                    } ?>
                </tbody>
            </table>
        </div>

        <div class="box">
            <h3>Tank Status Overview</h3>
            <table>
                <thead>
                    <tr><th>Tank</th><th>Status</th></tr>
                </thead>
                <tbody>
                    <?php
                    $tanks = $conn->query("SELECT name, status FROM tanks LIMIT 5");
                    while($t = $tanks->fetch_assoc()){
                        echo "<tr>
                            <td>{$t['name']}</td>
                            <td>{$t['status']}</td>
                        </tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
// RENDER BAR CHART: Water Levels
const levelCtx = document.getElementById('levelChart').getContext('2d');
new Chart(levelCtx, {
    type: 'bar',
    data: {
        labels: ['Main', 'Library', 'Hostel A', 'Hostel B', 'Sports', 'Admin'],
        datasets: [{
            data: [85, 60, 45, 90, 20, 75], // Dynamically sourced in full version
            backgroundColor: ['#34d399', '#f59e0b', '#f59e0b', '#34d399', '#ef4444', '#34d399']
        }]
    },
    options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, max: 100 } } }
});

// RENDER LINE CHART: Daily Water Usage
const usageCtx = document.getElementById('usageChart').getContext('2d');
new Chart(usageCtx, {
    type: 'line',
    data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
            label: 'Usage (L)',
            data: [7200, 9500, 8100, 10000, 8400, 7900, 9300],
            borderColor: '#0ea5e9',
            backgroundColor: 'rgba(14, 165, 233, 0.1)',
            fill: true,
            tension: 0.4
        }]
    },
    options: { plugins: { legend: { display: false } } }
});
</script>

</body>
</html>