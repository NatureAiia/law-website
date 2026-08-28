<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

$id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);

if ($id <= 0) {
    flash_set('error', 'Invalid faculty member.');
    redirect(BASE_URL . '/admin/faculty/list.php');
}

$stmt = get_db()->prepare('SELECT * FROM faculty WHERE id = ?');
$stmt->execute([$id]);
$existing = $stmt->fetch();

if (!$existing) {
    flash_set('error', 'Faculty member not found.');
    redirect(BASE_URL . '/admin/faculty/list.php');
}

$errors = [];
$form = [
    'full_name' => $existing['full_name'],
    'title' => $existing['title'],
    'department' => $existing['department'],
    'bio' => $existing['bio'],
    'email' => $existing['email'],
    'is_dean' => (bool) $existing['is_dean'],
    'display_order' => (int) $existing['display_order'],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_verify($_POST['csrf_token'] ?? null)) {
        flash_set('error', 'Invalid form submission. Please try again.');
        redirect(BASE_URL . '/admin/faculty/edit.php?id=' . $id);
    }

    $form['full_name'] = trim($_POST['full_name'] ?? '');
    $form['title'] = trim($_POST['title'] ?? '');
    $form['department'] = trim($_POST['department'] ?? '');
    $form['bio'] = trim($_POST['bio'] ?? '');
    $form['email'] = trim($_POST['email'] ?? '');
    $form['is_dean'] = isset($_POST['is_dean']);
    $form['display_order'] = (int) ($_POST['display_order'] ?? 0);

    if ($form['full_name'] === '' || mb_strlen($form['full_name']) > 120) {
        $errors[] = 'Full name is required and must be 120 characters or fewer.';
    }
    if ($form['title'] === '' || mb_strlen($form['title']) > 100) {
        $errors[] = 'Title is required and must be 100 characters or fewer.';
    }
    if (!in_whitelist($form['department'], FACULTY_DEPARTMENTS)) {
        $errors[] = 'Please select a valid department.';
    }
    if ($form['email'] !== '') {
        if (mb_strlen($form['email']) > 150 || filter_var($form['email'], FILTER_VALIDATE_EMAIL) === false) {
            $errors[] = 'Please enter a valid email address.';
        }
    }

    if (empty($errors)) {
        $stmt = get_db()->prepare(
            'UPDATE faculty SET full_name = ?, title = ?, department = ?, bio = ?, email = ?, is_dean = ?, display_order = ?
             WHERE id = ?'
        );
        $stmt->execute([
            $form['full_name'],
            $form['title'],
            $form['department'],
            $form['bio'] !== '' ? $form['bio'] : null,
            $form['email'] !== '' ? $form['email'] : null,
            $form['is_dean'] ? 1 : 0,
            $form['display_order'],
            $id,
        ]);

        flash_set('success', 'Faculty member updated.');
        redirect(BASE_URL . '/admin/faculty/list.php');
    }

    flash_set('error', implode(' ', $errors));
}

$admin_page = 'faculty';
$admin_title = 'Edit Faculty Member';
include __DIR__ . '/../includes/admin-header.php';
?>

<form method="post" action="<?= h(BASE_URL) ?>/admin/faculty/edit.php?id=<?= (int) $id ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= (int) $id ?>">

    <div class="form-group">
        <label for="full_name">Full Name</label>
        <input type="text" id="full_name" name="full_name" class="form-control" maxlength="120" required value="<?= h($form['full_name']) ?>">
    </div>

    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" id="title" name="title" class="form-control" maxlength="100" required placeholder="e.g. Senior Lecturer" value="<?= h($form['title']) ?>">
    </div>

    <div class="form-group">
        <label for="department">Department</label>
        <select id="department" name="department" class="form-control" required>
            <option value="">-- Select Department --</option>
            <?php foreach (FACULTY_DEPARTMENTS as $dept): ?>
                <option value="<?= h($dept) ?>" <?= $form['department'] === $dept ? 'selected' : '' ?>><?= h($dept) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="bio">Bio</label>
        <textarea id="bio" name="bio" class="form-control" rows="6"><?= h($form['bio']) ?></textarea>
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" class="form-control" maxlength="150" value="<?= h($form['email']) ?>">
    </div>

    <div class="form-group">
        <label>
            <input type="checkbox" name="is_dean" value="1" <?= $form['is_dean'] ? 'checked' : '' ?>>
            Is Dean
        </label>
    </div>

    <div class="form-group">
        <label for="display_order">Display Order</label>
        <input type="number" id="display_order" name="display_order" class="form-control" value="<?= (int) $form['display_order'] ?>">
    </div>

    <button type="submit" class="btn btn-primary">Save Changes</button>
    <a href="<?= h(BASE_URL) ?>/admin/faculty/list.php" class="btn btn-outline-dark">Cancel</a>
</form>

<?php include __DIR__ . '/../includes/admin-footer.php'; ?>
