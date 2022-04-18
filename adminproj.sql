-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: custsql-ipg88.eigbox.net
-- Generation Time: Apr 18, 2022 at 01:10 AM
-- Server version: 5.6.51-91.0-log
-- PHP Version: 7.0.33-0ubuntu0.16.04.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `navkarcreation`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `material`
--

CREATE TABLE `material` (
  `material_id` char(36) NOT NULL,
  `category_id` char(36) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `quantity` varchar(20) DEFAULT NULL,
  `damagePrice` varchar(20) DEFAULT NULL,
  `rentPrice` varchar(20) DEFAULT NULL,
  `rentperPrice` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `material`
--

INSERT INTO `material` (`material_id`, `category_id`, `name`, `quantity`, `damagePrice`, `rentPrice`, `rentperPrice`, `created_at`, `updated_at`, `deleted_at`) VALUES
('8f4fcaa5-6117-468d-afe2-0b4df90e5bbf', NULL, 'Teka 10 foot', '1949', '120', '10', '0.66666666666667', '2022-04-10 05:44:37', '2022-04-17 05:02:09', NULL),
('c684a31d-218d-4f9d-a042-716d8dddef43', NULL, 'Teka 11 foot', '2200', '120', '11', '0.73333333333333', '2022-04-10 05:45:42', '2022-04-17 05:40:51', NULL),
('83ff6946-748e-4345-834a-50629f8d48ec', NULL, 'Teka 10 foot - 12', '2500', '120', '12', '0.8', '2022-04-10 05:46:15', '2022-04-10 14:43:37', NULL),
('c02cf106-e688-44e8-a86a-198e11b61778', NULL, 'Teka 12 foot', '5000', '50', '12', '0.8', '2022-04-16 09:26:19', '2022-04-16 09:26:19', NULL),
('ce18369b-665f-4833-bbf4-ed16153c200f', NULL, 'walpet 8 foot', '2960', '100', '50', '3.3333333333333', '2022-04-16 09:33:55', '2022-04-17 05:41:52', NULL),
('fd2414a6-49d2-4815-b8c9-cd2360ce66f1', NULL, 'Farma 3X9', '2838', '50', '20', '1.3333333333333', '2022-04-16 09:34:58', '2022-04-17 05:41:22', NULL),
('04028d9b-8a1e-4b93-b453-88ad976ef19a', NULL, 'Teka 14 foot', '2700', '50', '14', '0.93333333333333', '2022-04-16 09:35:30', '2022-04-17 06:23:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `received_material`
--

CREATE TABLE `received_material` (
  `received_id` char(36) NOT NULL,
  `rent_id` char(36) DEFAULT NULL,
  `material_id` char(36) DEFAULT NULL,
  `customer_id` char(36) DEFAULT NULL,
  `receive_status` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '0 for incomplete ,1 for partial ,2 for complete',
  `receive_date` datetime(6) DEFAULT NULL,
  `received_quantity` varchar(50) DEFAULT NULL,
  `is_damage` enum('0','1') DEFAULT '0',
  `is_lose` enum('0','1') DEFAULT '0',
  `pending_material` varchar(50) DEFAULT NULL,
  `damaged_quantity` varchar(50) DEFAULT NULL,
  `losed_quantity` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `received_material`
--

INSERT INTO `received_material` (`received_id`, `rent_id`, `material_id`, `customer_id`, `receive_status`, `receive_date`, `received_quantity`, `is_damage`, `is_lose`, `pending_material`, `damaged_quantity`, `losed_quantity`, `created_at`, `updated_at`, `deleted_at`) VALUES
('50a24ce2-e021-4634-9875-5075a67781aa', '523844e9-52c0-4c9f-ad13-778e84c64ceb', 'c684a31d-218d-4f9d-a042-716d8dddef43', 'caa6540d-2cce-49ca-941d-f76a900a6c16', '2', '2022-04-04 00:00:00.000000', '140', '0', '0', '0', '0', '0', '2022-04-16 15:56:42', '2022-04-16 15:56:42', NULL),
('62de9669-b018-4c40-9e61-947b7bd158ad', 'cc5d565d-6643-4897-9332-631bced0ce35', 'c684a31d-218d-4f9d-a042-716d8dddef43', 'caa6540d-2cce-49ca-941d-f76a900a6c16', '2', '2022-04-04 00:00:00.000000', '100', '0', '0', '0', '0', '0', '2022-04-16 15:56:42', '2022-04-16 15:56:42', NULL),
('a12c4e94-623d-4e41-a7ed-80babaed045c', 'ee923bc8-4519-4ac3-9d5d-1134e946f8e8', 'fd2414a6-49d2-4815-b8c9-cd2360ce66f1', 'caa6540d-2cce-49ca-941d-f76a900a6c16', '1', '2022-04-04 00:00:00.000000', '2', '0', '0', '28', '0', '0', '2022-04-16 15:56:42', '2022-04-16 15:56:42', NULL),
('046c973c-7858-4ba0-b93c-1ca2756159ae', 'c94b6f62-4e33-4950-83af-0ff6914aec79', 'ce18369b-665f-4833-bbf4-ed16153c200f', 'caa6540d-2cce-49ca-941d-f76a900a6c16', '2', '2022-04-04 00:00:00.000000', '50', '0', '0', '0', '0', '0', '2022-04-16 15:56:42', '2022-04-16 15:56:42', NULL),
('6022c042-c12f-48ee-9bac-9512e15e5c19', 'd90cfbb3-16ac-4e8c-9f05-274ede3b1d54', '8f4fcaa5-6117-468d-afe2-0b4df90e5bbf', 'a9b2789b-7f2e-453a-8c2e-5b859f22de5e', '1', '2022-01-15 00:00:00.000000', '250', '0', '0', '250', '0', '0', '2022-04-16 18:18:04', '2022-04-16 18:18:04', NULL),
('3c1ca0eb-19ba-41cf-bb07-90c95415bee9', 'e273c601-a016-4ed3-a34c-5999d9075ab2', 'c684a31d-218d-4f9d-a042-716d8dddef43', 'a9b2789b-7f2e-453a-8c2e-5b859f22de5e', '1', '2022-01-15 00:00:00.000000', '200', '0', '0', '300', '0', '0', '2022-04-16 18:18:04', '2022-04-16 18:18:04', NULL),
('b2d30f37-d0bc-4321-a335-39f7b15d654c', '26b1d814-451c-49f6-b58f-7c407ad7a3b5', 'fd2414a6-49d2-4815-b8c9-cd2360ce66f1', 'a9b2789b-7f2e-453a-8c2e-5b859f22de5e', '1', '2022-01-15 00:00:00.000000', '50', '0', '0', '50', '0', '0', '2022-04-16 18:18:04', '2022-04-16 18:18:04', NULL),
('c2737c50-242a-4fc4-98a8-bdac6aeb7e83', '7f9d22fe-094d-457a-85ca-3b0e74ec7ac6', '04028d9b-8a1e-4b93-b453-88ad976ef19a', 'a9b2789b-7f2e-453a-8c2e-5b859f22de5e', '1', '2022-01-20 00:00:00.000000', '50', '0', '0', '150', '0', '0', '2022-04-16 18:32:20', '2022-04-16 18:32:20', NULL),
('8c2a2fde-e53f-4dc5-9b94-aec61497ba8e', '24615b77-704f-4f36-8efe-e9625810ea05', 'ce18369b-665f-4833-bbf4-ed16153c200f', 'a9b2789b-7f2e-453a-8c2e-5b859f22de5e', '1', '2022-01-20 00:00:00.000000', '10', '0', '0', '40', '0', '0', '2022-04-16 18:41:00', '2022-04-16 18:41:00', NULL),
('debbc0bf-b973-4c54-abba-15f70731b8e7', 'd90cfbb3-16ac-4e8c-9f05-274ede3b1d54', '8f4fcaa5-6117-468d-afe2-0b4df90e5bbf', 'a9b2789b-7f2e-453a-8c2e-5b859f22de5e', '1', '2022-01-30 00:00:00.000000', '50', '0', '0', '450', '0', '0', '2022-04-16 18:45:26', '2022-04-16 18:45:26', NULL),
('be5809fe-7d4d-42d1-87c5-e532aa445f07', 'b267b389-7f7c-4e07-9ffc-3094c5e703e6', '8f4fcaa5-6117-468d-afe2-0b4df90e5bbf', '23d96001-c20b-4dfc-bbb7-423a0daf6ed1', '1', '2022-01-19 00:00:00.000000', '50', '0', '0', '50', '0', '0', '2022-04-17 04:56:35', '2022-04-17 04:56:35', NULL),
('6f844c7f-a128-4081-8d80-a98e0e83ee0b', '5e2c7405-3ef5-47f6-af0c-849e6efdfdd0', 'c684a31d-218d-4f9d-a042-716d8dddef43', '23d96001-c20b-4dfc-bbb7-423a0daf6ed1', '1', '2022-01-19 00:00:00.000000', '50', '0', '0', '50', '0', '0', '2022-04-17 04:56:35', '2022-04-17 04:56:35', NULL),
('3b864bcd-7250-4991-9ebe-e2ef716f223f', 'b267b389-7f7c-4e07-9ffc-3094c5e703e6', '8f4fcaa5-6117-468d-afe2-0b4df90e5bbf', '23d96001-c20b-4dfc-bbb7-423a0daf6ed1', '2', '2022-01-22 00:00:00.000000', '50', '0', '0', '50', '0', '0', '2022-04-17 05:02:09', '2022-04-17 05:02:09', NULL),
('654e73c7-6e9b-4e72-967e-faa659fdc837', '5e2c7405-3ef5-47f6-af0c-849e6efdfdd0', 'c684a31d-218d-4f9d-a042-716d8dddef43', '23d96001-c20b-4dfc-bbb7-423a0daf6ed1', '2', '2022-01-22 00:00:00.000000', '50', '0', '0', '50', '0', '0', '2022-04-17 05:02:09', '2022-04-17 05:02:09', NULL),
('d1b623ee-78d4-474c-8c9e-2d095a0bdbba', '3c62243a-1083-4fbb-9942-f34c50e609c7', '04028d9b-8a1e-4b93-b453-88ad976ef19a', '23d96001-c20b-4dfc-bbb7-423a0daf6ed1', '2', '2022-01-22 00:00:00.000000', '100', '0', '0', '0', '0', '0', '2022-04-17 05:02:09', '2022-04-17 05:02:09', NULL),
('c2672020-283b-48d8-bf49-4a99bfdb7c5b', '2a3031e7-46bf-4398-ae41-f7f2a0a20f59', 'fd2414a6-49d2-4815-b8c9-cd2360ce66f1', '23d96001-c20b-4dfc-bbb7-423a0daf6ed1', '2', '2022-01-22 00:00:00.000000', '10', '0', '0', '0', '0', '0', '2022-04-17 05:02:09', '2022-04-17 05:02:09', NULL),
('b92601a6-9911-4d4d-bb7a-75a8906067d7', 'a5311bc1-ac12-45f9-9e03-352c5a71a783', 'ce18369b-665f-4833-bbf4-ed16153c200f', '23d96001-c20b-4dfc-bbb7-423a0daf6ed1', '2', '2022-01-22 00:00:00.000000', '50', '0', '0', '0', '0', '0', '2022-04-17 05:02:09', '2022-04-17 05:02:09', NULL),
('35549179-388f-4f4f-9872-0060cd33f462', '43637223-5e9f-4380-bfb8-fb2a2db1adf6', 'c684a31d-218d-4f9d-a042-716d8dddef43', 'cd5be317-fc20-4e9a-aeab-e9210b1afebe', '2', '2022-04-04 00:00:00.000000', '140', '0', '0', '0', '0', '0', '2022-04-17 05:40:16', '2022-04-17 05:40:16', NULL),
('9cd60164-f341-4398-ae62-9a485d74ff57', 'e4bdc17a-853f-400e-b62f-95fef25b70f1', 'c684a31d-218d-4f9d-a042-716d8dddef43', 'cd5be317-fc20-4e9a-aeab-e9210b1afebe', '1', '2022-04-04 00:00:00.000000', '5', '0', '0', '95', '0', '0', '2022-04-17 05:40:16', '2022-04-17 05:40:16', NULL),
('f02572eb-2d9d-4de0-9993-10b2d286680e', 'e4bdc17a-853f-400e-b62f-95fef25b70f1', 'c684a31d-218d-4f9d-a042-716d8dddef43', 'cd5be317-fc20-4e9a-aeab-e9210b1afebe', '2', '2022-04-04 00:00:00.000000', '95', '0', '0', '5', '0', '0', '2022-04-17 05:40:51', '2022-04-17 05:40:51', NULL),
('1e87b108-aea5-454b-b0fb-3502bff0b955', '6c0d44d0-6502-4b73-b501-251f8443c632', 'fd2414a6-49d2-4815-b8c9-cd2360ce66f1', 'cd5be317-fc20-4e9a-aeab-e9210b1afebe', '1', '2022-04-04 00:00:00.000000', '2', '0', '0', '28', '0', '0', '2022-04-17 05:41:22', '2022-04-17 05:41:22', NULL),
('8537ee0e-5ec9-46ff-beee-c21c86d4baca', '4769983c-c116-480e-b968-2ae5d7980523', 'ce18369b-665f-4833-bbf4-ed16153c200f', 'cd5be317-fc20-4e9a-aeab-e9210b1afebe', '2', '2022-04-04 00:00:00.000000', '50', '0', '0', '0', '0', '0', '2022-04-17 05:41:52', '2022-04-17 05:41:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rent_material`
--

CREATE TABLE `rent_material` (
  `rent_id` char(36) NOT NULL,
  `customer_id` char(36) DEFAULT NULL,
  `category_id` char(36) DEFAULT NULL,
  `material_id` char(36) DEFAULT NULL,
  `quantity` varchar(50) DEFAULT NULL,
  `return_quantity` varchar(50) DEFAULT NULL,
  `remain_quantity` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `ordered_at` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rent_material`
--

INSERT INTO `rent_material` (`rent_id`, `customer_id`, `category_id`, `material_id`, `quantity`, `return_quantity`, `remain_quantity`, `status`, `ordered_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
('26b1d814-451c-49f6-b58f-7c407ad7a3b5', 'a9b2789b-7f2e-453a-8c2e-5b859f22de5e', NULL, 'fd2414a6-49d2-4815-b8c9-cd2360ce66f1', '100', '50', '50', 0, '2022-01-01', '2022-04-16 18:09:45', '2022-04-16 18:18:04', NULL),
('e273c601-a016-4ed3-a34c-5999d9075ab2', 'a9b2789b-7f2e-453a-8c2e-5b859f22de5e', NULL, 'c684a31d-218d-4f9d-a042-716d8dddef43', '500', '200', '300', 0, '2022-01-01', '2022-04-16 18:09:45', '2022-04-16 18:18:04', NULL),
('d90cfbb3-16ac-4e8c-9f05-274ede3b1d54', 'a9b2789b-7f2e-453a-8c2e-5b859f22de5e', NULL, '8f4fcaa5-6117-468d-afe2-0b4df90e5bbf', '500', '300', '200', 0, '2022-01-01', '2022-04-16 18:09:45', '2022-04-16 18:45:26', NULL),
('2bd85cec-e89a-48cf-9f5b-3d28812fa50b', 'caa6540d-2cce-49ca-941d-f76a900a6c16', NULL, 'fd2414a6-49d2-4815-b8c9-cd2360ce66f1', '28', NULL, NULL, 0, '2022-03-13', '2022-04-16 16:02:37', '2022-04-16 16:02:37', NULL),
('955e679d-597d-4c67-b2ac-e6a3667d96f8', 'caa6540d-2cce-49ca-941d-f76a900a6c16', NULL, '04028d9b-8a1e-4b93-b453-88ad976ef19a', '50', NULL, NULL, 0, '2022-04-08', '2022-04-16 15:53:44', '2022-04-16 15:53:44', NULL),
('ee923bc8-4519-4ac3-9d5d-1134e946f8e8', 'caa6540d-2cce-49ca-941d-f76a900a6c16', NULL, 'fd2414a6-49d2-4815-b8c9-cd2360ce66f1', '30', '2', '28', 0, '2022-03-13', '2022-04-16 15:53:03', '2022-04-16 15:56:42', NULL),
('cc5d565d-6643-4897-9332-631bced0ce35', 'caa6540d-2cce-49ca-941d-f76a900a6c16', NULL, 'c684a31d-218d-4f9d-a042-716d8dddef43', '100', '100', '0', 1, '2022-03-10', '2022-04-16 15:52:00', '2022-04-16 15:56:42', NULL),
('c94b6f62-4e33-4950-83af-0ff6914aec79', 'caa6540d-2cce-49ca-941d-f76a900a6c16', NULL, 'ce18369b-665f-4833-bbf4-ed16153c200f', '50', '50', '0', 1, '2022-03-13', '2022-04-16 15:53:03', '2022-04-16 15:56:42', NULL),
('523844e9-52c0-4c9f-ad13-778e84c64ceb', 'caa6540d-2cce-49ca-941d-f76a900a6c16', NULL, 'c684a31d-218d-4f9d-a042-716d8dddef43', '140', '140', '0', 1, '2022-03-07', '2022-04-16 15:51:01', '2022-04-16 15:56:42', NULL),
('24615b77-704f-4f36-8efe-e9625810ea05', 'a9b2789b-7f2e-453a-8c2e-5b859f22de5e', NULL, 'ce18369b-665f-4833-bbf4-ed16153c200f', '50', '10', '40', 0, '2022-01-01', '2022-04-16 18:09:45', '2022-04-16 18:41:00', NULL),
('7f9d22fe-094d-457a-85ca-3b0e74ec7ac6', 'a9b2789b-7f2e-453a-8c2e-5b859f22de5e', NULL, '04028d9b-8a1e-4b93-b453-88ad976ef19a', '200', '50', '150', 0, '2022-01-01', '2022-04-16 18:09:45', '2022-04-16 18:32:19', NULL),
('b267b389-7f7c-4e07-9ffc-3094c5e703e6', '23d96001-c20b-4dfc-bbb7-423a0daf6ed1', NULL, '8f4fcaa5-6117-468d-afe2-0b4df90e5bbf', '100', '100', '0', 1, '2022-01-01', '2022-04-17 04:52:55', '2022-04-17 05:02:09', NULL),
('5e2c7405-3ef5-47f6-af0c-849e6efdfdd0', '23d96001-c20b-4dfc-bbb7-423a0daf6ed1', NULL, 'c684a31d-218d-4f9d-a042-716d8dddef43', '100', '100', '0', 1, '2022-01-01', '2022-04-17 04:52:55', '2022-04-17 05:02:09', NULL),
('3c62243a-1083-4fbb-9942-f34c50e609c7', '23d96001-c20b-4dfc-bbb7-423a0daf6ed1', NULL, '04028d9b-8a1e-4b93-b453-88ad976ef19a', '100', '100', '0', 1, '2022-01-01', '2022-04-17 04:52:55', '2022-04-17 05:02:09', NULL),
('2a3031e7-46bf-4398-ae41-f7f2a0a20f59', '23d96001-c20b-4dfc-bbb7-423a0daf6ed1', NULL, 'fd2414a6-49d2-4815-b8c9-cd2360ce66f1', '10', '10', '0', 1, '2022-01-01', '2022-04-17 04:52:55', '2022-04-17 05:02:09', NULL),
('a5311bc1-ac12-45f9-9e03-352c5a71a783', '23d96001-c20b-4dfc-bbb7-423a0daf6ed1', NULL, 'ce18369b-665f-4833-bbf4-ed16153c200f', '50', '50', '0', 1, '2022-01-01', '2022-04-17 04:52:55', '2022-04-17 05:02:09', NULL),
('43637223-5e9f-4380-bfb8-fb2a2db1adf6', 'cd5be317-fc20-4e9a-aeab-e9210b1afebe', NULL, 'c684a31d-218d-4f9d-a042-716d8dddef43', '140', '140', '0', 1, '2022-03-07', '2022-04-17 05:27:37', '2022-04-17 05:40:16', NULL),
('e4bdc17a-853f-400e-b62f-95fef25b70f1', 'cd5be317-fc20-4e9a-aeab-e9210b1afebe', NULL, 'c684a31d-218d-4f9d-a042-716d8dddef43', '100', '100', '0', 1, '2022-03-10', '2022-04-17 05:28:33', '2022-04-17 05:40:51', NULL),
('4769983c-c116-480e-b968-2ae5d7980523', 'cd5be317-fc20-4e9a-aeab-e9210b1afebe', NULL, 'ce18369b-665f-4833-bbf4-ed16153c200f', '50', '50', '0', 1, '2022-03-13', '2022-04-17 05:29:35', '2022-04-17 05:41:52', NULL),
('6c0d44d0-6502-4b73-b501-251f8443c632', 'cd5be317-fc20-4e9a-aeab-e9210b1afebe', NULL, 'fd2414a6-49d2-4815-b8c9-cd2360ce66f1', '30', '2', '28', 0, '2022-03-13', '2022-04-17 05:29:35', '2022-04-17 05:41:22', NULL),
('45edd3af-3655-4a0d-bed2-27d0d2da22d1', 'cd5be317-fc20-4e9a-aeab-e9210b1afebe', NULL, '04028d9b-8a1e-4b93-b453-88ad976ef19a', '50', NULL, NULL, 0, '2022-04-08', '2022-04-17 05:30:35', '2022-04-17 05:30:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `reference_name` varchar(255) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `type` tinyint(1) DEFAULT '0' COMMENT '0 -rental 1-provider',
  `mobile` varchar(50) DEFAULT NULL,
  `amount` varchar(50) DEFAULT NULL,
  `reference_mobile` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `reference_name`, `address`, `type`, `mobile`, `amount`, `reference_mobile`, `created_at`, `updated_at`) VALUES
('0d79d6f4-46c7-46d9-9fad-9c0ffcd435df', 'Nitinbhai Maganbhai Gajera', NULL, 'Hathijan', NULL, '9879553543', NULL, NULL, '2022-04-10 05:43:31', '2022-04-10 05:43:31'),
('ad1fb488-64d2-429a-972d-8eba0899ecce', 'manish', NULL, 'bakrol', NULL, '9429212348', NULL, NULL, '2022-04-10 07:33:17', '2022-04-10 07:33:17'),
('a9b2789b-7f2e-453a-8c2e-5b859f22de5e', 'Mayur Patel', 'Rahul', 'nikol', 0, '9016577134', NULL, NULL, '2022-04-15 18:05:04', '2022-04-15 18:05:04'),
('23d96001-c20b-4dfc-bbb7-423a0daf6ed1', 'Diya kunjadiya', 'mayur', 'nikol', 0, '9016577134', NULL, NULL, '2022-04-16 09:28:19', '2022-04-16 09:28:19'),
('caa6540d-2cce-49ca-941d-f76a900a6c16', 'jigneshbhai bhalabhai', NULL, 'shiyam-1', 0, '8980495980', NULL, NULL, '2022-04-16 09:36:36', '2022-04-16 09:36:36'),
('cd5be317-fc20-4e9a-aeab-e9210b1afebe', 'demo1', 'tewt', 'tewt', 0, '999999999', NULL, NULL, '2022-04-17 05:26:11', '2022-04-17 05:26:11');

-- --------------------------------------------------------

--
-- Table structure for table `usermaster`
--

CREATE TABLE `usermaster` (
  `id` char(36) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usermaster`
--

INSERT INTO `usermaster` (`id`, `firstname`, `lastname`, `email`, `username`, `password`, `created`) VALUES
('1', 'Global1', 'Admin', 'Admin@winterwood.com', 'admin', '$2y$10$Dg8CzQGMmrfrmcb9dhjeB.29D02blpsSFJ.L9EqATcfyvb7eilz0W', '2017-06-01 01:08:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`material_id`);

--
-- Indexes for table `received_material`
--
ALTER TABLE `received_material`
  ADD PRIMARY KEY (`received_id`);

--
-- Indexes for table `rent_material`
--
ALTER TABLE `rent_material`
  ADD PRIMARY KEY (`rent_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `usermaster`
--
ALTER TABLE `usermaster`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
