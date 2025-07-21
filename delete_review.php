<?php
session_start();
if (!isset($_SESSION['user_email']) || $_SESSION['user_email'] !== 'admin@example.com') {
    die("Доступ запрещен");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new PDO("pgsql:host=localhost;dbname=mydb", "myuser", "mypassword");
    $stmt = $conn->prepare("DELETE FROM reviews WHERE id = :id");
    $stmt->execute([':id' => $_POST['review_id']]);
}

header("Location: admin.php");
exit;
