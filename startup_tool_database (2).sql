-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2026 at 04:49 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `startup_tool_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `path`, `name`) VALUES
(11, 'bucket/', 'Cute Puppy!.jpg'),
(12, 'bucket/', '(1)Cute Puppy!.jpg'),
(18, 'bucket/', '(5)Cute Puppy! Awesome.jpg'),
(19, 'bucket/', 'Cute Puppy! Awesome.jpg'),
(20, 'bucket/', 'final.txt');

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `id` int(11) NOT NULL,
  `org_name` varchar(64) DEFAULT NULL,
  `org_desc` text NOT NULL,
  `logo_file_name` varchar(255) NOT NULL,
  `logo_file_path` varchar(255) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `question_ids` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`id`, `org_name`, `org_desc`, `logo_file_name`, `logo_file_path`, `owner_id`, `question_ids`) VALUES
(1, 'Cool Org', 'Awesome place for super coool guys', 'deez2.png', 'bucket/', 0, NULL),
(2, 'Sussy Org', 'Amogus imposter palace', 'peas.jpg', 'bucket/', 0, NULL),
(3, 'Asher INC.', 'We made Asher. Yep. Sorry. So so sorry. We know an apology isn\'t enough. We\'re Sorry.', 'Wanted poster.PNG', 'bucket/', 7, NULL),
(4, 'Testing Organization', 'this IS FOR TESTING!!!!!!!!', 'Cute Puppy! Awesome.jpg', 'bucket/', 9, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orgmembers`
--

