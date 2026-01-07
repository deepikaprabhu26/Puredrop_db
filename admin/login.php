<?php include '../config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Portal Login</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body { display: flex; justify-content: center; align-items: center; height: 100vh; background: #0f172a; }
        .login-box { background: #1e293b; padding: 40px; border-radius: 15px; width: 350px; text-align: center; box-shadow: 0 10px 25px rgba(0,0,0,0.5); }
        .login-box h2 { color: #0ea5e9; margin-bottom: 10px; }
        .login-box input { width: 100%; padding: 12px; margin: 10px 0; border-radius: 8px; border: 1px solid #334155; background: #0f172a; color: white; }
        .login-btn { width: 100%; background: #0ea5e9; font-weight: bold; margin-top: 20px; transition: 0.3s; }
        .login-btn:hover { background: #0284c7; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Admin Portal Login</h2>
        <p style="font-size: 0.8rem; color: #94a3b8;">High Security Area - Authorized Personnel Only</p>
        <form method="POST">
            <input type="email" name="email" placeholder="Admin Email (must contain 'admin')" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login" class="login-btn">Secure Login</button>
        </form>
        <p style="font-size: 0.8rem; margin-top: 20px;">Need an account? <a href="signup.php" style="color: #0ea5e9;">Register here</a></p>
    </div>
</body>
</html>

<?php
if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $res = $conn->query("SELECT * FROM admins WHERE email='$email'");
    if($user = $res->fetch_assoc()){
        if(password_verify($password, $user['password'])){
            $_SESSION['admin'] = $user['fullname'];
            header("Location: dashboard.php");
        } else { echo "<script>alert('Invalid Password');</script>"; }
    } else { echo "<script>alert('Admin not found');</script>"; }
}
?>