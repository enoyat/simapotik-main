-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 18 Nov 2026 pada 17.16
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pati`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_name` varchar(150) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `module` varchar(50) NOT NULL,
  `activity` varchar(30) NOT NULL,
  `description` varchar(255) NOT NULL,
  `subject_type` varchar(150) DEFAULT NULL,
  `subject_id` varchar(100) DEFAULT NULL,
  `old_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_values`)),
  `new_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_values`)),
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`properties`)),
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `request_id` varchar(64) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `method` varchar(10) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'SUCCESS',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_id_created_at_index` (`user_id`,`created_at`),
  KEY `activity_logs_branch_id_created_at_index` (`branch_id`,`created_at`),
  KEY `activity_logs_module_created_at_index` (`module`,`created_at`),
  KEY `activity_logs_activity_created_at_index` (`activity`,`created_at`),
  KEY `activity_logs_subject_type_subject_id_index` (`subject_type`,`subject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `login_histories`
--

DROP TABLE IF EXISTS `login_histories`;
CREATE TABLE IF NOT EXISTS `login_histories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_name` varchar(150) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `event` varchar(20) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `occurred_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `login_histories_branch_id_foreign` (`branch_id`),
  KEY `login_histories_user_id_occurred_at_index` (`user_id`,`occurred_at`),
  KEY `login_histories_event_occurred_at_index` (`event`,`occurred_at`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `login_histories`
--

INSERT INTO `login_histories` (`id`, `user_id`, `user_name`, `username`, `branch_id`, `event`, `ip_address`, `user_agent`, `session_id`, `occurred_at`) VALUES
(1, 348, 'Test', 'test@gmail.com', NULL, 'LOGOUT', '192.168.1.10', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', 'J5WPivejCNPKTQZOKb0Bcg0Y7A0O01MWpUxwpgiP', '2026-11-18 16:13:47'),
(2, 264, 'Admin', 'admin@gmail.com', NULL, 'LOGIN', '192.168.1.10', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', 'DPMNGONCyErsRfucZ69vPb0eoaC2jAqzNHuKj7Nx', '2026-11-18 16:13:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `stock_audits`
--

DROP TABLE IF EXISTS `stock_audits`;
CREATE TABLE IF NOT EXISTS `stock_audits` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `kdbarang` varchar(100) DEFAULT NULL,
  `idlokasi` varchar(100) DEFAULT NULL,
  `stok_awal` int(11) NOT NULL,
  `perubahan` int(11) NOT NULL,
  `stok_akhir` int(11) NOT NULL,
  `aktivitas` varchar(50) NOT NULL DEFAULT 'STOK_UPDATE',
  `referensi_id` varchar(100) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `username` varchar(150) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_stock_barang` (`kdbarang`),
  KEY `idx_stock_lokasi` (`idlokasi`),
  KEY `idx_stock_aktivitas` (`aktivitas`),
  KEY `idx_stock_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `login_histories`
--
ALTER TABLE `login_histories`
  ADD CONSTRAINT `login_histories_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `login_histories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
