<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Your Portal | Pure Drop AI</title>
    <style>
        :root {
            --bg-dark: #0f172a;
            --sidebar-bg: #1e293b;
            --card-bg: #1e293b;
            --primary: #0ea5e9;
            --text-white: #f8fafc;
            --border: #334155;
        }

        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* The main container uses Flexbox to center everything on the screen */
        .selection-body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: radial-gradient(circle, #1e293b 0%, #0f172a 100%);
            margin: 0;
            color: var(--text-white);
        }

        .selection-container {
            text-align: center;
            width: 100%;
            max-width: 1000px;
            padding: 20px;
        }

        h1 {
            font-size: 3rem;
            margin-bottom: 10px;
            color: var(--text-white);
            text-shadow: 0 0 15px rgba(14, 165, 233, 0.3);
        }

        .subtitle {
            color: #94a3b8;
            margin-bottom: 50px;
            font-size: 1.1rem;
        }

        /* Grid for the two portal cards */
        .portal-cards {
            display: flex;
            gap: 40px;
            justify-content: center;
            flex-wrap: wrap; /* Ensures responsiveness on smaller screens */
        }

        /* Card styling to match the provided dashboard theme */
        .portal-card {
            background: rgba(30, 41, 59, 0.8);
            padding: 45px;
            border-radius: 20px;
            border: 2px solid var(--border);
            width: 350px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
            text-align: left;
        }

        .portal-card:hover {
            border-color: var(--primary);
            transform: translateY(-15px);
            background: rgba(30, 41, 59, 1);
            box-shadow: 0 20px 45px rgba(14, 165, 233, 0.2);
        }

        .portal-card h2 {
            color: var(--primary);
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 1.8rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .portal-card p {
            color: #cbd5e1;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 0;
        }

        .back-home {
            margin-top: 60px;
            background: transparent;
            border: 1px solid var(--border);
            color: #94a3b8;
            padding: 12px 30px;
            border-radius: 50px;
            cursor: pointer;
            transition: 0.3s;
            font-size: 1rem;
            text-decoration: none;
            display: inline-block;
        }

        .back-home:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: rgba(14, 165, 233, 0.05);
        }
    </style>
</head>
<body class="selection-body">
    <div class="selection-container">
        <h1>Select Your Portal</h1>
        <p class="subtitle">Choose between Public Access or Admin Management</p>
        
        <div class="portal-cards">
            <div class="portal-card" onclick="location.href='public/login.php'">
                <h2>Public Access</h2>
                <p>For students and staff to check real-time water availability, hygiene status, and cleaning history.</p>
            </div>
            
            <div class="portal-card" onclick="location.href='admin/login.php'">
                <h2>Admin Portal</h2>
                <p>For authorized personnel to manage tanks, monitor user activity, and refine AI chatbot responses.</p>
            </div>
        </div>
        
        <a href="index.php" class="back-home">Back to Home Screen</a>
    </div>
</body>
</html>