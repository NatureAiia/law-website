<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

$id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_verify($_POST['csrf_token'] ?? null)) {
        flash_set('error', 'Invalid form submission. Please try again.');
        redirect(BASE_URL . '/admin/news/edit.php?id=' . $id);
    }

    $title = trim($_POST['title'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $summary = trim($_POST['summary'] ?? '');
    $body = trim($_POST['body'] ?? '');
    $entry_date_raw = trim($_POST['entry_date'] ?? '');

    if ($id <= 0) {
        flash_set('error', 'Invalid item.');
        redirect(BASE_URL . '/admin/news/list.php');
    }

    if ($title === '' || $category === '' || $summary === '' || $body === '' || $entry_date_raw === '') {
        flash_set('error', 'All fields are required.');
        redirect(BASE_URL . '/admin/news/edit.php?id=' . $id);
    }

    if (mb_strlen($title) > 200) {
        flash_set('error', 'Title must be 200 characters or fewer.');
        redirect(BASE_URL . '/admin/news/edit.php?id=' . $id);
    }

    if (mb_strlen($summary) > 300) {
        flash_set('error', 'Summary must be 300 characters or fewer.');
        redirect(BASE_URL . '/admin/news/edit.php?id=' . $id);
    }

    if (!in_whitelist($category, NEWS_EVENT_CATEGORIES)) {
        flash_set('error', 'Invalid category selected.');
        redirect(BASE_URL . '/admin/news/edit.php?id=' . $id);
    }

    $entry_date_obj = DateTime::createFromFormat('Y-m-d', $entry_date_raw);
    if ($entry_date_obj === false) {
        flash_set('error', 'Invalid date.');
        redirect(BASE_URL . '/admin/news/edit.php?id=' . $id);
    }
    $entry_date = $entry_date_obj->format('Y-m-d');

    $stmt = get_db()->prepare('UPDATE news_events SET title = ?, category = ?, summary = ?, body = ?, entry_date = ? WHERE id = ?');
    $stmt->execute([$title, $category, $summary, $body, $entry_date, $id]);

    flash_set('success', 'News/Event updated.');
    redirect(BASE_URL . '/admin/news/list.php');
}

if ($id <= 0) {
    flash_set('error', 'Invalid item.');
    redirect(BASE_URL . '/admin/news/list.php');
}

$stmt = get_db()->prepare('SELECT * FROM news_events WHERE id = ?');
$stmt->execute([$id]);
$item = $stmt->fetch();

if (!$item) {
    flash_set('error', 'Item not found.');
    redirect(BASE_URL . '/admin/news/list.php');
}

$entry_date_value = $item['entry_date'];
$dt = DateTime::createFromFormat('Y-m-d', substr((string) $entry_date_value, 0, 10));
if ($dt !== false) {
    $entry_date_value = $dt->format('Y-m-d');
}

$admin_page = 'news';
$admin_title = 'Edit News / Event';
include __DIR__ . '/../includes/admin-header.php';
?>

<form method="post" action="edit.php">
  <?= csrf_field() ?>
  <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">

  <div class="form-group">
    <label for="title">Title</label>
    <input type="text" id="title" name="title" class="form-control" maxlength="200" required value="<?= h($item['title']) ?>">
  </div>

  <div class="form-group">
    <label for="category">Category</label>
    <select id="category" name="category" class="form-control" required>
      <?php foreach (NEWS_EVENT_CATEGORIES as $cat): ?>
        <option value="<?= h($cat) ?>" <?= $item['category'] === $cat ? 'selected' : '' ?>><?= h(ucfirst($cat)) ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="form-group">
    <label for="summary">Summary</label>
    <textarea id="summary" name="summary" class="form-control" maxlength="300" required><?= h($item['summary']) ?></textarea>
  </div>

  <div class="form-group">
    <label for="body">Body</label>
    <textarea id="body" name="body" class="form-control" rows="8" required><?= h($item['body']) ?></textarea>
  </div>

  <div class="form-group">
    <label for="entry_date">Date</label>
    <input type="date" id="entry_date" name="entry_date" class="form-control" required value="<?= h($entry_date_value) ?>">
  </div>

  <button type="submit" class="btn btn-primary">Save Changes</button>
  <a href="<?= h(BASE_URL) ?>/admin/news/list.php" class="btn btn-outline-dark">Cancel</a>
</form>

<?php include __DIR__ . '/../includes/admin-footer.php'; ?>
