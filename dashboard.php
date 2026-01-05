<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Get theme from cookie, default to light mode
$theme = isset($_COOKIE['theme']) ? $_COOKIE['theme'] : 'light';

// Apply theme styles
$bgColor = $theme === 'dark' ? '#1a1a1a' : '#ffffff';
$textColor = $theme === 'dark' ? '#ffffff' : '#333333';
$cardBg = $theme === 'dark' ? '#2d2d2d' : '#f8f9fa';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: <?php echo $bgColor; ?>;
            color: <?php echo $textColor; ?>;
            min-height: 100vh;
            transition: background-color 0.3s, color 0.3s;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .welcome {
            font-size: 24px;
            font-weight: bold;
        }
        .nav-buttons {
            display: flex;
            gap: 10px;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            transition: transform 0.2s;
        }
        .btn:hover {
            transform: translateY(-2px);
        }
        .btn-primary {
            background: white;
            color: #667eea;
        }
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .card {
            background-color: <?php echo $cardBg; ?>;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            transition: background-color 0.3s;
        }
        .card h2 {
            margin-bottom: 20px;
            color: <?php echo $textColor; ?>;
        }
        .nav-links {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 20px;
        }
        .nav-link {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: transform 0.2s;
        }
        .nav-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .info-box {
            background: <?php echo $theme === 'dark' ? '#3d3d3d' : '#e9ecef'; ?>;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .info-box p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <div class="welcome">
                Welcome, <?php echo htmlspecialchars($_SESSION['name'] ?? 'Student'); ?>!
            </div>
            <div class="nav-buttons">
                <a href="preference.php" class="btn btn-primary">Theme Settings</a>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
    
    <div class="container">
        <div class="card">
            <h2>Dashboard</h2>
            <p>Welcome to your Student Grade Portal dashboard. Use the navigation links below to access different sections.</p>
            
            <div class="info-box">
                <p><strong>Student ID:</strong> <?php echo htmlspecialchars($_SESSION['student_id'] ?? 'N/A'); ?></p>
                <p><strong>Current Theme:</strong> <?php echo ucfirst($theme); ?> Mode</p>
            </div>
            
            <div class="nav-links">
                <a href="preference.php" class="nav-link">Theme Preferences</a>
                <a href="dashboard.php" class="nav-link">Dashboard</a>
            </div>
        </div>
    </div>
</body>
</html>
