<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

$stmt = get_db()->query('SELECT * FROM news_events ORDER BY entry_date DESC');
$items = $stmt->fetchAll();

$admin_page = 'news';
$admin_title = 'Manage News & Events';
include __DIR__ . '/../includes/admin-header.php';
?>

<p><a href="<?= h(BASE_URL) ?>/admin/news/add.php" class="btn btn-primary">+ Add News/Event</a></p>

<div class="table-wrap">
  <table class="table">
    <thead>
      <tr>
        <th>Title</th>
        <th>Category</th>
        <th>Date</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($items)): ?>
        <tr>
          <td colspan="4">No news or events found.</td>
        </tr>
      <?php else: ?>
        <?php foreach ($items as $item): ?>
          <tr>
            <td><?= h($item['title']) ?></td>
            <td>
              <?php if ($item['category'] === 'event'): ?>
                <span class="badge badge-event">Event</span>
              <?php else: ?>
                <span class="badge badge-news">News</span>
              <?php endif; ?>
            </td>
            <td><?= h(format_date($item['entry_date'])) ?></td>
            <td class="table-actions">
              <a href="<?= h(BASE_URL) ?>/admin/news/edit.php?id=<?= (int) $item['id'] ?>" class="btn btn-sm btn-outline-dark">Edit</a>
              <form method="post" action="delete.php" style="display:inline;">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this item?');">Delete</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?php include __DIR__ . '/../includes/admin-footer.php'; ?>
