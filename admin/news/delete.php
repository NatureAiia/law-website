<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(BASE_URL . '/admin/news/list.php');
}

if (!csrf_verify($_POST['csrf_token'] ?? null)) {
    flash_set('error', 'Invalid form submission. Please try again.');
    redirect(BASE_URL . '/admin/news/list.php');
}

$id = (int) ($_POST['id'] ?? 0);

if ($id > 0) {
    $stmt = get_db()->prepare('DELETE FROM news_events WHERE id = ?');
    $stmt->execute([$id]);
}

flash_set('success', 'Item deleted.');
redirect(BASE_URL . '/admin/news/list.php');
