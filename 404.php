<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$page = '';
$page_title = 'Not Found';
include __DIR__ . '/includes/header.php';
?>

<div class="page-header">
    <div class="container text-center">
        <h1>Page Not Found</h1>
        <p>Sorry, the page you are looking for does not exist or may have been moved.</p>
    </div>
</div>

<section class="section text-center">
    <div class="container">
        <a class="btn btn-primary" href="index.php">Return to Home</a>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
