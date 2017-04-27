-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2017 at 11:37 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `group17`
--

CREATE DATABASE group17;
USE group17;

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `getTasksByUser` (IN `user_number` INTEGER(10))  BEGIN
	SELECT task_id, task_title, description, review_deadline, claim_deadline FROM tasks WHERE user_id = user_number;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getUserMajor` (IN `calling_user` INTEGER(10) UNSIGNED)  BEGIN 
	SELECT major FROM Users WHERE user_id = calling_user;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getUsersWithSameMajor` (IN `user_major` VARCHAR(255))  BEGIN
	SELECT user_id FROM Users WHERE major = (user_major);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `IncrementLastActive` ()  BEGIN
	UPDATE Sessions
	SET last_active = last_active + 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `logout` ()  BEGIN
	DECLARE ctr INTEGER(10) DEFAULT 0;
	DECLARE id INTEGER(10);
    DECLARE table_size INTEGER(10);
    DECLARE state INTEGER(10);
    SELECT COUNT(*) INTO table_size FROM Sessions;
    SET ctr = 0;
        WHILE ctr < table_size
    DO
    	SELECT user_id INTO id FROM Sessions LIMIT ctr,1;
    	SELECT last_active INTO state FROM Sessions WHERE user_id = id;
		   		IF state >= 2 THEN
    		INSERT INTO total_sessions(user_id, date_logged_in, date_logged_out) VALUES (id, (SELECT date_time FROM Sessions WHERE user_id = id), Now());
        DELETE FROM Sessions WHERE user_id = id;
   		END IF;
                SET ctr = ctr + 1;
    END WHILE;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `logoutUser` ()  BEGIN
	DECLARE id INTEGER(10);
    DECLARE table_size INTEGER(10);
    DECLARE state TIMESTAMP;
    SELECT COUNT(*) INTO table_size FROM Sessions;
    SELECT user_id INTO id FROM Sessions LIMIT table_size,1;
    SELECT last_active INTO state FROM Sessions WHERE user_id = id;
    IF state >= 2 THEN
    	INSERT INTO total_sessions(user_id, date_logged_in, date_logged_out) VALUES (id, (SELECT date_time FROM Sessions WHERE user_id = id), Now());
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `assigned_tags`
--

CREATE TABLE `assigned_tags` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `tags` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `frequencies` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subscribed_tags` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `assigned_tags`
--

INSERT INTO `assigned_tags` (`user_id`, `tags`, `frequencies`, `subscribed_tags`) VALUES
(15164748, '0,10,11,14,17,20,22', '1,1,2,3,4,5,6', '0,1,16,18,23,24');

-- --------------------------------------------------------

--
-- Table structure for table `banned`
--

CREATE TABLE `banned` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `banned_by` int(10) UNSIGNED NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reason` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `banned`
--

INSERT INTO `banned` (`user_id`, `banned_by`, `date_time`, `reason`) VALUES
(15164748, 15123529, '2017-04-15 19:40:23', 'Was a gobshite');

-- --------------------------------------------------------

--
-- Table structure for table `cancelled_tasks`
--

