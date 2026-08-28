<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
if ($id === false || $id === null || $id <= 0) {
    redirect(BASE_URL . '/404.php');
}

$db = get_db();
$stmt = $db->prepare('SELECT * FROM news_events WHERE id = ? LIMIT 1');
$stmt->execute([$id]);
$row = $stmt->fetch();

if (!$row) {
    redirect(BASE_URL . '/404.php');
}

$page = 'news';
$page_title = $row['title'];
include __DIR__ . '/includes/header.php';
?>

<div class="page-header">
    <div class="container">
        <span class="badge badge-<?= h($row['category']) ?>"><?= h(ucfirst($row['category'])) ?></span>
        <h1><?= h($row['title']) ?></h1>
        <p><?= h(format_date($row['entry_date'])) ?></p>
    </div>
</div>

<div class="section">
    <div class="container">
        <div><?= render_body($row['body']) ?></div>
        <div class="divider"></div>
        <a href="news.php">&larr; Back to News</a>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
