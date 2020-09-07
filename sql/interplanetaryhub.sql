-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for interplanetaryhub
CREATE DATABASE IF NOT EXISTS `interplanetaryhub` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `interplanetaryhub`;

-- Dumping structure for table interplanetaryhub.activity_log
CREATE TABLE IF NOT EXISTS `activity_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `activity_type` int(11) DEFAULT NULL,
  `activity_reference` int(11) DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table interplanetaryhub.activity_log: ~4 rows (approximately)
/*!40000 ALTER TABLE `activity_log` DISABLE KEYS */;
REPLACE INTO `activity_log` (`id`, `user_id`, `activity_type`, `activity_reference`, `created`) VALUES
	(1, 1, 1, 4, NULL),
	(2, 1, 1, 9, NULL),
	(3, 1, 1, 10, NULL),
	(4, 1, 1, 11, NULL),
	(5, 1, 1, 12, NULL),
	(6, 1, 1, 13, NULL);
/*!40000 ALTER TABLE `activity_log` ENABLE KEYS */;

-- Dumping structure for table interplanetaryhub.activity_type
CREATE TABLE IF NOT EXISTS `activity_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `permission_level` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table interplanetaryhub.activity_type: ~3 rows (approximately)
/*!40000 ALTER TABLE `activity_type` DISABLE KEYS */;
REPLACE INTO `activity_type` (`id`, `name`, `permission_level`) VALUES
	(1, 'create_link', 1),
	(2, 'upvote', 1),
	(3, 'downvote', 1);
/*!40000 ALTER TABLE `activity_type` ENABLE KEYS */;

-- Dumping structure for table interplanetaryhub.featured_links
CREATE TABLE IF NOT EXISTS `featured_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table interplanetaryhub.featured_links: ~0 rows (approximately)
/*!40000 ALTER TABLE `featured_links` DISABLE KEYS */;
/*!40000 ALTER TABLE `featured_links` ENABLE KEYS */;

-- Dumping structure for table interplanetaryhub.groups
CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(20) DEFAULT NULL,
  `permissions` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table interplanetaryhub.groups: ~2 rows (approximately)
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
REPLACE INTO `groups` (`id`, `NAME`, `permissions`) VALUES
	(1, 'user', '1'),
	(2, 'admin', '10');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;

-- Dumping structure for table interplanetaryhub.links
CREATE TABLE IF NOT EXISTS `links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT '0',
  `hash` varchar(50) DEFAULT '0',
  `file_extension` varchar(100) DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `upvotes` int(11) DEFAULT '0',
  `downvotes` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- Dumping data for table interplanetaryhub.links: ~10 rows (approximately)
/*!40000 ALTER TABLE `links` DISABLE KEYS */;
REPLACE INTO `links` (`id`, `name`, `hash`, `file_extension`, `created`, `user_id`, `upvotes`, `downvotes`) VALUES
	(3, 'Batman3', 'QmZqkuqX1qTspb1GgmnzyRFetf1uMyA3CemvvgPZD39ss3', NULL, '2020-06-25 08:13:44', 1, 0, 0),
	(4, 'Batman4', 'QmZqkuqX1qTspb1GgmnzyRFetf1uMyA3CemvvgPZD39ss4', NULL, '2020-06-25 08:16:34', 1, 1, 1),
	(5, 'Batman5', 'QmZqkuqX1qTspb1GgmnzyRFetf1uMyA3CemvvgPZD39ss5', NULL, '2020-06-25 08:19:24', 1, 0, 0),
	(6, 'Batman6', 'QmZqkuqX1qTspb1GgmnzyRFetf1uMyA3CemvvgPZD39ss6', NULL, '2020-06-25 08:20:44', 1, 0, 0),
	(7, 'Batman7', 'QmZqkuqX1qTspb1GgmnzyRFetf1uMyA3CemvvgPZD39ss7', NULL, '2020-06-25 08:22:38', 1, 0, 0),
	(8, 'Batman8', 'QmZqkuqX1qTspb1GgmnzyRFetf1uMyA3CemvvgPZD39ss8', NULL, '2020-06-25 08:24:06', 1, 3, 1),
	(9, 'Batman9', 'QmZqkuqX1qTspb1GgmnzyRFetf1uMyA3CemvvgPZD39ss9', NULL, '2020-06-25 08:25:00', 1, 0, 0),
	(10, 'Batman10', 'QmZqkuqX1qTspb1GgmnzyRFetf1uMyA3CemvvgPZD39s10', NULL, '2020-06-25 08:27:46', 1, 1, 0),
	(11, 'Batman11', 'QmZqkuqX1qTspb1GgmnzyRFetf1uMyA3CemvvgPZD39s11', NULL, '2020-06-25 08:30:55', 1, 0, 0),
	(12, 'Batman12', 'QmZqkuqX1qTspb1GgmnzyRFetf1uMyA3CemvvgPZD39s12', NULL, '2020-06-25 08:50:22', 1, 2, 0),
	(13, 'Batman - The Dark Knight Rises', 'QmfWQHVazH6so9p27z27rr8TJSdBFGpH7hunDcaZ1EAQ2c', 'The.Dark.Knight.Rises.2012.720p.BluRay.x264.YIFY.mp4', '2020-06-26 03:46:22', 1, 35, 8);
/*!40000 ALTER TABLE `links` ENABLE KEYS */;

-- Dumping structure for table interplanetaryhub.new_links
CREATE TABLE IF NOT EXISTS `new_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link_id` int(11) NOT NULL DEFAULT '0',
  `created` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- Dumping data for table interplanetaryhub.new_links: ~6 rows (approximately)
/*!40000 ALTER TABLE `new_links` DISABLE KEYS */;
REPLACE INTO `new_links` (`id`, `link_id`, `created`) VALUES
	(8, 8, '2020-06-25 08:24:06'),
	(9, 9, '2020-06-25 08:25:00'),
	(10, 10, '2020-06-25 08:27:46'),
	(11, 11, '2020-06-25 08:30:55'),
	(12, 12, '2020-06-25 08:50:22'),
	(13, 13, '2020-06-26 03:46:22');
/*!40000 ALTER TABLE `new_links` ENABLE KEYS */;

-- Dumping structure for table interplanetaryhub.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `salt` varchar(32) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `joined` timestamp NULL DEFAULT NULL,
  `group` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table interplanetaryhub.users: ~0 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
REPLACE INTO `users` (`id`, `username`, `password`, `salt`, `name`, `joined`, `group`) VALUES
	(1, 'Powikillyou', 'e86ba85634061a392f4a31240c9b4db1ee38acc1fb3f1947c8f164d2494fef1b', '×{jgœ;Myy3›€Ÿ‚ð+¨CŠô–ÙÏXæ»ææ', 'Alex', '2020-05-30 04:09:50', 1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumping structure for table interplanetaryhub.users_session
CREATE TABLE IF NOT EXISTS `users_session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `HASH` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- Dumping data for table interplanetaryhub.users_session: ~1 rows (approximately)
/*!40000 ALTER TABLE `users_session` DISABLE KEYS */;
REPLACE INTO `users_session` (`id`, `user_id`, `HASH`) VALUES
	(12, 1, 'f36d2763170c7b554e9958bf5fbd7536816f127a930786209ac5daaed9803a8a');
/*!40000 ALTER TABLE `users_session` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
