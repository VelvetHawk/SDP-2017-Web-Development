CREATE DATABASE IF NOT EXISTS group17 COLLATE utf8_unicode_ci;

-- --------------------------------------------------------

USE group17;

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
	score MEDIUMINT(8) NOT NULL DEFAULT 0,
	-- secretQuestion VARCHAR(255) NOT NULL,
	-- secretAnswer VARCHAR(255) NOT NULL,
	activated ENUM('0', '1') NOT NULL DEFAULT '0',
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
	rated ENUM('true', 'false') NOT NULL DEFAULT 'false',
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
-- Table structure for table `completed_tasks`
--

CREATE TABLE IF NOT EXISTS group17.Completed_Tasks
(
	task_id INTEGER(10) UNSIGNED NOT NULL,
	claimant INTEGER(10) UNSIGNED NOT NULL,
	time_completed TIMESTAMP NOT NULL,
	review TEXT(1000) NOT NULL,
	PRIMARY KEY(task_id),
	FOREIGN KEY(claimant) REFERENCES Users(user_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cancelled_tasks`
--

CREATE TABLE IF NOT EXISTS group17.Cancelled_Tasks
(
	task_id INTEGER(10) UNSIGNED NOT NULL,
	cancelled_by INTEGER(10) UNSIGNED NOT NULL,
	time_cancelled TIMESTAMP NOT NULL,
	PRIMARY KEY(task_id),
	FOREIGN KEY(cancelled_by) REFERENCES Users(user_id),
	FOREIGN KEY(task_id) REFERENCES Tasks(task_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expired_tasks`
--

CREATE TABLE IF NOT EXISTS group17.Expired_Tasks
(
	task_id INTEGER(10) UNSIGNED NOT NULL,
	date_expired TIMESTAMP NOT NULL,
	PRIMARY KEY(task_id),
	FOREIGN KEY(task_id) REFERENCES Tasks(task_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS group17.Tags
(
	tag_id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
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
	last_active INTEGER(2),
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
	subscribed_tags VARCHAR(255) DEFAULT NULL,
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
	PRIMARY KEY(user_id, date_logged_in),
	FOREIGN KEY(user_id) REFERENCES Users(user_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

-- POPULATE DATABASE

-- --------------------------------------------------------

-- This is to create our 3 admin accounts

-- James
INSERT INTO group17.Users (user_id, first_name, last_name, email, _password, date_joined, major, score, activated)
VALUES (15157776, 'James', 'Gilatt-Haughton', '15157776@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-01-01 00:00:00', 'Computer Science', 1337, "1");

-- Artem
INSERT INTO group17.Users (user_id, first_name, last_name, email, _password, date_joined, major, score, activated)
VALUES (15164748, 'Artem', 'Semenov', '15164748@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-01-01 00:00:00', 'Computer Science', 1000, "1");

-- Brian
INSERT INTO group17.Users (user_id, first_name, last_name, email, _password, date_joined, major, score, activated)
VALUES (15123529, 'Brian', 'Dooley', '15123529@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-01-01 00:00:00', 'Computer Science', 1000, "1");

-- ********** END OF MODS **********

-- ********** GENERAL USERS **********

-- User 0
INSERT INTO group17.Users (user_id, first_name, last_name, email, _password, date_joined, major, score, activated)
VALUES (0, 'Auto', 'Bot', '0@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-01-01 00:00:00', 'NaN', 1000, "1");

-- User 1
INSERT INTO group17.Users (user_id, first_name, last_name, email, _password, date_joined, major, score, activated)
VALUES (15111111, 'John', 'Doe', '15111111@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-01-01 15:23:11', 'Accounting & Finance', 0, "1");

-- User 2
INSERT INTO group17.Users (user_id, first_name, last_name, email, _password, date_joined, major, score, activated)
VALUES (15111112, 'Sean', 'McSweeney', '15111112@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-01-02 12:23:11', 'History', 0, "1");

-- User 3
INSERT INTO group17.Users (user_id, first_name, last_name, email, _password, date_joined, major, score, activated)
VALUES (15111113, 'Jane', 'Rielly', '15111113@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-01-02 12:23:11', 'Accounting & Finance', 0, "1");

-- User 4
INSERT INTO group17.Users (user_id, first_name, last_name, email, _password, date_joined, major, score, activated)
VALUES (15111114, 'Mark', 'Brown', '15111114@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-01-05 18:55:59', 'Financial Mathematics', 0, "1");

-- User 5
INSERT INTO group17.Users (user_id, first_name, last_name, email, _password, date_joined, major, score, activated)
VALUES (15111115, 'Rick', 'Ross', '15111115@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-01-08 16:20:00', 'Sociology', 0, "1");

-- User 6
INSERT INTO group17.Users (user_id, first_name, last_name, email, _password, date_joined, major, score, activated)
VALUES (15111116, 'Bill', 'Joe', '15111116@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-01-11 16:20:00', 'Biology', 0, "1");

-- User 7
INSERT INTO group17.Users (user_id, first_name, last_name, email, _password, date_joined, major, score, activated)
VALUES (15111117, 'Steve', 'McGrath', '15111117@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-01-15 21:59:59', 'Civil Engineering', 0, "1");

-- User 8
INSERT INTO group17.Users (user_id, first_name, last_name, email, _password, date_joined, major, score, activated)
VALUES (15111118, 'Oliver', 'Twist', '15111118@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-01-15 03:11:01', 'Electrical and Computer Engineering', 0, "1");

-- User 9
INSERT INTO group17.Users (user_id, first_name, last_name, email, _password, date_joined, major, score, activated)
VALUES (15111119, 'Sarah', 'Walsh', '15111119@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-01-18 08:00:00', 'Microbiology', 0, "1");

-- User 10
INSERT INTO group17.Users (user_id, first_name, last_name, email, _password, date_joined, major, score, activated)
VALUES (15111120, 'Jessica', 'Walsh', '15111120@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-01-21 20:20:20', 'Sociology', 0, "1");

-- User 11
INSERT INTO group17.Users (user_id, first_name, last_name, email, _password, date_joined, major, score, activated)
VALUES (15111121, 'Sean', 'O''Mahony', '15111121@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-01-20 16:54:36', 'Computer Science', 0, "1");

-- User 12
INSERT INTO group17.Users (user_id, first_name, last_name, email, _password, date_joined, major, score, activated)
VALUES (15111122, 'Timothy', 'James', '15111122@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-01-13 06:11:12', 'Civil Engineering', 0, "1");

-- User 13
INSERT INTO group17.Users (user_id, first_name, last_name, email, _password, date_joined, major, score, activated)
VALUES (15111123, 'Bob', 'Ronson', '15111123@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-01-25 01:23:45', 'Civil Engineering', 0, "1");

-- User 14
INSERT INTO group17.Users (user_id, first_name, last_name, email, _password, date_joined, major, score, activated)
VALUES (15111124, 'Francois', 'Hollonde', '15111124@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-02-01 16:20:00', 'Chemistry', 0, "1");

-- User 15
INSERT INTO group17.Users (user_id, first_name, last_name, email, _password, date_joined, major, score, activated)
VALUES (15111125, 'Michael', 'Moore', '15111125@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-02-02 15:35:00', 'Electrical and Computer Engineering', 0, "1");

-- User 16
INSERT INTO group17.Users (user_id, first_name, last_name, email, _password, date_joined, major, score, activated)
VALUES (15111126, 'Jane', 'Fitzgerald', '15111126@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-02-05 10:10:10', 'Sociology', 0, "1");

-- User 17
INSERT INTO group17.Users (user_id, first_name, last_name, email, _password, date_joined, major, score, activated)
VALUES (15111127, 'Amy', 'Mahon', '15111127@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-02-06 11:11:11', 'Financial Mathematics', 0, "1");

-- User 18
INSERT INTO group17.Users (user_id, first_name, last_name, email, _password, date_joined, major, score, activated)
VALUES (15111128, 'Paul', 'Blart', 'paul.blart@ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-02-07 12:12:12', 'Microbiology', 0, "1");

-- User 19
INSERT INTO group17.Users (user_id, first_name, last_name, email, _password, date_joined, major, score, activated)
VALUES (15111129, 'John', 'Snow', 'john.snow@ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-02-11 16:20:00', 'Electrical and Computer Engineering', 0, "1");

-- User 20
INSERT INTO group17.Users (user_id, first_name, last_name, email, _password, date_joined, major, score, activated)
VALUES (15111130, 'Mary', 'Wall', '15111130@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-02-13 15:15:00', 'Microbiology', 0, "1");

-- User 21
INSERT INTO group17.Users (user_id, first_name, last_name, email, _password, date_joined, major, score, activated)
VALUES (15111131, 'Sue', 'Hill', '15111131@studentmail.ul.ie', '$2y$10$64j9Jb0RA8vVj2zb5D1u1urJapCRxMf0Yk6S6MElBCf3hLhxggR6S', '2017-02-14 03:45:01', 'Biology', 0, "1");

-- END OF GENERAL USERS

-- --------------------------------------------------------

-- ********** TAGS ********** 

-- Tag 1
INSERT INTO group17.Tags (tag_id, _value)
VALUES (1, 'computer');

-- Tag 2
INSERT INTO group17.Tags (_value)
VALUES ('html');

-- Tag 3
INSERT INTO group17.Tags (_value)
VALUES ('project-report');

-- Tag 4
INSERT INTO group17.Tags (_value)
VALUES ('cs4014');

-- Tag 5
INSERT INTO group17.Tags (_value)
VALUES ('thesis');

-- Tag 6
INSERT INTO group17.Tags (_value)
VALUES ('dissertation');

-- Tag 7
INSERT INTO group17.Tags (_value)
VALUES ('essay');

-- Tag 8
INSERT INTO group17.Tags (_value)
VALUES ('phd');

-- Tag 9
INSERT INTO group17.Tags (_value)
VALUES ('biology');

-- Tag 10
INSERT INTO group17.Tags (_value)
VALUES ('chemistry');

-- Tag 11
INSERT INTO group17.Tags (_value)
VALUES ('physics');

-- Tag 12
INSERT INTO group17.Tags (_value)
VALUES ('science');

-- Tag 13
INSERT INTO group17.Tags (_value)
VALUES ('business');

-- Tag 14
INSERT INTO group17.Tags (_value)
VALUES ('maths');

-- Tag 15
INSERT INTO group17.Tags (_value)
VALUES ('politics');

-- Tag 16
INSERT INTO group17.Tags (_value)
VALUES ('sociology');

-- Tag 17
INSERT INTO group17.Tags (_value)
VALUES ('history');

-- Tag 18
INSERT INTO group17.Tags (_value)
VALUES ('english');

-- Tag 19
INSERT INTO group17.Tags (_value)
VALUES ('psychology');

-- Tag 20
INSERT INTO group17.Tags (_value)
VALUES ('media');

-- Tag 21
INSERT INTO group17.Tags (_value)
VALUES ('technology');

-- Tag 22
INSERT INTO group17.Tags (_value)
VALUES ('report');

-- Tag 23
INSERT INTO group17.Tags (_value)
VALUES ('doctorate');

-- Tag 24
INSERT INTO group17.Tags (_value)
VALUES ('research');

-- Tag 25
INSERT INTO group17.Tags (_value)
VALUES ('assignment');

-- ********** END OF TAGS ********** 

-- ********** TASKS ********** 

-- Task 1
INSERT INTO group17.Tasks (task_id, user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (1, 15111115, 'Test task 1', 'Thesis', 'This document is really boring and needs proofreading because I really cant spell and my grammar is appalling. Coincidently this description would be ideal to showcase the functionality of a proofreading website. I sure hope nobody takes this description to show that task descriptions display correctly from a database.', '2017-06-02 00:00:00', '2017-05-03 00:00:00', '7,1,3,5', 'Test_task1', '.pdf', 3000, 5, 'files/docs/test_task1.pdf', 'false');

-- Task 2
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111118, 'Test task 2', 'Thesis', 'This document is really important and needs proofreading ASAP. It is for my FYP and it is due in two weeks. I wrote all of this last night in a redbull fueled frenzy. As a result it is littered with errors and typos. I hope this description is sufficient.', '2017-06-04 00:00:00', '2017-05-05 00:00:00', '7,9,11,13', 'Test_task2', '.pdf', 3000, 3, 'files/docs/test_task2.pdf', 'false');

-- Task 3
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111123, 'Test task 3', 'Thesis', 'This is for a end of year project, the deadline is in a fortnight. Here''s the problem I haven''t attended a single lecture all semester and my knowledge on the stuff in this paper is... none existant so perhaps you could add a tiny bit while correcting it, if you know what I mean.', '2017-06-06 00:00:00', '2017-05-07 00:00:00', '15,17,19,21', 'Test_task3', '.pdf', 3000, 7, 'files/docs/test_task3.pdf', 'false');

-- Task 4
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111127, 'Test task 4', 'Thesis', 'This paper isn''t mine it''s actually my girlfriends, She''s studying psychology and I may have dug myself into a bit of trouble by saying I had a masters in Psychology when in reality I have an arts degree. Could you do me a favor and proofread this so I can pretend it was me and score some brownie points? Thanks in advance.', '2017-06-05 00:00:00', '2017-05-06 00:00:00', '23,25,2,4', 'Test_task4', '.pdf', 3000, 5, 'files/docs/test_task4.pdf', 'false');

-- Task 5
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111111, 'Test task 5', 'Thesis', 'My paper is about galaxies and I think you should read this brief description of a galaxy before you continue. A galaxy is a gravitationally bound system of stars, stellar remnants, interstellar gas, dust, and dark matter. The word galaxy is derived from the Greek galaxias, literally "milky", a reference to the Milky Way. Galaxies range in size from dwarfs with just a few billion (109) stars to giants with one hundred trillion (1014) stars, each orbiting its galaxy''s center of mass. Galaxies are categorized according to their visual morphology as elliptical, spiral and irregular. Many galaxies are thought to have black holes at their active centers. The Milky Way''s central black hole, known as Sagittarius A*, has a mass four million times greater than the Sun. As of March 2016, GN-z11 is the oldest and most distant observed galaxy with a comoving distance of 32 billion light-years from Earth, and observed as it existed just 400 million years after the Big Bang. Recent estimates of the number of galaxies in the observable universe range from 200 billion (2×1011) to 2 trillion (2×1012) or more, containing more stars than all the grains of sand on planet Earth. Most of the galaxies are 1,000 to 100,000 parsecs in diameter and separated by distances on the order of millions of parsecs (or megaparsecs). The space between galaxies is filled with a tenuous gas having an average density of less than one atom per cubic meter. The majority of galaxies are gravitationally organized into groups, clusters, and superclusters. At the largest scale, these associations are generally arranged into sheets and filaments surrounded by immense voids. The largest structure of galaxies yet recognised is a cluster of superclusters, that has been named Laniakea. Thank you for reading about galaxies. I lied about the galaxies. Please now continue to proofread my work on kangaroos.', '2017-06-02 00:00:00', '2017-05-03 00:00:00', '6,8,10,12', 'Test_task5', '.pdf', 3000, 4, 'files/docs/test_task5.pdf', 'false');

-- Task 6
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111122, 'Test task 6', 'Thesis', 'This document is my final year project in rocket science. Rocket science being such an incredibally difficult subject limits this task to only the brightest and most talented of individuals. Not that you will find any faults with my flawless work. I think you will be pleasently surprised at the skill and accuracy shown in my work.', '2017-06-01 00:00:00', '2017-05-02 00:00:00', '14,16,18,20', 'Test_task6', '.pdf', 3000, 3, 'files/docs/test_task6.pdf', 'false');

-- Task 7
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111131, 'Test task 7', 'Thesis', 'This description is going to be short and brief. Like just long enough to meet the requirements. Read my paper', '2017-06-04 00:00:00', '2017-05-05 00:00:00', '22,24,3,1', 'Test_task7', '.pdf', 3000, 5, 'files/docs/test_task7.pdf', 'false');

-- Task 8
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111116, 'Test task 8', 'Thesis', 'This document is really boring and needs proofreading because I really cant spell and my grammar is appalling. Coincidently this description would be ideal to showcase the functionality of a proofreading website. I sure hope nobody takes this description to show that task descriptions display correctly from a database.', '2017-06-06 00:00:00', '2017-05-07 00:00:00', '3,5,7,11', 'Test_task8', '.pdf', 3000, 4, 'files/docs/test_task8.pdf', 'false');

