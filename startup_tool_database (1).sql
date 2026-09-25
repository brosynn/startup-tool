-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 25, 2026 at 02:58 AM
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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user` varchar(32) NOT NULL,
  `pass` text NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user`, `pass`, `first_name`, `last_name`) VALUES
('ssongforisabelle', '$2y$10$ymNmjN5Pburr0.z461GtqeFaN3Losxu2wb/zwqZGV32kM3QlTPK/i', 'Isabelle', 'Allen'),
('jackieScumworth56', '$2y$10$okbn5Cu8RnSISV3jaeeGgOVnviMUEbMJCeXMNZdFKckrtyN8TT8Mq', 'Jackie', 'Scumworth'),
('bylerfan84', '$2y$10$bg0jwkYK6mTbKsj.FoGFZ.Wmx1WNZruVIw9B.LSALBOks5PMBKlBe', 'William', 'Byers'),
('Genusluvr', '$2y$10$Bwhlb7PCL6v5/J2rbD2CYev0.3rif8FAbYbeyBWK1kjVATm/MdL7y', 'Alberto', 'Einstien');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
