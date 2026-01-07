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

// Session Protection
if(!isset($_SESSION['admin'])) { 
    header("Location: login.php"); 
    exit(); 
}

// 1. Database Queries: Get Real-time counts for the Doughnut Chart
$student_query = $conn->query("SELECT COUNT(*) as count FROM users WHERE role = 'Student'");
$student_count = $student_query ? $student_query->fetch_assoc()['count'] : 0;

$staff_query = $conn->query("SELECT COUNT(*) as count FROM users WHERE role = 'Staff'");
$staff_count = $staff_query ? $staff_query->fetch_assoc()['count'] : 0;

$total_users = $student_count + $staff_count;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Water Analytics | Pure Drop </title>
    <link rel="stylesheet" href="../style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { display: flex; margin: 0; background: #0f172a; color: white; font-family: 'Segoe UI', sans-serif; }
        .sidebar { width: 260px; background: #1e293b; height: 100vh; position: fixed; border-right: 1px solid #334155; }
        .main-content { margin-left: 260px; flex-grow: 1; padding: 40px; }
        .row { display: flex; gap: 20px; margin-bottom: 30px; }
        .chart-box { background: #1e293b; border-radius: 15px; padding: 25px; border: 1px solid #334155; flex: 1; text-align: center; }
        .chart-box h3 { margin-top: 0; color: white; font-size: 1.1rem; border-bottom: 1px solid #334155; padding-bottom: 10px; margin-bottom: 20px; }
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
    <h1 style="margin-bottom: 10px;">Water Usage Analytics</h1>
    <p style="color:#94a3b8; margin-bottom: 30px;">System consumption and user demographics.</p>
    
    <div class="stats-summary-bar" style="display: grid; grid-template-columns: repeat(6, 1fr); gap: 15px; margin-bottom: 30px;">
        <div class="summary-card" style="background: #1e293b; padding: 15px; border-radius: 12px; border: 1px solid #334155; text-align: center;">
            <p style="font-size: 0.7rem; color: #94a3b8; text-transform: uppercase;">Active Users</p>
            <h3 style="color: #0ea5e9;"><?php echo $total_users; ?></h3>
        </div>
        </div>

    <div class="row">
        <div class="chart-box">
            <h3>Users by Role</h3>
            <div style="position: relative; height:300px;">
                <canvas id="roleDoughnut"></canvas>
            </div>
            <p style="color:#94a3b8; margin-top:15px;">Total Users: <?php echo $total_users; ?></p>
        </div>

        <div class="chart-box">
            <h3>Daily Logins</h3>
            <div style="position: relative; height:300px;">
                <canvas id="loginAreaChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    
    // 1. ROLE DOUGHNUT CHART
    const roleCtx = document.getElementById('roleDoughnut').getContext('2d');
    new Chart(roleCtx, {
        type: 'doughnut',
        data: {
            labels: ['Students', 'Staff'],
            datasets: [{
                data: [<?php echo (int)$student_count; ?>, <?php echo (int)$staff_count; ?>],
                backgroundColor: ['#0ea5e9', '#1e293b'],
                borderColor: '#334155',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { color: '#94a3b8' } }
            },
            cutout: '70%'
        }
    });

    // 2. DAILY LOGINS AREA CHART
    const loginCtx = document.getElementById('loginAreaChart').getContext('2d');
    new Chart(loginCtx, {
        type: 'line',
        data: {
            labels: ['6am', '8am', '10am', '12pm', '2pm', '4pm', '6pm'],
            datasets: [{
                label: 'Logins',
                data: [8, 25, 42, 38, 22, 28, 12],
                borderColor: '#34d399',
                backgroundColor: 'rgba(52, 211, 153, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { grid: { color: '#334155' }, ticks: { color: '#94a3b8' } },
                x: { grid: { display: false }, ticks: { color: '#94a3b8' } }
            }
        }
    });
});
</script>
</body>
</html>

