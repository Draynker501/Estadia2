-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.30 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para estadia
CREATE DATABASE IF NOT EXISTS `estadia` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `estadia`;

-- Volcando estructura para tabla estadia.customers
CREATE TABLE IF NOT EXISTS `customers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customers_phone_unique` (`phone`),
  UNIQUE KEY `customers_email_unique` (`email`),
  KEY `customers_user_id_foreign` (`user_id`),
  CONSTRAINT `customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla estadia.customers: ~50 rows (aproximadamente)
INSERT INTO `customers` (`id`, `user_id`, `name`, `last_name`, `phone`, `email`, `status`, `created_at`, `updated_at`) VALUES
	(1, 2, 'Monroe', 'Gorczany', '839 517 832 165', 'damien.jacobi@example.com', 1, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(2, 2, 'Vanessa', 'Reichert', '878 351 344 379', 'emerson53@example.net', 1, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(3, 2, 'Mittie', 'DuBuque', '286 675 182 162', 'richard99@example.com', 1, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(4, 2, 'Fleta', 'Ebert', '053 566 432 459', 'roman68@example.com', 1, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(5, 2, 'Hector', 'Dibbert', '928 737 626 471', 'vidal07@example.org', 1, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(6, 2, 'Anna', 'Erdman', '203 241 402 879', 'rolson@example.com', 1, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(7, 2, 'Adrianna', 'Ankunding', '663 787 781 171', 'swillms@example.net', 1, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(8, 2, 'Joesph', 'Hartmann', '585 763 503 255', 'gerson83@example.net', 1, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(9, 2, 'Celine', 'Von', '820 193 364 830', 'hoeger.laurianne@example.net', 1, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(10, 2, 'Josiane', 'West', '426 530 292 347', 'darryl67@example.com', 1, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(11, 2, 'Queenie', 'McKenzie', '193 808 802 698', 'kylee88@example.com', 1, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(12, 2, 'Anna', 'Legros', '636 549 193 948', 'adrian67@example.net', 1, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(13, 2, 'Hailie', 'Walter', '892 318 449 003', 'fisher.ariel@example.org', 1, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(14, 2, 'Una', 'Shields', '351 004 420 988', 'margaret57@example.com', 1, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(15, 2, 'Loyce', 'Ernser', '185 194 848 931', 'nbergstrom@example.net', 1, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(16, 2, 'Marilie', 'Bergnaum', '543 859 473 340', 'macejkovic.dayton@example.org', 1, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(17, 2, 'Prudence', 'Walter', '652 820 879 303', 'sammie.carroll@example.com', 1, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(18, 2, 'Sam', 'Dooley', '828 922 579 192', 'ffisher@example.org', 1, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(19, 2, 'Durward', 'Reinger', '974 258 592 456', 'rath.kaley@example.net', 1, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(20, 2, 'Eveline', 'Klocko', '670 299 360 295', 'gcasper@example.com', 1, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(21, 2, 'Monty', 'Crona', '384 786 969 653', 'lilliana.jones@example.org', 1, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(22, 2, 'Guy', 'O\'Keefe', '026 773 707 290', 'mpfannerstill@example.com', 1, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(23, 2, 'Veronica', 'Bogisich', '261 971 713 301', 'abbey.zulauf@example.org', 1, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(24, 2, 'Deondre', 'McCullough', '867 110 347 306', 'rodolfo.windler@example.com', 1, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(25, 2, 'Gerhard', 'Wuckert', '140 628 367 801', 'turcotte.marge@example.org', 1, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(26, 3, 'Chandler', 'Kunze', '341 067 687 843', 'jarret.oreilly@example.org', 0, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(27, 3, 'Baylee', 'Franecki', '720 966 360 931', 'clemens.konopelski@example.com', 0, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(28, 3, 'Geoffrey', 'Cummings', '562 868 193 573', 'stanton.vladimir@example.com', 0, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(29, 3, 'Mackenzie', 'Keeling', '243 478 681 701', 'allen.crooks@example.org', 0, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(30, 3, 'Madisen', 'Mitchell', '974 726 870 600', 'vcronin@example.com', 0, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(31, 3, 'Reuben', 'Thiel', '008 005 634 939', 'sandrine.runte@example.net', 0, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(32, 3, 'Rosie', 'Hand', '253 710 039 241', 'roob.anderson@example.com', 0, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(33, 3, 'Assunta', 'Goyette', '576 071 504 645', 'bergnaum.zoila@example.net', 0, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(34, 3, 'Olin', 'Borer', '843 281 846 756', 'mueller.jovanny@example.net', 0, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(35, 3, 'Camylle', 'Kihn', '076 347 215 384', 'reichel.lupe@example.net', 0, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(36, 3, 'Tyrique', 'Jaskolski', '732 903 456 507', 'chesley97@example.com', 0, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(37, 3, 'Scottie', 'Ondricka', '104 682 799 769', 'considine.genoveva@example.net', 0, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(38, 3, 'Penelope', 'Runolfsdottir', '220 656 926 891', 'breanna11@example.net', 0, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(39, 3, 'Ethyl', 'Johnson', '081 707 735 371', 'pollich.alexandrine@example.org', 0, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(40, 3, 'Angela', 'Schaefer', '005 086 792 259', 'adams.carson@example.org', 0, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(41, 3, 'Barrett', 'Labadie', '703 911 522 247', 'vyundt@example.org', 0, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(42, 3, 'Vito', 'Ferry', '333 649 463 257', 'fisher.amie@example.com', 0, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(43, 3, 'Hilma', 'Shanahan', '283 965 912 834', 'sofia03@example.com', 0, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(44, 3, 'Landen', 'Emard', '335 955 208 851', 'ada.hudson@example.com', 0, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(45, 3, 'Carlos', 'Gulgowski', '432 637 577 964', 'ward.ortiz@example.net', 0, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(46, 3, 'Martina', 'Lang', '109 968 717 283', 'oolson@example.net', 0, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(47, 3, 'Ron', 'Dickens', '433 997 658 921', 'osteuber@example.com', 0, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(48, 3, 'Melany', 'Balistreri', '504 053 640 529', 'briana40@example.net', 0, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(49, 3, 'Caesar', 'Erdman', '465 208 524 998', 'ruecker.billie@example.com', 0, '2025-01-24 00:25:24', '2025-01-24 00:25:24'),
	(50, 3, 'Drake', 'Leffler', '529 109 548 736', 'christy.douglas@example.org', 0, '2025-01-24 00:25:24', '2025-01-24 00:25:24');

-- Volcando estructura para tabla estadia.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla estadia.failed_jobs: ~0 rows (aproximadamente)

-- Volcando estructura para tabla estadia.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla estadia.migrations: ~15 rows (aproximadamente)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2025_01_14_155632_create_customers_table', 1),
	(6, '2025_01_15_185008_create_permission_tables', 1),
	(7, '2025_01_20_174425_add_send_notification_to_users_table', 2),
	(8, '2025_01_21_171322_delus', 3),
	(9, '2025_01_21_171343_delcus', 3),
	(10, '2025_01_21_171354_delrol', 3),
	(11, '2025_01_21_171407_delper', 3),
	(12, '2025_01_22_191749_create_user_roles_table', 4),
	(13, '2025_01_22_191854_create_user_permissions_table', 4),
	(14, '2025_01_22_191854_create_role_permissions_table', 5),
	(15, '2025_01_23_182437_customers', 6);

-- Volcando estructura para tabla estadia.model_has_permissions
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla estadia.model_has_permissions: ~27 rows (aproximadamente)
INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
	(1, 'App\\Models\\User', 1),
	(2, 'App\\Models\\User', 1),
	(3, 'App\\Models\\User', 1),
	(4, 'App\\Models\\User', 1),
	(1, 'App\\Models\\User', 2),
	(2, 'App\\Models\\User', 2),
	(3, 'App\\Models\\User', 2),
	(4, 'App\\Models\\User', 2),
	(1, 'App\\Models\\User', 3),
	(2, 'App\\Models\\User', 3),
	(4, 'App\\Models\\User', 3),
	(1, 'App\\Models\\User', 4),
	(2, 'App\\Models\\User', 4),
	(4, 'App\\Models\\User', 4),
	(5, 'App\\Models\\User', 12),
	(5, 'App\\Models\\User', 18),
	(5, 'App\\Models\\User', 19),
	(5, 'App\\Models\\User', 36),
	(5, 'App\\Models\\User', 37),
	(5, 'App\\Models\\User', 38),
	(5, 'App\\Models\\User', 39),
	(5, 'App\\Models\\User', 40),
	(5, 'App\\Models\\User', 41),
	(5, 'App\\Models\\User', 42),
	(5, 'App\\Models\\User', 43),
	(5, 'App\\Models\\User', 44),
	(5, 'App\\Models\\User', 45);

-- Volcando estructura para tabla estadia.model_has_roles
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla estadia.model_has_roles: ~14 rows (aproximadamente)
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
	(1, 'App\\Models\\User', 1),
	(10, 'App\\Models\\User', 3),
	(11, 'App\\Models\\User', 4),
	(12, 'App\\Models\\User', 12),
	(12, 'App\\Models\\User', 36),
	(12, 'App\\Models\\User', 37),
	(12, 'App\\Models\\User', 38),
	(12, 'App\\Models\\User', 39),
	(12, 'App\\Models\\User', 40),
	(12, 'App\\Models\\User', 41),
	(12, 'App\\Models\\User', 42),
	(12, 'App\\Models\\User', 43),
	(12, 'App\\Models\\User', 44),
	(12, 'App\\Models\\User', 45);

-- Volcando estructura para tabla estadia.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla estadia.password_reset_tokens: ~0 rows (aproximadamente)

-- Volcando estructura para tabla estadia.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla estadia.permissions: ~5 rows (aproximadamente)
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'Crear cliente', 'web', '2025-01-17 21:59:16', '2025-01-17 21:59:16'),
	(2, 'Editar cliente', 'web', '2025-01-17 22:01:01', '2025-01-17 22:01:01'),
	(3, 'Eliminar cliente', 'web', '2025-01-17 22:01:29', '2025-01-17 22:01:29'),
	(4, 'Ver cliente', 'web', '2025-01-17 22:01:36', '2025-01-17 22:01:36'),
	(5, 'Ninguno', 'web', '2025-01-17 22:28:34', '2025-01-17 22:28:34');

-- Volcando estructura para tabla estadia.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla estadia.personal_access_tokens: ~0 rows (aproximadamente)

-- Volcando estructura para tabla estadia.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla estadia.roles: ~5 rows (aproximadamente)
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'Super Admin', 'web', '2025-01-17 00:58:10', '2025-01-22 00:17:11'),
	(9, 'Administrador', 'web', '2025-01-24 01:44:10', '2025-01-24 01:44:10'),
	(10, 'Editor', 'web', '2025-01-27 20:53:04', '2025-01-27 20:53:04'),
	(11, 'Autor', 'web', '2025-01-27 20:53:23', '2025-01-27 20:53:23'),
	(12, 'Subscriptor', 'web', '2025-01-27 22:57:13', '2025-01-27 22:57:13');

-- Volcando estructura para tabla estadia.role_has_permissions
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla estadia.role_has_permissions: ~15 rows (aproximadamente)
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
	(1, 1),
	(2, 1),
	(3, 1),
	(4, 1),
	(1, 9),
	(2, 9),
	(3, 9),
	(4, 9),
	(1, 10),
	(2, 10),
	(4, 10),
	(1, 11),
	(2, 11),
	(4, 11),
	(5, 12);

-- Volcando estructura para tabla estadia.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `send_notification` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla estadia.users: ~15 rows (aproximadamente)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `send_notification`) VALUES
	(1, 'SuperAdmin', 'superadmin@gmail.com', '2025-01-17 16:26:03', '$2y$12$8NCyNItNGEr54tnE4o3oEeKfH77ia8JWxENWZwbrOwpYViUazRQp6', 'mNcGG8zifc2siGiLbIhlUVp7kNbb6FC01bZuB00I4BUKw9Cv6ayAcad4cEwc', '2025-01-17 00:58:10', '2025-01-21 00:19:15', 1),
	(2, 'Administrador', 'admin@gmail.com', '2025-01-17 16:26:10', '$2y$12$EGqOJHyf9doEWuYPi6bPXug2TwCyYk88K3081wygaM7E90Nttzx5q', 'bxzJ9PcMVdFIijoAEbgCJ56T7QjYx3yJEsBZpDX5vzZyd0e9G0LIwiLatea0', '2025-01-17 00:58:10', '2025-01-24 02:04:51', 1),
	(3, 'Editor', 'editor@gmail.com', '2025-01-17 16:26:34', '$2y$12$MBmarBCh1P9N.9Zbrl5I4ObtdpdF8Fh.9Ut5dvUiPsIz8rAR8j.te', NULL, NULL, '2025-01-27 22:58:15', 1),
	(4, 'Autor', 'autor@gmail.com', '2025-01-17 16:27:36', '$2y$12$mbDUH7TbAXfw52vAB.OO5.3GxjpRVwe249VVldDj2xhf7ajN0JGnW', NULL, NULL, '2025-01-27 22:58:59', 1),
	(12, 'Subscriptor', 'subscriptor@gmail.com', '2025-01-17 18:43:14', '$2y$12$X1p8XPPByIXmCP4TE/tn3OiYGsIJjuLVQNMPLkRrdZTloGcswfd1y', NULL, '2025-01-18 00:43:19', '2025-01-27 22:59:13', 1),
	(36, 'Bernhard Purdy', 'lindsay.vonrueden@example.org', '2025-01-27 23:01:08', '$2y$12$e6Jjy2f8jGKQ2rWPcytzXOPLoG.8XjCiT6b3MAHsXXYUq0OUrI3q6', 'PQKEpdXpjG', '2025-01-27 23:01:08', '2025-01-27 23:01:08', 1),
	(37, 'Adelle Daugherty', 'lucious89@example.net', '2025-01-27 23:01:08', '$2y$12$e6Jjy2f8jGKQ2rWPcytzXOPLoG.8XjCiT6b3MAHsXXYUq0OUrI3q6', '4NtGn8NbLN', '2025-01-27 23:01:08', '2025-01-27 23:01:08', 1),
	(38, 'Blaze Frami', 'jade.brown@example.net', '2025-01-27 23:01:08', '$2y$12$e6Jjy2f8jGKQ2rWPcytzXOPLoG.8XjCiT6b3MAHsXXYUq0OUrI3q6', 'YN0feAVkfc', '2025-01-27 23:01:08', '2025-01-27 23:01:08', 1),
	(39, 'Kim Moen', 'makayla.moen@example.org', '2025-01-27 23:01:08', '$2y$12$e6Jjy2f8jGKQ2rWPcytzXOPLoG.8XjCiT6b3MAHsXXYUq0OUrI3q6', 'qjpx7arBoW', '2025-01-27 23:01:08', '2025-01-27 23:01:08', 0),
	(40, 'Gabriella Beier III', 'cjacobson@example.net', '2025-01-27 23:01:08', '$2y$12$e6Jjy2f8jGKQ2rWPcytzXOPLoG.8XjCiT6b3MAHsXXYUq0OUrI3q6', 'etEeUAOt8T', '2025-01-27 23:01:08', '2025-01-27 23:01:08', 0),
	(41, 'Yvonne Windler', 'dubuque.bell@example.net', NULL, '$2y$12$e6Jjy2f8jGKQ2rWPcytzXOPLoG.8XjCiT6b3MAHsXXYUq0OUrI3q6', 'diQyCVYWJp', '2025-01-27 23:01:08', '2025-01-27 23:01:08', 0),
	(42, 'Hank Muller', 'violet.schroeder@example.com', NULL, '$2y$12$e6Jjy2f8jGKQ2rWPcytzXOPLoG.8XjCiT6b3MAHsXXYUq0OUrI3q6', '5EoOVqenxV', '2025-01-27 23:01:08', '2025-01-27 23:01:08', 1),
	(43, 'Karen Littel DDS', 'ara85@example.net', NULL, '$2y$12$e6Jjy2f8jGKQ2rWPcytzXOPLoG.8XjCiT6b3MAHsXXYUq0OUrI3q6', 'KGfBQ4ObBn', '2025-01-27 23:01:08', '2025-01-27 23:01:08', 0),
	(44, 'Dr. Brandon Prosacco DDS', 'hilton39@example.org', NULL, '$2y$12$e6Jjy2f8jGKQ2rWPcytzXOPLoG.8XjCiT6b3MAHsXXYUq0OUrI3q6', 'Ho3zHFdGog', '2025-01-27 23:01:08', '2025-01-27 23:01:08', 0),
	(45, 'Ms. Susana Bartoletti II', 'judge44@example.org', NULL, '$2y$12$e6Jjy2f8jGKQ2rWPcytzXOPLoG.8XjCiT6b3MAHsXXYUq0OUrI3q6', 'QrZ6IG3pxu', '2025-01-27 23:01:08', '2025-01-27 23:01:08', 0);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
