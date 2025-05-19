<?php
require_once '../config/db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("Invalid request: No ID provided.");
}

try {
    $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php"); // Redirect back to list
    exit;
} catch (PDOException $e) {
    die("Error deleting student: " . $e->getMessage());
}
?>
