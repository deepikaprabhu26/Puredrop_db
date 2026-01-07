<?php
// fetch_tanks.php
include '../config.php';

// Fetch ALL tanks (No LIMIT 6) so 7+ tanks show up
$res = $conn->query("SELECT * FROM tanks ORDER BY id ASC");

if ($res->num_rows > 0) {
    while($tank = $res->fetch_assoc()) {
        $level = $tank['water_level'];
        $color = ($level <= 20) ? "#ef4444" : "#0ea5e9"; // Red if low (matching your Lab Tank image)
        
        echo "
        <div class='tank-card' onclick=\"location.href='tank-details.php?id={$tank['id']}'\">
            <img src='https://cdn-icons-png.flaticon.com/512/3105/3105807.png' class='tank-img' alt='tank'>
            <h3 style='margin: 10px 0;'>{$tank['name']}</h3>
            <p style='color:#94a3b8; font-size: 0.9rem;'>{$tank['location']}</p>
            <div class='progress-bg'>
                <div class='progress-fill' style='width:{$level}%; background:{$color};'></div>
            </div>
            <p style='font-weight: bold;'>Level: {$level}%</p>
        </div>";
    }
} else {
    echo "<p>No tanks found in system.</p>";
}
?>