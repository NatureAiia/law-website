<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

if (!empty($_SESSION['admin_id'])) {
    redirect(BASE_URL . '/admin/index.php');
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_verify($_POST['csrf_token'] ?? null)) {
        $error = 'Your session expired. Please try again.';
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = (string)($_POST['password'] ?? '');

        if ($username === '' || $password === '') {
            $error = 'Please enter both a username and password.';
        } else {
            $stmt = get_db()->prepare('SELECT id, username, password_hash, full_name FROM admins WHERE username = ? LIMIT 1');
            $stmt->execute([$username]);
            $admin = $stmt->fetch();

            if ($admin && password_verify($password, $admin['password_hash'])) {
                session_regenerate_id(true);
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['full_name'];
                redirect(BASE_URL . '/admin/index.php');
            } else {
                // Deliberately generic: never reveal whether the username exists.
                $error = 'Invalid username or password.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login | <?= h(APP_NAME) ?></title>
<link rel="stylesheet" href="<?= h(BASE_URL) ?>/assets/css/style.css">
</head>
<body>
<div class="container" style="max-width: 420px; padding-top: var(--space-6);">
  <div class="text-center" style="margin-bottom: var(--space-4);">
    <h1 style="font-size:1.6rem;">Admin Login</h1>
    <p>School of Law content management</p>
  </div>
  <div class="card">
    <?php if ($error): ?>
      <div class="alert alert-error"><?= h($error) ?></div>
    <?php endif; ?>
    <form method="post" novalidate>
      <?= csrf_field() ?>
      <div class="form-group">
        <label for="username">Username</label>
        <input class="form-control" type="text" id="username" name="username" required autofocus>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input class="form-control" type="password" id="password" name="password" required>
      </div>
      <button type="submit" class="btn btn-primary" style="width:100%;">Log In</button>
    </form>
  </div>
  <p class="text-center" style="margin-top: var(--space-3);"><a href="<?= h(BASE_URL) ?>/index.php">&larr; Back to site</a></p>
</div>
</body>
</html>