-- Task 9
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111121, 'Test task 9', 'Thesis', 'This document is really important and needs proofreading ASAP. It is for my FYP and it is due in two weeks. I wrote all of this last night in a redbull fueled frenzy. As a result it is littered with errors and typos. I hope this description is sufficient.', '2017-06-04 00:00:00', '2017-05-05 00:00:00', '13,15,17,19', 'Test_task9', '.pdf', 3000, 6, 'files/docs/test_task9.pdf', 'false');

-- Task 10
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111128, 'Test task 10', 'Thesis', 'This is for a end of year project, the deadline is in a fortnight. Here''s the problem I haven''t attended a single lecture all semester and my knowledge on the stuff in this paper is... none existant so perhaps you could add a tiny bit while correcting it, if you know what I mean.', '2017-06-01 00:00:00', '2017-05-02 00:00:00', '21,23,25,2', 'Test_task10', '.pdf', 3000, 3, 'files/docs/test_task10.pdf', 'false');

-- Task 11
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111114, 'Test task 11', 'Thesis', 'This paper isn''t mine it''s actually my girlfriends, She''s studying psychology and I may have dug myself into a bit of trouble by saying I had a masters in Psychology when in reality I have an arts degree. Could you do me a favor and proofread this so I can pretend it was me and score some brownie points? Thanks in advance.', '2017-06-02 00:00:00', '2017-05-03 00:00:00', '4,6,8,10', 'Test_task11', '.pdf', 3000, 5, 'files/docs/test_task11.pdf', 'false');

