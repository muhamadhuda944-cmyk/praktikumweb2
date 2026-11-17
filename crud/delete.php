<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/auth_check.php';

// Validasi id dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Hapus data alat berdasarkan id menggunakan prepared statement
    $stmt = mysqli_prepare($mysqli, "DELETE FROM alat WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}

// Redirect ke index.php dengan notifikasi
header("Location: index.php?msg=deleted");
exit;
?>
