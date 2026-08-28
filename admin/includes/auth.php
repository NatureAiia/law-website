<?php
/**
 * Include at the very top of every admin page except login.php.
 * Requires includes/config.php (and thus an active session) to already be loaded.
 */
if (empty($_SESSION['admin_id'])) {
    redirect(BASE_URL . '/admin/login.php');
}