-- Task 12
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111126, 'Test task 12', 'Thesis', 'My paper is about galaxies and I think you should read this brief description of a galaxy before you continue. A galaxy is a gravitationally bound system of stars, stellar remnants, interstellar gas, dust, and dark matter. The word galaxy is derived from the Greek galaxias, literally "milky", a reference to the Milky Way. Galaxies range in size from dwarfs with just a few billion (109) stars to giants with one hundred trillion (1014) stars, each orbiting its galaxy''s center of mass. Galaxies are categorized according to their visual morphology as elliptical, spiral and irregular. Many galaxies are thought to have black holes at their active centers. The Milky Way''s central black hole, known as Sagittarius A*, has a mass four million times greater than the Sun. As of March 2016, GN-z11 is the oldest and most distant observed galaxy with a comoving distance of 32 billion light-years from Earth, and observed as it existed just 400 million years after the Big Bang. Recent estimates of the number of galaxies in the observable universe range from 200 billion (2×1011) to 2 trillion (2×1012) or more, containing more stars than all the grains of sand on planet Earth. Most of the galaxies are 1,000 to 100,000 parsecs in diameter and separated by distances on the order of millions of parsecs (or megaparsecs). The space between galaxies is filled with a tenuous gas having an average density of less than one atom per cubic meter. The majority of galaxies are gravitationally organized into groups, clusters, and superclusters. At the largest scale, these associations are generally arranged into sheets and filaments surrounded by immense voids. The largest structure of galaxies yet recognised is a cluster of superclusters, that has been named Laniakea. Thank you for reading about galaxies. I lied about the galaxies. Please now continue to proofread my work on kangaroos.', '2017-06-05 00:00:00', '2017-05-06 00:00:00', '12,14,16,18', 'Test_task12', '.pdf', 3000, 8, 'files/docs/test_task12.pdf', 'false');

-- Task 13
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111119, 'Test task 13', 'Thesis', 'This document is my final year project in rocket science. Rocket science being such an incredibally difficult subject limits this task to only the brightest and most talented of individuals. Not that you will find any faults with my flawless work. I think you will be pleasently surprised at the skill and accuracy shown in my work.', '2017-06-06 00:00:00', '2017-05-07 00:00:00', '20,22,24,7', 'Test_task13', '.pdf', 3000, 3, 'files/docs/test_task13.pdf', 'false');

-- Task 14
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111130, 'Test task 14', 'Thesis', 'This description is going to be short and brief. Like just long enough to meet the requirements. Read my paper', '2017-06-02 00:00:00', '2017-05-03 00:00:00', '1,3,5,7', 'Test_task14', '.pdf', 3000, 6, 'files/docs/test_task14.pdf', 'false');

-- Task 15
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111117, 'Test task 15', 'Thesis', 'This document is really boring and needs proofreading because I really cant spell and my grammar is appalling. Coincidently this description would be ideal to showcase the functionality of a proofreading website. I sure hope nobody takes this description to show that task descriptions display correctly from a database.', '2017-06-04 00:00:00', '2017-05-05 00:00:00', '11,13,15,17', 'Test_task15', '.pdf', 3000, 4, 'files/docs/test_task15.pdf', 'false');

-- Task 16
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111125, 'Test task 16', 'Thesis', 'This document is really important and needs proofreading ASAP. It is for my FYP and it is due in two weeks. I wrote all of this last night in a redbull fueled frenzy. As a result it is littered with errors and typos. I hope this description is sufficient.', '2017-06-03 00:00:00', '2017-05-04 00:00:00', '19,21,23,25', 'Test_task16', '.pdf', 3000, 5, 'files/docs/test_task16.pdf', 'false');

-- Task 17
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111112, 'Test task 17', 'Thesis', 'This is for a end of year project, the deadline is in a fortnight. Here''s the problem I haven''t attended a single lecture all semester and my knowledge on the stuff in this paper is... none existant so perhaps you could add a tiny bit while correcting it, if you know what I mean.', '2017-06-08 00:00:00', '2017-05-09 00:00:00', '2,4,6,8', 'Test_task17', '.pdf', 3000, 2, 'files/docs/test_task17.pdf', 'false');

-- Task 18
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111129, 'Test task 18', 'Thesis', 'This paper isn''t mine it''s actually my girlfriends, She''s studying psychology and I may have dug myself into a bit of trouble by saying I had a masters in Psychology when in reality I have an arts degree. Could you do me a favor and proofread this so I can pretend it was me and score some brownie points? Thanks in advance.', '2017-06-06 00:00:00', '2017-05-07 00:00:00', '10,12,14,16', 'Test_task18', '.pdf', 3000, 8, 'files/docs/test_task18.pdf', 'false');

-- Task 19
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111113, 'Test task 19', 'Thesis', 'My paper is about galaxies and I think you should read this brief description of a galaxy before you continue. A galaxy is a gravitationally bound system of stars, stellar remnants, interstellar gas, dust, and dark matter. The word galaxy is derived from the Greek galaxias, literally "milky", a reference to the Milky Way. Galaxies range in size from dwarfs with just a few billion (109) stars to giants with one hundred trillion (1014) stars, each orbiting its galaxy''s center of mass. Galaxies are categorized according to their visual morphology as elliptical, spiral and irregular. Many galaxies are thought to have black holes at their active centers. The Milky Way''s central black hole, known as Sagittarius A*, has a mass four million times greater than the Sun. As of March 2016, GN-z11 is the oldest and most distant observed galaxy with a comoving distance of 32 billion light-years from Earth, and observed as it existed just 400 million years after the Big Bang. Recent estimates of the number of galaxies in the observable universe range from 200 billion (2×1011) to 2 trillion (2×1012) or more, containing more stars than all the grains of sand on planet Earth. Most of the galaxies are 1,000 to 100,000 parsecs in diameter and separated by distances on the order of millions of parsecs (or megaparsecs). The space between galaxies is filled with a tenuous gas having an average density of less than one atom per cubic meter. The majority of galaxies are gravitationally organized into groups, clusters, and superclusters. At the largest scale, these associations are generally arranged into sheets and filaments surrounded by immense voids. The largest structure of galaxies yet recognised is a cluster of superclusters, that has been named Laniakea. Thank you for reading about galaxies. I lied about the galaxies. Please now continue to proofread my work on kangaroos.', '2017-06-03 00:00:00', '2017-05-04 00:00:00', '18,20,22,24', 'Test_task19', '.pdf', 3000, 7, 'files/docs/test_task19.pdf', 'false');

-- Task 20
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111124, 'Test task 20', 'Thesis', 'This document is my final year project in rocket science. Rocket science being such an incredibally difficult subject limits this task to only the brightest and most talented of individuals. Not that you will find any faults with my flawless work. I think you will be pleasently surprised at the skill and accuracy shown in my work.', '2017-06-04 00:00:00', '2017-05-05 00:00:00', '7,1,3,5', 'Test_task20', '.pdf', 3000, 9, 'files/docs/test_task20.pdf', 'false');

-- Task 21
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111120, 'Test task 21', 'Thesis', 'This description is going to be short and brief. Like just long enough to meet the requirements. Read my paper', '2017-06-02 00:00:00', '2017-05-03 00:00:00', '7,11,13,15', 'Test_task21', '.pdf', 3000, 5, 'files/docs/test_task21.pdf', 'false');

-- Task 22
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111115, 'Test task 22', 'Thesis', 'This document is really boring and needs proofreading because I really cant spell and my grammar is appalling. Coincidently this description would be ideal to showcase the functionality of a proofreading website. I sure hope nobody takes this description to show that task descriptions display correctly from a database.', '2017-06-01 00:00:00', '2017-05-02 00:00:00', '17,19,21,23', 'Test_task22', '.pdf', 3000, 3, 'files/docs/test_task22.pdf', 'false');

