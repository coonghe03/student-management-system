<?php
require_once '../config/db.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $contact = trim($_POST['contact_no']);
    $course = trim($_POST['course']);

    // Basic Validation
    if (empty($name)) $errors[] = 'Full Name is required';
    if (empty($email)) $errors[] = 'Email is required';

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO students (full_name, email, contact_no, course) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $contact, $course]);
            $success = "Student added successfully!";
        } catch (PDOException $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../assets/style.css">
    <title>Add Student</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        form { max-width: 400px; }
        input, select, button { width: 100%; padding: 10px; margin-top: 10px; }
        .msg { padding: 10px; margin-top: 10px; }
        .error { background: #f8d7da; color: #721c24; }
        .success { background: #d4edda; color: #155724; }
    </style>
</head>
<body>
    <h1>Add New Student</h1>
    <a href="index.php">← Back to List</a>

    <?php if (!empty($errors)): ?>
        <div class="msg error">
            <?= implode('<br>', $errors); ?>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="msg success"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="full_name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email
