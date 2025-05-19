<?php
require_once '../config/db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("Student ID not provided.");
}

try {
    // Fetch existing student data
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
            header("Location: index.php"); // Redirect after success
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
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        input, button { width: 100%; padding: 10px; margin-top: 10px; }
        .msg { padding: 10px; margin-top: 10px; }
        .error { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <h1>Edit Student</h1>
    <a href="index.php">← Back to List</a>

    <?php if (!empty($errors)): ?>
        <div class="msg error"><?= implode('<br>', $errors); ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="full_name" value="<?= htmlspecialchars($student['full_name']) ?>" required>
        <input type="email" name="email" value="<?= htmlspecialchars($student['email']) ?>" required>
        <input type="text" name="contact_no" value="<?= htmlspecialchars($student['contact_no']) ?>">
        <input type="text" name="course" value="<?= htmlspecialchars($student['course']) ?>">
        <button type="submit">Update Student</button>
    </form>
</body>
</html>
