<?php
require_once __DIR__ . '/config.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?auth_required=1");
    exit;
}
?>
