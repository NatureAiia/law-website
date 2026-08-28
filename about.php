<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$stmt = get_db()->prepare("SELECT full_name, title, bio FROM faculty WHERE is_dean = 1 LIMIT 1");
$stmt->execute();
$dean = $stmt->fetch();

$page = 'about';
$page_title = 'About';
include __DIR__ . '/includes/header.php';
?>

<div class="page-header">
    <div class="container">
        <h1>About the School of Law</h1>
        <p>Learn about our mission, our leadership, and the departments that make up the School.</p>
    </div>
</div>

<section class="section">
    <div class="container">
        <h2>Our Mission</h2>
        <p>The Africa University School of Law is a dedicated online platform showcasing the School, its programmes, activities, achievements, and impact. We are committed to producing graduates of integrity who serve their communities with skill and conscience, while advancing access to justice through teaching, research, and community engagement.</p>
    </div>
</section>

<?php if ($dean): ?>
<section class="section section-alt">
    <div class="container">
        <div class="grid grid-2">
            <div>
                <div class="card-img-placeholder">&#128100;</div>
            </div>
            <div>
                <h2>A Welcome from the Dean</h2>
                <p><strong><?= h($dean['full_name']) ?></strong><br>
                <?= h($dean['title']) ?></p>
                <p>&ldquo;Welcome to the Africa University School of Law. Our mission is to cultivate principled, practice-ready legal professionals equipped to serve their communities and shape the rule of law across Africa. Through our academic programmes and the work of our Law Clinic, we strive to combine rigorous scholarship with meaningful service to society. I invite you to explore what we offer and to join us on this journey.&rdquo;</p>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="section">
    <div class="container">
        <h2 class="text-center">Our Departments</h2>
        <div class="grid grid-3">
            <div class="card">
                <h3>Private Law</h3>
                <p>Focuses on the legal relationships between individuals and entities, including contracts, property, and family law.</p>
            </div>
            <div class="card">
                <h3>Procedural Law</h3>
                <p>Covers civil and criminal procedure, the law of evidence, and litigation practice skills essential to courtroom advocacy.</p>
            </div>
            <div class="card">
                <h3>Public Law</h3>
                <p>Examines constitutional law, human rights, and administrative law that govern the relationship between the state and citizens.</p>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
