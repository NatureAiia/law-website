<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    flash_set('error', 'Request not found.');
    redirect(BASE_URL . '/admin/submissions/list.php');
}

$stmt = get_db()->prepare('SELECT * FROM legal_help_requests WHERE id = ?');
$stmt->execute([$id]);
$req = $stmt->fetch();

if (!$req) {
    flash_set('error', 'Request not found.');
    redirect(BASE_URL . '/admin/submissions/list.php');
}

$admin_page = 'submissions';
$admin_title = 'Request Details';
include __DIR__ . '/../includes/admin-header.php';
?>

<div class="card">
    <div class="card-body">
        <p><strong>Full Name:</strong> <?= h($req['full_name']) ?></p>
        <p><strong>Contact Info:</strong> <?= h($req['contact_info']) ?></p>
        <p><strong>Issue Category:</strong> <span class="badge"><?= h($req['issue_category']) ?></span></p>
        <p><strong>Submitted:</strong> <?= h(format_date($req['submitted_at'], 'F j, Y g:i a')) ?></p>
        <p><strong>Description:</strong></p>
        <p><?= render_body($req['description']) ?></p>
    </div>
</div>

<p><a href="<?= h(BASE_URL) ?>/admin/submissions/list.php">Back to all requests</a></p>

<?php include __DIR__ . '/../includes/admin-footer.php'; ?>
