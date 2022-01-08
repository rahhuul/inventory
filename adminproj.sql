-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 08, 2022 at 01:41 PM
-- Server version: 5.7.21
-- PHP Version: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
-- Table structure for table `bt_user`
--

DROP TABLE IF EXISTS `bt_user`;
CREATE TABLE IF NOT EXISTS `bt_user` (
  `id` char(36) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `type` tinyint(1) DEFAULT '0' COMMENT '0 -rental 1-provider',
  `mobile` varchar(50) DEFAULT NULL,
  `created` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bt_user`
--

INSERT INTO `bt_user` (`id`, `name`, `email`, `address`, `type`, `mobile`, `created`) VALUES
('ce812181-960b-44fd-b0ff-4b3bdd4718ed', 'mnp1', 'mnp@gmail.com', 'sdgfsdg', 0, '47658476489e6', '2022-01-08 13:19:08.000000'),
('bcda2cc1-4fe4-4b1a-b5e3-4979f3a543eb', 'pno', 'pno@gmail.com', 'sdfdsf', 0, '972415600534', '2022-01-08 12:24:12.000000'),
('42c06fb7-d128-44c4-8656-f1fd5a742a7f', 'xyz', 'xyz@gmail.com', 'dgfdg', 0, '87978980890', '2022-01-08 13:14:24.000000');

-- --------------------------------------------------------

--
-- Table structure for table `bt_usermaster`
--

DROP TABLE IF EXISTS `bt_usermaster`;
CREATE TABLE IF NOT EXISTS `bt_usermaster` (
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
-- Dumping data for table `bt_usermaster`
--

INSERT INTO `bt_usermaster` (`id`, `firstname`, `lastname`, `email`, `username`, `password`, `created`) VALUES
('1', 'Global1', 'Admin', 'Admin@winterwood.com', 'admin', '$2y$10$Dg8CzQGMmrfrmcb9dhjeB.29D02blpsSFJ.L9EqATcfyvb7eilz0W', '2017-06-01 01:08:18');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
