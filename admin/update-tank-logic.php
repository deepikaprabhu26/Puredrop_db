<?php
include '../config.php';

if(isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $lvl = intval($_POST['lvl']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $method = mysqli_real_escape_string($conn, $_POST['method']); // New Field
    $last = mysqli_real_escape_string($conn, $_POST['last']);

    // Update query including cleaning_method
    $sql = "UPDATE tanks SET 
            name = '$name', 
            water_level = '$lvl', 
            status = '$status', 
            cleaning_method = '$method', 
            last_cleaned = '$last' 
            WHERE id = $id";
    
    if($conn->query($sql)) {
        echo "Success";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>