-- Task 23
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111118, 'Test task 23', 'Thesis', 'This document is really important and needs proofreading ASAP. It is for my FYP and it is due in two weeks. I wrote all of this last night in a redbull fueled frenzy. As a result it is littered with errors and typos. I hope this description is sufficient.', '2017-06-06 00:00:00', '2017-05-07 00:00:00', '25,2,4,6', 'Test_task23', '.pdf', 3000, 6, 'files/docs/test_task23.pdf', 'false');

-- Task 24
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111123, 'Test task 24', 'Thesis', 'This is for a end of year project, the deadline is in a fortnight. Here''s the problem I haven''t attended a single lecture all semester and my knowledge on the stuff in this paper is... none existant so perhaps you could add a tiny bit while correcting it, if you know what I mean.', '2017-06-04 00:00:00', '2017-05-05 00:00:00', '8,10,12,14', 'Test_task24', '.pdf', 3000, 7, 'files/docs/test_task24.pdf', 'false');

-- Task 25
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111127, 'Test task 25', 'Thesis', 'This paper isn''t mine it''s actually my girlfriends, She''s studying psychology and I may have dug myself into a bit of trouble by saying I had a masters in Psychology when in reality I have an arts degree. Could you do me a favor and proofread this so I can pretend it was me and score some brownie points? Thanks in advance.', '2017-06-08 00:00:00', '2017-05-09 00:00:00', '16,18,20,22', 'Test_task25', '.pdf', 3000, 9, 'files/docs/test_task25.pdf', 'false');

-- Task 26
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111111, 'Test task 26', 'Thesis', 'My paper is about galaxies and I think you should read this brief description of a galaxy before you continue. A galaxy is a gravitationally bound system of stars, stellar remnants, interstellar gas, dust, and dark matter. The word galaxy is derived from the Greek galaxias, literally "milky", a reference to the Milky Way. Galaxies range in size from dwarfs with just a few billion (109) stars to giants with one hundred trillion (1014) stars, each orbiting its galaxy''s center of mass. Galaxies are categorized according to their visual morphology as elliptical, spiral and irregular. Many galaxies are thought to have black holes at their active centers. The Milky Way''s central black hole, known as Sagittarius A*, has a mass four million times greater than the Sun. As of March 2016, GN-z11 is the oldest and most distant observed galaxy with a comoving distance of 32 billion light-years from Earth, and observed as it existed just 400 million years after the Big Bang. Recent estimates of the number of galaxies in the observable universe range from 200 billion (2×1011) to 2 trillion (2×1012) or more, containing more stars than all the grains of sand on planet Earth. Most of the galaxies are 1,000 to 100,000 parsecs in diameter and separated by distances on the order of millions of parsecs (or megaparsecs). The space between galaxies is filled with a tenuous gas having an average density of less than one atom per cubic meter. The majority of galaxies are gravitationally organized into groups, clusters, and superclusters. At the largest scale, these associations are generally arranged into sheets and filaments surrounded by immense voids. The largest structure of galaxies yet recognised is a cluster of superclusters, that has been named Laniakea. Thank you for reading about galaxies. I lied about the galaxies. Please now continue to proofread my work on kangaroos.', '2017-06-01 00:00:00', '2017-05-02 00:00:00', '24,7,1,3', 'Test_task26', '.pdf', 3000, 5, 'files/docs/test_task26.pdf', 'false');

-- Task 27
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111122, 'Test task 27', 'Thesis', 'This document is my final year project in rocket science. Rocket science being such an incredibally difficult subject limits this task to only the brightest and most talented of individuals. Not that you will find any faults with my flawless work. I think you will be pleasently surprised at the skill and accuracy shown in my work.', '2017-06-04 00:00:00', '2017-05-05 00:00:00', '5,7,11,13', 'Test_task27', '.pdf', 3000, 2, 'files/docs/test_task27.pdf', 'false');

-- Task 28
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111131, 'Test task 28', 'Thesis', 'This description is going to be short and brief. Like just long enough to meet the requirements. Read my paper', '2017-06-07 00:00:00', '2017-05-08 00:00:00', '15,17,19,21', 'Test_task28', '.pdf', 3000, 6, 'files/docs/test_task28.pdf', 'false');

-- Task 29
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111116, 'Test task 29', 'Thesis', 'This document is really boring and needs proofreading because I really cant spell and my grammar is appalling. Coincidently this description would be ideal to showcase the functionality of a proofreading website. I sure hope nobody takes this description to show that task descriptions display correctly from a database.', '2017-06-06 00:00:00', '2017-05-07 00:00:00', '23,25,2,4', 'Test_task29', '.pdf', 3000, 3, 'files/docs/test_task29.pdf', 'false');

-- Task 30
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111121, 'Test task 30', 'Thesis', 'This document is really important and needs proofreading ASAP. It is for my FYP and it is due in two weeks. I wrote all of this last night in a redbull fueled frenzy. As a result it is littered with errors and typos. I hope this description is sufficient.', '2017-06-02 00:00:00', '2017-05-03 00:00:00', '6,8,10,12', 'Test_task30', '.pdf', 3000, 7, 'files/docs/test_task30.pdf', 'false');

-- Task 31
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111128, 'Test task 31', 'Thesis', 'This is for a end of year project, the deadline is in a fortnight. Here''s the problem I haven''t attended a single lecture all semester and my knowledge on the stuff in this paper is... none existant so perhaps you could add a tiny bit while correcting it, if you know what I mean.', '2017-06-05 00:00:00', '2017-05-06 00:00:00', '14,16,18,20', 'Test_task31', '.pdf', 3000, 5, 'files/docs/test_task31.pdf', 'false');

-- Task 32
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111114, 'Test task 32', 'Thesis', 'This paper isn''t mine it''s actually my girlfriends, She''s studying psychology and I may have dug myself into a bit of trouble by saying I had a masters in Psychology when in reality I have an arts degree. Could you do me a favor and proofread this so I can pretend it was me and score some brownie points? Thanks in advance.', '2017-06-06 00:00:00', '2017-05-07 00:00:00', '22,24,7,1', 'Test_task32', '.pdf', 3000, 3, 'files/docs/test_task32.pdf', 'false');

-- Task 33
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111126, 'Test task 33', 'Thesis', 'My paper is about galaxies and I think you should read this brief description of a galaxy before you continue. A galaxy is a gravitationally bound system of stars, stellar remnants, interstellar gas, dust, and dark matter. The word galaxy is derived from the Greek galaxias, literally "milky", a reference to the Milky Way. Galaxies range in size from dwarfs with just a few billion (109) stars to giants with one hundred trillion (1014) stars, each orbiting its galaxy''s center of mass. Galaxies are categorized according to their visual morphology as elliptical, spiral and irregular. Many galaxies are thought to have black holes at their active centers. The Milky Way''s central black hole, known as Sagittarius A*, has a mass four million times greater than the Sun. As of March 2016, GN-z11 is the oldest and most distant observed galaxy with a comoving distance of 32 billion light-years from Earth, and observed as it existed just 400 million years after the Big Bang. Recent estimates of the number of galaxies in the observable universe range from 200 billion (2×1011) to 2 trillion (2×1012) or more, containing more stars than all the grains of sand on planet Earth. Most of the galaxies are 1,000 to 100,000 parsecs in diameter and separated by distances on the order of millions of parsecs (or megaparsecs). The space between galaxies is filled with a tenuous gas having an average density of less than one atom per cubic meter. The majority of galaxies are gravitationally organized into groups, clusters, and superclusters. At the largest scale, these associations are generally arranged into sheets and filaments surrounded by immense voids. The largest structure of galaxies yet recognised is a cluster of superclusters, that has been named Laniakea. Thank you for reading about galaxies. I lied about the galaxies. Please now continue to proofread my work on kangaroos.', '2017-06-03 00:00:00', '2017-05-04 00:00:00', '3,5,7,9', 'Test_task33', '.pdf', 3000, 9, 'files/docs/test_task33.pdf', 'false');

-- Task 34
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111119, 'Test task 34', 'Thesis', 'This document is my final year project in rocket science. Rocket science being such an incredibally difficult subject limits this task to only the brightest and most talented of individuals. Not that you will find any faults with my flawless work. I think you will be pleasently surprised at the skill and accuracy shown in my work.', '2017-06-04 00:00:00', '2017-05-05 00:00:00', '11,13,15,17', 'Test_task34', '.pdf', 3000, 4, 'files/docs/test_task34.pdf', 'false');

