-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 16, 2017 at 07:52 PM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `group17`
--

-- --------------------------------------------------------

CREATE DATABASE IF NOT EXISTS group17 COLLATE utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS group17.Users
(
	user_id INTEGER(10) UNSIGNED NOT NULL,
	first_name VARCHAR(32) NOT NULL,
	last_name VARCHAR(32) NOT NULL,
	email VARCHAR(255) NOT NULL,
	_password VARCHAR(255) NOT NULL,
	date_joined TIMESTAMP NOT NULL,
	major VARCHAR(255) NOT NULL,
	score MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT 0,
	PRIMARY KEY(user_id),
	UNIQUE(email)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE IF NOT EXISTS group17.Tasks
(
	task_id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	user_id INTEGER(10) UNSIGNED NOT NULL,
	task_title VARCHAR(255) NOT NULL,
	task_type VARCHAR(255) NOT NULL,
	description TEXT(500) NOT NULL,
	review_deadline DATE NOT NULL,
	claim_deadline DATE NOT NULL,
	tags VARCHAR(255) DEFAULT NULL,
	doc_title VARCHAR(255) NOT NULL,
	file_format VARCHAR(32) NOT NULL,
	word_length MEDIUMINT(8) UNSIGNED NOT NULL,
	page_length MEDIUMINT(8) UNSIGNED NOT NULL,
	path_to_file VARCHAR(255) NOT NULL,
	PRIMARY KEY(task_id),
	FOREIGN KEY(user_id) REFERENCES Users(user_id),
	UNIQUE (path_to_file)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `claimed_tasks`
--

CREATE TABLE IF NOT EXISTS group17.Claimed_Tasks
(
	task_id INTEGER(10) UNSIGNED NOT NULL,
	claimant INTEGER(10) UNSIGNED NOT NULL,
	time_claimed TIMESTAMP NOT NULL,
	PRIMARY KEY(task_id),
	FOREIGN KEY(claimant) REFERENCES Users(user_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS group17.Tags
(
	tag_id INTEGER(10) UNSIGNED NOT NULL,
	_value VARCHAR(255) NOT NULL,
	PRIMARY KEY(tag_id),
	UNIQUE(_value)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banned`
--

CREATE TABLE IF NOT EXISTS group17.Banned
(
	user_id INTEGER(10) UNSIGNED NOT NULL,
	banned_by INTEGER(10) UNSIGNED NOT NULL,
	date_time TIMESTAMP NOT NULL,
	reason TEXT(500) NOT NULL,
	PRIMARY KEY(user_id),
	FOREIGN KEY(banned_by) REFERENCES Users(user_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `flagged_tasks`
--

CREATE TABLE IF NOT EXISTS group17.Flagged_Tasks
(
	task_id INTEGER(10) UNSIGNED NOT NULL,
	flagged_by INTEGER(10) UNSIGNED NOT NULL,
	date_time TIMESTAMP NOT NULL,
	reason TEXT(500),
	PRIMARY KEY(task_id, flagged_by),
	FOREIGN KEY (flagged_by) REFERENCES Users(user_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS group17.Sessions
(
	user_id INTEGER(10) UNSIGNED NOT NULL,
	date_time TIMESTAMP NOT NULL,
	PRIMARY KEY(user_id),
	FOREIGN KEY(user_id) REFERENCES Users(user_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assigned_tags`
--

CREATE TABLE IF NOT EXISTS group17.Assigned_Tags
(
	user_id INTEGER(10) UNSIGNED NOT NULL,
	tags VARCHAR(255) DEFAULT NULL,
	frequencies VARCHAR(255) DEFAULT NULL,
	PRIMARY KEY(user_id),
	FOREIGN KEY(user_id) REFERENCES Users(user_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `total_sessions`
--

CREATE TABLE IF NOT EXISTS group17.Total_Sessions
(
	user_id INTEGER(10) UNSIGNED NOT NULL,
	date_logged_in TIMESTAMP NOT NULL,
	date_logged_out TIMESTAMP NOT NULL,
	PRIMARY KEY(user_id),
	FOREIGN KEY(user_id) REFERENCES Users(user_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;