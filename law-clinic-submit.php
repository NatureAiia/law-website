<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect(BASE_URL . '/law-clinic.php');
}

if (!csrf_verify($_POST['csrf_token'] ?? null)) {
    flash_set('error', 'Your session expired. Please try again.');
    redirect(BASE_URL . '/law-clinic.php#legal-help-form');
}

$full_name = trim($_POST['full_name'] ?? '');
$contact_info = trim($_POST['contact_info'] ?? '');
$issue_category = trim($_POST['issue_category'] ?? '');
$description = trim($_POST['description'] ?? '');

$valid = true;

if ($full_name === '' || mb_strlen($full_name) > 120) {
    $valid = false;
}
if ($contact_info === '' || mb_strlen($contact_info) > 150) {
    $valid = false;
}
if (!in_whitelist($issue_category, LEGAL_HELP_CATEGORIES)) {
    $valid = false;
}
if ($description === '') {
    $valid = false;
}

if (!$valid) {
    flash_set('error', 'Please fill in all fields correctly.');
    redirect(BASE_URL . '/law-clinic.php#legal-help-form');
}

$db = get_db();
$stmt = $db->prepare('INSERT INTO legal_help_requests (full_name, contact_info, issue_category, description) VALUES (?, ?, ?, ?)');
$stmt->execute([$full_name, $contact_info, $issue_category, $description]);

flash_set('success', 'Thank you — your request has been received. Our Law Clinic team will be in touch soon.');
redirect(BASE_URL . '/law-clinic.php?submitted=1#legal-help-form');
