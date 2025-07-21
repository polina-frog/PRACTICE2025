<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = new PDO("pgsql:host=localhost;dbname=mydb", "myuser", "mypassword");
$restaurants = $conn->query("SELECT id, name FROM restaurants")->fetchAll(PDO::FETCH_ASSOC);

$rating_stmt = $conn->prepare("SELECT restaurant_id, ROUND(AVG(rating),1) AS avg_rating FROM reviews GROUP BY restaurant_id");
$rating_stmt->execute();
$ratings = $rating_stmt->fetchAll(PDO::FETCH_KEY_PAIR);

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Корейские рестораны</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
<?php
session_start();
?>
<div class="auth-bar">
    <?php if (isset($_SESSION['user_id'])): ?>
        Добро пожаловать, <?= htmlspecialchars($_SESSION['user_name']) ?>! <a href="logout.php">Выйти</a>
    <?php else: ?>
        <a href="login.php">Войти</a> | <a href="register.php">Регистрация</a>
    <?php endif; ?>
</div>

        <h1>Корейские рестораны</h1>
        <ul>
            <?php foreach ($restaurants as $r): ?>
                <li><a href="restaurant.php?id=<?= $r['id'] ?>"><?= htmlspecialchars($r['name']) ?></a><span class='rating'><?= isset($ratings[$r['id']]) ? str_repeat('★', round($ratings[$r['id']])) : '—' ?></span></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
