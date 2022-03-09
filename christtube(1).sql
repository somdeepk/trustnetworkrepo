-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2022 at 03:14 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `christtube`
--

-- --------------------------------------------------------

--
-- Table structure for table `tn_events`
--

CREATE TABLE `tn_events` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `event_type` varchar(20) DEFAULT NULL,
  `event_title` varchar(100) DEFAULT NULL,
  `event_desc` text DEFAULT NULL,
  `all_day_event` tinyint(1) NOT NULL DEFAULT 0,
  `event_start` datetime DEFAULT NULL,
  `event_end` datetime DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tn_events`
--

INSERT INTO `tn_events` (`id`, `member_id`, `event_type`, `event_title`, `event_desc`, `all_day_event`, `event_start`, `event_end`, `create_date`, `update_date`, `status`, `deleted`) VALUES
(1, 7, 'Appointment', 'My AnniversaryE', 'My Anniversary Description', 1, '2022-01-27 00:00:00', '2022-01-27 23:59:00', '2022-01-26 09:24:03', '2022-01-26 15:33:29', '1', '0'),
(2, 7, 'Meeting', 'Somdeepp Admin MY Birthday', 'All Are invited to my birthday', 0, '2022-01-28 20:56:53', '2022-01-29 23:48:02', '2022-01-26 10:28:38', '2022-01-26 15:19:49', '1', '0'),
(3, 22, 'Event', 'My Firthday Pranay Gupta', 'My Firthday Pranay Gupta desc', 0, '2022-01-27 19:00:00', '2022-01-27 21:30:00', '2022-01-26 15:24:55', NULL, '1', '0'),
(4, 7, 'Appointment', 'evnet title1', 'evnet title1 Desc1', 0, '2022-01-31 09:00:00', '2022-01-31 17:00:00', '2022-01-28 15:59:00', NULL, '1', '0'),
(5, 7, 'Task', 'evnet title2', 'evnet title2 Desc', 1, '2022-01-31 00:00:00', '2022-01-31 23:59:00', '2022-01-28 15:59:42', NULL, '1', '0'),
(6, 27, 'Meeting', 'dsd', 'dsd', 0, '2022-01-28 09:00:00', '2022-01-28 17:00:00', '2022-01-28 17:27:50', NULL, '1', '0'),
(7, 27, 'Task', 'soha events', 'soha events Desc', 0, '2022-01-29 09:00:00', '2022-01-29 17:00:00', '2022-01-28 17:48:04', NULL, '1', '0'),
(8, 27, 'Task', 'rer', 'erer', 0, '2022-01-28 23:00:00', '2022-01-28 23:30:00', '2022-01-28 17:50:07', '2022-01-28 18:33:06', '1', '0'),
(9, 7, 'Meeting', 'gaffar marriage', 'gaffar', 0, '2022-02-17 07:45:00', '2022-02-17 17:00:00', '2022-02-03 15:38:46', NULL, '1', '0'),
(10, 7, 'Meeting', 'soha birthdatt', 'soha birthdatt desc', 0, '2022-02-03 09:00:00', '2022-02-03 17:00:00', '2022-02-03 15:39:38', NULL, '1', '0'),
(12, 1, 'Event', 'aaa1111', 'bbb2222', 0, '2022-03-03 09:00:00', '2022-03-03 17:00:00', '2022-02-24 16:02:43', '2022-02-27 06:30:05', '1', '0'),
(13, 1, 'Appointment', 'ccc', 'ddd', 0, '2022-03-04 16:00:00', '2022-03-04 17:00:00', '2022-02-24 17:31:55', NULL, '1', '0'),
(14, 3, 'Event', 'ooo', 'ppp', 0, '2022-02-25 09:00:00', '2022-02-25 10:45:00', '2022-02-24 18:30:49', NULL, '1', '0'),
(15, 3, 'Meeting', 'fff', 'ggg', 0, '2022-02-24 23:00:00', '2022-02-24 23:30:00', '2022-02-24 18:31:37', NULL, '1', '0'),
(16, 1, 'Appointment', 'abcd', 'zzzzzzzzzzzzz', 1, '2022-02-27 00:00:00', '2022-02-27 23:59:00', '2022-02-27 06:29:39', NULL, '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tn_events_friend`
--

CREATE TABLE `tn_events_friend` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  `event_accept_reject` enum('P','A','R') NOT NULL DEFAULT 'P' COMMENT 'P:InProgress;A:Accept;R:Reject',
  `deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tn_events_friend`
--