CREATE TABLE `orgmembers` (
  `user_id` int(11) NOT NULL,
  `org_id` int(11) NOT NULL,
  `joined_at` timestamp NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0=pending,1=approved,2=rejected'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orgmembers`
--

INSERT INTO `orgmembers` (`user_id`, `org_id`, `joined_at`, `status`) VALUES
(7, 3, '2026-11-09 20:36:28', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orgposts`
--

CREATE TABLE `orgposts` (
  `id` int(11) NOT NULL,
  `post` int(11) DEFAULT NULL,
  `org` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `text` varchar(1000) DEFAULT NULL,
  `file` int(11) DEFAULT NULL,
  `author` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `text`, `file`, `author`) VALUES
(1, 'My title big', 'My text is big', 12, NULL),
(2, 'Text title!', 'Epic awesome', 18, NULL),
(3, 'Hello!', 'bryson', 19, NULL),
(4, 'Hello wrold', 'Hi', NULL, NULL),
(5, 'oky', 'yay', NULL, NULL),
(6, 'NEw post 18 milion', '', 20, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rolemembers`
--

CREATE TABLE `rolemembers` (
  `id` int(11) NOT NULL,
  `user` int(11) DEFAULT NULL,
  `org` int(11) DEFAULT NULL,
  `role` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rolemembers`
--

INSERT INTO `rolemembers` (`id`, `user`, `org`, `role`) VALUES
(1, 7, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `roleposts`
--

CREATE TABLE `roleposts` (
  `id` int(11) NOT NULL,
  `post` int(11) DEFAULT NULL,
  `role` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `org` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `org`, `name`) VALUES
(1, 3, 'Scourge of All That is Good');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user` varchar(32) NOT NULL,
  `pass` text NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user`, `pass`, `first_name`, `last_name`, `id`) VALUES
('ssongforisabelle', '$2y$10$ymNmjN5Pburr0.z461GtqeFaN3Losxu2wb/zwqZGV32kM3QlTPK/i', 'Isabelle', 'Allen', 1),
('jackieScumworth56', '$2y$10$okbn5Cu8RnSISV3jaeeGgOVnviMUEbMJCeXMNZdFKckrtyN8TT8Mq', 'Jackie', 'Scumworth', 2),
('bylerfan84', '$2y$10$bg0jwkYK6mTbKsj.FoGFZ.Wmx1WNZruVIw9B.LSALBOks5PMBKlBe', 'William', 'Byers', 3),
('Genusluvr', '$2y$10$Bwhlb7PCL6v5/J2rbD2CYev0.3rif8FAbYbeyBWK1kjVATm/MdL7y', 'Alberto', 'Einstien', 4),
('SNASOTE', '$2y$10$0uLYKQcsWcVG9g2lUxu0teJx13XyjrDxUt6vprDmmOdQUtRqBHOIi', 'Asher', 'Rains', 5),
('WormsHaver', '$2y$10$lgmJAKJlnqiLQnMjQEpCyesEtYgFyylEm6smrgeFL20TTHbU2Krl.', 'Naz', 'Norris', 6),
('SNASOTE2', '$2y$10$gLkYM62vmWsCq3r6oiZiden8oZ3qo6PHn9yNfCTExy2UNg9S00hSW', 'a', 'r', 7),
('khiggins', '$2y$10$5CJaV7tBJ9oPlcI2JREEXuE11nlukJf84NG7M/0K97ZXz5nhqR7bC', 'Kristin', 'Higgins', 8),
('brosynn', '$2y$10$.yXmH6VDoueNTlV9dJpwRubgs/8laO2Ai6g09jYsbd6Fw4lKC2cIe', 'Bryson', 'Steward', 9),
('TestUser1', '$2y$10$Ymgj1dfJWy1OE1xcuu.pj.NIwTAPB86mUjK4cNawzQrKWdjKC.gWe', 'test 1', 'user 1', 10),
('TestUser2', '$2y$10$U75jQww0ChRG2UXF3rnjZelxpQtXuRHyMoYbUQBFImewzlAVCzpwu', 'test 2', 'user 2', 11),
('TestUser3', '$2y$10$6oyBYGmI80LjMhMiBLWrwO08Cjkjy1A4lcVgag4.0YDkonB863Tmi', 'test 3', 'user 3', 12);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orgmembers`
--
ALTER TABLE `orgmembers`
  ADD PRIMARY KEY (`user_id`,`org_id`),
  ADD KEY `org_id` (`org_id`);

--
-- Indexes for table `orgposts`
--
ALTER TABLE `orgposts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_post` (`post`),
  ADD KEY `fk_org` (`org`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_file` (`file`),
  ADD KEY `fk_author` (`author`);

--
-- Indexes for table `rolemembers`
--
ALTER TABLE `rolemembers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rolemember` (`user`),
  ADD KEY `fk_orgmember` (`org`),
  ADD KEY `fk_role` (`role`);

--
-- Indexes for table `roleposts`
--
ALTER TABLE `roleposts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rolepost` (`post`),
  ADD KEY `fk_postrole` (`role`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orgID` (`org`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rolemembers`
--
ALTER TABLE `rolemembers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orgmembers`
--
ALTER TABLE `orgmembers`
  ADD CONSTRAINT `orgmembers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orgmembers_ibfk_2` FOREIGN KEY (`org_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orgposts`
--
ALTER TABLE `orgposts`
  ADD CONSTRAINT `fk_org` FOREIGN KEY (`org`) REFERENCES `organizations` (`id`),
  ADD CONSTRAINT `fk_post` FOREIGN KEY (`post`) REFERENCES `posts` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_author` FOREIGN KEY (`author`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_file` FOREIGN KEY (`file`) REFERENCES `files` (`id`);

--
-- Constraints for table `rolemembers`
--
ALTER TABLE `rolemembers`
  ADD CONSTRAINT `fk_orgmember` FOREIGN KEY (`org`) REFERENCES `organizations` (`id`),
  ADD CONSTRAINT `fk_role` FOREIGN KEY (`role`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `fk_rolemember` FOREIGN KEY (`user`) REFERENCES `users` (`id`);

--
-- Constraints for table `roleposts`
--
ALTER TABLE `roleposts`
  ADD CONSTRAINT `fk_postrole` FOREIGN KEY (`role`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `fk_rolepost` FOREIGN KEY (`post`) REFERENCES `posts` (`id`);

--
-- Constraints for table `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `fk_orgID` FOREIGN KEY (`org`) REFERENCES `organizations` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
