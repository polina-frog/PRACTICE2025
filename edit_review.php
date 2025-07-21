<?php
session_start();
if (!isset($_SESSION['user_email']) || $_SESSION['user_email'] !== 'admin@example.com') {
    die("Доступ запрещен");
}

$conn = new PDO("pgsql:host=localhost;dbname=mydb", "myuser", "mypassword");
$id = (int)$_GET['id'];

$stmt = $conn->prepare("SELECT * FROM reviews WHERE id = :id");
$stmt->execute([':id' => $id]);
$review = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$review) die("Отзыв не найден");
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Редактирование</title><link rel="stylesheet" href="css/style.css"></head>
<body><div class="container">
    <h2>Редактировать отзыв</h2>
    <form method="POST" action="update_review.php">
        <input type="hidden" name="id" value="<?= $review['id'] ?>">
        Имя: <input type="text" name="name" value="<?= htmlspecialchars($review['name']) ?>" required>
        Email: <input type="email" name="email" value="<?= htmlspecialchars($review['email']) ?>" required>
        Оценка:
        <select name="rating" required>
            <?php for ($i = 5; $i >= 1; $i--): ?>
                <option value="<?= $i ?>" <?= $review['rating'] == $i ? 'selected' : '' ?>><?= $i ?></option>
            <?php endfor; ?>
        </select>
        Комментарий:<br>
        <textarea name="comment" rows="5" required><?= htmlspecialchars($review['comment']) ?></textarea>
        <button type="submit">Сохранить</button>
    </form>
</div></body></html>
