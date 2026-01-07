<?php
include '../config.php';

if(isset($_POST['msg'])) {
    $userMsg = strtolower(mysqli_real_escape_string($conn, $_POST['msg']));
    $username = $_SESSION['username'] ?? 'Guest';
    $response = "I can only answer queries regarding water levels, hygiene safety, and cleaning schedules. For other matters, please contact admin.";
    $status = "Rejected";

    // 1. Specific Tank & Water Level Queries
    if (strpos($userMsg, 'level') !== false || strpos($userMsg, 'status') !== false || strpos($userMsg, 'available') !== false || strpos($userMsg, 'tank') !== false) {
        
        // Fetch all tanks to check for specific matches
        $res = $conn->query("SELECT * FROM tanks");
        $all_tanks = [];
        $matched_tank = null;

        while($row = $res->fetch_assoc()) {
            $all_tanks[] = $row;
            // Check if the specific tank name exists in the user's message
            if (strpos($userMsg, strtolower($row['name'])) !== false) {
                $matched_tank = $row;
                break; // Stop at first match
            }
        }

        if ($matched_tank) {
            // Provide info for the specific tank requested
            $response = "The " . $matched_tank['name'] . " is currently at " . $matched_tank['water_level'] . "%. Status: " . $matched_tank['status'] . ".";
        } else {
            // Provide general overview if no specific tank is mentioned
            $response = "Current Water Levels: ";
            $tanks_info = [];
            foreach ($all_tanks as $t) {
                $tanks_info[] = $t['name'] . " (" . $t['water_level'] . "%)";
            }
            $response .= implode(", ", $tanks_info) . ".";
        }
        $status = "Answered";
    } 
    // 2. Hygiene & Safety Queries
    elseif (strpos($userMsg, 'hygiene') !== false || strpos($userMsg, 'safe') !== false || strpos($userMsg, 'clean') !== false) {
        $response = "We maintain high hygiene standards. Tanks are treated with multi-stage filtration and chlorination to ensure drinking water is 100% safe.";
        $status = "Answered";
    }
    // 3. Cleaning Schedule Queries
    elseif (strpos($userMsg, 'schedule') !== false || strpos($userMsg, 'when') !== false || strpos($userMsg, 'date') !== false) {
        $response = "Our automated cleaning cycles are performed twice a week, every Sunday and Thursday.";
        $status = "Answered";
    }

    // MANDATORY: Save interaction to database for Admin Portal
    $conn->query("INSERT INTO chatbot_queries (username, question, response, status) 
                  VALUES ('$username', '$userMsg', '$response', '$status')");

    echo $response;
}
?>