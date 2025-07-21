<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = new PDO("pgsql:host=localhost;dbname=mydb", "myuser", "mypassword");
$id = (int)$_GET['id'];
$restaurant = $conn->query("SELECT * FROM restaurants WHERE id = $id")->fetch(PDO::FETCH_ASSOC);
$reviews = $conn->query("SELECT * FROM reviews WHERE restaurant_id = $id ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($restaurant['name']) ?></title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <div class="container">
    <div style="margin-bottom: 20px;">
        <a href="index.php" style="background-color: #0077cc; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none;">
            ← Вернуться к списку ресторанов
        </a>
    </div>

        <h1><?= htmlspecialchars($restaurant['name']) ?></h1>
        <img src="<?= htmlspecialchars($restaurant['image_path']) ?>" alt="image">
        <p><?= nl2br(htmlspecialchars($restaurant['description'])) ?></p>

        <h2>Отзывы:</h2>
        <ul>
            <?php foreach ($reviews as $review): ?>
                <li>
    <strong><?= htmlspecialchars($review['name']) ?></strong> (<?= htmlspecialchars($review['email']) ?>):
    <br><?= htmlspecialchars($review['comment']) ?>
    <br><span style="color:#f1c40f; font-size:1.1em;">
        <?= str_repeat('★', (int)$review['rating']) ?>
    </span>
    <br><small><?= $review['created_at'] ?></small>
</li>
            <?php endforeach; ?>
        </ul>

        <h3>Добавить отзыв:</h3>
        <?php if (isset($_SESSION['user_id'])): ?>
<form action="submit_review.php" method="POST">
            <input type="hidden" name="restaurant_id" value="<?= $id ?>">
            <label>Email:</label>
            <input type="email" name="email" required>
            <label>Имя:</label>
            <input type="text" name="name" required>
            <label>Отзыв:</label>
            <textarea name="comment" required rows="5"></textarea>
            
<label>Оценка:</label>
<select name="rating" required>
    <option value="">Выберите</option>
    <option value="5">5 — Отлично</option>
    <option value="4">4 — Хорошо</option>
    <option value="3">3 — Нормально</option>
    <option value="2">2 — Плохо</option>
    <option value="1">1 — Ужасно</option>
</select>

<div class="g-recaptcha" data-sitekey="6LfjwYgrAAAAAAD3mMVkvFvVSwwzA3f37FBklHCW"></div>
            <button type="submit">Отправить</button>
        <p><a href='logout.php'>Выйти</a></p>
</form>
<?php else: ?>
<p>Чтобы оставить отзыв, <a href='login.php'>войдите</a> или <a href='register.php'>зарегистрируйтесь</a>.</p>
<?php endif; ?>
    </div>
</body>
</html>
