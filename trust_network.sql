-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2021 at 05:13 PM
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
-- Table structure for table `tn_church`
--

CREATE TABLE `tn_church` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `type` int(4) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `trustee_board` varchar(255) DEFAULT NULL,
  `foundation_date` date DEFAULT NULL,
  `contact_email` varchar(25) DEFAULT NULL,
  `contact_mobile` varchar(20) DEFAULT NULL,
  `contact_alt_mobile` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `country_id` int(11) NOT NULL DEFAULT 0,
  `state_id` int(11) NOT NULL DEFAULT 0,
  `city` varchar(11) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tn_church`
--

INSERT INTO `tn_church` (`id`, `name`, `type`, `contact_person`, `trustee_board`, `foundation_date`, `contact_email`, `contact_mobile`, `contact_alt_mobile`, `address`, `country_id`, `state_id`, `city`, `postal_code`, `create_date`, `update_date`, `status`, `deleted`) VALUES
(1, 'somdeep', 2, 'Tanushri', 'My Board', '2021-12-04', 'tanu@ggmail.com', '9804330891', '8013179998', 'Guwahati', 0, 0, '', '700034', '2021-08-15 18:03:44', '2021-08-18 20:19:39', '1', '0'),
(2, 'yyy', 0, 'Rohit', 'general trust', NULL, NULL, NULL, NULL, '', 0, 0, '', '', '2021-08-15 18:06:20', '2021-08-15 18:41:15', '1', '0'),
(3, 'bobshell anirban', 2, 'Sukla', 'Champahati', '2021-08-15', NULL, NULL, NULL, '35 gm road', 0, 0, 'kolkata', '700034', '2021-08-15 18:50:10', NULL, '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tn_group`
--

CREATE TABLE `tn_group` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `group_desc` mediumtext DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tn_group`
--

INSERT INTO `tn_group` (`id`, `name`, `group_desc`, `create_date`, `update_date`, `status`, `deleted`) VALUES
(1, 'rahmar', 'sasoomm khisdhfdfd', '2021-08-14 12:39:39', NULL, '1', '0'),
(2, 'Frien', 'froend ddesc', '2021-08-14 12:53:24', NULL, '1', '0'),
(3, 'sas', 'sas', '2021-08-14 13:03:26', NULL, '1', '0'),
(4, 'dsdsd', 'dsdsd', '2021-08-14 13:03:49', NULL, '0', '0'),
(5, 'dsdsd', 'dsdsd', '2021-08-14 13:04:11', NULL, '1', '0'),
(6, 'j', 'jhj', '2021-08-14 13:06:13', NULL, '0', '0'),
(7, 'friends', 'my description', '2021-08-14 13:10:08', '2021-08-15 18:21:21', '1', '0'),
(8, 'Familysh', 'family desc tt', '2021-08-15 18:21:58', '2021-08-18 20:35:25', '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tn_members`
--

CREATE TABLE `tn_members` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `gender` enum('M','F','T') DEFAULT 'M',
  `marital_status` enum('Married','Unmarried','Divorcee') DEFAULT 'Unmarried',
  `blood_group` char(5) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `membership_type` enum('RM','CM') DEFAULT 'RM',
  `church_id` int(11) NOT NULL DEFAULT 0,
  `contact_mobile` varchar(20) DEFAULT NULL,
  `contact_alt_mobile` varchar(20) DEFAULT NULL,
  `contact_email` varchar(25) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `country` int(11) NOT NULL DEFAULT 0,
  `state` int(11) NOT NULL DEFAULT 0,
  `city` varchar(11) DEFAULT NULL,
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

INSERT INTO `tn_members` (`id`, `first_name`, `middle_name`, `last_name`, `gender`, `marital_status`, `blood_group`, `dob`, `membership_type`, `church_id`, `contact_mobile`, `contact_alt_mobile`, `contact_email`, `password`, `address`, `country`, `state`, `city`, `postal_code`, `profile_image`, `create_date`, `update_date`, `status`, `deleted`) VALUES
(1, 'somdeep', '', 'Kanu', 'M', 'Married', '', '2021-08-17', 'CM', 3, '9674137989', '', 'somdeep@ezineastrology.co', '838924', '', 0, 0, '', '', NULL, '2021-08-17 15:49:56', '2021-08-17 17:09:15', '1', '0'),
(2, 'Joydeeps12', 'Kumar1', 'Kanu1', 'T', 'Divorcee', '', '2021-09-17', 'CM', 1, '98044578961', '99966633391', 'joy@ezineastrology.comE', '137644', 'Champassari. pokijoteE', 0, 0, 'SiliguriE', '704403', NULL, '2021-08-17 16:00:19', '2021-08-17 16:55:19', '1', '0'),
(3, 'Sohalia', '', 'Kanu', 'F', 'Unmarried', 'B+', '2013-03-21', 'RM', 0, '8013179998', '9804330891', 'sohalia@gmail.com', '224632', '35 GM Road; Behala', 0, 0, 'Kolkata', '700034', NULL, '2021-08-17 17:12:42', NULL, '1', '0'),
(4, 'dsd', 'dsd', 'dsd', 'M', 'Married', 'A-', '2021-08-17', 'RM', 0, 'dsdsdsdsd', 'dsdsd', 'social@ezineastrology.com', '615239', '', 0, 0, '', '', NULL, '2021-08-18 16:31:35', NULL, '1', '0'),
(5, 'dsd', 'dsd', 'dsd', 'M', 'Married', 'A-', '2021-08-17', 'RM', 0, 'dsdsdsdsd', 'dsdsd', 'social@ezineastrology.com', '722682', '', 0, 0, '', '', '16293064882564.jpg', '2021-08-18 19:08:08', NULL, '1', '0'),
(6, 'dsd', 'dsd', 'dsd', 'M', 'Married', 'A-', '2021-08-17', 'RM', 0, 'dsdsdsdsd', 'dsdsd', 'social@ezineastrology.com', '350071', '', 0, 0, '', '', '16293065374257.jpg', '2021-08-18 19:08:57', NULL, '1', '0'),
(7, 'dsds', 'dsd', 'dsd', 'M', 'Married', 'A-', '2021-08-17', 'RM', 0, 'dsdsdsdsd', 'dsdsd', 'social@ezineastrology.com', '638962', '', 0, 0, '', '', '16293065889063.jpg', '2021-08-18 19:09:26', '2021-08-18 19:17:02', '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role_id` int(11) NOT NULL,
  `zipcode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dob` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `register_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `username`, `contact`, `address`, `gender`, `image`, `role_id`, `zipcode`, `dob`, `status`, `register_date`) VALUES
(1, 'Administrator', 'trustnetwork@ggmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'lucifer', '9898989898', 'Maidan', 'Female', 'YADU_Logo.JPG', 1, '700001', '1990-08-03', 1, '2017-08-18 10:46:38'),
(4, 'Somdeep Kanu', 'somdeepkanu@ggmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'som123', '9898989898', 'durga nagar asas', 'Male', 'slide_05.jpg', 2, '700002', '1990-08-03', 1, '2017-08-09 13:19:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tn_church`
--
ALTER TABLE `tn_church`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tn_group`
--
ALTER TABLE `tn_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tn_members`
--
ALTER TABLE `tn_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tn_church`
--
ALTER TABLE `tn_church`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tn_group`
--
ALTER TABLE `tn_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tn_members`
--
ALTER TABLE `tn_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
