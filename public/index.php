<?php
require_once '../config/db.php';

$search = trim($_GET['search'] ?? '');

try {
    if ($search) {
        $stmt = $pdo->prepare("SELECT * FROM students WHERE full_name LIKE ? OR course LIKE ? ORDER BY id DESC");
        $stmt->execute(["%$search%", "%$search%"]);
    } else {
        $stmt = $pdo->query("SELECT * FROM students ORDER BY id DESC");
    }
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching students: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student List</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            background: #f2f2f2;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .heading-3d {
            text-align: center;
            font-size: 36px;
            color: #333;
            margin-bottom: 30px;
            text-shadow: 3px 3px 8px rgba(0, 0, 0, 0.2);
            font-weight: bold;
        }

        .search-area {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 40px;
        }

        .search-form {
            width: 100%;
            max-width: 1000px;
            display: flex;
        }

        .search-form input[type="text"] {
            flex: 1;
            padding: 14px;
            font-size: 16px;
            border-radius: 8px 0 0 8px;
            border: 1px solid #ccc;
            outline: none;
        }

        .search-form button {
            padding: 14px 30px;
            font-size: 16px;
            border-radius: 0 8px 8px 0;
            background-color: #007bff;
            border: none;
            color: white;
            cursor: pointer;
            font-weight: bold;
        }

        .search-form button:hover {
            background-color: #0056b3;
        }

        .btn-add {
            align-self: flex-start;
            margin-top: 15px;
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .student-container {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
            justify-content: center;
        }

        .student-card {
            background: linear-gradient(145deg, #ffffff, #e6e6e6);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            padding: 18px;
            border-radius: 16px;
            width: 280px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .student-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 30px rgba(0,0,0,0.2);
        }

        .student-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .student-card h3 {
            margin: 0 0 8px;
            color: #222;
        }

        .student-card p {
            margin: 4px 0;
            color: #555;
            font-size: 14px;
        }

        .actions {
            margin-top: 15px;
        }

        .actions a {
            display: inline-block;
            padding: 8px 14px;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            margin-right: 6px;
        }

        .edit-btn { background-color: #17a2b8; }
        .delete-btn { background-color: #dc3545; }
    </style>
</head>
<body>

<div class="container">
    <!-- 🔹 3D Heading -->
    <h1 class="heading-3d">Student List</h1>

    <!-- 🔹 Search Area -->
    <div class="search-area">
        <form method="GET" class="search-form">
            <input type="text" name="search" placeholder="Search by name or course" value="<?= htmlspecialchars($search) ?>">
            <button type="submit">Search</button>
        </form>
        <a href="add.php" class="btn-add">+ Add New Student</a>
    </div>

    <!-- 📦 Student Cards -->
    <div class="student-container">
        <?php foreach ($students as $student): ?>
            <div class="student-card">
                <?php if (!empty($student['profile_image'])): ?>
                    <img src="../<?= htmlspecialchars($student['profile_image']) ?>" alt="Profile">
                <?php endif; ?>
                <h3><?= htmlspecialchars($student['full_name']) ?></h3>
                <p><strong>Email:</strong> <?= htmlspecialchars($student['email']) ?></p>
                <p><strong>Contact:</strong> <?= htmlspecialchars($student['contact_no']) ?></p>
                <p><strong>Course:</strong> <?= htmlspecialchars($student['course']) ?></p>
                <p><strong>Registered:</strong> <?= htmlspecialchars($student['registered_at']) ?></p>
                <div class="actions">
                    <a class="edit-btn" href="edit.php?id=<?= $student['id'] ?>">Edit</a>
                    <a class="delete-btn" href="delete.php?id=<?= $student['id'] ?>" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>
