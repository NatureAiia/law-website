<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/includes/auth.php';

$db = get_db();
$newsCount = (int)$db->query('SELECT COUNT(*) FROM news_events')->fetchColumn();
$facultyCount = (int)$db->query('SELECT COUNT(*) FROM faculty')->fetchColumn();
$submissionsCount = (int)$db->query('SELECT COUNT(*) FROM legal_help_requests')->fetchColumn();

$latestSubmissions = $db->query(
    'SELECT id, full_name, issue_category, submitted_at FROM legal_help_requests ORDER BY submitted_at DESC LIMIT 5'
)->fetchAll();

$admin_page = 'dashboard';
$admin_title = 'Dashboard';
include __DIR__ . '/includes/admin-header.php';
?>

<div class="grid grid-3" style="margin-bottom: var(--space-5);">
  <div class="card text-center">
    <div class="stat-number" style="font-size:2.2rem;color:var(--color-crimson);font-weight:700;"><?= $newsCount ?></div>
    <p class="mb-0">News &amp; Events</p>
  </div>
  <div class="card text-center">
    <div class="stat-number" style="font-size:2.2rem;color:var(--color-crimson);font-weight:700;"><?= $facultyCount ?></div>
    <p class="mb-0">Faculty Members</p>
  </div>
  <div class="card text-center">
    <div class="stat-number" style="font-size:2.2rem;color:var(--color-crimson);font-weight:700;"><?= $submissionsCount ?></div>
    <p class="mb-0">Legal Help Requests</p>
  </div>
</div>

<div class="card">
  <h3>Latest Legal Help Requests</h3>
  <?php if (empty($latestSubmissions)): ?>
    <p>No requests have been submitted yet.</p>
  <?php else: ?>
    <div class="table-wrap">
      <table class="table">
        <thead>
          <tr><th>Name</th><th>Category</th><th>Submitted</th><th></th></tr>
        </thead>
        <tbody>
          <?php foreach ($latestSubmissions as $row): ?>
            <tr>
              <td><?= h($row['full_name']) ?></td>
              <td><?= h($row['issue_category']) ?></td>
              <td><?= h(format_date($row['submitted_at'], 'M j, Y g:ia')) ?></td>
              <td><a href="<?= h(BASE_URL) ?>/admin/submissions/view.php?id=<?= (int)$row['id'] ?>">View</a></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <p style="margin-top: var(--space-3);"><a href="<?= h(BASE_URL) ?>/admin/submissions/list.php">View all requests &rarr;</a></p>
  <?php endif; ?>
</div>

<?php include __DIR__ . '/includes/admin-footer.php'; ?>