-- Task 35
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111130, 'Test task 35', 'Thesis', 'This document is really boring and needs proofreading because I really cant spell and my grammar is appalling. Coincidently this description would be ideal to showcase the functionality of a proofreading website. I sure hope nobody takes this description to show that task descriptions display correctly from a database.', '2017-06-02 00:00:00', '2017-05-03 00:00:00', '19,21,23,25', 'Test_task35', '.pdf', 3000, 3, 'files/docs/test_task35.pdf', 'false');

-- Task 36
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111117, 'Test task 36', 'Thesis', 'This document is really important and needs proofreading ASAP. It is for my FYP and it is due in two weeks. I wrote all of this last night in a redbull fueled frenzy. As a result it is littered with errors and typos. I hope this description is sufficient.', '2017-06-07 00:00:00', '2017-05-08 00:00:00', '2,4,6,8', 'Test_task36', '.pdf', 3000, 5, 'files/docs/test_task36.pdf', 'false');

-- Task 37
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111125, 'Test task 37', 'Thesis', 'This is for a end of year project, the deadline is in a fortnight. Here''s the problem I haven''t attended a single lecture all semester and my knowledge on the stuff in this paper is... none existant so perhaps you could add a tiny bit while correcting it, if you know what I mean.', '2017-06-03 00:00:00', '2017-05-04 00:00:00', '10,12,14,16', 'Test_task37', '.pdf', 3000, 8, 'files/docs/test_task37.pdf', 'false');

-- Task 38
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111112, 'Test task 38', 'Thesis', 'This paper isn''t mine it''s actually my girlfriends, She''s studying psychology and I may have dug myself into a bit of trouble by saying I had a masters in Psychology when in reality I have an arts degree. Could you do me a favor and proofread this so I can pretend it was me and score some brownie points? Thanks in advance.', '2017-06-02 00:00:00', '2017-05-03 00:00:00', '18,21,23,25', 'Test_task38', '.pdf', 3000, 3, 'files/docs/test_task38.pdf', 'false');

-- Task 39
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111129, 'Test task 39', 'Thesis', 'My paper is about galaxies and I think you should read this brief description of a galaxy before you continue. A galaxy is a gravitationally bound system of stars, stellar remnants, interstellar gas, dust, and dark matter. The word galaxy is derived from the Greek galaxias, literally "milky", a reference to the Milky Way. Galaxies range in size from dwarfs with just a few billion (109) stars to giants with one hundred trillion (1014) stars, each orbiting its galaxy''s center of mass. Galaxies are categorized according to their visual morphology as elliptical, spiral and irregular. Many galaxies are thought to have black holes at their active centers. The Milky Way''s central black hole, known as Sagittarius A*, has a mass four million times greater than the Sun. As of March 2016, GN-z11 is the oldest and most distant observed galaxy with a comoving distance of 32 billion light-years from Earth, and observed as it existed just 400 million years after the Big Bang. Recent estimates of the number of galaxies in the observable universe range from 200 billion (2×1011) to 2 trillion (2×1012) or more, containing more stars than all the grains of sand on planet Earth. Most of the galaxies are 1,000 to 100,000 parsecs in diameter and separated by distances on the order of millions of parsecs (or megaparsecs). The space between galaxies is filled with a tenuous gas having an average density of less than one atom per cubic meter. The majority of galaxies are gravitationally organized into groups, clusters, and superclusters. At the largest scale, these associations are generally arranged into sheets and filaments surrounded by immense voids. The largest structure of galaxies yet recognised is a cluster of superclusters, that has been named Laniakea. Thank you for reading about galaxies. I lied about the galaxies. Please now continue to proofread my work on kangaroos.', '2017-06-04 00:00:00', '2017-05-05 00:00:00', '9,2,7,11', 'Test_task39', '.pdf', 3000, 7, 'files/docs/test_task39.pdf', 'false');

-- Task 40
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111113, 'Test task 40', 'Thesis', 'This document is my final year project in rocket science. Rocket science being such an incredibally difficult subject limits this task to only the brightest and most talented of individuals. Not that you will find any faults with my flawless work. I think you will be pleasently surprised at the skill and accuracy shown in my work.', '2017-06-06 00:00:00', '2017-05-07 00:00:00', '14,17,22,3', 'Test_task40', '.pdf', 3000, 4, 'files/docs/test_task40.pdf', 'false');

-- Task 41
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111124, 'Test task 41', 'Thesis', 'This description is going to be short and brief. Like just long enough to meet the requirements. Read my paper', '2017-06-04 00:00:00', '2017-05-05 00:00:00', '3,5,7,9', 'Test_task41', '.pdf', 3000, 6, 'files/docs/test_task41.pdf', 'false');

-- Task 42
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111120, 'Test task 42', 'Thesis', 'This document is really boring and needs proofreading because I really cant spell and my grammar is appalling. Coincidently this description would be ideal to showcase the functionality of a proofreading website. I sure hope nobody takes this description to show that task descriptions display correctly from a database.', '2017-06-03 00:00:00', '2017-05-04 00:00:00', '11,13,15,17', 'Test_task42', '.pdf', 3000, 9, 'files/docs/test_task42.pdf', 'false');

-- Task 43
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111115, 'Test task 43', 'Thesis', 'This document is really important and needs proofreading ASAP. It is for my FYP and it is due in two weeks. I wrote all of this last night in a redbull fueled frenzy. As a result it is littered with errors and typos. I hope this description is sufficient.', '2017-06-08 00:00:00', '2017-05-09 00:00:00', '19,21,22,23', 'Test_task43', '.pdf', 3000, 3, 'files/docs/test_task43.pdf', 'false');

-- Task 44
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111118, 'Test task 44', 'Thesis', 'This is for a end of year project, the deadline is in a fortnight. Here''s the problem I haven''t attended a single lecture all semester and my knowledge on the stuff in this paper is... none existant so perhaps you could add a tiny bit while correcting it, if you know what I mean.', '2017-06-01 00:00:00', '2017-05-02 00:00:00', '25,2,4,6', 'Test_task44', '.pdf', 3000, 5, 'files/docs/test_task44.pdf', 'false');

-- Task 45
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111123, 'Test task 45', 'Thesis', 'This paper isn''t mine it''s actually my girlfriends, She''s studying psychology and I may have dug myself into a bit of trouble by saying I had a masters in Psychology when in reality I have an arts degree. Could you do me a favor and proofread this so I can pretend it was me and score some brownie points? Thanks in advance.', '2017-06-03 00:00:00', '2017-05-04 00:00:00', '8,10,12,14', 'Test_task45', '.pdf', 3000, 7, 'files/docs/test_task45.pdf', 'false');

-- Task 46
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111127, 'Test task 46', 'Thesis', 'My paper is about galaxies and I think you should read this brief description of a galaxy before you continue. A galaxy is a gravitationally bound system of stars, stellar remnants, interstellar gas, dust, and dark matter. The word galaxy is derived from the Greek galaxias, literally "milky", a reference to the Milky Way. Galaxies range in size from dwarfs with just a few billion (109) stars to giants with one hundred trillion (1014) stars, each orbiting its galaxy''s center of mass. Galaxies are categorized according to their visual morphology as elliptical, spiral and irregular. Many galaxies are thought to have black holes at their active centers. The Milky Way''s central black hole, known as Sagittarius A*, has a mass four million times greater than the Sun. As of March 2016, GN-z11 is the oldest and most distant observed galaxy with a comoving distance of 32 billion light-years from Earth, and observed as it existed just 400 million years after the Big Bang. Recent estimates of the number of galaxies in the observable universe range from 200 billion (2×1011) to 2 trillion (2×1012) or more, containing more stars than all the grains of sand on planet Earth. Most of the galaxies are 1,000 to 100,000 parsecs in diameter and separated by distances on the order of millions of parsecs (or megaparsecs). The space between galaxies is filled with a tenuous gas having an average density of less than one atom per cubic meter. The majority of galaxies are gravitationally organized into groups, clusters, and superclusters. At the largest scale, these associations are generally arranged into sheets and filaments surrounded by immense voids. The largest structure of galaxies yet recognised is a cluster of superclusters, that has been named Laniakea. Thank you for reading about galaxies. I lied about the galaxies. Please now continue to proofread my work on kangaroos.', '2017-06-06 00:00:00', '2017-05-07 00:00:00', '16,18,20,22', 'Test_task46', '.pdf', 3000, 6, 'files/docs/test_task46.pdf', 'false');

-- Task 47
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111111, 'Test task 47', 'Thesis', 'This document is my final year project in rocket science. Rocket science being such an incredibally difficult subject limits this task to only the brightest and most talented of individuals. Not that you will find any faults with my flawless work. I think you will be pleasently surprised at the skill and accuracy shown in my work.', '2017-06-04 00:00:00', '2017-05-05 00:00:00', '24,7,1,3', 'Test_task47', '.pdf', 3000, 4, 'files/docs/test_task47.pdf', 'false');

