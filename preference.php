<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

$message = '';

// Handle theme preference update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $theme = $_POST['theme'] ?? 'light';
    
    // Set cookie for 30 days
    setcookie('theme', $theme, time() + (86400 * 30), '/');
    
    $message = 'Theme preference saved successfully!';
    
    // Redirect to apply theme immediately
    header('Location: preference.php?updated=1');
    exit();
}

// Get current theme from cookie
$currentTheme = isset($_COOKIE['theme']) ? $_COOKIE['theme'] : 'light';

// Apply theme styles
$bgColor = $currentTheme === 'dark' ? '#1a1a1a' : '#ffffff';
$textColor = $currentTheme === 'dark' ? '#ffffff' : '#333333';
$cardBg = $currentTheme === 'dark' ? '#2d2d2d' : '#f8f9fa';

// Show success message
if (isset($_GET['updated']) && $_GET['updated'] == 1) {
    $message = 'Theme preference updated successfully!';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Theme Preferences</title>
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
        .header h1 {
            font-size: 24px;
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
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .card {
            background-color: <?php echo $cardBg; ?>;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: background-color 0.3s;
        }
        .card h2 {
            margin-bottom: 20px;
            color: <?php echo $textColor; ?>;
        }
        .form-group {
            margin-bottom: 25px;
        }
        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: <?php echo $textColor; ?>;
        }
        .radio-group {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        .radio-option {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            border: 2px solid <?php echo $currentTheme === 'dark' ? '#555' : '#ddd'; ?>;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            background: <?php echo $currentTheme === 'dark' ? '#3d3d3d' : '#fff'; ?>;
        }
        .radio-option:hover {
            border-color: #667eea;
            transform: translateY(-2px);
        }
        .radio-option input[type="radio"] {
            margin-right: 10px;
            cursor: pointer;
        }
        .radio-option input[type="radio"]:checked + label {
            color: #667eea;
            font-weight: bold;
        }
        .radio-option label {
            cursor: pointer;
            margin: 0;
        }
        button[type="submit"] {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s;
        }
        button[type="submit"]:hover {
            transform: translateY(-2px);
        }
        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .preview-box {
            margin-top: 20px;
            padding: 15px;
            background: <?php echo $currentTheme === 'dark' ? '#3d3d3d' : '#e9ecef'; ?>;
            border-radius: 5px;
            border-left: 4px solid #667eea;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>Theme Preferences</h1>
            <div class="nav-buttons">
                <a href="dashboard.php" class="btn btn-primary">Back to Dashboard</a>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
    
    <div class="container">
        <div class="card">
            <h2>Select Your Theme</h2>
            
            <?php if ($message): ?>
                <div class="message"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label>Choose a theme:</label>
                    <div class="radio-group">
                        <div class="radio-option" style="<?php echo $currentTheme === 'light' ? 'border-color: #667eea; background: ' . ($currentTheme === 'dark' ? '#4d4d4d' : '#f0f0ff') . ';' : ''; ?>">
                            <input type="radio" id="light" name="theme" value="light" 
                                   <?php echo $currentTheme === 'light' ? 'checked' : ''; ?>>
                            <label for="light">Light Mode</label>
                        </div>
                        <div class="radio-option" style="<?php echo $currentTheme === 'dark' ? 'border-color: #667eea; background: ' . ($currentTheme === 'dark' ? '#4d4d4d' : '#f0f0ff') . ';' : ''; ?>">
                            <input type="radio" id="dark" name="theme" value="dark" 
                                   <?php echo $currentTheme === 'dark' ? 'checked' : ''; ?>>
                            <label for="dark">Dark Mode</label>
                        </div>
                    </div>
                </div>
                
                <button type="submit">Save Preference</button>
            </form>
            
            <div class="preview-box">
                <strong>Current Theme:</strong> <?php echo ucfirst($currentTheme); ?> Mode
                <br>
                <small>The theme will be applied immediately after saving and will persist for 30 days.</small>
            </div>
        </div>
    </div>
</body>
</html>
