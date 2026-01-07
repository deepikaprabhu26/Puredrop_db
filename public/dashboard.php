<?php 
include '../config.php'; 

// Optional: Redirect if not logged in (Uncomment if needed)
// if(!isset($_SESSION['username'])) { header("Location: login.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Pure Drop</title>
    <link rel="stylesheet" href="../style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { background: #0f172a; color: white; font-family: 'Segoe UI', sans-serif; margin: 0; padding-bottom: 60px; }
        
        .dashboard-container { max-width: 1200px; margin: 0 auto; padding: 40px 20px; }
        .header { text-align: center; margin-bottom: 50px; }
        .header h1 { color: #0ea5e9; font-size: 2.5rem; margin: 0; }
        .header p { color: #94a3b8; margin-top: 10px; }

        /* TANK GRID */
        .section-title { color: white; border-left: 5px solid #0ea5e9; padding-left: 15px; margin-bottom: 25px; }
        .tank-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); 
            gap: 25px; 
            margin-bottom: 60px;
        }
        .tank-card { background: #1e293b; padding: 25px; border-radius: 15px; border: 1px solid #334155; text-align: center; transition: 0.3s; }
        .tank-card:hover { transform: translateY(-5px); border-color: #0ea5e9; }
        .progress-bg { background: #0f172a; height: 10px; border-radius: 10px; margin: 15px 0; overflow: hidden; }
        .progress-fill { height: 100%; transition: width 1s; }

        /* HEALTH INFORMATION SECTION (NEW) */
        .health-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }
        .health-card {
            background: #1e293b;
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #334155;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .health-card::before {
            content: ""; position: absolute; top: 0; left: 0; width: 100%; height: 4px; background: #34d399; /* Green for safe */
        }
        .health-card h3 { font-size: 2rem; margin: 10px 0; color: white; }
        .health-card span { font-size: 0.8rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; }
        .status-badge { 
            display: inline-block; padding: 5px 12px; border-radius: 20px; 
            font-size: 0.75rem; font-weight: bold; margin-top: 10px;
            background: rgba(52, 211, 153, 0.1); color: #34d399; 
        }

        /* Responsive */
        @media (max-width: 768px) { .health-grid { grid-template-columns: 1fr 1fr; } }

        /* CHATBOT STYLES */
        #chat-container { position: fixed; bottom: 90px; right: 30px; width: 350px; height: 450px; background: #1e293b; border: 1px solid #334155; border-radius: 15px; display: none; flex-direction: column; z-index: 9999; box-shadow: 0 10px 40px rgba(0,0,0,0.6); }
        #chat-history { flex: 1; padding: 15px; overflow-y: auto; background: #0f172a; display: flex; flex-direction: column; gap: 10px; }
        /* Custom Scrollbar */
        #chat-history::-webkit-scrollbar { width: 5px; }
        #chat-history::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
    </style>
</head>
<body>

<div class="dashboard-container">
    <div class="header">
        <h1>Pure Drop: Smart Water Monitoring</h1>
        <p>Real-time tracking of water availability and quality standards.</p>
    </div>

    <h2 class="section-title">Live Health & Quality Metrics</h2>
    <div class="health-grid">
        <div class="health-card">
            <span>Average pH Level</span>
            <h3>7.4</h3>
            <div class="status-badge">✔ Normal (Safe)</div>
        </div>
        <div class="health-card">
            <span>TDS (PPM)</span>
            <h3>145</h3>
            <div class="status-badge">✔ Excellent</div>
        </div>
        <div class="health-card">
            <span>Turbidity (NTU)</span>
            <h3>0.8</h3>
            <div class="status-badge">✔ Clear</div>
        </div>
        <div class="health-card">
            <span>Coliform Status</span>
            <h3 style="font-size: 1.5rem; margin: 15px 0;">Negative</h3>
            <div class="status-badge">✔ Safe to Drink</div>
        </div>
    </div>

    <h2 class="section-title">Water Tank Levels</h2>
    <div class="tank-grid" id="tank-display-area">
        <?php
        // Fetch Tanks Directly
        $res = $conn->query("SELECT * FROM tanks ORDER BY id ASC");
        if ($res->num_rows > 0) {
            while($tank = $res->fetch_assoc()) {
                $level = $tank['water_level'];
                $color = ($level <= 30) ? "#ef4444" : "#0ea5e9"; // Red if low, Blue if normal
                
                echo "
                <div class='tank-card' onclick=\"location.href='tank-details.php?id={$tank['id']}'\">
                    <h3 style='margin: 0 0 10px; color: #0ea5e9;'>{$tank['name']}</h3>
                    <p style='color:#94a3b8; font-size: 0.9rem; margin-bottom: 15px;'>{$tank['location']}</p>
                    <div class='progress-bg'>
                        <div class='progress-fill' style='width:{$level}%; background:{$color};'></div>
                    </div>
                    <div style='display:flex; justify-content:space-between; font-weight:bold; font-size:0.9rem;'>
                        <span>Level: {$level}%</span>
                        <span style='color:{$color}'>{$tank['status']}</span>
                    </div>
                </div>";
            }
        } else {
            echo "<p style='color: #94a3b8;'>No tank data found.</p>";
        }
        ?>
    </div>
</div>

<div id="chat-container">
    <div style="background: #0ea5e9; padding: 15px; color: white; font-weight: bold; border-radius: 15px 15px 0 0; display: flex; justify-content: space-between;">
        <span>Pure Drop Assistant</span>
        <span onclick="$('#chat-container').fadeOut()" style="cursor: pointer;">&times;</span>
    </div>
    <div id="chat-history">
        <div style="align-self: flex-start; background: #1e293b; color: #cbd5e1; padding: 10px; border-radius: 10px; max-width: 80%; border: 1px solid #334155; font-size: 0.9rem;">
            Hello! Ask me about water quality or tank levels.
        </div>
    </div>
    <div style="padding: 15px; background: #1e293b; border-top: 1px solid #334155; display: flex; gap: 10px;">
        <input type="text" id="chat-input" placeholder="Type here..." style="flex: 1; padding: 10px; border-radius: 5px; border: 1px solid #334155; background: #0f172a; color: white;">
        <button onclick="sendChat()" style="background: #0ea5e9; color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer;">Send</button>
    </div>
</div>

<div onclick="$('#chat-container').fadeIn()" style="position: fixed; bottom: 30px; right: 30px; width: 60px; height: 60px; background: #0ea5e9; border-radius: 50%; display: flex; justify-content: center; align-items: center; cursor: pointer; box-shadow: 0 5px 20px rgba(0,0,0,0.5); z-index: 10000;">
    <span style="font-size: 30px;">💬</span>
</div>

<script>
// Auto-refresh Tanks every 5 seconds
setInterval(function(){
    $('#tank-display-area').load(location.href + ' #tank-display-area > *');
}, 5000);

// Chatbot Logic
function sendChat() {
    let msg = $('#chat-input').val().trim();
    if(msg === "") return;

    $('#chat-history').append(`<div style="align-self: flex-end; background: #0ea5e9; color: white; padding: 10px; border-radius: 10px; max-width: 80%; margin-bottom: 5px; font-size: 0.9rem;">${msg}</div>`);
    $('#chat-input').val('');
    
    let chatBox = document.getElementById('chat-history');
    chatBox.scrollTop = chatBox.scrollHeight;

    $.ajax({
        url: 'chatbot-handler.php',
        type: 'POST',
        data: { question: msg },
        success: function(response) {
            $('#chat-history').append(`<div style="align-self: flex-start; background: #1e293b; color: #cbd5e1; padding: 10px; border-radius: 10px; max-width: 80%; border: 1px solid #334155; font-size: 0.9rem;">${response}</div>`);
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    });
}
$('#chat-input').keypress(function(e) { if(e.which == 13) sendChat(); });
</script>

</body>
</html>