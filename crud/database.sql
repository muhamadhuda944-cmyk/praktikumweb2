-- Database: simrs
-- Skrip Pembuatan Database dan Tabel untuk Aplikasi SIM RS Praktikum 2

CREATE DATABASE IF NOT EXISTS `simrs` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `simrs`;

-- --------------------------------------------------------
-- Struktur dari tabel `users`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Data awal untuk tabel `users`
-- Password default: admin123
-- --------------------------------------------------------
INSERT INTO `users` (`id`, `nama`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'Administrator', 'admin', 'admin@simrs.local', '$2y$10$UoW0M4kKx8c8qZ5Z4x7N4.q6D/3gT8G7iF2n0bH9Oq3h7j9v9t5yq', NOW())
ON DUPLICATE KEY UPDATE `id`=`id`;

-- --------------------------------------------------------
-- Struktur dari tabel `alat`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `alat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_alat` varchar(100) NOT NULL,
  `tahun` year(4) NOT NULL,
  `merek` varchar(60) NOT NULL,
  `lokasi` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Data contoh untuk tabel `alat`
-- --------------------------------------------------------
INSERT INTO `alat` (`id`, `nama_alat`, `tahun`, `merek`, `lokasi`) VALUES
(4, 'X-Ray Stationary', 2023, 'Ceiling Unit', 'Radiologi Central'),
(5, 'Defibrillator Monitor', 2022, 'Philips HeartStart', 'IGD Emergency'),
(6, 'Infusion Pump', 2024, 'Terumo TE-171', 'ICU'),
(7, 'Electrocardiograph (ECG)', 2023, 'Nihon Kohden', 'Poli Jantung')
ON DUPLICATE KEY UPDATE `id`=`id`;
