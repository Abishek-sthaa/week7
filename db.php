<?php
// Database connection configuration
$host = 'localhost';
$dbname = 'np03cs4s250052';
$username = 'np03cs4s250052';
$password = '8oy3cq6JHz';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
