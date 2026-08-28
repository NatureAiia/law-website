<?php
/**
 * Shared helpers used across every public and admin page.
 * Requires config.php (session already started) to be included first.
 */

// --- Shared category lists: single source of truth, reused by forms, DB ENUM values, and display code ---

// Matches the `faculty`.`department` ENUM in sql/schema.sql
const FACULTY_DEPARTMENTS = ['Private Law', 'Procedural Law', 'Public Law', 'Administration'];

// Matches the `legal_help_requests`.`issue_category` ENUM in sql/schema.sql (case-intake categories only)
const LEGAL_HELP_CATEGORIES = [
    'Family Law',
    'Housing & Land',
    'Human Rights',
    'Health & HIV/AIDS Related',
    'Consumer/Small Claims',
    'Other',
];

// Matches the `news_events`.`category` ENUM in sql/schema.sql
const NEWS_EVENT_CATEGORIES = ['news', 'event'];

/**
 * Escape a string for safe HTML output. Use this around every piece of
 * DB-sourced or user-supplied text before echoing it into a page.
 */
function h(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Render a TEXT body (news article, bio, submission description) as safe
 * paragraphed HTML: escape first, then convert newlines to <br>. Never
 * renders raw HTML from the database.
 */
function render_body(?string $value): string
{
    return nl2br(h($value));
}

function format_date(?string $date, string $format = 'F j, Y'): string
{
    if (empty($date)) {
        return '';
    }
    $ts = strtotime($date);
    return $ts === false ? '' : date($format, $ts);
}

function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}

// --- CSRF protection ---

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . h(csrf_token()) . '">';
}

function csrf_verify(?string $token): bool
{
    return is_string($token) && !empty($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// --- Flash messages (one-time success/error banners across a redirect) ---

function flash_set(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function flash_get(): ?array
{
    if (empty($_SESSION['flash'])) {
        return null;
    }
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flash;
}

/**
 * Validate a value against a whitelist (used for ENUM fields before every
 * INSERT/UPDATE so nothing outside the known set ever reaches the DB).
 */
function in_whitelist(string $value, array $whitelist): bool
{
    return in_array($value, $whitelist, true);
}
