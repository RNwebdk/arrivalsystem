-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 07, 2022 at 08:44 AM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `arrivalsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

DROP TABLE IF EXISTS `grades`;
CREATE TABLE IF NOT EXISTS `grades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `name`) VALUES
(1, 'Grade 1'),
(2, 'Grade 2'),
(3, 'Grade 3'),
(4, 'Grade 4'),
(5, 'Grade 5'),
(6, 'Grade 6'),
(7, 'Grade 7'),
(8, 'Grade 8'),
(9, 'Grade 9');

-- --------------------------------------------------------

--
-- Table structure for table `pupils`
--

DROP TABLE IF EXISTS `pupils`;
CREATE TABLE IF NOT EXISTS `pupils` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `gradeId` int(11) NOT NULL,
  `checked` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pupils`
--

INSERT INTO `pupils` (`id`, `name`, `gradeId`, `checked`) VALUES
(1, 'Jordan Smith', 1, 1),
(3, 'Casey  Brown', 2, 1),
(4, 'Morgan Williams', 3, 0),
(5, 'Jonas Jordan', 4, 0),
(8, 'Monir Rodriguez', 5, 0),
(9, 'John Wilson', 6, 0),
(11, 'Riley Johnson', 7, 1),
(12, 'Alex Jones', 8, 1),
(13, 'Kent Brown', 9, 1),
(14, 'Quinn Miller', 1, 1),
(15, 'Casey Swap', 2, 1),
(16, 'Benyamin Davis', 3, 1),
(17, 'Jamie Wilson', 4, 1),
(18, 'Mona Lisa', 5, 1),
(20, 'Mohammad Ali', 6, 0),
(21, 'Taylor Petersen', 7, 1),
(22, 'Nova Nebula', 8, 0),
(23, 'Lumen Cosmos', 9, 0),
(24, 'Solaris Galaxy', 1, 0),
(25, 'Orion Nebula', 2, 1),
(33, 'Jonas johansen', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `isAdmin` BOOLEAN NOT NULL default 0,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `isAdmin`, `created_at`) VALUES
(1, 'Admin', 'Administrator', 'admin@admin.com', '$2y$10$z0/gbA8s1TZ2Wn/kaKat4.X2cL6VjAPT0JMYfL59cBER6a0e/7xN.', '1', '2024-03-23 20:18:48'),
(2, 'Teacher', 'Teacher', 'teacher@teacher.com', '$2y$10$z0/gbA8s1TZ2Wn/kaKat4.X2cL6VjAPT0JMYfL59cBER6a0e/7xN.', '0', '2024-03-23 20:18:48');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
