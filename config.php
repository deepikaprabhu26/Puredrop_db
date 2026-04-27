<?php
// config.php
$servername = "sql309.infinityfree.com";
$username = "if0_41761361";
$password = "nideepreethee";
$dbname = "if0_41761361_puredrop_db";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>