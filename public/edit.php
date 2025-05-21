<?php
require_once '../config/db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("Student ID not provided.");
}

try {
    $stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->execute([$id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        die("Student not found.");
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $contact = trim($_POST['contact_no']);
    $course = trim($_POST['course']);

    if (empty($name)) $errors[] = 'Full Name is required';
    if (empty($email)) $errors[] = 'Email is required';

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("UPDATE students SET full_name = ?, email = ?, contact_no = ?, course = ? WHERE id = ?");
            $stmt->execute([$name, $email, $contact, $course, $id]);
            $success = "Student updated successfully!";
            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            $errors[] = "Error updating: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        h1 {
            margin-top: 0;
            text-align: center;
            color: #333;
            text-shadow: 2px 2px 6px rgba(0,0,0,0.1);
        }

        .form-container a {
            display: inline-block;
            margin-bottom: 20px;
            color: #5a00a0;
            text-decoration: none;
        }

        .form-container a:hover {
            text-decoration: underline;
        }

        form input, form button {
            width: 100%;
            padding: 14px;
            margin-top: 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 15px;
        }

        form button {
            background: #007bff;
            color: white;
            font-weight: bold;
            border: none;
            transition: background 0.3s ease;
        }

        form button:hover {
            background: #0056b3;
        }

        .msg {
            padding: 12px;
            margin-top: 10px;
            border-radius: 6px;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
        }

        .success {
            background: #d4edda;
            color: #155724;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h1>Edit Student</h1>
    <a href="index.php">← Back to List</a>

    <?php if (!empty($errors)): ?>
        <div class="msg error"><?= implode('<br>', $errors); ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="full_name" value="<?= htmlspecialchars($student['full_name']) ?>" placeholder="Full Name" required>
        <input type="email" name="email" value="<?= htmlspecialchars($student['email']) ?>" placeholder="Email Address" required>
        <input type="text" name="contact_no" value="<?= htmlspecialchars($student['contact_no']) ?>" placeholder="Contact Number">
        <input type="text" name="course" value="<?= htmlspecialchars($student['course']) ?>" placeholder="Course">
        <button type="submit">Update Student</button>
    </form>
</div>

</body>
</html>
