<?php
/**
 * Shared admin chrome. Expects the including page to have already set:
 *   $admin_page   - short slug matching a sidebar link (dashboard|news|faculty|submissions)
 *   $admin_title  - string used in <title> and the topbar heading
 * and to have already required config.php, db.php, functions.php, and admin/includes/auth.php.
 */
$admin_page = $admin_page ?? '';
$admin_title = $admin_title ?? 'Admin';
$flash = flash_get();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= h($admin_title) ?> | Admin | <?= h(APP_NAME) ?></title>
<link rel="stylesheet" href="<?= h(BASE_URL) ?>/assets/css/style.css">
</head>
<body>
<div class="admin-shell">
  <aside class="admin-sidebar">
    <h4 style="color:#fff;margin-bottom:1.5rem;">Admin Panel</h4>
    <a href="<?= h(BASE_URL) ?>/admin/index.php" class="<?= $admin_page === 'dashboard' ? 'active' : '' ?>">Dashboard</a>
    <a href="<?= h(BASE_URL) ?>/admin/news/list.php" class="<?= $admin_page === 'news' ? 'active' : '' ?>">News &amp; Events</a>
    <a href="<?= h(BASE_URL) ?>/admin/faculty/list.php" class="<?= $admin_page === 'faculty' ? 'active' : '' ?>">Faculty</a>
    <a href="<?= h(BASE_URL) ?>/admin/submissions/list.php" class="<?= $admin_page === 'submissions' ? 'active' : '' ?>">Legal Help Requests</a>
    <hr style="border-color: rgba(255,255,255,0.2); margin: 1rem 0;">
    <a href="<?= h(BASE_URL) ?>/index.php" target="_blank">View Site &#8599;</a>
    <a href="<?= h(BASE_URL) ?>/admin/logout.php">Logout</a>
  </aside>
  <main class="admin-main">
    <div class="admin-topbar">
      <h2 class="mb-0"><?= h($admin_title) ?></h2>
      <span>Signed in as <strong><?= h($_SESSION['admin_name'] ?? '') ?></strong></span>
    </div>
    <?php if ($flash): ?>
      <div class="alert alert-<?= h($flash['type']) ?>"><?= h($flash['message']) ?></div>
    <?php endif; ?>
