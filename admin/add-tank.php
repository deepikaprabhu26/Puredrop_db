<?php 
include '../config.php'; 
if(!isset($_SESSION['admin'])) { header("Location: login.php"); exit(); }

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $level = intval($_POST['level']);
    
    // id is excluded so database auto-assigns it (fixes entry '0' error)
    $sql = "INSERT INTO tanks (name, location, water_level, status, last_cleaned, next_cleaning, cleaning_method, autocleaning) 
            VALUES ('$name', '$location', '$level', 'Active', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 7 DAY), 'Filtration', 1)";
    
    if($conn->query($sql)){
        header("Location: tank-management.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Tank | Pure Drop</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body { display: flex; justify-content: center; align-items: center; min-height: 100vh; background: #0f172a; }
        .form-box { background: #1e293b; padding: 40px; border-radius: 15px; width: 450px; border: 1px solid #334155; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        input { width: 100%; padding: 12px; margin: 10px 0 20px; background: #0f172a; color: white; border: 1px solid #334155; border-radius: 8px; box-sizing: border-box; }
        button { width: 100%; padding: 15px; background: #0ea5e9; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; font-size: 1rem; }
    </style>
</head>
<body>
    <div class="form-box">
        <h2 style="color: #0ea5e9; text-align: center; margin-bottom: 30px;">Add New Water Tank</h2>
        <form method="POST">
            <label style="color: #94a3b8;">Tank Name</label>
            <input type="text" name="name" placeholder="e.g. Science Block Tank" required>
            
            <label style="color: #94a3b8;">Location</label>
            <input type="text" name="location" placeholder="e.g. Ground Floor" required>
            
            <label style="color: #94a3b8;">Initial Water Level (%)</label>
            <input type="number" name="level" min="0" max="100" required>
            
            <button type="submit">Save Tank to System</button>
            <a href="tank-management.php" style="display: block; text-align: center; color: #94a3b8; margin-top: 20px; text-decoration: none;">Cancel</a>
        </form>
    </div>
</body>
</html>