INSERT INTO `tn_events_friend` (`id`, `event_id`, `friend_id`, `event_accept_reject`, `deleted`) VALUES
(27, 2, 6, 'P', '0'),
(28, 2, 27, 'R', '0'),
(29, 2, 5, 'P', '0'),
(30, 3, 27, 'A', '0'),
(31, 3, 5, 'P', '0'),
(32, 3, 14, 'P', '0'),
(33, 1, 6, 'P', '0'),
(34, 1, 5, 'P', '0'),
(35, 4, 5, 'P', '0'),
(36, 4, 27, 'A', '0'),
(37, 4, 6, 'P', '0'),
(38, 5, 5, 'P', '0'),
(39, 5, 27, 'A', '0'),
(40, 6, 22, 'P', '0'),
(41, 6, 26, 'P', '0'),
(42, 6, 7, 'P', '0'),
(43, 7, 26, 'P', '0'),
(44, 7, 7, 'A', '0'),
(46, 8, 26, 'P', '0'),
(47, 9, 5, 'P', '0'),
(48, 9, 27, 'P', '0'),
(49, 10, 6, 'A', '0'),
(50, 10, 27, 'P', '0'),
(51, 10, 5, 'P', '0'),
(54, 13, 4, 'P', '0'),
(55, 14, 1, 'P', '0'),
(56, 14, 2, 'P', '0'),
(57, 15, 1, 'P', '0'),
(58, 16, 4, 'P', '0'),
(59, 16, 2, 'P', '0'),
(60, 12, 4, 'P', '0'),
(61, 12, 2, 'P', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tn_group`
--

CREATE TABLE `tn_group` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `group_desc` mediumtext DEFAULT NULL,
  `is_editable` enum('Y','N') NOT NULL DEFAULT 'Y',
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tn_group`
--

INSERT INTO `tn_group` (`id`, `member_id`, `name`, `group_desc`, `is_editable`, `create_date`, `update_date`, `status`, `deleted`) VALUES
(1, 0, 'Leadership', 'Leadership', 'N', '2021-08-14 13:03:49', NULL, '1', '0'),
(2, 0, 'Staff', 'Staff', 'N', '2021-08-14 13:03:49', NULL, '1', '0'),
(3, 0, 'Clergy', 'Clergy', 'N', '2021-08-14 13:03:49', NULL, '1', '0'),
(4, 0, 'Ministers', 'Ministers', 'N', '2021-08-14 13:03:49', NULL, '1', '0'),
(5, 0, 'Virtual Members', 'Virtual Members', 'N', '2021-08-14 13:03:49', NULL, '1', '0'),
(6, 0, 'Fans', 'Fans', 'N', '2021-08-14 13:03:49', NULL, '1', '0'),
(7, 0, 'Followers', 'Followers', 'N', '2021-08-14 13:03:49', NULL, '1', '0'),
(8, 0, 'Partners', 'Partners', 'N', '2021-08-14 13:03:49', NULL, '1', '0'),
(9, 0, 'Sponsors', 'Sponsors', 'N', '2021-08-14 13:03:49', NULL, '1', '0'),
(10, 0, 'Businesses', 'Businesses', 'N', '2021-08-14 13:03:49', NULL, '1', '0'),
(11, 0, 'Advertisers', 'Advertisers', 'N', '2021-08-14 13:03:49', NULL, '1', '0'),
(12, 0, 'Mens Groups', 'Mens Groups', 'N', '2021-08-14 13:03:49', NULL, '1', '0'),
(13, 0, 'Women Groups', 'Women Groups', 'N', '2021-08-14 13:03:49', NULL, '1', '0'),
(14, 0, 'Adults Groups', 'Adults Groups', 'N', '2021-08-14 13:03:49', NULL, '1', '0'),
(15, 0, 'Media', 'Media', 'N', '2021-08-14 13:03:49', NULL, '1', '0'),
(20, 7, 'Sibling', 'Sibling description', 'Y', '2022-02-18 17:04:29', NULL, '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tn_members`
--

CREATE TABLE `tn_members` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `membership_type` enum('PM','RM') DEFAULT NULL,
  `membership_option` varchar(30) DEFAULT NULL,
  `church_type` varchar(30) DEFAULT NULL,
  `denomination` int(4) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `user_email` varchar(50) DEFAULT NULL,
  `gender` varchar(4) DEFAULT NULL,
  `marital_status` varchar(12) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `alt_email` varchar(50) DEFAULT NULL,
  `website` varchar(175) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `is_pass_changed` enum('Y','N') NOT NULL DEFAULT 'N',
  `authenticator_secret` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `country` int(11) NOT NULL DEFAULT 0,
  `state` int(11) NOT NULL DEFAULT 0,
  `city` int(11) NOT NULL DEFAULT 0,
  `postal_code` varchar(8) DEFAULT NULL,
  `about_church` mediumtext DEFAULT NULL,
  `profile_image` varchar(30) DEFAULT NULL,
  `cover_image` varchar(30) DEFAULT NULL,
  `notification_data` text DEFAULT NULL,
  `security_data` text DEFAULT NULL,
  `profile_question` longtext DEFAULT NULL,
  `is_approved` enum('Y','N') NOT NULL DEFAULT 'N',
  `inactive_account` enum('0','1') NOT NULL DEFAULT '0',
  `delete_account` enum('0','1') NOT NULL DEFAULT '0',
  `delete_account_date` datetime DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tn_members`
--

INSERT INTO `tn_members` (`id`, `parent_id`, `membership_type`, `membership_option`, `church_type`, `denomination`, `first_name`, `last_name`, `user_email`, `gender`, `marital_status`, `dob`, `mobile`, `alt_email`, `website`, `password`, `is_pass_changed`, `authenticator_secret`, `address`, `country`, `state`, `city`, `postal_code`, `about_church`, `profile_image`, `cover_image`, `notification_data`, `security_data`, `profile_question`, `is_approved`, `inactive_account`, `delete_account`, `delete_account_date`, `create_date`, `update_date`, `status`, `deleted`) VALUES
(1, 5, 'RM', 'regular_members', '', 0, 'Somdeep', 'Kanu', 'somdeepkanu@gmail.com', NULL, NULL, '2022-01-03', '8013179998', NULL, NULL, 's1omdeepkanu@gmail.comA1', 'Y', 'BHJX7XYTOUOHQTYG', '35 GM ROADE', 101, 41, 5583, '7000346', 'About churchE', '1644680710.png', '1644680689.png', NULL, '{\"who_can_follow_me\":true,\"show_my_activities\":true,\"encrypted_notification_emails\":false,\"allow_commenting\":false}', '{\"q1\":\"q1\",\"q2\":\"q2\",\"q3\":\"q3\",\"q4\":\"a4\",\"q5\":\"rwr\",\"q6\":\"rer\",\"q7\":\"dsd\"}', 'Y', '0', '0', NULL, '2022-01-08 09:32:55', '2022-03-06 08:29:01', '1', '0'),
(2, 0, 'PM', 'church_ministries', 'Global Ministries', 5, 'Thomass Church', '', 'thomaschurch@gmail.com', NULL, NULL, '2022-01-05', '9674137989', NULL, NULL, '123456', 'Y', NULL, '', 0, 0, 0, '', '', '1645204366.png', '1645540330.png', NULL, NULL, '{\"q1\":\"ffdfdf\",\"q2\":\"df\",\"q3\":\"fdf\",\"q4\":\"fdf\",\"q5\":\"fdf\",\"q6\":\"fd\",\"q7\":\"fdf\"}', 'Y', '0', '0', NULL, '2022-01-08 09:38:13', '2022-02-09 16:26:45', '1', '0'),
(3, 2, 'RM', 'regular_members', '', 0, 'Tanushri1', 'Kanu', 'tanushrikanu@gmail.com', NULL, NULL, '2022-02-01', '9804330891', NULL, NULL, '123456', 'N', NULL, NULL, 0, 0, 0, NULL, NULL, '1645028643.png', NULL, NULL, NULL, NULL, 'Y', '0', '0', NULL, '2022-02-05 09:16:02', NULL, '1', '0'),
(4, 5, 'RM', 'regular_members', '', 0, 'Sohalia', 'Kanu', 'sohaliakanu@gmail.com', NULL, NULL, '2022-02-02', '9639639639', NULL, NULL, '123456', 'Y', NULL, NULL, 0, 0, 0, NULL, NULL, '1645195642.png', NULL, NULL, NULL, '{\"q1\":\"232\",\"q2\":\"323\",\"q3\":\"323\",\"q4\":\"323\",\"q5\":\"434\",\"q6\":\"434\",\"q7\":\"454545\"}', 'Y', '0', '0', NULL, '2022-02-05 09:16:43', NULL, '1', '0'),
(5, 0, 'PM', 'church_ministries', 'Local Churche', 0, 'Pointo Church', '', 'pointo@gmail.com', NULL, NULL, '2022-01-01', '118899002255', NULL, NULL, '123456', 'N', NULL, NULL, 0, 0, 0, NULL, NULL, '1645204338.png', NULL, NULL, '{\"who_can_follow_me\":true,\"show_my_activities\":false,\"encrypted_notification_emails\":true,\"allow_commenting\":false}', NULL, 'Y', '0', '0', NULL, '2022-02-05 09:18:20', NULL, '1', '0'),
(6, 0, 'RM', 'regular_members', '', 0, 'Ross', 'Taylor', 'rosstaylor@gmail.com', NULL, NULL, '1980-08-18', '8013179998', NULL, NULL, '123456', 'N', NULL, NULL, 0, 0, 0, NULL, NULL, '1645200713.png', NULL, NULL, NULL, NULL, 'Y', '0', '0', NULL, '2022-02-18 16:52:40', NULL, '1', '0'),
(7, 0, 'PM', 'church_ministries', 'Local Ministrie', 2, 'Adamas', '', 'adams@gmail.com', NULL, NULL, '2022-02-02', '9674137989', NULL, NULL, '123456', 'Y', NULL, '34 GM Road; Near Sen Paly Auto Stand( SBI BANK;) Behala', 0, 0, 0, '1980-08-', 'The is demo of About Church', '1645200052.png', '1645200061.png', '{\"comment_email\":true,\"comment_push\":true,\"comment_sms\":true,\"people_email\":true,\"people_push\":true,\"people_sms\":false,\"birthday_email\":true,\"birthday_push\":true,\"birthday_sms\":true,\"event_email\":true,\"event_push\":true,\"event_sms\":true}', '{\"who_can_follow_me\":true,\"show_my_activities\":true,\"encrypted_notification_emails\":true,\"allow_commenting\":true}', '{\"q1\":\"demo1\",\"q2\":\"demo2\",\"q3\":\"demo3\",\"q4\":\"demo3\",\"q5\":\"demo4\",\"q6\":\"demo5\",\"q7\":\"demo5\"}', 'Y', '0', '0', NULL, '2022-02-18 16:55:58', '2022-02-18 17:00:11', '1', '0'),
(8, 7, 'RM', 'regular_members', '', 0, 'Tanushri', 'Kanu', 'tanushrisoha@gmail.com', NULL, NULL, '2022-02-01', '9804330891', NULL, NULL, '123456', 'Y', NULL, '34 GM Road; Near Sen Paly Auto Stand( SBI BANK;) Behala', 0, 0, 0, '1980-08-', '', '1645200541.png', '1645200581.png', NULL, NULL, '{\"q1\":\"we\",\"q2\":\"wewe\",\"q3\":\"ew\",\"q4\":\"ee\",\"q5\":\"ewe\",\"q6\":\"ewe\",\"q7\":\"ewe\"}', 'Y', '0', '0', NULL, '2022-02-18 17:07:59', '2022-02-18 17:10:35', '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tn_member_friends`
--

CREATE TABLE `tn_member_friends` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL DEFAULT 0,
  `friend_id` int(11) NOT NULL DEFAULT 0,
  `request_status` enum('1','2','3','4') NOT NULL DEFAULT '1' COMMENT '1: Request Send,2: Added As Friend,3: Remove From Suggestion,4: Delete From Friend',
  `request_date` datetime DEFAULT NULL,
  `remove_date` datetime DEFAULT NULL,
  `confirm_date` datetime DEFAULT NULL,
  `deletion_date` datetime DEFAULT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tn_member_friends`
--

INSERT INTO `tn_member_friends` (`id`, `member_id`, `friend_id`, `request_status`, `request_date`, `remove_date`, `confirm_date`, `deletion_date`, `deleted`) VALUES
(1, 1, 2, '2', '2022-02-22 16:21:02', NULL, '2022-02-22 16:26:25', NULL, '0'),
(2, 3, 2, '2', '2022-02-22 16:22:52', NULL, '2022-02-22 16:27:00', NULL, '0'),
(3, 5, 2, '2', '2022-02-22 16:23:54', NULL, '2022-02-22 16:27:10', NULL, '0'),
(4, 4, 1, '2', '2022-02-22 16:59:35', NULL, '2022-02-22 17:02:35', NULL, '0'),
(5, 1, 7, '1', '2022-02-23 13:08:19', NULL, NULL, NULL, '0'),
(6, 1, 5, '1', '2022-02-23 13:08:19', NULL, NULL, NULL, '0'),
(7, 1, 6, '1', '2022-02-23 13:08:20', NULL, NULL, NULL, '0'),
(8, 1, 8, '1', '2022-02-23 13:08:21', NULL, NULL, NULL, '0'),
(9, 1, 3, '2', '2022-02-23 13:08:21', NULL, '2022-02-23 13:09:26', NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `tn_member_timeline`
--

CREATE TABLE `tn_member_timeline` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL DEFAULT 0,
  `from_member_id` int(11) NOT NULL DEFAULT 0,
  `to_member_id` int(11) NOT NULL DEFAULT 0,
  `post_type` varchar(20) DEFAULT 'newsfeed' COMMENT 'tagged,newsfeed',
  `create_date` datetime DEFAULT NULL,
  `status` enum('S','H') NOT NULL DEFAULT 'S' COMMENT 'S:Show in timeline; H:Hide for time',
  `disabled_comments` tinyint(1) NOT NULL DEFAULT 0,
  `add_favorites` tinyint(1) NOT NULL DEFAULT 0,
  `deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tn_member_timeline`
--

INSERT INTO `tn_member_timeline` (`id`, `post_id`, `from_member_id`, `to_member_id`, `post_type`, `create_date`, `status`, `disabled_comments`, `add_favorites`, `deleted`) VALUES
(1, 1, 1, 1, 'newsfeed', '2022-02-12 08:34:05', 'S', 0, 0, '0'),
(2, 2, 1, 1, 'newsfeed', '2022-02-12 08:42:06', 'S', 0, 0, '0'),
(3, 2, 1, 4, 'tagged', '2022-02-12 08:42:06', 'S', 0, 0, '0'),
(4, 2, 1, 3, 'tagged', '2022-02-12 08:42:06', 'S', 0, 0, '0'),
(5, 1, 1, 1, 'newsfeed', '2022-02-12 11:41:08', 'S', 0, 0, '0'),
(6, 2, 1, 1, 'newsfeed', '2022-02-12 11:41:30', 'S', 0, 0, '0'),
(7, 3, 1, 1, 'newsfeed', '2022-02-12 11:43:37', 'S', 0, 0, '0'),
(8, 4, 1, 1, 'newsfeed', '2022-02-12 13:35:30', 'S', 0, 0, '0'),
(9, 5, 1, 1, 'newsfeed', '2022-02-12 13:36:28', 'S', 0, 0, '0'),
(10, 6, 1, 1, 'newsfeed', '2022-02-12 13:37:40', 'S', 0, 0, '0'),
(11, 6, 1, 4, 'tagged', '2022-02-12 13:37:40', 'S', 0, 0, '0'),
(12, 6, 1, 3, 'tagged', '2022-02-12 13:37:40', 'S', 0, 0, '0'),
(13, 6, 1, 2, 'tagged', '2022-02-12 13:37:40', 'S', 0, 0, '0'),
(14, 7, 1, 1, 'newsfeed', '2022-02-12 13:39:24', 'S', 0, 0, '0'),
(15, 1, 1, 1, 'newsfeed', '2022-02-12 13:46:13', 'S', 0, 0, '0'),
(16, 1, 1, 1, 'newsfeed', '2022-02-12 13:50:21', 'S', 0, 0, '0'),
(17, 2, 1, 1, 'newsfeed', '2022-02-12 13:50:33', 'S', 0, 0, '0'),
(18, 3, 1, 1, 'newsfeed', '2022-02-12 13:50:50', 'S', 0, 0, '0'),
(19, 4, 1, 1, 'newsfeed', '2022-02-12 13:53:25', 'S', 0, 0, '0'),
(20, 5, 1, 1, 'newsfeed', '2022-02-12 13:53:38', 'S', 0, 0, '0'),
(21, 6, 1, 1, 'newsfeed', '2022-02-12 13:54:31', 'S', 0, 0, '0'),
(22, 7, 1, 1, 'newsfeed', '2022-02-12 15:37:23', 'S', 0, 0, '0'),
(23, 8, 1, 1, 'newsfeed', '2022-02-12 15:42:19', 'S', 0, 0, '0'),
(24, 9, 1, 1, 'newsfeed', '2022-02-12 15:43:09', 'S', 0, 0, '0'),
(25, 10, 1, 1, 'newsfeed', '2022-02-12 15:43:25', 'S', 0, 0, '0'),
(26, 11, 1, 1, 'newsfeed', '2022-02-12 15:43:43', 'S', 0, 0, '0'),
(27, 12, 1, 1, 'newsfeed', '2022-02-12 15:43:55', 'S', 0, 0, '0'),
(28, 13, 1, 1, 'newsfeed', '2022-02-12 15:44:33', 'S', 0, 0, '0'),
(29, 14, 1, 1, 'newsfeed', '2022-02-12 15:44:50', 'S', 0, 0, '0'),
(30, 15, 1, 1, 'newsfeed', '2022-02-12 15:59:19', 'S', 0, 0, '0'),
(31, 16, 1, 1, 'newsfeed', '2022-02-12 16:02:00', 'S', 0, 0, '0'),
(32, 17, 1, 1, 'newsfeed', '2022-02-12 16:07:21', 'S', 0, 0, '0'),
(33, 18, 1, 1, 'newsfeed', '2022-02-12 16:07:41', 'S', 0, 0, '0'),
(34, 19, 1, 1, 'newsfeed', '2022-02-12 16:17:02', 'S', 0, 0, '0'),
(35, 1, 1, 1, 'newsfeed', '2022-02-12 16:18:52', 'S', 0, 0, '0'),
(36, 2, 1, 1, 'newsfeed', '2022-02-12 16:18:58', 'S', 0, 0, '0'),
(37, 3, 1, 1, 'newsfeed', '2022-02-12 16:19:07', 'S', 0, 0, '0'),
(38, 4, 1, 1, 'newsfeed', '2022-02-12 16:19:48', 'S', 0, 0, '0'),
(39, 5, 1, 1, 'newsfeed', '2022-02-12 16:21:04', 'S', 0, 0, '0'),
(40, 6, 1, 1, 'newsfeed', '2022-02-12 16:21:29', 'S', 0, 0, '0'),
(41, 7, 1, 1, 'newsfeed', '2022-02-12 16:45:52', 'S', 0, 0, '0'),
(42, 8, 1, 1, 'newsfeed', '2022-02-12 16:46:28', 'S', 0, 0, '0'),
(43, 8, 1, 3, 'tagged', '2022-02-12 16:46:28', 'S', 0, 0, '0'),
(44, 8, 1, 4, 'tagged', '2022-02-12 16:46:28', 'S', 0, 0, '0'),
(45, 8, 1, 2, 'tagged', '2022-02-12 16:46:28', 'S', 0, 0, '0'),
(46, 9, 1, 1, 'newsfeed', '2022-02-13 08:16:18', 'S', 0, 0, '0'),
(47, 10, 1, 1, 'newsfeed', '2022-02-13 08:16:41', 'S', 0, 0, '0'),
(48, 11, 1, 1, 'newsfeed', '2022-02-13 08:17:09', 'S', 0, 0, '0'),
(49, 12, 1, 1, 'newsfeed', '2022-02-13 08:17:28', 'S', 0, 0, '0'),
(50, 13, 1, 1, 'newsfeed', '2022-02-13 08:18:38', 'S', 0, 0, '0'),
(51, 14, 1, 1, 'newsfeed', '2022-02-13 08:20:34', 'S', 0, 0, '0'),
(52, 15, 1, 1, 'newsfeed', '2022-02-13 08:21:03', 'S', 0, 0, '0'),
(53, 16, 1, 1, 'newsfeed', '2022-02-13 09:06:16', 'S', 0, 0, '0'),
(54, 17, 1, 1, 'newsfeed', '2022-02-16 16:29:11', 'S', 0, 1, '0'),
(55, 17, 1, 4, 'tagged', '2022-02-16 16:29:11', 'S', 0, 0, '0'),
(56, 17, 1, 3, 'tagged', '2022-02-16 16:29:11', 'S', 0, 0, '0'),
(57, 18, 4, 4, 'newsfeed', '2022-02-16 18:07:05', 'S', 0, 0, '0'),
(58, 19, 1, 1, 'newsfeed', '2022-02-18 15:45:23', 'S', 0, 0, '0'),
(59, 19, 1, 3, 'tagged', '2022-02-18 15:45:23', 'S', 0, 0, '0'),
(60, 20, 6, 6, 'newsfeed', '2022-02-18 17:20:50', 'S', 0, 0, '0'),
(61, 20, 6, 7, 'tagged', '2022-02-18 17:20:50', 'S', 0, 0, '0'),
(62, 20, 6, 8, 'tagged', '2022-02-18 17:20:50', 'S', 0, 0, '0'),
(63, 21, 7, 7, 'newsfeed', '2022-02-18 17:24:28', 'S', 0, 0, '0'),
(64, 21, 7, 6, 'tagged', '2022-02-18 17:24:28', 'S', 0, 0, '0'),
(65, 22, 7, 7, 'newsfeed', '2022-02-18 17:24:56', 'S', 0, 0, '0'),
(66, 23, 7, 7, 'newsfeed', '2022-02-18 17:25:20', 'S', 0, 0, '0'),
(67, 23, 7, 6, 'tagged', '2022-02-18 17:25:20', 'S', 0, 0, '0'),
(68, 24, 7, 7, 'newsfeed', '2022-02-18 17:25:42', 'S', 0, 0, '0'),
(69, 24, 7, 6, 'tagged', '2022-02-18 17:25:42', 'S', 0, 0, '0');

-- --------------------------------------------------------

--
-- Table structure for table `tn_page`
--

CREATE TABLE `tn_page` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `page_url` varchar(100) DEFAULT NULL,
  `page_category` varchar(100) DEFAULT NULL,
  `page_desc` mediumtext DEFAULT NULL,
  `meta_title` varchar(100) DEFAULT NULL,
  `meta_keyword` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tn_page`
--

INSERT INTO `tn_page` (`id`, `member_id`, `name`, `page_url`, `page_category`, `page_desc`, `meta_title`, `meta_keyword`, `meta_description`, `create_date`, `update_date`, `status`, `deleted`) VALUES
(1, 1, 'Test page name', 'abcd.com', 'Statement of faith', 'Test page Desc', 'Test Meta title', 'Test met keyword, aaa, bbb', 'test meta descsfkjhsfjgsdd sdmfbsdgjksdf mnsd vsdv', '2022-02-07 17:41:49', NULL, '1', '0'),
(2, 1, 'aaa', 'vvv', 'Church Information', 'kgjhjh', 'hkjhkjhkjq', 'jkjhkjhkj', 'gggggggg', '2022-02-07 17:43:17', NULL, '1', '0'),
(3, 1, 'hhh', 'hhhhhh', 'Statement of faith', 'hhhh', 'hhhhhhhhh', 'hhhhhhhhhh', 'hhhhhhhhh', '2022-02-07 17:57:28', NULL, '1', '0'),
(4, 1, '232', '323', 'Church Members', '323', 'mtitle', 'ewe', 'ewe', '2022-02-09 17:05:59', NULL, '1', '0'),
(5, 5, 'my popage', 'mypageurl', 'Church Information', 'trtr', 'rtrt', 'trt', 'trtrtr', '2022-02-09 17:20:37', NULL, '1', '0'),
(6, 7, 'About', 'about', 'Church Information', 'Mu About Description', 'Meta title', 'Meta tkeywords1, Meta tkeywords', 'meta descripon', '2022-02-18 17:05:38', NULL, '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tn_post`
--

CREATE TABLE `tn_post` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `post` mediumtext DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tn_post`
--

INSERT INTO `tn_post` (`id`, `member_id`, `post`, `create_date`, `update_date`, `status`, `deleted`) VALUES
(1, 1, '1111', '2022-02-12 16:18:52', NULL, '1', '0'),
(2, 1, '2222', '2022-02-12 16:18:58', NULL, '1', '0'),
(3, 1, '3333', '2022-02-12 16:19:07', NULL, '1', '0'),
(4, 1, '444', '2022-02-12 16:19:48', NULL, '1', '0'),
(5, 1, '5555', '2022-02-12 16:21:04', NULL, '1', '0'),
(6, 1, '66666', '2022-02-12 16:21:29', NULL, '1', '0'),
(7, 1, 'cchana masla', '2022-02-12 16:45:52', NULL, '1', '0'),
(8, 1, 'my all iamges', '2022-02-12 16:46:28', NULL, '1', '0'),
(9, 1, 'test three', '2022-02-13 08:16:18', NULL, '1', '0'),
(10, 1, 'fdfdf', '2022-02-13 08:16:41', NULL, '1', '0'),
(11, 1, 'fdf', '2022-02-13 08:17:09', NULL, '1', '0'),
(12, 1, 'fdfdf', '2022-02-13 08:17:28', NULL, '1', '0'),
(13, 1, 'dsdsd', '2022-02-13 08:18:38', NULL, '1', '0'),
(14, 1, 'dsdsdsds', '2022-02-13 08:20:34', NULL, '1', '0'),
(15, 1, 'fefe', '2022-02-13 08:21:03', NULL, '1', '0'),
(16, 1, '', '2022-02-13 09:06:16', NULL, '1', '0'),
(17, 1, 'Hi My comments', '2022-02-16 16:29:11', NULL, '1', '0'),
(18, 4, 'khoka', '2022-02-16 18:07:05', NULL, '1', '1'),
(19, 1, 'my new video', '2022-02-18 15:45:23', NULL, '1', '0'),
(20, 6, 'My First Post', '2022-02-18 17:20:50', NULL, '1', '0'),
(21, 7, 'test2', '2022-02-18 17:24:28', NULL, '1', '0'),
(22, 7, 'comment2', '2022-02-18 17:24:56', NULL, '1', '0'),
(23, 7, 'comment2', '2022-02-18 17:25:20', NULL, '1', '0'),
(24, 7, 'est4', '2022-02-18 17:25:42', NULL, '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tn_post_comments`
--

CREATE TABLE `tn_post_comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL DEFAULT 0,
  `member_id` int(11) NOT NULL DEFAULT 0,
  `member_comment` mediumtext DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tn_post_file`
--

CREATE TABLE `tn_post_file` (
  `id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `module_type` varchar(15) DEFAULT NULL,
  `member_id` int(11) NOT NULL,
  `file_original_name` varchar(100) NOT NULL,
  `file_name` varchar(25) DEFAULT NULL,
  `file_size` varchar(15) DEFAULT NULL,
  `file_type` varchar(15) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tn_post_file`
--

INSERT INTO `tn_post_file` (`id`, `module_id`, `module_type`, `member_id`, `file_original_name`, `file_name`, `file_size`, `file_type`, `create_date`, `deleted`) VALUES
(1, 1, 'coverimages', 1, '1644680689.png', '1644680689.png', '0', 'image/png', '2022-02-12 16:44:49', '0'),
(2, 1, 'members', 1, '1644680710.png', '1644680710.png', '0', 'image/png', '2022-02-12 16:45:10', '0'),
(3, 7, 'postfiles', 1, '1633019789774 - Copy.mp4', '16446807524357.mp4', '2107842', 'video/mp4', '2022-02-12 16:45:52', '0'),
(4, 8, 'postfiles', 1, 'church2 - Copy.jpg', '1644680789498.jpg', '166208', 'image/jpeg', '2022-02-12 16:46:28', '0'),
(5, 8, 'postfiles', 1, 'church2.jpg', '1644680789665.jpg', '166208', 'image/jpeg', '2022-02-12 16:46:28', '0'),
(6, 8, 'postfiles', 1, 'man - Copy - Copy.jpg', '16446807897758.jpg', '52323', 'image/jpeg', '2022-02-12 16:46:28', '0'),
(7, 8, 'postfiles', 1, 'man - Copy.jpg', '16446807898917.jpg', '52323', 'image/jpeg', '2022-02-12 16:46:28', '0'),
(8, 8, 'postfiles', 1, 'man.jpg', '16446807902306.jpg', '52323', 'image/jpeg', '2022-02-12 16:46:28', '0'),
(9, 8, 'postfiles', 1, 'rug_polygon - Copy.jpg', '16446807903993.jpg', '1194703', 'image/jpeg', '2022-02-12 16:46:28', '0'),
(10, 8, 'postfiles', 1, 'rug_polygon.jpg', '16446807906138.jpg', '1194703', 'image/jpeg', '2022-02-12 16:46:28', '0'),
(11, 9, 'postfiles', 1, '1633019789774 - Copy.mp4', '16447365788549.mp4', '2107842', 'video/mp4', '2022-02-13 08:16:18', '0'),
(12, 9, 'postfiles', 1, 'church - Copy - Copy.jpg', '16447365793362.jpg', '78771', 'image/jpeg', '2022-02-13 08:16:18', '0'),
(13, 9, 'postfiles', 1, 'man - Copy - Copy.jpg', '16447365794943.jpg', '52323', 'image/jpeg', '2022-02-13 08:16:18', '0'),
(14, 10, 'postfiles', 1, '1633019789774.mp4', '16447366013371.mp4', '2107842', 'video/mp4', '2022-02-13 08:16:41', '0'),
(15, 10, 'postfiles', 1, 'church.jpg', '16447366014417.jpg', '78771', 'image/jpeg', '2022-02-13 08:16:41', '0'),
(16, 10, 'postfiles', 1, 'church2.jpg', '16447366017057.jpg', '166208', 'image/jpeg', '2022-02-13 08:16:41', '0'),
(17, 10, 'postfiles', 1, 'man - Copy - Copy.jpg', '16447366017938.jpg', '52323', 'image/jpeg', '2022-02-13 08:16:41', '0'),
(18, 11, 'postfiles', 1, 'church - Copy - Copy.jpg', '16447366292605.jpg', '78771', 'image/jpeg', '2022-02-13 08:17:09', '0'),
(19, 11, 'postfiles', 1, 'church2.jpg', '16447366293829.jpg', '166208', 'image/jpeg', '2022-02-13 08:17:09', '0'),
(20, 11, 'postfiles', 1, 'man - Copy - Copy.jpg', '16447366294554.jpg', '52323', 'image/jpeg', '2022-02-13 08:17:09', '0'),
(21, 11, 'postfiles', 1, 'man - Copy.jpg', '1644736629544.jpg', '52323', 'image/jpeg', '2022-02-13 08:17:09', '0'),
(22, 12, 'postfiles', 1, 'church - Copy - Copy.jpg', '16447366486668.jpg', '78771', 'image/jpeg', '2022-02-13 08:17:28', '0'),
(23, 12, 'postfiles', 1, 'church2 - Copy.jpg', '16447366488129.jpg', '166208', 'image/jpeg', '2022-02-13 08:17:28', '0'),
(24, 12, 'postfiles', 1, 'church2.jpg', '1644736648884.jpg', '166208', 'image/jpeg', '2022-02-13 08:17:28', '0'),
(25, 12, 'postfiles', 1, 'man - Copy - Copy.jpg', '16447366490136.jpg', '52323', 'image/jpeg', '2022-02-13 08:17:28', '0'),
(26, 12, 'postfiles', 1, 'rug_polygon - Copy.jpg', '16447366492962.jpg', '1194703', 'image/jpeg', '2022-02-13 08:17:28', '0'),
(27, 13, 'postfiles', 1, '222.jpg', '16447367181527.jpg', '166208', 'image/jpeg', '2022-02-13 08:18:38', '0'),
(28, 13, 'postfiles', 1, '1111.jpg', '16447367182208.jpg', '78771', 'image/jpeg', '2022-02-13 08:18:38', '0'),
(29, 13, 'postfiles', 1, '3333.jpg', '16447367182987.jpg', '52323', 'image/jpeg', '2022-02-13 08:18:38', '0'),
(30, 13, 'postfiles', 1, '4444.jpg', '1644736718449.jpg', '1194703', 'image/jpeg', '2022-02-13 08:18:38', '0'),
(31, 14, 'postfiles', 1, '222.jpg', '16447368343986.jpg', '166208', 'image/jpeg', '2022-02-13 08:20:34', '0'),
(32, 14, 'postfiles', 1, '3333.jpg', '16447368344705.jpg', '52323', 'image/jpeg', '2022-02-13 08:20:34', '0'),
(33, 14, 'postfiles', 1, '1633019789774 - Copy.mp4', '16447368345594.mp4', '2107842', 'video/mp4', '2022-02-13 08:20:34', '0'),
(34, 15, 'postfiles', 1, '1111.jpg', '16447368637068.jpg', '78771', 'image/jpeg', '2022-02-13 08:21:03', '0'),
(35, 15, 'postfiles', 1, '3333.jpg', '16447368639749.jpg', '52323', 'image/jpeg', '2022-02-13 08:21:03', '0'),
(36, 15, 'postfiles', 1, '1633019789774.mp4', '1644736864085.mp4', '2107842', 'video/mp4', '2022-02-13 08:21:03', '0'),
(37, 15, 'postfiles', 1, 'church.jpg', '16447368641689.jpg', '78771', 'image/jpeg', '2022-02-13 08:21:03', '0'),
(38, 16, 'postfiles', 1, '222.jpg', '16447395766153.jpg', '166208', 'image/jpeg', '2022-02-13 09:06:16', '0'),
(39, 16, 'postfiles', 1, '1111.jpg', '16447395767929.jpg', '78771', 'image/jpeg', '2022-02-13 09:06:16', '0'),
(40, 16, 'postfiles', 1, '3333.jpg', '16447395769522.jpg', '52323', 'image/jpeg', '2022-02-13 09:06:16', '0'),
(41, 17, 'postfiles', 1, '222.jpg', '16450253520954.jpg', '166208', 'image/jpeg', '2022-02-16 16:29:11', '0'),
(42, 17, 'postfiles', 1, '1111.jpg', '16450253521768.jpg', '78771', 'image/jpeg', '2022-02-16 16:29:11', '0'),
(43, 17, 'postfiles', 1, '3333.jpg', '16450253522415.jpg', '52323', 'image/jpeg', '2022-02-16 16:29:11', '0'),
(44, 17, 'postfiles', 1, '4444.jpg', '16450253522989.jpg', '1194703', 'image/jpeg', '2022-02-16 16:29:11', '0'),
(45, 3, 'members', 3, '1645028643.png', '1645028643.png', '0', 'image/png', '2022-02-16 17:24:03', '0'),
(46, 18, 'postfiles', 4, '1633019789774.mp4', '16450312252434.mp4', '2107842', 'video/mp4', '2022-02-16 18:07:05', '0'),
(47, 18, 'postfiles', 4, '3333.jpg', '16450312254459.jpg', '52323', 'image/jpeg', '2022-02-16 18:07:05', '0'),
(48, 18, 'postfiles', 4, 'church2.jpg', '16450312255345.jpg', '166208', 'image/jpeg', '2022-02-16 18:07:05', '0'),
(49, 19, 'postfiles', 1, '1633019789774 - Copy - Copy.mp4', '16451955236325.mp4', '2107842', 'video/mp4', '2022-02-18 15:45:23', '0'),
(50, 4, 'members', 4, '1645195642.png', '1645195642.png', '0', 'image/png', '2022-02-18 15:47:22', '0'),
(51, 7, 'members', 7, '1645200052.png', '1645200052.png', '0', 'image/png', '2022-02-18 17:00:52', '0'),
(52, 7, 'coverimages', 7, '1645200061.png', '1645200061.png', '0', 'image/png', '2022-02-18 17:01:01', '0'),
(53, 8, 'members', 8, '1645200541.png', '1645200541.png', '0', 'image/png', '2022-02-18 17:09:01', '0'),
(54, 8, 'coverimages', 8, '1645200548.png', '1645200548.png', '0', 'image/png', '2022-02-18 17:09:08', '0'),
(55, 8, 'coverimages', 8, '1645200581.png', '1645200581.png', '0', 'image/png', '2022-02-18 17:09:41', '0'),
(56, 6, 'members', 6, '1645200713.png', '1645200713.png', '0', 'image/png', '2022-02-18 17:11:53', '0'),
(57, 20, 'postfiles', 6, 'church2.jpg', '16452012508933.jpg', '166208', 'image/jpeg', '2022-02-18 17:20:50', '0'),
(58, 20, 'postfiles', 6, 'man.jpg', '16452012510239.jpg', '52323', 'image/jpeg', '2022-02-18 17:20:50', '0'),
(59, 20, 'postfiles', 6, '1633019789774.mp4', '16452012512979.mp4', '2107842', 'video/mp4', '2022-02-18 17:20:50', '0'),
(60, 21, 'postfiles', 7, 'cover2.jpg', '16452014689073.jpg', '8787', 'image/jpeg', '2022-02-18 17:24:28', '0'),
(61, 22, 'postfiles', 7, 'church.jpg', '16452014961997.jpg', '78771', 'image/jpeg', '2022-02-18 17:24:56', '0'),
(62, 22, 'postfiles', 7, 'cover1.jpeg', '16452014962682.jpeg', '8558', 'image/jpeg', '2022-02-18 17:24:56', '0'),
(63, 22, 'postfiles', 7, 'cover1.jpg', '16452014964169.jpg', '175947', 'image/jpeg', '2022-02-18 17:24:56', '0'),
(64, 22, 'postfiles', 7, 'cover2.jpg', '16452014967446.jpg', '8787', 'image/jpeg', '2022-02-18 17:24:56', '0'),
(65, 23, 'postfiles', 7, 'men2.jpg', '16452015209749.jpg', '14920', 'image/jpeg', '2022-02-18 17:25:20', '0'),
(66, 23, 'postfiles', 7, 'men3.jpg', '16452015212225.jpg', '4850', 'image/jpeg', '2022-02-18 17:25:20', '0'),
(67, 23, 'postfiles', 7, 'women3.jpg', '16452015215754.jpg', '36331', 'image/jpeg', '2022-02-18 17:25:20', '0'),
(68, 24, 'postfiles', 7, 'church.jpg', '16452015430503.jpg', '78771', 'image/jpeg', '2022-02-18 17:25:42', '0'),
(69, 5, 'members', 5, '1645204338.png', '1645204338.png', '0', 'image/png', '2022-02-18 18:12:18', '0'),
(70, 2, 'members', 2, '1645204366.png', '1645204366.png', '0', 'image/png', '2022-02-18 18:12:46', '0'),
(71, 2, 'coverimages', 2, '1645540330.png', '1645540330.png', '0', 'image/png', '2022-02-22 15:32:10', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tn_post_like`
--

CREATE TABLE `tn_post_like` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL DEFAULT 0,
  `member_id` int(11) NOT NULL DEFAULT 0,
  `create_date` datetime DEFAULT NULL,
  `deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tn_post_like`
--

INSERT INTO `tn_post_like` (`id`, `post_id`, `member_id`, `create_date`, `deleted`) VALUES
(2, 17, 4, '2022-02-16 17:21:16', '0'),
(3, 17, 3, '2022-02-16 17:22:55', '0'),
(4, 17, 1, '2022-02-16 18:08:33', '0'),
(5, 19, 1, '2022-02-18 15:45:42', '0'),
(6, 20, 6, '2022-02-18 17:22:16', '0'),
(7, 20, 7, '2022-02-18 17:22:52', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tn_post_tag_friend`
--

CREATE TABLE `tn_post_tag_friend` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `tagged_member_id` int(11) NOT NULL,
  `create_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tn_post_tag_friend`
--

INSERT INTO `tn_post_tag_friend` (`id`, `post_id`, `member_id`, `tagged_member_id`, `create_date`) VALUES
(1, 8, 1, 3, '2022-02-12 16:46:28'),
(2, 8, 1, 4, '2022-02-12 16:46:28'),
(3, 8, 1, 2, '2022-02-12 16:46:28'),
(4, 17, 1, 4, '2022-02-16 16:29:11'),
(5, 17, 1, 3, '2022-02-16 16:29:11'),
(6, 19, 1, 3, '2022-02-18 15:45:23'),
(7, 20, 6, 7, '2022-02-18 17:20:50'),
(8, 20, 6, 8, '2022-02-18 17:20:50'),
(9, 21, 7, 6, '2022-02-18 17:24:28'),
(10, 23, 7, 6, '2022-02-18 17:25:20'),
(11, 24, 7, 6, '2022-02-18 17:25:42');

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
(1, 'Administrator', 'trustnetwork@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Administrator', '9898989898', 'Maidan', 'Female', 'YADU_Logo.JPG', 1, '700001', '1990-08-03', 1, '2017-08-18 10:46:38'),
(4, 'Somdeep Kanu', 'somdeepkanu@ggmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'som123', '9898989898', 'durga nagar asas', 'Male', 'slide_05.jpg', 2, '700002', '1990-08-03', 1, '2017-08-09 13:19:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tn_events`
--
ALTER TABLE `tn_events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tn_events_friend`
--
ALTER TABLE `tn_events_friend`
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
-- Indexes for table `tn_member_friends`
--
ALTER TABLE `tn_member_friends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tn_member_timeline`
--
ALTER TABLE `tn_member_timeline`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tn_page`
--
ALTER TABLE `tn_page`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tn_post`
--
ALTER TABLE `tn_post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tn_post_comments`
--
ALTER TABLE `tn_post_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tn_post_file`
--
ALTER TABLE `tn_post_file`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tn_post_like`
--
ALTER TABLE `tn_post_like`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tn_post_tag_friend`
--
ALTER TABLE `tn_post_tag_friend`
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
-- AUTO_INCREMENT for table `tn_events`
--
ALTER TABLE `tn_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tn_events_friend`
--
ALTER TABLE `tn_events_friend`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `tn_group`
--
ALTER TABLE `tn_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tn_members`
--
ALTER TABLE `tn_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `tn_member_friends`
--
ALTER TABLE `tn_member_friends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tn_member_timeline`
--
ALTER TABLE `tn_member_timeline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `tn_page`
--
ALTER TABLE `tn_page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tn_post`
--
ALTER TABLE `tn_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tn_post_comments`
--
ALTER TABLE `tn_post_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tn_post_file`
--
ALTER TABLE `tn_post_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `tn_post_like`
--
ALTER TABLE `tn_post_like`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tn_post_tag_friend`
--
ALTER TABLE `tn_post_tag_friend`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
