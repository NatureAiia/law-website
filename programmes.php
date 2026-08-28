<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$page = 'programmes';
$page_title = 'Programmes';
include __DIR__ . '/includes/header.php';
?>

<div class="page-header">
    <div class="container">
        <h1>Programmes</h1>
        <p>Explore our degree programmes offered across the School's three academic departments.</p>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="grid grid-3">
            <div>
                <h2>Private Law</h2>
                <div class="card-programme">
                    <h3>Bachelor of Laws Honours (LLB)</h3>
                    <p>A comprehensive undergraduate degree covering the private law fields of contract, property, and family law.</p>
                </div>
                <div class="card-programme">
                    <h3>Doctor of Philosophy in Intellectual Property</h3>
                    <p>An advanced doctoral programme for scholars pursuing original research in intellectual property law.</p>
                </div>
            </div>
            <div>
                <h2>Procedural Law</h2>
                <div class="card-programme">
                    <h3>Bachelor of Laws Honours (LLB)</h3>
                    <p>Builds strong grounding in civil and criminal procedure, evidence, and litigation practice.</p>
                </div>
            </div>
            <div>
                <h2>Public Law</h2>
                <div class="card-programme">
                    <h3>Bachelor of Laws Honours (LLB)</h3>
                    <p>Introduces students to constitutional law, human rights, and administrative law fundamentals.</p>
                </div>
                <div class="card-programme">
                    <h3>Master in Intellectual Property</h3>
                    <p>A graduate degree focused on the legal frameworks protecting creative and innovative works.</p>
                </div>
                <div class="card-programme">
                    <h3>Master in Human Rights, Peace &amp; Development</h3>
                    <p>Prepares graduates to advance human rights, peacebuilding, and development across Africa.</p>
                </div>
                <div class="card-programme">
                    <h3>MSc in Child Rights and Childhood Studies</h3>
                    <p>Examines the legal and social frameworks protecting the rights and wellbeing of children.</p>
                </div>
                <div class="card-programme">
                    <h3>Doctor of Philosophy in Child Rights and Childhood Studies</h3>
                    <p>A doctoral programme for advanced research into child rights law and policy.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section section-alt text-center">
    <div class="container">
        <h2>Ready to Apply?</h2>
        <p>Get in touch with the School of Law to learn more about admission requirements and how to apply.</p>
        <a class="btn btn-accent" href="contact.php">Contact Us</a>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
