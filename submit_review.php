<?php
session_start();

$secret = '6LfjwYgrAAAAAN9Ts7R0L5109ZvqpyUC7CH6LDeY';
$response = $_POST['g-recaptcha-response'];

$verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$response}");
$captcha_success = json_decode($verify);

if (!$captcha_success->success) {
    die("Проверка reCAPTCHA не пройдена. Попробуйте снова.");
}

$conn = new PDO("pgsql:host=localhost;dbname=mydb", "myuser", "mypassword");

$stmt = $conn->prepare("INSERT INTO reviews (restaurant_id, email, name, comment, rating) VALUES (:restaurant_id, :email, :name, :comment, :rating)");
$stmt->execute([
    ':restaurant_id' => $_POST['restaurant_id'],
    ':email' => $_POST['email'],
    ':name' => $_POST['name'],
    ':comment' => $_POST['comment'],
    ':rating' => $_POST['rating']
]);

header("Location: restaurant.php?id=" . $_POST['restaurant_id']);
exit;
