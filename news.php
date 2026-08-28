<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$category = $_GET['category'] ?? 'all';
if (!in_array($category, ['all', 'news', 'event'], true)) {
    $category = 'all';
}

$db = get_db();
if ($category === 'all') {
    $stmt = $db->prepare('SELECT * FROM news_events ORDER BY entry_date DESC');
    $stmt->execute();
} else {
    $stmt = $db->prepare('SELECT * FROM news_events WHERE category = ? ORDER BY entry_date DESC');
    $stmt->execute([$category]);
}
$items = $stmt->fetchAll();

$page = 'news';
$page_title = 'News & Events';
include __DIR__ . '/includes/header.php';
?>

<div class="page-header">
    <div class="container">
        <h1>News &amp; Events</h1>
        <p>Stay up to date with the latest happenings at the School of Law.</p>
    </div>
</div>

<div class="section">
    <div class="container">
        <div class="tag-list">
            <a href="news.php?category=all" class="tab-btn<?= $category === 'all' ? ' active' : '' ?>" data-filter="all">All</a>
            <a href="news.php?category=news" class="tab-btn<?= $category === 'news' ? ' active' : '' ?>" data-filter="news">News</a>
            <a href="news.php?category=event" class="tab-btn<?= $category === 'event' ? ' active' : '' ?>" data-filter="event">Events</a>
        </div>

        <?php if (count($items) === 0): ?>
            <p>No items found.</p>
        <?php else: ?>
            <div class="grid grid-3">
                <?php foreach ($items as $item): ?>
                    <div class="card-news" data-category="<?= h($item['category']) ?>">
                        <div class="card-img-placeholder">📰</div>
                        <div class="card-body">
                            <span class="badge badge-<?= h($item['category']) ?>"><?= h(ucfirst($item['category'])) ?></span>
                            <h3><?= h($item['title']) ?></h3>
                            <p><em><?= h(format_date($item['entry_date'])) ?></em></p>
                            <p><?= h($item['summary']) ?></p>
                            <a href="news-detail.php?id=<?= (int) $item['id'] ?>">Read More</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
