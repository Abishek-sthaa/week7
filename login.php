<?php
session_start();
require_once 'db.php';

// If already logged in, redirect to dashboard
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: dashboard.php');
    exit();
}

$message = '';
$error = '';

// Show success message if redirected from registration
if (isset($_GET['registered']) && $_GET['registered'] == 1) {
    $message = 'Registration successful! Please login.';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = trim($_POST['student_id'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($student_id) || empty($password)) {
        $error = 'Please enter both Student ID and Password!';
    } else {
        try {
            // Check if student exists
            $stmt = $conn->prepare("SELECT student_id, full_name, password_hash FROM students WHERE student_id = ?");
            $stmt->execute([$student_id]);
            $student = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($student) {
                // Verify password
                if (password_verify($password, $student['password_hash'])) {
                    // Start session
                    session_start();
                    $_SESSION['logged_in'] = true;
                    $_SESSION['student_id'] = $student['student_id'];
                    $_SESSION['name'] = $student['full_name'];
                    
                    // Redirect to dashboard
                    header('Location: dashboard.php');
                    exit();
                } else {
                    $error = 'Invalid password!';
                }
            } else {
                $error = 'Student ID not found!';
            }
        } catch(PDOException $e) {
            $error = 'Login failed: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 400px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #667eea;
        }
        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s;
        }
        button:hover {
            transform: translateY(-2px);
        }
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }
        .error {
            background: #fee;
            color: #c33;
            border: 1px solid #fcc;
        }
        .success {
            background: #efe;
            color: #3c3;
            border: 1px solid #cfc;
        }
        .register-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }
        .register-link a {
            color: #667eea;
            text-decoration: none;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Student Login</h1>
        
        <?php if ($error): ?>
            <div class="message error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <?php if ($message): ?>
            <div class="message success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="student_id">Student ID:</label>
                <input type="text" id="student_id" name="student_id" required 
                       value="<?php echo htmlspecialchars($_POST['student_id'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit">Login</button>
        </form>
        
        <div class="register-link">
            Don't have an account? <a href="register.php">Register here</a>
        </div>
    </div>
</body>
</html>
