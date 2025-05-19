<?php
require_once '../config/db.php';

try {
    $stmt = $pdo->query("SELECT * FROM students ORDER BY id DESC");
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching students: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student List</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border: 1px solid #ccc; text-align: left; }
        th { background-color: #f4f4f4; }
        a.btn { padding: 6px 12px; background: #007BFF; color: white; text-decoration: none; border-radius: 4px; }
    </style>
</head>
<body>
    <h1>Student List</h1>
    <a href="add.php" class="btn">Add New Student</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Course</th>
                <th>Registered</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?= htmlspecialchars($student['id']) ?></td>
                    <td><?= htmlspecialchars($student['full_name']) ?></td>
                    <td><?= htmlspecialchars($student['email']) ?></td>
                    <td><?= htmlspecialchars($student['contact_no']) ?></td>
                    <td><?= htmlspecialchars($student['course']) ?></td>
                    <td><?= htmlspecialchars($student['registered_at']) ?></td>
                    <td><a class="btn" href="edit.php?id=<?= $student['id'] ?>">Edit</a></td>
                    <td><a class="btn" href="edit.php?id=<?= $student['id'] ?>">Edit</a>
                        <a class="btn" style="background: #dc3545;" 
                        href="delete.php?id=<?= $student['id'] ?>" 
                        onclick="return confirm('Are you sure you want to delete this student?');"> Delete </a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
