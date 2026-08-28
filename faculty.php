<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

$stmt = get_db()->prepare(
    'SELECT id, full_name, title, department, bio, email, photo_path, is_dean, display_order
     FROM faculty
     ORDER BY is_dean DESC, display_order ASC'
);
$stmt->execute();
$faculty = $stmt->fetchAll();

function faculty_initials(string $full_name): string
{
    $name = trim(preg_replace('/^\[.*?\]\s*/', '', $full_name));
    $titles = ['dr', 'dr.', 'prof', 'prof.', 'mr', 'mr.', 'mrs', 'mrs.', 'ms', 'ms.', 'adv', 'adv.'];
    $words = preg_split('/\s+/', $name);
    $real = [];
    foreach ($words as $w) {
        if ($w === '') {
            continue;
        }
        $clean = strtolower(trim($w, '.'));
        if (in_array($clean, array_map(fn($t) => trim($t, '.'), $titles), true)) {
            continue;
        }
        $real[] = $w;
    }
    if (count($real) === 0) {
        return '?';
    }
    if (count($real) === 1) {
        return mb_strtoupper(mb_substr($real[0], 0, 1));
    }
    $first = mb_strtoupper(mb_substr($real[0], 0, 1));
    $last = mb_strtoupper(mb_substr($real[count($real) - 1], 0, 1));
    return $first . $last;
}

$page = 'faculty';
$page_title = 'Faculty Directory';
include __DIR__ . '/includes/header.php';
?>

<div class="page-header">
    <div class="container">
        <h1>Meet Our Faculty</h1>
        <p>Our dedicated teaching staff bring decades of scholarship, legal practice, and mentorship to every classroom across the School of Law.</p>
    </div>
</div>

<div class="section">
    <div class="container">
        <?php if (empty($faculty)): ?>
            <p class="text-center">Faculty information coming soon.</p>
        <?php else: ?>
            <div class="grid grid-3">
                <?php foreach ($faculty as $member): ?>
                    <div class="card card-faculty">
                        <div class="avatar"><?= h(faculty_initials($member['full_name'])) ?></div>
                        <h3>
                            <?= h($member['full_name']) ?>
                            <?php if (!empty($member['is_dean'])): ?>
                                <span class="badge badge-dean">Dean</span>
                            <?php endif; ?>
                        </h3>
                        <p><?= h($member['title']) ?></p>
                        <p class="text-center"><small><?= h($member['department']) ?></small></p>
                        <?php if (!empty($member['bio'])): ?>
                            <?php
                            $bio = $member['bio'];
                            $excerpt = mb_strlen($bio) > 150 ? mb_substr($bio, 0, 150) . '…' : $bio;
                            ?>
                            <p><?= render_body($excerpt) ?></p>
                        <?php endif; ?>
                        <?php if (!empty($member['email'])): ?>
                            <p><a href="mailto:<?= h($member['email']) ?>"><?= h($member['email']) ?></a></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
