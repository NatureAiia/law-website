<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

$stmt = get_db()->query('SELECT * FROM faculty ORDER BY display_order ASC');
$faculty = $stmt->fetchAll();

$admin_page = 'faculty';
$admin_title = 'Manage Faculty';
include __DIR__ . '/../includes/admin-header.php';
?>

<div class="table-actions">
    <a href="<?= h(BASE_URL) ?>/admin/faculty/add.php" class="btn btn-primary">+ Add Faculty Member</a>
</div>

<div class="table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Title</th>
                <th>Department</th>
                <th>Dean?</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($faculty)): ?>
                <tr>
                    <td colspan="5">No faculty members found.</td>
                </tr>
            <?php endif; ?>
            <?php foreach ($faculty as $member): ?>
                <tr>
                    <td><?= h($member['full_name']) ?></td>
                    <td><?= h($member['title']) ?></td>
                    <td><?= h($member['department']) ?></td>
                    <td>
                        <?php if (!empty($member['is_dean'])): ?>
                            <span class="badge badge-dean">Dean</span>
                        <?php else: ?>
                            &mdash;
                        <?php endif; ?>
                    </td>
                    <td class="table-actions">
                        <a href="<?= h(BASE_URL) ?>/admin/faculty/edit.php?id=<?= (int) $member['id'] ?>" class="btn btn-sm btn-outline-dark">Edit</a>
                        <form method="post" action="<?= h(BASE_URL) ?>/admin/faculty/delete.php" onsubmit="return confirm('Are you sure you want to delete this faculty member?');" style="display:inline;">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= (int) $member['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../includes/admin-footer.php'; ?>
