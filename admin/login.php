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
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= h(BASE_URL) ?>/assets/css/style.css">
</head>
<body style="background: var(--gradient-brand); min-height: 100vh; display: flex; align-items: center; position: relative; overflow: hidden; isolation: isolate;">
<div style="position:absolute; width:420px; height:420px; border-radius:50%; background:var(--color-gold); opacity:0.25; filter:blur(90px); top:-160px; right:-100px; z-index:-1;"></div>
<div style="position:absolute; width:360px; height:360px; border-radius:50%; background:var(--color-crimson-light); opacity:0.25; filter:blur(90px); bottom:-160px; left:-100px; z-index:-1;"></div>
<div class="container" style="max-width: 420px;">
  <div class="text-center" style="margin-bottom: var(--space-4);">
    <span class="brand-logo" style="margin: 0 auto var(--space-3); width:56px; height:56px; box-shadow:0 0 0 4px rgba(217,171,61,0.4);">
      <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" style="width:34px;height:34px;">
        <circle cx="12" cy="12" r="11" fill="#ffffff"/>
        <path d="M12 3c-1 2-3 3-3 5.5 0 1 .4 1.8 1 2.4-1.8.4-3.5 1.7-4.3 3.6-.2.5.2 1 .7.8 1.4-.6 2.9-.9 4.3-.9v4.1a.6.6 0 0 0 1.2 0v-4.1c1.4 0 2.9.3 4.3.9.5.2.9-.3.7-.8-.8-1.9-2.5-3.2-4.3-3.6.6-.6 1-1.4 1-2.4C13.6 6 11.6 5 12 3z" fill="#3d0a0a"/>
      </svg>
    </span>
    <h1 style="font-size:1.6rem; color: var(--color-white);">Admin Login</h1>
    <p style="color: rgba(255,255,255,0.82);">School of Law content management</p>
  </div>
  <div class="card" style="box-shadow: var(--shadow-lg); border: none;">
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
  <p class="text-center" style="margin-top: var(--space-4);"><a href="<?= h(BASE_URL) ?>/index.php" style="color: rgba(255,255,255,0.85);">&larr; Back to site</a></p>
</div>
</body>
</html>
