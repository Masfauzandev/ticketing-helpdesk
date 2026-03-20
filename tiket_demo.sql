-- ============================================================
-- SETUP LENGKAP DATABASE: tiket_demo
-- Jalankan di phpMyAdmin / MySQL CLI pada XAMPP 8.2
-- Script ini akan:
--   1. Membuat database tiket_demo
--   2. Membuat semua tabel
--   3. Mengisi data awal (master + demo users)
--   4. Menerapkan semua upgrade modernisasi
-- ============================================================

-- Buat database
CREATE DATABASE IF NOT EXISTS `tiket_demo` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `tiket_demo`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- ============================================================
-- TABEL: attachments
-- ============================================================
CREATE TABLE `attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `path` varchar(1000) DEFAULT NULL,
  `uploaded_by` varchar(100) DEFAULT NULL,
  `ref` int(11) DEFAULT NULL,
  `ext` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================================
-- TABEL: mst_gender
-- ============================================================
CREATE TABLE `mst_gender` (
  `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode` varchar(2) NOT NULL,
  `nama` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_mjk_kode` (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `mst_gender` (`id`, `kode`, `nama`) VALUES
(1, 'L', 'Male'),
(2, 'P', 'Female');

-- ============================================================
-- TABEL: mst_cabang
-- ============================================================
CREATE TABLE `mst_cabang` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode` varchar(10) NOT NULL,
  `nama_cabang` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_cabang_kode` (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `mst_cabang` (`id`, `kode`, `nama_cabang`, `is_active`) VALUES
(1, 'HO', 'AGA Pusat', 1),
(2, 'HO2', 'TBG Pusat', 1),
(3, 'CBG1', 'AGA Cilegon', 1),
(4, 'CBG2', 'AGA Cikampek', 1),
(5, 'CBG3', 'AGA Tegal', 1),
(6, 'CBG4', 'AGA Purbalingga', 1),
(7, 'CBG5', 'AGA Cikupa', 1),
(8, 'CBG6', 'BAG Jambi', 1),
(9, 'CBG7', 'MAG Bogor', 1),
(10, 'CBG8', 'MBG Bekasi', 1),
(11, 'CBG9', 'SEA Morowali', 1),
(12, 'CBG10', 'TBG Workshop', 1),
(13, 'CBG11', 'AGA Workshop', 1);

-- ============================================================
-- TABEL: mst_divisi
-- ============================================================
CREATE TABLE `mst_divisi` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_divisi` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_nama_divisi` (`nama_divisi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `mst_divisi` (`id`, `nama_divisi`, `is_active`) VALUES
(1, 'IT', 1),
(2, 'Finance', 1),
(3, 'Kasir', 1),
(4, 'HRD', 1),
(5, 'Cost Control', 1),
(6, 'Admin Marketing', 1),
(7, 'Marketing', 1),
(8, 'Admin Invoice', 1),
(9, 'Finance AR', 1),
(10, 'Finance AP', 1),
(11, 'Pajak', 1),
(12, 'Purchasing', 1),
(13, 'Asset', 1),
(14, 'Management', 1),
(15, 'Legal', 1),
(16, 'Admin Operasional', 1),
(17, 'Koordinator Operasional', 1),
(18, 'Marketing Project', 1),
(19, 'Admin Surat Jalan', 1);

-- ============================================================
-- TABEL: mst_category (untuk kategori tiket)
-- ============================================================
CREATE TABLE `mst_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `mst_category` (`id`, `name`, `is_active`) VALUES
(1, 'Bug', 1),
(2, 'Feature Request', 1),
(3, 'Software Troubleshooting', 1),
(4, 'How To', 1),
(5, 'Password Reset', 1),
(6, 'Network', 1),
(7, 'Hardware', 1),
(8, 'Access and Authorization', 1);

-- ============================================================
-- TABEL: users
-- UPGRADE: password VARCHAR(255) untuk bcrypt
-- ============================================================
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `call_name` varchar(100) DEFAULT NULL,
  `employee_id` varchar(50) DEFAULT NULL,
  `gender_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `divisi_id` int(10) UNSIGNED DEFAULT NULL,
  `cabang_id` int(10) UNSIGNED DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_users_gender` (`gender_id`),
  KEY `fk_users_divisi` (`divisi_id`),
  KEY `fk_users_cabang` (`cabang_id`),
  CONSTRAINT `fk_users_cabang` FOREIGN KEY (`cabang_id`) REFERENCES `mst_cabang` (`id`),
  CONSTRAINT `fk_users_divisi` FOREIGN KEY (`divisi_id`) REFERENCES `mst_divisi` (`id`),
  CONSTRAINT `fk_users_gender` FOREIGN KEY (`gender_id`) REFERENCES `mst_gender` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Demo users (password masih MD5; akan otomatis di-rehash ke bcrypt saat login pertama)
-- admin    -> password: admin
-- user.demo -> password: demo
-- agent.demo -> password: demo
INSERT INTO `users` (`id`, `name`, `call_name`, `employee_id`, `gender_id`, `divisi_id`, `cabang_id`, `email`, `mobile`, `username`, `password`, `type`, `status`, `created`, `updated`) VALUES
(1, 'Admin Demo', NULL, NULL, NULL, NULL, NULL, 'admin.demo@tikaj.com', '9999999999', 'admin', '21232f297a57a5a743894a0e4a801fc3', 100, 1, 1568270653, 1769324162),
(2, 'Demo User', NULL, NULL, NULL, NULL, NULL, 'user.demo@tikaj.com', '9999999999', 'user.demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 10, 1, 1569649164, 1569649164),
(3, 'Demo Agent', NULL, NULL, NULL, NULL, NULL, 'agent.demo@tikaj.com', '9999999999', 'agent.demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 60, 1, 1569649194, 1569649194);

-- ============================================================
-- TABEL: tickets
-- ============================================================
CREATE TABLE `tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_no` varchar(50) DEFAULT NULL,
  `owner` varchar(100) NOT NULL,
  `purpose` varchar(500) DEFAULT NULL,
  `subject` varchar(100) NOT NULL,
  `message` varchar(3000) NOT NULL,
  `assign_to` varchar(100) DEFAULT NULL,
  `assign_on` varchar(100) DEFAULT NULL,
  `progress` int(11) NOT NULL DEFAULT 0,
  `updated` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `severity` int(11) DEFAULT 0,
  `priority` int(11) DEFAULT 0,
  `cc` text DEFAULT NULL,
  `data` text DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================================
-- TABEL: messages
-- ============================================================
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `data` text DEFAULT NULL,
  `owner` varchar(100) NOT NULL,
  `ref` int(11) NOT NULL DEFAULT 0,
  `created` int(11) NOT NULL,
  `type` int(11) DEFAULT 0,
  `to` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
