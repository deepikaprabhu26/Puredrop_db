<?php 
include '../config.php'; 

// Logic to handle the login and store data in XAMPP
if(isset($_POST['login'])){
    $name = mysqli_real_escape_string($conn, $_POST['fullname']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $class = isset($_POST['class']) ? mysqli_real_escape_string($conn, $_POST['class']) : 'N/A';
    
    // Store user login details in the database
    $query = "INSERT INTO users (fullname, role, class_name) VALUES ('$name', '$role', '$class')";
    if(mysqli_query($conn, $query)){
        // Set session for chatbot tracking
        $_SESSION['username'] = $name;
        $_SESSION['role'] = $role;
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Public Access - Pure Drop</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: radial-gradient(circle, #1e293b 0%, #0f172a 100%);
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
        }
        .login-container {
            background: #1e293b;
            padding: 40px;
            border-radius: 20px;
            width: 400px;
            text-align: center;
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
            border: 1px solid #334155;
        }
        .login-container h1 {
            color: #f8fafc;
            margin-bottom: 5px;
            font-size: 2.5rem;
        }
        .login-container p {
            color: #94a3b8;
            margin-bottom: 30px;
        }
        .form-group {
            text-align: left;
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            color: #f8fafc;
            margin-bottom: 8px;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #334155;
            background: #0f172a;
            color: white;
            box-sizing: border-box;
        }
        .role-selection {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }
        .role-btn {
            flex: 1;
            padding: 15px;
            border-radius: 10px;
            border: 2px solid #334155;
            background: #1e293b;
            color: #94a3b8;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }
        .role-btn.active {
            border-color: #0ea5e9;
            background: rgba(14, 165, 233, 0.1);
            color: #0ea5e9;
        }
        .login-submit {
            width: 100%;
            padding: 15px;
            background: #0ea5e9;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }
        .login-submit:hover {
            background: #0284c7;
            transform: translateY(-2px);
        }
        .back-link {
            display: block;
            margin-top: 20px;
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.9rem;
        }
        #class-group {
            display: none;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h1>Public Access</h1>
    <p>Login to access water filter information</p>

    <form method="POST" id="loginForm">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="fullname" placeholder="Enter your full name" required>
        </div>

        <label style="color: #f8fafc; display: block; text-align: left; margin-bottom: 8px; font-weight: bold;">Select Your Role</label>
        <div class="role-selection">
            <button type="button" class="role-btn" id="studentBtn" onclick="selectRole('Student')">Student</button>
            <button type="button" class="role-btn" id="staffBtn" onclick="selectRole('Staff')">Staff</button>
        </div>
        
        <input type="hidden" name="role" id="selectedRole" required>

        <div class="form-group" id="class-group">
            <label>Class/Section</label>
            <input type="text" name="class" placeholder="e.g. B.Tech CS - A">
        </div>

        <button type="submit" name="login" class="login-submit">Continue to Dashboard</button>
    </form>

    <a href="../portal-selection.php" class="back-link">Back to Portal Selection</a>
</div>

<script>
    function selectRole(role) {
        document.getElementById('selectedRole').value = role;
        
        // Toggle active button styles
        document.getElementById('studentBtn').classList.remove('active');
        document.getElementById('staffBtn').classList.remove('active');
        
        if(role === 'Student') {
            document.getElementById('studentBtn').classList.add('active');
            document.getElementById('class-group').style.display = 'block';
        } else {
            document.getElementById('staffBtn').classList.add('active');
            document.getElementById('class-group').style.display = 'none';
        }
    }
</script>

</body>
</html>