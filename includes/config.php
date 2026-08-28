<?php
/**
 * Central configuration: DB credentials, session cookie hardening, debug flag.
 * Must be included before session_start() is ever called anywhere in the app.
 */

// --- Database ---
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'au_law_school');
define('DB_USER', 'root');
define('DB_PASS', ''); // XAMPP default: blank root password. Change for other environments.
define('DB_CHARSET', 'utf8mb4');

// --- App ---
define('APP_DEBUG', true); // Set to false in production: suppresses raw error output.
define('APP_NAME', 'Africa University School of Law');
define('BASE_URL', '/law-website'); // Adjust if the project folder name under htdocs differs.

// --- Session hardening (must run before session_start()) ---
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

if (APP_DEBUG) {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
    error_reporting(0);
}
