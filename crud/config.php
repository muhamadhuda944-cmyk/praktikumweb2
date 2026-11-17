<?php
// Mulai session jika belum dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Konfigurasi Database
$databaseHost     = 'localhost';
$databaseName     = 'simrs';
$databseUsername  = 'root'; // tetap dipertahankan untuk kompatibilitas kode lama
$databaseUsername = 'root';
$databasePassword = '';

// Koneksi ke database MySQL
$mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);

if (!$mysqli) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Pastikan tabel 'users' otomatis tersedia jika belum ada
$tableUsersQuery = "CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nama` VARCHAR(100) NOT NULL,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
mysqli_query($mysqli, $tableUsersQuery);

// Pastikan tabel 'alat' memiliki kolom lokasi yang cukup panjang
@mysqli_query($mysqli, "ALTER TABLE `alat` MODIFY `lokasi` VARCHAR(50)");

// Seed user admin default jika tabel users masih kosong
$checkUser = mysqli_query($mysqli, "SELECT COUNT(*) as total FROM `users`");
if ($checkUser) {
    $row = mysqli_fetch_assoc($checkUser);
    if ((int)$row['total'] === 0) {
        $defaultPass = password_hash('admin123', PASSWORD_DEFAULT);
        $insertAdmin = "INSERT INTO `users` (`nama`, `username`, `email`, `password`) 
                        VALUES ('Administrator', 'admin', 'admin@simrs.local', '$defaultPass')";
        mysqli_query($mysqli, $insertAdmin);
    }
}
?>
