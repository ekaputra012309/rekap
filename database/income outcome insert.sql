-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping data for table rekap.incomes: ~11 rows (approximately)
INSERT INTO `incomes` (`id`, `nama_list_in`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, 'Tromol Rawatib', 1, '2025-06-25 20:48:37', '2025-06-25 20:48:37'),
	(2, 'Kotak Parkir', 1, '2025-06-25 20:49:37', '2025-06-25 20:49:37'),
	(3, 'Kajian Sabtu Subuh', 1, '2025-06-25 20:49:53', '2025-06-25 21:18:05'),
	(4, 'Kajian Kamis Malam', 1, '2025-06-25 20:50:09', '2025-06-25 21:17:30'),
	(5, 'Kajian Ahad Malam', 1, '2025-06-25 20:50:17', '2025-06-25 21:18:46'),
	(6, 'Kotak Ifthar', 1, '2025-06-25 20:50:42', '2025-06-25 20:50:42'),
	(7, 'Kotak Amal', 1, '2025-06-25 20:50:53', '2025-06-25 20:50:53'),
	(8, 'Tromol Jum\'at', 1, '2025-06-25 20:51:06', '2025-06-25 20:51:06'),
	(12, 'Infaq Sewa Toko', 1, '2025-06-25 21:08:33', '2025-06-25 21:08:33'),
	(13, 'Infaq Lain-lain', 1, '2025-06-25 21:08:43', '2025-06-25 21:08:43'),
	(14, 'Kajian Ahad Subuh', 1, '2025-06-25 21:19:06', '2025-06-25 21:19:06');

-- Dumping data for table rekap.outcomes: ~10 rows (approximately)
INSERT INTO `outcomes` (`id`, `nama_list_out`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, 'Uang Harian Marbot', 1, '2025-06-26 05:00:57', '2025-06-26 05:00:57'),
	(2, 'Ifthor', 1, '2025-06-26 05:00:57', '2025-06-26 05:00:57'),
	(3, 'Transport Ustadz Kajian Kamis Malam', 1, '2025-06-26 05:00:57', '2025-06-26 05:00:57'),
	(4, 'Transport Khotib Jum\'at', 1, '2025-06-26 05:00:57', '2025-06-26 05:00:57'),
	(5, 'Kosumsi Jum\'at', 1, '2025-06-26 05:00:57', '2025-06-26 05:00:57'),
	(6, 'Kosumsi Kajian Sabtu Ahad', 1, '2025-06-26 05:00:57', '2025-06-26 05:00:57'),
	(7, 'Transport Ustadz Kajian Sabtu Subuh', 1, '2025-06-26 05:00:57', '2025-06-26 05:00:57'),
	(8, 'Transport Ustadz Kajian Ahad Subuh', 1, '2025-06-26 05:00:57', '2025-06-26 05:00:57'),
	(9, 'Iuran Sampah', 1, '2025-06-26 05:00:57', '2025-06-26 05:00:57'),
	(10, 'Uang Kas', 1, '2025-06-26 05:00:57', '2025-06-26 05:00:57');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