-- Task 48
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111122, 'Test task 48', 'Thesis', 'This description is going to be short and brief. Like just long enough to meet the requirements. Read my paper', '2017-06-02 00:00:00', '2017-05-03 00:00:00', '5,7,9,11', 'Test_task48', '.pdf', 3000, 8, 'files/docs/test_task48.pdf', 'false');

-- Task 49
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111131, 'Test task 49', 'Thesis', 'This document is really boring and needs proofreading because I really cant spell and my grammar is appalling. Coincidently this description would be ideal to showcase the functionality of a proofreading website. I sure hope nobody takes this description to show that task descriptions display correctly from a database.', '2017-06-03 00:00:00', '2017-05-04 00:00:00', '13,15,17,19', 'Test_task49', '.pdf', 3000, 3, 'files/docs/test_task49.pdf', 'false');

-- Task 50
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111116, 'Test task 50', 'Thesis', 'This document is really important and needs proofreading ASAP. It is for my FYP and it is due in two weeks. I wrote all of this last night in a redbull fueled frenzy. As a result it is littered with errors and typos. I hope this description is sufficient.', '2017-06-05 00:00:00', '2017-05-06 00:00:00', '21,23,25,7', 'Test_task50', '.pdf', 3000, 7, 'files/docs/test_task50.pdf', 'false');

-- Task 51
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111121, 'Test task 51', 'Thesis', 'This is for a end of year project, the deadline is in a fortnight. Here''s the problem I haven''t attended a single lecture all semester and my knowledge on the stuff in this paper is... none existant so perhaps you could add a tiny bit while correcting it, if you know what I mean.', '2017-06-07 00:00:00', '2017-05-08 00:00:00', '2,4,5,8', 'Test_task51', '.pdf', 3000, 5, 'files/docs/test_task51.pdf', 'false');

-- Task 52
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111128, 'Test task 52', 'Thesis', 'This paper isn''t mine it''s actually my girlfriends, She''s studying psychology and I may have dug myself into a bit of trouble by saying I had a masters in Psychology when in reality I have an arts degree. Could you do me a favor and proofread this so I can pretend it was me and score some brownie points? Thanks in advance.', '2017-06-01 00:00:00', '2017-05-02 00:00:00', '10,12,15,18', 'Test_task52', '.pdf', 3000, 3, 'files/docs/test_task52.pdf', 'false');

-- Task 53
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111114, 'Test task 53', 'Thesis', 'My paper is about galaxies and I think you should read this brief description of a galaxy before you continue. A galaxy is a gravitationally bound system of stars, stellar remnants, interstellar gas, dust, and dark matter. The word galaxy is derived from the Greek galaxias, literally "milky", a reference to the Milky Way. Galaxies range in size from dwarfs with just a few billion (109) stars to giants with one hundred trillion (1014) stars, each orbiting its galaxy''s center of mass. Galaxies are categorized according to their visual morphology as elliptical, spiral and irregular. Many galaxies are thought to have black holes at their active centers. The Milky Way''s central black hole, known as Sagittarius A*, has a mass four million times greater than the Sun. As of March 2016, GN-z11 is the oldest and most distant observed galaxy with a comoving distance of 32 billion light-years from Earth, and observed as it existed just 400 million years after the Big Bang. Recent estimates of the number of galaxies in the observable universe range from 200 billion (2×1011) to 2 trillion (2×1012) or more, containing more stars than all the grains of sand on planet Earth. Most of the galaxies are 1,000 to 100,000 parsecs in diameter and separated by distances on the order of millions of parsecs (or megaparsecs). The space between galaxies is filled with a tenuous gas having an average density of less than one atom per cubic meter. The majority of galaxies are gravitationally organized into groups, clusters, and superclusters. At the largest scale, these associations are generally arranged into sheets and filaments surrounded by immense voids. The largest structure of galaxies yet recognised is a cluster of superclusters, that has been named Laniakea. Thank you for reading about galaxies. I lied about the galaxies. Please now continue to proofread my work on kangaroos.', '2017-06-02 00:00:00', '2017-05-03 00:00:00', '20,22,24,5', 'Test_task53', '.pdf', 3000, 8, 'files/docs/test_task53.pdf', 'false');

-- Task 54
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111126, 'Test task 54', 'Thesis', 'This document is my final year project in rocket science. Rocket science being such an incredibally difficult subject limits this task to only the brightest and most talented of individuals. Not that you will find any faults with my flawless work. I think you will be pleasently surprised at the skill and accuracy shown in my work.', '2017-06-07 00:00:00', '2017-05-08 00:00:00', '11,15,17,19', 'Test_task54', '.pdf', 3000, 5, 'files/docs/test_task54.pdf', 'false');

-- Task 55
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111119, 'Test task 55', 'Thesis', 'This description is going to be short and brief. Like just long enough to meet the requirements. Read my paper', '2017-06-04 00:00:00', '2017-05-05 00:00:00', '21,23,25,10', 'Test_task55', '.pdf', 3000, 2, 'files/docs/test_task55.pdf', 'false');

-- Task 56
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111130, 'Test task 56', 'Thesis', 'This document is really boring and needs proofreading because I really cant spell and my grammar is appalling. Coincidently this description would be ideal to showcase the functionality of a proofreading website. I sure hope nobody takes this description to show that task descriptions display correctly from a database.', '2017-06-08 00:00:00', '2017-05-09 00:00:00', '12,7,3,22', 'Test_task56', '.pdf', 3000, 7, 'files/docs/test_task56.pdf', 'false');

-- Task 57
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111117, 'Test task 57', 'Thesis', 'This document is really important and needs proofreading ASAP. It is for my FYP and it is due in two weeks. I wrote all of this last night in a redbull fueled frenzy. As a result it is littered with errors and typos. I hope this description is sufficient.', '2017-06-06 00:00:00', '2017-05-07 00:00:00', '7,1,3,5', 'Test_task57', '.pdf', 3000, 4, 'files/docs/test_task57.pdf', 'false');

-- Task 58
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111125, 'Test task 58', 'Thesis', 'This is for a end of year project, the deadline is in a fortnight. Here''s the problem I haven''t attended a single lecture all semester and my knowledge on the stuff in this paper is... none existant so perhaps you could add a tiny bit while correcting it, if you know what I mean.', '2017-06-02 00:00:00', '2017-05-03 00:00:00', '7,9,21,23', 'Test_task58', '.pdf', 3000, 3, 'files/docs/test_task58.pdf', 'false');

-- Task 59
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111112, 'Test task 59', 'Thesis', 'This paper isn''t mine it''s actually my girlfriends, She''s studying psychology and I may have dug myself into a bit of trouble by saying I had a masters in Psychology when in reality I have an arts degree. Could you do me a favor and proofread this so I can pretend it was me and score some brownie points? Thanks in advance.', '2017-06-04 00:00:00', '2017-05-05 00:00:00', '25,2,5,8', 'Test_task59', '.pdf', 3000, 6, 'files/docs/test_task59.pdf', 'false');

-- Task 60
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111129, 'Test task 60', 'Thesis', 'My paper is about galaxies and I think you should read this brief description of a galaxy before you continue. A galaxy is a gravitationally bound system of stars, stellar remnants, interstellar gas, dust, and dark matter. The word galaxy is derived from the Greek galaxias, literally "milky", a reference to the Milky Way. Galaxies range in size from dwarfs with just a few billion (109) stars to giants with one hundred trillion (1014) stars, each orbiting its galaxy''s center of mass. Galaxies are categorized according to their visual morphology as elliptical, spiral and irregular. Many galaxies are thought to have black holes at their active centers. The Milky Way''s central black hole, known as Sagittarius A*, has a mass four million times greater than the Sun. As of March 2016, GN-z11 is the oldest and most distant observed galaxy with a comoving distance of 32 billion light-years from Earth, and observed as it existed just 400 million years after the Big Bang. Recent estimates of the number of galaxies in the observable universe range from 200 billion (2×1011) to 2 trillion (2×1012) or more, containing more stars than all the grains of sand on planet Earth. Most of the galaxies are 1,000 to 100,000 parsecs in diameter and separated by distances on the order of millions of parsecs (or megaparsecs). The space between galaxies is filled with a tenuous gas having an average density of less than one atom per cubic meter. The majority of galaxies are gravitationally organized into groups, clusters, and superclusters. At the largest scale, these associations are generally arranged into sheets and filaments surrounded by immense voids. The largest structure of galaxies yet recognised is a cluster of superclusters, that has been named Laniakea. Thank you for reading about galaxies. I lied about the galaxies. Please now continue to proofread my work on kangaroos.', '2017-06-03 00:00:00', '2017-05-04 00:00:00', '10,16,25,22', 'Test_task60', '.pdf', 3000, 9, 'files/docs/test_task60.pdf', 'false');

