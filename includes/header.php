<?php
/**
 * Shared page header. Expects the including page to have already set:
 *   $page        - short slug matching a nav link's data-page (e.g. 'home')
 *   $page_title  - string used in <title>
 * and to have already required config.php, db.php, functions.php.
 */
$page = $page ?? '';
$page_title = $page_title ?? APP_NAME;
$flash = flash_get();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= h($page_title) ?> | <?= h(APP_NAME) ?></title>
<link rel="stylesheet" href="<?= h(BASE_URL) ?>/assets/css/style.css">
</head>
<body data-page="<?= h($page) ?>">

<nav class="navbar">
  <div class="navbar-inner">
    <a class="brand" href="<?= h(BASE_URL) ?>/index.php">
      <span class="brand-logo">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <circle cx="12" cy="12" r="11" fill="#ffffff"/>
          <path d="M12 3c-1 2-3 3-3 5.5 0 1 .4 1.8 1 2.4-1.8.4-3.5 1.7-4.3 3.6-.2.5.2 1 .7.8 1.4-.6 2.9-.9 4.3-.9v4.1a.6.6 0 0 0 1.2 0v-4.1c1.4 0 2.9.3 4.3.9.5.2.9-.3.7-.8-.8-1.9-2.5-3.2-4.3-3.6.6-.6 1-1.4 1-2.4C13.6 6 11.6 5 12 3z" fill="#5c1010"/>
        </svg>
      </span>
      <span><span class="brand-text-au">AU</span> <span class="brand-text-law">School of Law</span></span>
    </a>
    <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation" aria-expanded="false">&#9776;</button>
    <ul class="nav-links" id="navLinks">
      <li><a href="<?= h(BASE_URL) ?>/index.php" data-page="home">Home</a></li>
      <li><a href="<?= h(BASE_URL) ?>/about.php" data-page="about">About</a></li>
      <li><a href="<?= h(BASE_URL) ?>/programmes.php" data-page="programmes">Programmes</a></li>
      <li><a href="<?= h(BASE_URL) ?>/law-clinic.php" data-page="law-clinic">Law Clinic</a></li>
      <li><a href="<?= h(BASE_URL) ?>/faculty.php" data-page="faculty">Faculty</a></li>
      <li><a href="<?= h(BASE_URL) ?>/news.php" data-page="news">News &amp; Events</a></li>
      <li><a href="<?= h(BASE_URL) ?>/contact.php" data-page="contact">Contact</a></li>
    </ul>
  </div>
</nav>

<?php if ($flash): ?>
<div class="container" style="padding-top: var(--space-4);">
  <div class="alert alert-<?= h($flash['type']) ?>"><?= h($flash['message']) ?></div>
</div>
<?php endif; ?>
