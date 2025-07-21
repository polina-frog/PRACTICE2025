<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new PDO("pgsql:host=localhost;dbname=mydb", "myuser", "mypassword");

    $email = $_POST['email'];
    $name = $_POST['name'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $conn->prepare("INSERT INTO users (email, password_hash, name) VALUES (:email, :password, :name)");
        $stmt->execute([
            ':email' => $email,
            ':password' => $password,
            ':name' => $name
        ]);
        header("Location: login.php?registered=1");
        exit;
    } catch (Exception $e) {
        die("Ошибка регистрации: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Регистрация</title><link rel="stylesheet" href="css/style.css"></head>
<body><div class="container">
    <h2>Регистрация</h2>
    <form method="POST">
        Email: <input type="email" name="email" required>
        Имя: <input type="text" name="name" required>
        Пароль: <input type="password" name="password" required>
        <button type="submit">Зарегистрироваться</button>
    </form>
</div></body></html>
