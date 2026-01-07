<?php 
// 1. Establish database connection
include '../config.php'; 

$error_msg = "";
$success_msg = "";

if(isset($_POST['signup'])){
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $reg_code = $_POST['reg_code'];

    // 2. Validate Registration Requirements
    if($reg_code !== "12345678") {
        $error_msg = "Invalid Admin Registration Code. Access Denied.";
    } elseif (strpos($email, 'admin') === false) {
        $error_msg = "Admin email must contain the keyword 'admin' (e.g., admin@puredrop.edu).";
    } elseif ($password !== $confirm_password) {
        $error_msg = "Passwords do not match.";
    } elseif (strlen($password) < 8) {
        $error_msg = "Password must be at least 8 characters long.";
    } else {
        // 3. Check if email already exists
        $checkEmail = $conn->query("SELECT id FROM admins WHERE email = '$email'");
        if($checkEmail->num_rows > 0) {
            $error_msg = "An account with this email already exists.";
        } else {
            // 4. Securely hash password and save to XAMPP database
            $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO admins (fullname, email, password) VALUES ('$fullname', '$email', '$hashed_pass')";
            
            if($conn->query($query)) {
                $success_msg = "Account created successfully! Redirecting to login...";
                header("refresh:2;url=login.php");
            } else {
                $error_msg = "Database error: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration | Pure Drop</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #0f172a;
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            color: white;
        }
        .signup-container {
            background: #1e293b;
            padding: 35px;
            border-radius: 15px;
            width: 450px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
            border: 1px solid #334155;
        }
        .signup-container h2 {
            color: #0ea5e9;
            margin-bottom: 5px;
            text-align: center;
        }
        .signup-container p.subtitle {
            text-align: center;
            color: #94a3b8;
            font-size: 0.9rem;
            margin-bottom: 25px;
        }
        .notice-box {
            background: rgba(239, 68, 68, 0.1);
            border-left: 4px solid #ef4444;
            padding: 10px;
            margin-bottom: 20px;
            font-size: 0.85rem;
            color: #f87171;
        }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-size: 0.9rem; color: #cbd5e1; }
        .form-group input {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #334155;
            background: #0f172a;
            color: white;
            box-sizing: border-box;
        }
        .req-list {
            font-size: 0.75rem;
            color: #94a3b8;
            margin-top: 10px;
            padding-left: 20px;
        }
        .btn-submit {
            width: 100%;
            padding: 12px;
            background: #0ea5e9;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }
        .btn-submit:hover { background: #0284c7; }
        .msg { padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center; font-size: 0.9rem; }
        .error { background: #7f1d1d; color: #f87171; }
        .success { background: #064e3b; color: #34d399; }
    </style>
</head>
<body>

<div class="signup-container">
    <h2>Admin Portal</h2>
    <p class="subtitle">Secure System Access Registration</p>

    <div class="notice-box">
        <strong>Security Notice:</strong> Admin registration requires authorization. Only authorized personnel with a valid registration code can create accounts.
    </div>

    <?php if($error_msg): ?>
        <div class="msg error"><?php echo $error_msg; ?></div>
    <?php endif; ?>

    <?php if($success_msg): ?>
        <div class="msg success"><?php echo $success_msg; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="fullname" placeholder="Enter your full name" required>
        </div>

        <div class="form-group">
            <label>Admin Email Address</label>
            <input type="email" name="email" placeholder="admin@puredrop.edu" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Min 8 characters" required>
        </div>

        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" placeholder="Repeat password" required>
        </div>

        <div class="form-group">
            <label>Admin Registration Code</label>
            <input type="password" name="reg_code" placeholder="Enter 8-digit code" required>
        </div>

        <button type="submit" name="signup" class="btn-submit">Create Admin Account</button>
    </form>

    <ul class="req-list">
        <li>Email must contain 'admin' keyword.</li>
        <li>Password must be at least 8 characters.</li>
        <li>Valid admin registration code required.</li>
        <li>Direct sign-ups are disabled without authorization.</li>
    </ul>

    <p style="text-align: center; font-size: 0.85rem; margin-top: 20px;">
        Already have an account? <a href="login.php" style="color: #0ea5e9; text-decoration: none;">Login here</a>
    </p>
</div>

</body>
</html>