-- Task 61
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111113, 'Test task 61', 'Thesis', 'This document is my final year project in rocket science. Rocket science being such an incredibally difficult subject limits this task to only the brightest and most talented of individuals. Not that you will find any faults with my flawless work. I think you will be pleasently surprised at the skill and accuracy shown in my work.', '2017-06-02 00:00:00', '2017-05-03 00:00:00', '9,1,3,5', 'Test_task61', '.pdf', 3000, 8, 'files/docs/test_task61.pdf', 'false');

-- Task 62
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111124, 'Test task 62', 'Thesis', 'This description is going to be short and brief. Like just long enough to meet the requirements. Read my paper', '2017-06-07 00:00:00', '2017-05-08 00:00:00', '7,9,11,13', 'Test_task62', '.pdf', 3000, 5, 'files/docs/test_task62.pdf', 'false');

-- Task 63
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111120, 'Test task 63', 'Thesis', 'This document is really boring and needs proofreading because I really cant spell and my grammar is appalling. Coincidently this description would be ideal to showcase the functionality of a proofreading website. I sure hope nobody takes this description to show that task descriptions display correctly from a database.', '2017-06-04 00:00:00', '2017-05-05 00:00:00', '15,17,19,20', 'Test_task63', '.pdf', 3000, 2, 'files/docs/test_task63.pdf', 'false');

-- Task 64
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111115, 'Test task 64', 'Thesis', 'This document is really important and needs proofreading ASAP. It is for my FYP and it is due in two weeks. I wrote all of this last night in a redbull fueled frenzy. As a result it is littered with errors and typos. I hope this description is sufficient.', '2017-06-06 00:00:00', '2017-05-07 00:00:00', '22,25,0,6', 'Test_task64', '.pdf', 3000, 7, 'files/docs/test_task64.pdf', 'false');

-- Task 65
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111118, 'Test task 65', 'Thesis', 'This is for a end of year project, the deadline is in a fortnight. Here''s the problem I haven''t attended a single lecture all semester and my knowledge on the stuff in this paper is... none existant so perhaps you could add a tiny bit while correcting it, if you know what I mean.', '2017-06-02 00:00:00', '2017-05-03 00:00:00', '8,10,12,14', 'Test_task65', '.pdf', 3000, 4, 'files/docs/test_task65.pdf', 'false');

-- Task 66
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111123, 'Test task 66', 'Thesis', 'This paper isn''t mine it''s actually my girlfriends, She''s studying psychology and I may have dug myself into a bit of trouble by saying I had a masters in Psychology when in reality I have an arts degree. Could you do me a favor and proofread this so I can pretend it was me and score some brownie points? Thanks in advance.', '2017-06-08 00:00:00', '2017-05-09 00:00:00', '16,18,20,22', 'Test_task66', '.pdf', 3000, 3, 'files/docs/test_task66.pdf', 'false');

-- Task 67
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111127, 'Test task 67', 'Thesis', 'My paper is about galaxies and I think you should read this brief description of a galaxy before you continue. A galaxy is a gravitationally bound system of stars, stellar remnants, interstellar gas, dust, and dark matter. The word galaxy is derived from the Greek galaxias, literally "milky", a reference to the Milky Way. Galaxies range in size from dwarfs with just a few billion (109) stars to giants with one hundred trillion (1014) stars, each orbiting its galaxy''s center of mass. Galaxies are categorized according to their visual morphology as elliptical, spiral and irregular. Many galaxies are thought to have black holes at their active centers. The Milky Way''s central black hole, known as Sagittarius A*, has a mass four million times greater than the Sun. As of March 2016, GN-z11 is the oldest and most distant observed galaxy with a comoving distance of 32 billion light-years from Earth, and observed as it existed just 400 million years after the Big Bang. Recent estimates of the number of galaxies in the observable universe range from 200 billion (2×1011) to 2 trillion (2×1012) or more, containing more stars than all the grains of sand on planet Earth. Most of the galaxies are 1,000 to 100,000 parsecs in diameter and separated by distances on the order of millions of parsecs (or megaparsecs). The space between galaxies is filled with a tenuous gas having an average density of less than one atom per cubic meter. The majority of galaxies are gravitationally organized into groups, clusters, and superclusters. At the largest scale, these associations are generally arranged into sheets and filaments surrounded by immense voids. The largest structure of galaxies yet recognised is a cluster of superclusters, that has been named Laniakea. Thank you for reading about galaxies. I lied about the galaxies. Please now continue to proofread my work on kangaroos.', '2017-06-06 00:00:00', '2017-05-07 00:00:00', '24,1,3,4', 'Test_task67', '.pdf', 3000, 9, 'files/docs/test_task67.pdf', 'false');

-- Task 68
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111111, 'Test task 68', 'Thesis', 'This document is my final year project in rocket science. Rocket science being such an incredibally difficult subject limits this task to only the brightest and most talented of individuals. Not that you will find any faults with my flawless work. I think you will be pleasently surprised at the skill and accuracy shown in my work.', '2017-06-01 00:00:00', '2017-05-02 00:00:00', '6,8,12,14', 'Test_task68', '.pdf', 3000, 6, 'files/docs/test_task68.pdf', 'false');

-- Task 69
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111122, 'Test task 69', 'Thesis', 'This description is going to be short and brief. Like just long enough to meet the requirements. Read my paper', '2017-06-05 00:00:00', '2017-05-06 00:00:00', '16,18,20,22', 'Test_task69', '.pdf', 3000, 7, 'files/docs/test_task69.pdf', 'false');

-- Task 70
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111131, 'Test task 70', 'Thesis', 'This document is really boring and needs proofreading because I really cant spell and my grammar is appalling. Coincidently this description would be ideal to showcase the functionality of a proofreading website. I sure hope nobody takes this description to show that task descriptions display correctly from a database.', '2017-06-03 00:00:00', '2017-05-04 00:00:00', '7,5,11,17', 'Test_task70', '.pdf', 3000, 9, 'files/docs/test_task70.pdf', 'false');

-- Task 71
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111116, 'Test task 71', 'Thesis', 'This document is really important and needs proofreading ASAP. It is for my FYP and it is due in two weeks. I wrote all of this last night in a redbull fueled frenzy. As a result it is littered with errors and typos. I hope this description is sufficient.', '2017-06-08 00:00:00', '2017-05-09 00:00:00', '23,25,4,10', 'Test_task71', '.pdf', 3000, 6, 'files/docs/test_task71.pdf', 'false');

-- Task 72
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111121, 'Test task 72', 'Thesis', 'This is for a end of year project, the deadline is in a fortnight. Here''s the problem I haven''t attended a single lecture all semester and my knowledge on the stuff in this paper is... none existant so perhaps you could add a tiny bit while correcting it, if you know what I mean.', '2017-06-06 00:00:00', '2017-05-07 00:00:00', '14,20,24,3', 'Test_task72', '.pdf', 3000, 4, 'files/docs/test_task72.pdf', 'false');

-- Task 73
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111128, 'Test task 73', 'Thesis', 'This paper isn''t mine it''s actually my girlfriends, She''s studying psychology and I may have dug myself into a bit of trouble by saying I had a masters in Psychology when in reality I have an arts degree. Could you do me a favor and proofread this so I can pretend it was me and score some brownie points? Thanks in advance.', '2017-06-02 00:00:00', '2017-05-03 00:00:00', '8,2,3,4', 'Test_task73', '.pdf', 3000, 5, 'files/docs/test_task73.pdf', 'false');

