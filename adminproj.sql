-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 23, 2022 at 04:52 PM
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
-- Table structure for table `material`
--

DROP TABLE IF EXISTS `material`;
CREATE TABLE IF NOT EXISTS `material` (
  `material_id` char(36) NOT NULL,
  `category_id` char(36) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `quantity` varchar(20) DEFAULT NULL,
  `damagePrice` varchar(20) DEFAULT NULL,
  `rentPrice` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`material_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `material`
--

INSERT INTO `material` (`material_id`, `category_id`, `name`, `quantity`, `damagePrice`, `rentPrice`, `created_at`, `updated_at`, `deleted_at`) VALUES
('a9101aa4-2e5f-4573-8f3e-0f886b9f6ba1', 'cae2d498-f570-45f8-b94a-105b29888761', 'Mat 1', '100', '120', '80', '2022-01-22 20:26:42', '2022-01-22 20:26:42', NULL),
('db787888-2a07-4d66-afae-8909105deaf9', '85cde456-22cf-448e-ba9e-57fb03c46ff9', 'Mat 2', '150', '50', '20', '2022-01-23 09:09:19', '2022-01-23 09:09:19', NULL),
('ad880abf-a124-45d5-adf5-9fe653812da2', '1457b1d4-be68-4abb-88b5-3ebb64642c06', 'Mat c1', '100', '180', '120', '2022-01-23 15:50:23', '2022-01-23 15:50:23', NULL),
('3ecd9100-dd43-4441-a82a-6dfa884be416', '5c9860e1-f798-498e-995e-f1034ee2dea5', 'Mat c2', '500', '580', '200', '2022-01-23 15:50:39', '2022-01-23 15:50:39', NULL),
('fbef61d6-c4de-43a9-97b4-e650c4e4c1bf', '1457b1d4-be68-4abb-88b5-3ebb64642c06', 'Mat c11', '1000', '1200', '400', '2022-01-23 15:51:02', '2022-01-23 15:51:02', NULL),
('08af3b06-e817-4dbb-a077-b058301a3cbe', '5c9860e1-f798-498e-995e-f1034ee2dea5', 'Mat C22', '2000', '2400', '1700', '2022-01-23 15:51:19', '2022-01-23 15:51:19', NULL),
('3f09bd52-905f-4d66-8d56-22338514cfd5', 'cae2d498-f570-45f8-b94a-105b29888761', 'Mat c3', '100', '1000', '620', '2022-01-23 15:51:40', '2022-01-23 15:51:40', NULL),
('fa063916-f109-4b57-a58f-7b7f933084af', '85cde456-22cf-448e-ba9e-57fb03c46ff9', 'Mat c4', '50', '10000', '8000', '2022-01-23 15:51:57', '2022-01-23 15:51:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rent_material`
--

DROP TABLE IF EXISTS `rent_material`;
CREATE TABLE IF NOT EXISTS `rent_material` (
  `rent_id` char(36) NOT NULL,
  `customer_id` char(36) DEFAULT NULL,
  `category_id` char(36) DEFAULT NULL,
  `material_id` char(36) DEFAULT NULL,
  `quantity` varchar(50) DEFAULT NULL,
  `ordered_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rent_material`
--

INSERT INTO `rent_material` (`rent_id`, `customer_id`, `category_id`, `material_id`, `quantity`, `ordered_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
('50c396d3-1bbe-4fa8-8a38-9a1bd9090658', 'effe56a1-2ee5-49bd-9806-e7447589242d', '5c9860e1-f798-498e-995e-f1034ee2dea5', '3ecd9100-dd43-4441-a82a-6dfa884be416', '150', NULL, '2022-01-23 16:30:37', '2022-01-23 16:30:37', NULL);

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
