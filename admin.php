<?php
session_start();
if (!isset($_SESSION['user_email']) || $_SESSION['user_email'] !== 'admin@example.com') {
    die("Доступ запрещен");
}

$conn = new PDO("pgsql:host=localhost;dbname=mydb", "myuser", "mypassword");
$reviews = $conn->query("SELECT r.id, r.comment, r.rating, r.created_at, r.name, r.email, res.name AS restaurant_name
                         FROM reviews r
                         JOIN restaurants res ON r.restaurant_id = res.id
                         ORDER BY r.created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Админ-панель</title><link rel="stylesheet" href="css/style.css"></head>
<body><div class="container">
    <h2>Админ-панель: Отзывы</h2>
    <table style="width:100%; border-collapse: collapse;">
        <tr><th>Ресторан</th><th>Пользователь</th><th>Оценка</th><th>Комментарий</th><th>Дата</th><th>Действия</th></tr>
        <?php foreach ($reviews as $r): ?>
            <tr style="border-bottom: 1px solid #ccc;">
                <td><?= htmlspecialchars($r['restaurant_name']) ?></td>
                <td><?= htmlspecialchars($r['name']) ?> (<?= htmlspecialchars($r['email']) ?>)</td>
                <td><?= str_repeat('★', (int)$r['rating']) ?></td>
                <td><?= nl2br(htmlspecialchars($r['comment'])) ?></td>
                <td><?= $r['created_at'] ?></td>
                <td>
                    <form method="POST" action="delete_review.php" style="display:inline;" onsubmit="return confirm('Удалить отзыв?');">
                        <input type="hidden" name="review_id" value="<?= $r['id'] ?>">
                        <button type="submit">Удалить</button>
                    </form>
                    <form method="GET" action="edit_review.php" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $r['id'] ?>">
                        <button type="submit">Редактировать</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div></body></html>
