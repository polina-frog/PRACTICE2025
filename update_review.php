<?php
session_start();
if (!isset($_SESSION['user_email']) || $_SESSION['user_email'] !== 'admin@example.com') {
    die("Доступ запрещен");
}

$conn = new PDO("pgsql:host=localhost;dbname=mydb", "myuser", "mypassword");

$stmt = $conn->prepare("UPDATE reviews SET name = :name, email = :email, rating = :rating, comment = :comment WHERE id = :id");
$stmt->execute([
    ':id' => $_POST['id'],
    ':name' => $_POST['name'],
    ':email' => $_POST['email'],
    ':rating' => $_POST['rating'],
    ':comment' => $_POST['comment']
]);

header("Location: admin.php");
exit;