CREATE TABLE `cancelled_tasks` (
  `task_id` int(10) UNSIGNED NOT NULL,
  `cancelled_by` int(10) UNSIGNED NOT NULL,
  `time_cancelled` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cancelled_tasks`
--

INSERT INTO `cancelled_tasks` (`task_id`, `cancelled_by`, `time_cancelled`) VALUES
(6, 15164748, '2017-04-14 17:17:06');

-- --------------------------------------------------------

--
-- Table structure for table `claimed_tasks`
--

CREATE TABLE `claimed_tasks` (
  `task_id` int(10) UNSIGNED NOT NULL,
  `claimant` int(10) UNSIGNED NOT NULL,
  `time_claimed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `claimed_tasks`
--

INSERT INTO `claimed_tasks` (`task_id`, `claimant`, `time_claimed`) VALUES
(1, 15123529, '2017-01-01 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `completed_tasks`
--

CREATE TABLE `completed_tasks` (
  `task_id` int(10) UNSIGNED NOT NULL,
  `claimant` int(10) UNSIGNED NOT NULL,
  `time_completed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `review` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `flagged_tasks`
--

CREATE TABLE `flagged_tasks` (
  `task_id` int(10) UNSIGNED NOT NULL,
  `flagged_by` int(10) UNSIGNED NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reason` text COLLATE utf8_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_active` int(2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`user_id`, `date_time`, `last_active`) VALUES
(15123529, '2017-04-15 21:37:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `tag_id` int(10) UNSIGNED NOT NULL,
  `_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tag_id`, `_value`) VALUES
(0, 'computer'),
(1, 'html'),
(2, 'project-report'),
(3, 'cs4014'),
(4, 'thesis'),
(5, 'dissertation'),
(6, 'essay'),
(7, 'phd'),
(8, 'biology'),
(9, 'chemistry'),
(10, 'physics'),
(11, 'science'),
(12, 'business'),
(13, 'maths'),
(14, 'politics'),
(15, 'sociology'),
(16, 'history'),
(17, 'english'),
(18, 'psychology'),
(19, 'media'),
(20, 'technology'),
(21, 'report'),
(22, 'doctorate'),
(23, 'research'),
(24, 'assignment');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `task_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `task_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `review_deadline` date NOT NULL,
  `claim_deadline` date NOT NULL,
  `tags` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `doc_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `file_format` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `word_length` mediumint(8) UNSIGNED NOT NULL,
  `page_length` mediumint(8) UNSIGNED NOT NULL,
  `path_to_file` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`task_id`, `user_id`, `task_title`, `task_type`, `description`, `review_deadline`, `claim_deadline`, `tags`, `doc_title`, `file_format`, `word_length`, `page_length`, `path_to_file`) VALUES
(2, 15164748, 'Test task 1', 'Thesis', 'This is an obnoxiously long description that is unnecessarily being used to test whether or not the character limit is sufficient. Maybe having more than 40 characters may be a better idea. Hopefully, most people will have good and long descriptions placed here', '2017-06-01', '2017-05-05', '0,1,3,4', 'Test_task', '.pdf', 3000, 5, 'files/docs/test_task.pdf'),
(1, 15164748, 'Test task 2', 'Thesis', 'This is an obnoxiously long description that is unnecessarily being used to test whether or not the character limit is sufficient. Maybe having more than 40 characters may be a better idea. Hopefully, most people will have good and long descriptions placed here.', '2017-06-01', '2017-05-01', '0,1,3,4', 'Test_task2', '.pdf', 3000, 5, 'files/docs/test_task2.pdf'),
(3, 15164748, 'Test task 3', 'Thesis', 'This is an obnoxiously long description that is unnecessarily being used to test whether or not the character limit is sufficient. Maybe having more than 40 characters may be a better idea. Hopefully, most people will have good and long descriptions placed here', '2017-06-01', '2017-05-03', '0,1,3,4', 'Test_task3', '.pdf', 3000, 5, 'files/docs/test_task3.pdf'),
(4, 15164748, 'Test task 4', 'Thesis', 'This is an obnoxiously long description that is unnecessarily being used to test whether or not the character limit is sufficient. Maybe having more than 40 characters may be a better idea. Hopefully, most people will have good and long descriptions placed here', '2017-06-01', '2017-05-02', '0,1,3,4', 'Test_task4', '.pdf', 3000, 5, 'files/docs/test_task4.pdf'),
(5, 15164748, 'Test task 5', 'Thesis', 'This is an obnoxiously long description that is unnecessarily being used to test whether or not the character limit is sufficient. Maybe having more than 40 characters may be a better idea. Hopefully, most people will have good and long descriptions placed here', '2017-06-01', '2017-05-04', '0,1,3,4', 'Test_task5', '.pdf', 3000, 5, 'files/docs/test_task5.pdf'),
(6, 15123529, 'Test task 6', 'Thesis', 'This is an obnoxiously long description that is unnecessarily being used to test whether or not the character limit is sufficient. Maybe having more than 40 characters may be a better idea. Hopefully, most people will have good and long descriptions placed here', '2017-06-01', '2017-05-01', '0,1,3,4', 'Test_task5', '.pdf', 3000, 5, 'files/docs/test_task6.pdf'),
(7, 15123529, 'Test task 7', 'Thesis', 'This is an obnoxiously long description that is unnecessarily being used to test whether or not the character limit is sufficient. Maybe having more than 40 characters may be a better idea. Hopefully, most people will have good and long descriptions placed here', '2017-06-01', '2017-05-01', '0,1,3,4', 'Test_task5', '.pdf', 3000, 5, 'files/docs/test_task7.pdf'),
(8, 15123529, 'Test task 8', 'Thesis', 'This is an obnoxiously long description that is unnecessarily being used to test whether or not the character limit is sufficient. Maybe having more than 40 characters may be a better idea. Hopefully, most people will have good and long descriptions placed here', '2017-06-01', '2017-05-01', '0,1,3,4', 'Test_task5', '.pdf', 3000, 5, 'files/docs/test_task8.pdf'),
(9, 15123529, 'Test task 9', 'Thesis', 'This is an obnoxiously long description that is unnecessarily being used to test whether or not the character limit is sufficient. Maybe having more than 40 characters may be a better idea. Hopefully, most people will have good and long descriptions placed here', '2017-06-01', '2017-05-01', '0,1,3,4', 'Test_task5', '.pdf', 3000, 5, 'files/docs/test_task9.pdf'),
(10, 15123529, 'Test task 10', 'Thesis', 'This is an obnoxiously long description that is unnecessarily being used to test whether or not the character limit is sufficient. Maybe having more than 40 characters may be a better idea. Hopefully, most people will have good and long descriptions placed here', '2017-06-01', '2017-05-01', '0,1,3,4', 'Test_task5', '.pdf', 3000, 5, 'files/docs/test_task10.pdf'),
(11, 15123529, 'Test task 11', 'Thesis', 'This is an obnoxiously long description that is unnecessarily being used to test whether or not the character limit is sufficient. Maybe having more than 40 characters may be a better idea. Hopefully, most people will have good and long descriptions placed here', '2017-06-01', '2017-05-01', '0,1,3,4', 'Test_task5', '.pdf', 3000, 5, 'files/docs/test_task11.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `total_sessions`
--

CREATE TABLE `total_sessions` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `date_logged_in` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_logged_out` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `total_sessions`
--

INSERT INTO `total_sessions` (`user_id`, `date_logged_in`, `date_logged_out`) VALUES
(15164748, '2017-04-14 18:20:00', '2017-04-14 18:20:00'),
(15123529, '2017-04-15 13:37:00', '2017-04-15 13:37:00'),
(15123529, '2017-04-15 13:42:00', '2017-04-15 13:42:00'),
(15164748, '2017-04-15 14:46:00', '2017-04-15 14:46:00'),
(15164748, '2017-04-15 19:12:00', '2017-04-15 19:12:00'),
(15164748, '2017-04-15 19:29:00', '2017-04-15 19:29:00'),
(15123529, '2017-04-15 20:27:00', '2017-04-15 20:27:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `_password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_joined` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `major` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `score` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `activated` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `_password`, `date_joined`, `major`, `score`, `activated`) VALUES
(15157776, 'James', 'Gilatt-Haughton', '15157776@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-01-01 00:00:00', 'Computer Science', 1337, '0'),
(15184234, 'Steven', 'Fitzgerald', '15184234@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-01-01 00:00:00', 'Computer Science', 1000, '0'),
(15164748, 'Artem', 'Semenov', '15164748@studentmail.ul.ie', '$2y$10$Kl4RRM/hmYGcat/aiki6w.i.g9YAa/kEyKMUby17gvmwjDbH0KeTO', '2017-01-01 00:00:00', 'Computer Science', 1000, '0'),
(15111111, 'John', 'Doe', '15111111@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-01-01 15:23:11', 'Accounting & Finance', 0, '0'),
(15111112, 'Sean', 'McSweeney', '15111112@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-01-02 12:23:11', 'History', 0, '0'),
(15111113, 'Jane', 'Rielly', '15111113@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-01-02 12:23:11', 'Accounting & Finance', 0, '0'),
(15111114, 'Mark', 'Brown', '15111114@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-01-05 18:55:59', 'Financial Mathematics', 0, '0'),
(15111115, 'Rick', 'Ross', '15111115@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-01-08 16:20:00', 'Sociology', 0, '0'),
(14111111, 'Bill', 'Joe', '14111111@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-01-11 16:20:00', 'Biology', 0, '0'),
(14111112, 'Steve', 'McGrath', '14111112@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-01-15 21:59:59', 'Civil Engineering', 0, '0'),
(14111113, 'Oliver', 'Twist', '14111113@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-01-15 03:11:01', 'Electrical and Computer Engineering', 0, '0'),
(14111114, 'Sarah', 'Walsh', '14111114@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-01-18 08:00:00', 'Microbiology', 0, '0'),
(14111115, 'Jessica', 'Walsh', '14111115@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-01-21 20:20:20', 'Sociology', 0, '0'),
(13111111, 'Sean', 'O''Mahony', '13111111@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-01-20 16:54:36', 'Computer Science', 0, '0'),
(13111112, 'Timothy', 'James', '13111112@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-01-13 06:11:12', 'Civil Engineering', 0, '0'),
(12111111, 'Bob', 'Ronson', '12111111@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-01-25 01:23:45', 'Civil Engineering', 0, '0'),
(11111111, 'Francois', 'Hollonde', '11111111@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-02-01 16:20:00', 'Chemistry', 0, '0'),
(10111111, 'Michael', 'Moore', '10111111@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-02-02 15:35:00', 'Electrical and Computer Engineering', 0, '0'),
(10111112, 'Jane', 'Fitzgerald', '10111112@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-02-05 10:10:10', 'Sociology', 0, '0'),
(16111111, 'Amy', 'Mahon', '16111111@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-02-06 11:11:11', 'Financial Mathematics', 0, '0'),
(22222222, 'Paul', 'Blart', 'paul.blart@ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-02-07 12:12:12', 'Microbiology', 0, '0'),
(33333333, 'John', 'Snow', 'john.snow@ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-02-11 16:20:00', 'Electrical and Computer Engineering', 0, '0'),
(16111112, 'Mary', 'Wall', '16111112@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-02-13 15:15:00', 'Microbiology', 0, '0'),
(16111113, 'Sue', 'Hill', '16111113@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-02-14 03:45:01', 'Biology', 0, '0'),
(15123529, 'Brian', 'Dooley', '15123529@studentmail.ul.ie', '$2y$10$oZKRBWom2OEGXZbIu2PLvubSaD4ZI6Kbo50yubOUcfwNNBqMuO1Ta', '2017-04-15 21:29:56', 'Computer Science', 0, '1'),
(10000000, 'abcdefghijkl', 'abcdefghijkl', '10000000@studentmail.ul.fuck.yoursel', '$2y$10$20G1xgBu87U3GqY3zYTp2.UUHR5qvWo0tvl1YzlKGRU.36rXGOkKC', '2017-04-07 16:24:41', 'Financial Maths', 0, '0'),
(555666777, 'alan', 'flynn', '555666777@ul.ie', '$2y$10$AvJbimZ/g5ao/yZHInMQR.i4y19X2cT9BGxfjifhOkpHfpvs0b1aK', '2017-04-15 17:18:43', 'History', 0, '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assigned_tags`
--
ALTER TABLE `assigned_tags`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `banned`
--
ALTER TABLE `banned`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `banned_by` (`banned_by`);

--
-- Indexes for table `cancelled_tasks`
--
ALTER TABLE `cancelled_tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `claimant` (`cancelled_by`);

--
-- Indexes for table `claimed_tasks`
--
ALTER TABLE `claimed_tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `claimant` (`claimant`);

--
-- Indexes for table `completed_tasks`
--
ALTER TABLE `completed_tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `claimant` (`claimant`);

--
-- Indexes for table `flagged_tasks`
--
ALTER TABLE `flagged_tasks`
  ADD PRIMARY KEY (`task_id`,`flagged_by`),
  ADD KEY `flagged_by` (`flagged_by`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tag_id`),
  ADD UNIQUE KEY `_value` (`_value`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD UNIQUE KEY `path_to_file` (`path_to_file`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `total_sessions`
--
ALTER TABLE `total_sessions`
  ADD PRIMARY KEY (`user_id`,`date_logged_in`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `Increment_last_active` ON SCHEDULE EVERY 1 MINUTE STARTS '2017-01-01 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
	CALL incrementLastActive();
END$$

CREATE DEFINER=`root`@`localhost` EVENT `Logout_user` ON SCHEDULE EVERY 1 MINUTE STARTS '2017-01-01 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
	CALL logout();
END$$

DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
