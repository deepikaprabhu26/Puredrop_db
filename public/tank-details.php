<?php 
include '../config.php'; 
if(!isset($_GET['id'])) { header("Location: dashboard.php"); exit(); }
$id = mysqli_real_escape_string($conn, $_GET['id']);
$tank = $conn->query("SELECT * FROM tanks WHERE id = '$id'")->fetch_assoc();
if(!$tank) { echo "Tank not found."; exit(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pure Drop | Tank Details</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body { background: #0f172a; color: white; font-family: 'Segoe UI', sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .details-card { background: #1e293b; border-radius: 20px; width: 900px; display: flex; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.5); border: 1px solid #334155; }
        
        /* Left Side: Visuals */
        .visual-panel { flex: 1; background: #111827; padding: 40px; text-align: center; border-right: 1px solid #334155; }
        .tank-visual { width: 180px; height: 280px; border: 4px solid #f8fafc; border-top: none; margin: 0 auto 30px; position: relative; border-radius: 0 0 20px 20px; overflow: hidden; background: #0f172a; }
        .water-fill { position: absolute; bottom: 0; width: 100%; background: linear-gradient(to top, #0ea5e9, #38bdf8); transition: height 2s ease-in-out; }
        .water-fill::after { content: ""; position: absolute; top: -10px; left: 0; width: 200%; height: 20px; background: rgba(255,255,255,0.2); border-radius: 50%; animation: wave 2s infinite linear; }
        @keyframes wave { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
        
        /* Right Side: Data */
        .info-panel { flex: 1.5; padding: 40px; }
        .badge-status { display: inline-block; padding: 5px 15px; border-radius: 20px; background: #064e3b; color: #34d399; font-weight: bold; font-size: 0.8rem; margin-bottom: 10px; }
        .data-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 25px; }
        .data-item label { color: #94a3b8; font-size: 0.75rem; text-transform: uppercase; }
        .data-item p { margin: 5px 0; font-weight: bold; color: #f8fafc; }
        
        .methods-box { margin-top: 30px; background: #0f172a; padding: 20px; border-radius: 12px; border: 1px solid #334155; }
        .methods-box h4 { margin: 0 0 10px; color: #0ea5e9; font-size: 0.9rem; }
        .methods-box p { font-size: 0.85rem; line-height: 1.6; color: #cbd5e1; margin: 0; }
        .btn-back { display: block; width: 100%; margin-top: 30px; padding: 12px; background: #0ea5e9; color: white; text-align: center; text-decoration: none; border-radius: 8px; font-weight: bold; transition: 0.3s; }
        .btn-back:hover { background: #0284c7; }
    </style>
</head>
<body>
    <div class="details-card">
        <div class="visual-panel">
            <h3 style="color: #0ea5e9; margin-top: 0;">Real-time Level</h3>
            <div class="tank-visual">
                <div class="water-fill" style="height: <?php echo $tank['water_level']; ?>%;"></div>
            </div>
            <h1 style="font-size: 3.5rem; margin: 0;"><?php echo $tank['water_level']; ?>%</h1>
            <p style="color: #94a3b8;">Current Capacity</p>
        </div>
        <div class="info-panel">
            <span class="badge-status"><?php echo $tank['status']; ?></span>
            <h1 style="margin: 5px 0 0;"><?php echo $tank['name']; ?></h1>
            <p style="color: #94a3b8; margin-top: 5px;"><?php echo $tank['location']; ?></p>

            <div class="data-grid">
                <div class="data-item"><label>Last Cleaned</label><p><?php echo $tank['last_cleaned']; ?></p></div>
                <div class="data-item"><label>Next Cleaning</label><p><?php echo $tank['next_cleaning']; ?></p></div>
                <div class="data-item"><label>Method</label><p><?php echo $tank['cleaning_method']; ?></p></div>
                <div class="data-item"><label>Auto-Clean</label><p><?php echo $tank['autocleaning'] ? 'ENABLED ✓' : 'DISABLED ✗'; ?></p></div>
            </div>

            <div class="methods-box">
                <h4>System Insights</h4>
                <p>Ensuring transparency through intelligent monitoring. Our <b><?php echo $tank['cleaning_method']; ?></b> method removes sediments and neutralizes bacterial growth to maintain safe drinking standards.</p>
            </div>
            <a href="dashboard.php" class="btn-back">Back to Overview</a>
        </div>
    </div>
</body>
</html>