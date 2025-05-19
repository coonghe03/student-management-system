<?php
$host = 'localhost:3307';  // use the port from XAMPP
$dbname = 'student_db';
$user = 'root';
$pass = ''; // No password for XAMPP

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: Could not connect to the database.");
}
?>
