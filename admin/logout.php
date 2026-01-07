<?php
include '../config.php'; // Required for session_start()
session_unset();
session_destroy();
header("Location: login.php"); // Redirects back to login page
exit();
?>