<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$page = 'contact';
$page_title = 'Contact Us';
include __DIR__ . '/includes/header.php';
?>

<div class="page-header">
    <div class="container">
        <h1>Contact Us</h1>
        <p>Reach out to either of our campuses with your questions.</p>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="grid grid-2">
            <div class="card">
                <h3>Main Campus</h3>
                <p>Old Mutare, Zimbabwe</p>
                <p>Phone: <a href="tel:+263 8688002151">+263 8688002151</a></p>
                <p>Email: <a href="mailto:info@africau.edu">info@africau.edu</a></p>
            </div>
            <div class="card">
                <h3>AU Global Campus</h3>
                <p>Harare, Zimbabwe</p>
                <p>Phone: <a href="tel:+263 778879492">+263 778879492</a></p>
                <p>Email: <a href="mailto:globalcampus@africau.edu">globalcampus@africau.edu</a></p>
            </div>
        </div>
    </div>
</section>

<section class="section section-alt text-center">
    <div class="container">
        <h2>Need Legal Assistance?</h2>
        <p>If you are seeking free legal help rather than a general enquiry, please visit our Law Clinic page to learn how to submit your request.</p>
        <a class="btn btn-primary" href="law-clinic.php">Visit the Law Clinic</a>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
