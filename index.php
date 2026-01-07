<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pure Drop | Smart Water System</title>
    <style>
        body, html { margin: 0; height: 100%; font-family: 'Segoe UI', sans-serif; overflow: hidden; }
        .hero {
            background: linear-gradient(#95d3fa, #303c75), url('https://images.unsplash.com/photo-1523362628242-f513a005271b?auto=format&fit=crop&q=80');
            background-size: cover; height: 100vh; display: flex; flex-direction: column;
            justify-content: center; align-items: center; color: white; text-align: center;
        }
        .tank-display {
            width: 150px; height: 200px; border: 4px solid #2828e4ff; border-radius: 10px;
            position: relative; overflow: hidden; background: #222; margin-bottom: 20px;
        }
        .water-wave {
            position: absolute; bottom: 0; width: 100%; background: #00d2ff;
            height: 76%; animation: wave 3s infinite ease-in-out;
        }
        @keyframes wave { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        .btn-start {
            padding: 15px 40px; font-size: 20px; background: #04ef6aff; border: none;
            color: white; border-radius: 50px; cursor: pointer; transition: 0.3s;
        }
        .btn-start:hover { transform: scale(1.1); background: #025598ff; }
    </style>
</head>
<body>
    <div class="hero">
        <div class="tank-display">
            <div class="water-wave"></div>
            <div style="position:absolute; width:100%; top:40%; font-weight:bold;">76% <br> ACTIVE</div>
        </div>
        <h1 style="font-size: 4rem;">Pure Drop</h1>
        <p>Smart Auto-Cleaning Water Filter Monitoring & Transparency System</p>
        <button class="btn-start" onclick="location.href='portal-selection.php'">Get Started →</button>
    </div>
</body>
</html>