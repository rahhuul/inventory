-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 20, 2022 at 07:17 PM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `adminproj`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `category_id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
('1457b1d4-be68-4abb-88b5-3ebb64642c06', 'Cat 1', '2022-01-16 07:25:45', '2022-01-16 07:25:45', NULL),
('5c9860e1-f798-498e-995e-f1034ee2dea5', 'Cat 2', '2022-01-16 07:26:09', '2022-01-16 07:26:09', NULL),
('85cde456-22cf-448e-ba9e-57fb03c46ff9', 'Cat 4', '2022-01-20 18:57:32', '2022-01-20 18:57:32', NULL),
('cae2d498-f570-45f8-b94a-105b29888761', 'Cat 3', '2022-01-16 07:34:09', '2022-01-20 18:57:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `category_material`
--

DROP TABLE IF EXISTS `category_material`;
CREATE TABLE IF NOT EXISTS `category_material` (
  `category_id` char(36) DEFAULT NULL,
  `material_id` char(36) DEFAULT NULL,
  KEY `category_id` (`category_id`),
  KEY `material_id` (`material_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `material`
--

DROP TABLE IF EXISTS `material`;
CREATE TABLE IF NOT EXISTS `material` (
  `material_id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `quantity` varchar(20) DEFAULT NULL,
  `damagePrice` varchar(20) DEFAULT NULL,
  `rentPrice` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `reference_name` varchar(255) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `type` tinyint(1) DEFAULT '0' COMMENT '0 -rental 1-provider',
  `mobile` varchar(50) DEFAULT NULL,
  `reference_mobile` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `reference_name`, `address`, `type`, `mobile`, `reference_mobile`, `created_at`, `updated_at`) VALUES
('117674fa-cd17-4c11-a264-b55181cb828a', 'developer new 123', 'developer reference new', 'reference address', 0, '9787878787', '6525252525', '2022-01-09 15:17:42', '2022-01-19 18:56:05'),
('effe56a1-2ee5-49bd-9806-e7447589242d', 'New Customer', 'New Customer', 'New Customer', 0, '8888888888', '77777777777', '2022-01-14 06:30:42', '2022-01-14 06:30:42'),
('5f098b8d-f729-4676-94dc-7596b3adb7d0', 'Rahul Dushyantbhai Patel', 'Rahul Dushyantbhai Patel', '1490, Moti Vasan Sheri\r\nSaraspur', 0, '09033043379', '09033043379', '2022-01-09 11:51:12', '2022-01-09 11:51:12');

-- --------------------------------------------------------

--
-- Table structure for table `usermaster`
--

DROP TABLE IF EXISTS `usermaster`;
CREATE TABLE IF NOT EXISTS `usermaster` (
  `id` char(36) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usermaster`
--

INSERT INTO `usermaster` (`id`, `firstname`, `lastname`, `email`, `username`, `password`, `created`) VALUES
('1', 'Global1', 'Admin', 'Admin@winterwood.com', 'admin', '$2y$10$Dg8CzQGMmrfrmcb9dhjeB.29D02blpsSFJ.L9EqATcfyvb7eilz0W', '2017-06-01 01:08:18');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