-- Task 74
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111114, 'Test task 74', 'Thesis', 'My paper is about galaxies and I think you should read this brief description of a galaxy before you continue. A galaxy is a gravitationally bound system of stars, stellar remnants, interstellar gas, dust, and dark matter. The word galaxy is derived from the Greek galaxias, literally "milky", a reference to the Milky Way. Galaxies range in size from dwarfs with just a few billion (109) stars to giants with one hundred trillion (1014) stars, each orbiting its galaxy''s center of mass. Galaxies are categorized according to their visual morphology as elliptical, spiral and irregular. Many galaxies are thought to have black holes at their active centers. The Milky Way''s central black hole, known as Sagittarius A*, has a mass four million times greater than the Sun. As of March 2016, GN-z11 is the oldest and most distant observed galaxy with a comoving distance of 32 billion light-years from Earth, and observed as it existed just 400 million years after the Big Bang. Recent estimates of the number of galaxies in the observable universe range from 200 billion (2×1011) to 2 trillion (2×1012) or more, containing more stars than all the grains of sand on planet Earth. Most of the galaxies are 1,000 to 100,000 parsecs in diameter and separated by distances on the order of millions of parsecs (or megaparsecs). The space between galaxies is filled with a tenuous gas having an average density of less than one atom per cubic meter. The majority of galaxies are gravitationally organized into groups, clusters, and superclusters. At the largest scale, these associations are generally arranged into sheets and filaments surrounded by immense voids. The largest structure of galaxies yet recognised is a cluster of superclusters, that has been named Laniakea. Thank you for reading about galaxies. I lied about the galaxies. Please now continue to proofread my work on kangaroos.', '2017-06-04 00:00:00', '2017-05-05 00:00:00', '5,1,9,4', 'Test_task74', '.pdf', 3000, 9, 'files/docs/test_task74.pdf', 'false');

-- Task 75
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111126, 'Test task 75', 'Thesis', 'This document is my final year project in rocket science. Rocket science being such an incredibally difficult subject limits this task to only the brightest and most talented of individuals. Not that you will find any faults with my flawless work. I think you will be pleasently surprised at the skill and accuracy shown in my work.', '2017-06-06 00:00:00', '2017-05-07 00:00:00', '7,1,3,5', 'Test_task75', '.pdf', 3000, 7, 'files/docs/test_task75.pdf', 'false');

-- Task 76
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111119, 'Test task 76', 'Thesis', 'This description is going to be short and brief. Like just long enough to meet the requirements. Read my paper', '2017-06-02 00:00:00', '2017-05-03 00:00:00', '21,1,18,4', 'Test_task76', '.pdf', 3000, 6, 'files/docs/test_task76.pdf', 'false');

-- Task 77
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111130, 'Test task 77', 'Thesis', 'This document is really boring and needs proofreading because I really cant spell and my grammar is appalling. Coincidently this description would be ideal to showcase the functionality of a proofreading website. I sure hope nobody takes this description to show that task descriptions display correctly from a database.', '2017-06-08 00:00:00', '2017-05-07 00:00:00', '19,1,13,4', 'Test_task77', '.pdf', 3000, 3, 'files/docs/test_task77.pdf', 'false');

-- Task 78
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111117, 'Test task 78', 'Thesis', 'This document is really important and needs proofreading ASAP. It is for my FYP and it is due in two weeks. I wrote all of this last night in a redbull fueled frenzy. As a result it is littered with errors and typos. I hope this description is sufficient.', '2017-06-03 00:00:00', '2017-05-04 00:00:00', '13,21,23,4', 'Test_task78', '.pdf', 3000, 8, 'files/docs/test_task78.pdf', 'false');

-- Task 79
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111125, 'Test task 79', 'Thesis', 'This is for a end of year project, the deadline is in a fortnight. Here''s the problem I haven''t attended a single lecture all semester and my knowledge on the stuff in this paper is... none existant so perhaps you could add a tiny bit while correcting it, if you know what I mean.', '2017-06-08 00:00:00', '2017-05-09 00:00:00', '20,1,3,24', 'Test_task79', '.pdf', 3000, 2, 'files/docs/test_task79.pdf', 'false');

-- Task 80
INSERT INTO group17.Tasks (user_id, task_title, task_type, description, review_deadline, claim_deadline, tags, doc_title, file_format, word_length, page_length, path_to_file, rated)
VALUES (15111112, 'Test task 80', 'Thesis', 'This paper isn''t mine it''s actually my girlfriends, She''s studying psychology and I may have dug myself into a bit of trouble by saying I had a masters in Psychology when in reality I have an arts degree. Could you do me a favor and proofread this so I can pretend it was me and score some brownie points? Thanks in advance.', '2017-06-04 00:00:00', '2017-05-05 00:00:00', '15,21,3,25', 'Test_task80', '.pdf', 3000, 5, 'files/docs/test_task80.pdf', 'false');


-- ********** END OF TASKS **********

-- ********* PROCEDURES *********

--Procedure 1
DROP PROCEDURE IF EXISTS group17.getUserMajor;

DELIMITER //
CREATE PROCEDURE group17.getUserMajor(IN calling_user INTEGER(10) UNSIGNED)
BEGIN 
	SELECT major FROM Users WHERE user_id = calling_user;
END //
DELIMITER ;


-- Procedure 2
DELIMITER //
CREATE PROCEDURE group17.logoutUser()
BEGIN
	DECLARE id INTEGER(10);
    DECLARE table_size INTEGER(10);
    DECLARE state TIMESTAMP;
    SELECT COUNT(*) INTO table_size FROM Sessions;
    SELECT user_id INTO id FROM Sessions LIMIT table_size,1;
    SELECT last_active INTO state FROM Sessions WHERE user_id = id;
    IF state >= 2 THEN
    	INSERT INTO total_sessions(user_id, date_logged_in, date_logged_out) VALUES (id, (SELECT date_time FROM Sessions WHERE user_id = id), Now());
    END IF;
END //
DELIMITER ;


-- Procedure 3
DROP PROCEDURE IF EXISTS logout;

DELIMITER //
CREATE PROCEDURE group17.logout()
BEGIN
	DECLARE ctr INTEGER(10) DEFAULT 0;
	DECLARE id INTEGER(10);
    DECLARE table_size INTEGER(10);
    DECLARE state INTEGER(10);
    SELECT COUNT(*) INTO table_size FROM Sessions;
    SET ctr = 0;
    -- While loop starts
    WHILE ctr < table_size
    DO
    	SELECT user_id INTO id FROM Sessions LIMIT ctr,1;
    	SELECT last_active INTO state FROM Sessions WHERE user_id = id;
		-- CheCK if last_active >= 2
   		IF state >= 2 THEN
    		INSERT INTO total_sessions(user_id, date_logged_in, date_logged_out) VALUES (id, (SELECT date_time FROM Sessions WHERE user_id = id), Now());
        	DELETE FROM Sessions WHERE user_id = id;
   		END IF;
        -- Increment ctr
        SET ctr = ctr + 1;
    END WHILE;
END //
DELIMITER ;

-- ********* END OF PROCEDURES *********


-- ********* EVENTS *********

-- Event 1
DROP EVENT IF EXISTS Increment_last_active;

DELIMITER $$
CREATE EVENT Increment_last_active 
ON SCHEDULE EVERY 1 MINUTE STARTS '2017-01-01 00:00:00'
DO BEGIN
	-- event body
	UPDATE Sessions
	SET last_active = last_active + 1;
END $$
DELIMITER ;

DELETE EVENT Logout_Users;


-- Event 2
DROP EVENT IF EXISTS Logout_user;

DELIMITER $$
CREATE EVENT Logout_user 
ON SCHEDULE EVERY 1 MINUTE STARTS '2017-01-01 00:00:00' 
BEGIN
	CALL logout();
END $$
DELIMITER ;


-- Event 3
DROP EVENT IF EXISTS Check_Expired_Tasks;

DELIMITER $$
CREATE EVENT Check_Expired_Tasks
ON SCHEDULE EVERY 1 MINUTE STARTS '2017-01-01 00:00:00' -- CHANGE TO DAY LATER
DO BEGIN
	DECLARE ctr INTEGER(10) DEFAULT 0;
	DECLARE id INTEGER(10);
	DECLARE _user INTEGER(10);
    DECLARE table_size INTEGER(10);
    DECLARE review_by DATE;
    SELECT COUNT(*) INTO table_size FROM Sessions;
    SET ctr = 0;
    -- While loop starts
    WHILE ctr < table_size
    DO
    	-- Retrieve task id from cancelled tasks
    	SELECT task_id INTO id FROM claimed_tasks LIMIT ctr,1;
    	-- Retrieve the review_deadline for that task
    	SELECT review_deadline INTO review_by FROM Tasks WHERE task_id = id;
		-- Check if the review_deadline is less than Now()
   		IF review_deadline < CURDATE() THEN
   			-- Add task to cancelled tasks
    		INSERT INTO cancelled_tasks (task_id, cancelled_by, time_cancelled) VALUES (id, 0, Now());
    		-- Get claimant
    		SELECT claimant INTO _user FROM claimed_tasks WHERE task_id = id;
    		-- Remove from claimed_tasks
       		DELETE FROM claimed_tasks WHERE task_id = id;
       		-- Score -30 for this user
       		UPDATE users SET score = score-30 WHERE user_id = _user;
   		END IF;
        -- Increment ctr
        SET ctr = ctr + 1;
    END WHILE;
END $$
DELIMITER ;


-- ********* END OF EVENTS *********