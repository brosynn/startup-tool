-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2026 at 09:00 PM
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

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE IF NOT EXISTS `organizations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `org_name` varchar(64) DEFAULT NULL,
  `org_desc` text NOT NULL,
  `logo_file_name` varchar(255) NOT NULL,
  `logo_file_path` varchar(255) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `question_ids` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orgmembers`
--

CREATE TABLE IF NOT EXISTS `orgmembers` (
  `user_id` int(11) NOT NULL,
  `org_id` int(11) NOT NULL,
  `joined_at` timestamp NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0=pending,1=approved,2=rejected',
  PRIMARY KEY (`user_id`),
  KEY `fk_org_id_orgmembers` (`org_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orgposts`
--

CREATE TABLE IF NOT EXISTS `orgposts` (
  `id` int(11) NOT NULL,
  `post` int(11) DEFAULT NULL,
  `org` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_post_orgposts` (`post`),
  KEY `fk_org_orgposts` (`org`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `text` varchar(1000) DEFAULT NULL,
  `file` int(11) DEFAULT NULL,
  `author` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_file_posts` (`file`),
  KEY `fk_author_posts` (`author`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rolemembers`
--

CREATE TABLE IF NOT EXISTS `rolemembers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) DEFAULT NULL,
  `org` int(11) DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_rolemembers` (`user`),
  KEY `fk_org_rolemembers` (`org`),
  KEY `fk_role_rolemembers` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roleposts`
--

CREATE TABLE IF NOT EXISTS `roleposts` (
  `id` int(11) NOT NULL,
  `post` int(11) DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_post_roleposts` (`post`),
  KEY `fk_role_roleposts` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `org` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_org_roles` (`org`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user` varchar(32) NOT NULL,
  `pass` text NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orgmembers`
--
ALTER TABLE `orgmembers`
  ADD CONSTRAINT `fk_user_id_orgmembers` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_org_id_orgmembers` FOREIGN KEY (`org_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orgposts`
--
ALTER TABLE `orgposts`
  ADD CONSTRAINT `fk_org_orgposts` FOREIGN KEY (`org`) REFERENCES `organizations` (`id`),
  ADD CONSTRAINT `fk_post_orgposts` FOREIGN KEY (`post`) REFERENCES `posts` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_author_posts` FOREIGN KEY (`author`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_file_posts` FOREIGN KEY (`file`) REFERENCES `files` (`id`);

--
-- Constraints for table `rolemembers`
--
ALTER TABLE `rolemembers`
  ADD CONSTRAINT `fk_org_rolemembers` FOREIGN KEY (`org`) REFERENCES `organizations` (`id`),
  ADD CONSTRAINT `fk_role_rolemembers` FOREIGN KEY (`role`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `fk_user_rolemembers` FOREIGN KEY (`user`) REFERENCES `users` (`id`);

--
-- Constraints for table `roleposts`
--
ALTER TABLE `roleposts`
  ADD CONSTRAINT `fk_role_roleposts` FOREIGN KEY (`role`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `fk_post_roleposts` FOREIGN KEY (`post`) REFERENCES `posts` (`id`);

--
-- Constraints for table `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `fk_org_roles` FOREIGN KEY (`org`) REFERENCES `organizations` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
