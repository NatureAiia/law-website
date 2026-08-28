<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

$stmt = get_db()->query('SELECT * FROM legal_help_requests ORDER BY submitted_at DESC');
$requests = $stmt->fetchAll();

$admin_page = 'submissions';
$admin_title = 'Legal Help Requests';
include __DIR__ . '/../includes/admin-header.php';
?>

<div class="table-wrap">
    <?php if (empty($requests)): ?>
        <p>No requests have been submitted yet.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Submitted</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requests as $req): ?>
                    <tr>
                        <td><?= h($req['full_name']) ?></td>
                        <td><?= h($req['issue_category']) ?></td>
                        <td><?= h(format_date($req['submitted_at'], 'F j, Y g:i a')) ?></td>
                        <td class="table-actions">
                            <a class="btn btn-sm btn-outline-dark" href="<?= h(BASE_URL) ?>/admin/submissions/view.php?id=<?= (int) $req['id'] ?>">View</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../includes/admin-footer.php'; ?>
