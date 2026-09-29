-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 29, 2026 at 05:28 AM
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
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `id` int(11) NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `pass` text NOT NULL,
  `email` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
('WormsHaver', '$2y$10$lgmJAKJlnqiLQnMjQEpCyesEtYgFyylEm6smrgeFL20TTHbU2Krl.', 'Naz', 'Norris', 6);

--
-- Indexes for dumped tables
--

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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orgmembers`
--
ALTER TABLE `orgmembers`
  ADD CONSTRAINT `orgmembers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orgmembers_ibfk_2` FOREIGN KEY (`org_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
