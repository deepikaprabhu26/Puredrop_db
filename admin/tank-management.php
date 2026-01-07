<?php 
include '../config.php'; 

// Session Protection
if(!isset($_SESSION['admin'])) { 
    header("Location: login.php"); 
    exit(); 
}

// 1. Unified Real-Time Data Queries
$active_user_query = $conn->query("SELECT COUNT(*) as count FROM users");
$active_users = $active_user_query ? $active_user_query->fetch_assoc()['count'] : 0;

$total_tanks_query = $conn->query("SELECT COUNT(*) as count FROM tanks");
$total_tanks = $total_tanks_query ? $total_tanks_query->fetch_assoc()['count'] : 0;

$low_level_query = $conn->query("SELECT COUNT(*) as count FROM tanks WHERE water_level < 30");
$low_level_count = $low_level_query ? $low_level_query->fetch_assoc()['count'] : 0;

$chat_query = $conn->query("SELECT COUNT(*) as count FROM chatbot_queries");
$total_queries = $chat_query ? $chat_query->fetch_assoc()['count'] : 0;

// Handle Delete Logic
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM tanks WHERE id = $id");
    header("Location: tank-management.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Water Tank Management | Pure Drop</title>
    <link rel="stylesheet" href="../style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { display: flex; margin: 0; background: #0f172a; color: white; font-family: 'Segoe UI', sans-serif; }
        .sidebar { width: 260px; background: #1e293b; height: 100vh; position: fixed; border-right: 1px solid #334155; }
        .main-content { margin-left: 260px; flex-grow: 1; padding: 40px; box-sizing: border-box; }
        
        /* Stats Summary Bar */
        .stats-summary-bar { display: grid; grid-template-columns: repeat(6, 1fr); gap: 15px; margin-bottom: 30px; }
        .summary-card { background: #1e293b; padding: 15px; border-radius: 12px; border: 1px solid #334155; text-align: center; }
        .summary-card p { font-size: 0.7rem; color: #94a3b8; text-transform: uppercase; margin: 0 0 5px; }
        .summary-card h3 { font-size: 1.4rem; margin: 0; color: #0ea5e9; }

        /* Manage Table Styling */
        .management-container { background: #1e293b; border-radius: 15px; padding: 30px; border: 1px solid #334155; overflow-x: auto; }
        .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        
        table { width: 100%; border-collapse: collapse; min-width: 900px; }
        th { text-align: left; color: #0ea5e9; padding: 12px; border-bottom: 2px solid #334155; font-size: 0.85rem; }
        td { padding: 12px; border-bottom: 1px solid #334155; color: #cbd5e1; font-size: 0.85rem; vertical-align: middle; }
        
        .edit-input { background: #0f172a; color: white; border: 1px solid #334155; border-radius: 4px; padding: 8px; width: 100%; box-sizing: border-box; }
        .edit-input:focus { border-color: #0ea5e9; outline: none; }
        
        .btn-save { background: rgba(14, 165, 233, 0.1); color: #0ea5e9; border: 1px solid #0ea5e9; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-weight: bold; transition: 0.3s; margin-right: 5px; }
        .btn-save:hover { background: #0ea5e9; color: white; }
        
        .btn-delete { background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid #ef4444; padding: 6px 12px; border-radius: 4px; cursor: pointer; transition: 0.3s; }
        .btn-delete:hover { background: #ef4444; color: white; }
    </style>
</head>
<body>

<?php include 'admin_sidebar.php'; ?>

<div class="main-content">
    <h1 style="margin-bottom: 30px;">Water Tank Management</h1>

    <div class="stats-summary-bar">
        <div class="summary-card"><p>Active Users</p><h3><?php echo $active_users; ?></h3></div>
        <div class="summary-card"><p>Total Tanks</p><h3><?php echo $total_tanks; ?></h3></div>
        <div class="summary-card"><p>Low Level</p><h3><?php echo $low_level_count; ?></h3></div>
        <div class="summary-card"><p>Chat Queries</p><h3><?php echo $total_queries; ?></h3></div>
        <div class="summary-card"><p>Cleaning Today</p><h3>1</h3></div>
        <div class="summary-card"><p>System Uptime</p><h3>99.8%</h3></div>
    </div>

    <div class="management-container">
        <div class="header-flex">
            <h2 style="margin: 0; color: white;">Manage Water Tanks</h2>
            <button onclick="location.href='add-tank.php'" style="background: #0ea5e9; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-weight: bold;">+ Add New Tank</button>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">ID</th>
                    <th style="width: 20%;">Tank Name</th>
                    <th style="width: 10%;">Level %</th>
                    <th style="width: 15%;">Status</th>
                    <th style="width: 15%;">Cleaning Method</th> <th style="width: 15%;">Last Cleaned</th>
                    <th style="width: 15%;">Next Cleaning</th>
                    <th style="width: 20%;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $res = $conn->query("SELECT * FROM tanks ORDER BY id ASC");
                while($row = $res->fetch_assoc()){
                    // Ensure cleaning_method defaults to something if empty
                    $method = $row['cleaning_method'] ?? 'Filtration';
                    
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td><input type='text' id='name_{$row['id']}' value='{$row['name']}' class='edit-input'></td>
                        <td><input type='number' id='lvl_{$row['id']}' value='{$row['water_level']}' class='edit-input'></td>
                        <td>
                            <select id='status_{$row['id']}' class='edit-input'>
                                <option value='Active' ".($row['status']=='Active'?'selected':'').">Active</option>
                                <option value='Cleaning' ".($row['status']=='Cleaning'?'selected':'').">Cleaning</option>
                                <option value='Maintenance' ".($row['status']=='Maintenance'?'selected':'').">Maintenance</option>
                                <option value='Empty' ".($row['status']=='Empty'?'selected':'').">Empty</option>
                            </select>
                        </td>
                        <td>
                            <select id='method_{$row['id']}' class='edit-input'>
                                <option value='Filtration' ".($method=='Filtration'?'selected':'').">Filtration</option>
                                <option value='Chlorination' ".($method=='Chlorination'?'selected':'').">Chlorination</option>
                                <option value='Manual Scrubbing' ".($method=='Manual Scrubbing'?'selected':'').">Manual Scrubbing</option>
                                <option value='UV Treatment' ".($method=='UV Treatment'?'selected':'').">UV Treatment</option>
                                <option value='Boiling' ".($method=='Boiling'?'selected':'').">Boiling</option>
                            </select>
                        </td>
                        <td><input type='date' id='last_{$row['id']}' value='{$row['last_cleaned']}' class='edit-input'></td>
                        <td><input type='date' id='next_{$row['id']}' value='{$row['next_cleaning']}' class='edit-input'></td>
                        <td>
                            <button class='btn-save' onclick='updateTank({$row['id']})'>Save</button>
                            <button class='btn-delete' onclick='if(confirm(\"Are you sure?\")) location.href=\"?delete={$row['id']}\"'>Delete</button>
                        </td>
                    </tr>";
                } ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function updateTank(id) {
    var data = {
        id: id,
        name: $('#name_' + id).val(),
        lvl: $('#lvl_' + id).val(),
        status: $('#status_' + id).val(),
        method: $('#method_' + id).val(), // Catching the new method value
        last: $('#last_' + id).val()
    };

    $.post('update-tank-logic.php', data, function(response) {
        // Optional: console.log(response) for debugging
        alert("Tank details updated successfully!");
        location.reload();
    }).fail(function() {
        alert("Error saving data.");
    });
}
</script>

</body>
</html>