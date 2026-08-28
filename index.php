<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$stmt = get_db()->prepare("SELECT id, title, category, summary, entry_date FROM news_events ORDER BY entry_date DESC LIMIT 3");
$stmt->execute();
$latest_news = $stmt->fetchAll();

$page = 'home';
$page_title = 'Home';
include __DIR__ . '/includes/header.php';
?>

<section class="hero">
    <div class="container">
        <span class="eyebrow" style="justify-content:center;color:var(--color-gold-light);">Africa University &middot; A United Methodist-Related Institution</span>
        <h1>Africa University School of Law</h1>
        <p class="lead">A dedicated home for the School of Law &mdash; showcasing our programmes, faculty, activities, and the community impact of our Law Clinic.</p>
        <div class="hero-actions">
            <a class="btn btn-accent" href="law-clinic.php#legal-help-form">Get Legal Help</a>
            <a class="btn btn-outline" href="programmes.php">Explore Programmes</a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="stats-strip">
            <div class="grid grid-3">
                <div>
                    <div class="stat-number">95</div>
                    <div class="stat-label">Students</div>
                </div>
                <div>
                    <div class="stat-number">6</div>
                    <div class="stat-label">Faculty Members</div>
                </div>
                <div>
                    <div class="stat-number">6</div>
                    <div class="stat-label">Programmes</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container text-center">
        <h2>About the School</h2>
        <p>The Africa University School of Law prepares principled, practice-ready graduates through rigorous legal education grounded in African and international law. Through our academic programmes and community-facing Law Clinic, we combine scholarship with real-world impact.</p>
        <p><a href="about.php">Learn More &rarr;</a></p>
    </div>
</section>

<section class="section section-alt">
    <div class="container">
        <div class="grid grid-2">
            <div>
                <h2>Law Clinic Spotlight</h2>
                <p>Our Law Clinic is the flagship community engagement programme of the School, providing free legal assistance to underserved members of the Old Mutare and surrounding communities. Supervised student volunteers handle real cases spanning family law, housing and land disputes, human rights matters, and consumer complaints &mdash; gaining hands-on experience while extending access to justice.</p>
                <p><a class="btn btn-primary" href="law-clinic.php">Visit the Law Clinic</a></p>
            </div>
            <div>
                <div class="card-img-placeholder" style="height:260px;">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" style="width:64px;height:64px;">
                        <path d="M12 3v18M12 3l-6 3.5M12 3l6 3.5M4 8l-2.5 5a3 3 0 0 0 5.9 0L5 8m14 0l-2.4 5a3 3 0 0 0 5.9 0L20 8M4 21h16" stroke="#fff" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <h2 class="text-center">Our Programmes</h2>
        <div class="grid grid-3">
            <a class="card-programme" href="programmes.php">
                <h3>Bachelor of Laws Honours (LLB)</h3>
                <p>Our foundational undergraduate law degree, offered across Private, Procedural, and Public Law.</p>
            </a>
            <a class="card-programme" href="programmes.php">
                <h3>Master in Human Rights, Peace &amp; Development</h3>
                <p>A graduate programme focused on human rights protection and development in Africa.</p>
            </a>
            <a class="card-programme" href="programmes.php">
                <h3>PhD in Intellectual Property</h3>
                <p>Advanced doctoral research in intellectual property law and policy.</p>
            </a>
        </div>
    </div>
</section>

<section class="section section-alt">
    <div class="container">
        <h2 class="text-center">Latest News &amp; Events</h2>
        <?php if (empty($latest_news)): ?>
            <p class="text-center">No news yet.</p>
        <?php else: ?>
            <div class="carousel" id="newsCarousel">
                <div class="carousel-track">
                    <?php foreach ($latest_news as $i => $item): ?>
                        <div class="carousel-slide">
                            <div class="carousel-slide-inner">
                                <span class="badge <?= $item['category'] === 'event' ? 'badge-event' : 'badge-news' ?>"><?= h(ucfirst($item['category'])) ?></span>
                                <h3><?= h($item['title']) ?></h3>
                                <p><?= h($item['summary']) ?></p>
                                <p><small><?= h(format_date($item['entry_date'])) ?></small></p>
                                <p><a href="news-detail.php?id=<?= (int) $item['id'] ?>">Read More &rarr;</a></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="carousel-controls">
                    <?php foreach ($latest_news as $i => $item): ?>
                        <button class="carousel-dot<?= $i === 0 ? ' active' : '' ?>"></button>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="hero" style="padding: var(--space-6) 0;">
    <div class="container">
        <h2 style="color: var(--color-white);">Get in Touch</h2>
        <p class="lead">Have a question about admissions, programmes, or the Law Clinic? We would love to hear from you.</p>
        <div class="hero-actions">
            <a class="btn btn-outline" href="contact.php">Contact Us</a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
