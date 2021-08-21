-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 21, 2021 at 09:17 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trust_network`
--

-- --------------------------------------------------------

--
-- Table structure for table `tn_members`
--

CREATE TABLE `tn_members` (
  `id` int(11) NOT NULL,
  `user_email` varchar(25) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `gender` enum('M','F','T') DEFAULT 'M',
  `marital_status` enum('Married','Unmarried','Divorcee') DEFAULT 'Unmarried',
  `blood_group` char(5) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `membership_type` enum('RM','CM') DEFAULT 'RM',
  `church_id` int(11) NOT NULL DEFAULT 0,
  `contact_mobile` varchar(20) DEFAULT NULL,
  `contact_alt_mobile` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `country` int(11) NOT NULL DEFAULT 0,
  `state` int(11) NOT NULL DEFAULT 0,
  `city` int(11) NOT NULL DEFAULT 0,
  `is_approved` enum('Y','N') NOT NULL DEFAULT 'N',
  `postal_code` varchar(20) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tn_members`
--

INSERT INTO `tn_members` (`id`, `user_email`, `first_name`, `last_name`, `parent_id`, `gender`, `marital_status`, `blood_group`, `dob`, `membership_type`, `church_id`, `contact_mobile`, `contact_alt_mobile`, `password`, `address`, `country`, `state`, `city`, `is_approved`, `postal_code`, `profile_image`, `create_date`, `update_date`, `status`, `deleted`) VALUES
(1, 'admin1@gmail.com', 'Basilica of Bom Jesus', '', 0, NULL, NULL, '', NULL, 'CM', 0, NULL, '', '123456', '', 0, 0, 0, 'Y', '', NULL, '2021-08-17 15:49:56', '2021-08-17 17:09:15', '1', '0'),
(2, 'joy@ezineastrology.comE', 'Velankanni Church', '', 0, NULL, NULL, '', NULL, 'CM', 0, NULL, NULL, '123456', 'Champassari. pokijoteE', 101, 41, 5512, 'Y', '704403', NULL, '2021-08-17 16:00:19', '2021-08-19 19:34:42', '1', '0'),
(3, 'sohalia@gmail.com', 'Parumala Church', '', 0, NULL, NULL, NULL, NULL, 'CM', 0, NULL, NULL, '123456', '35 GM Road; Behala', 0, 0, 0, 'N', '700034', NULL, '2021-08-17 17:12:42', '2021-08-20 06:17:08', '1', '0'),
(9, 'admin@gmail.com', 'Church 1', '', 0, NULL, NULL, NULL, NULL, 'CM', 0, NULL, NULL, '123456', NULL, 0, 0, 0, 'N', NULL, NULL, '2021-08-21 19:57:24', NULL, '1', '0'),
(10, 'somdeepadmin@gmail.com', 'Somdeep', 'kanu', 9, 'M', '', NULL, NULL, 'RM', 9, NULL, NULL, '123456', NULL, 0, 0, 0, 'N', NULL, NULL, '2021-08-21 20:00:42', NULL, '1', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tn_members`
--
ALTER TABLE `tn_members`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tn_members`
--
ALTER TABLE `tn_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
