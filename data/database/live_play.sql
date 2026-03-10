-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 10, 2026 at 02:53 AM
-- Server version: 11.8.5-MariaDB-log
-- PHP Version: 8.5.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `live_play`
--

-- --------------------------------------------------------

--
-- Table structure for table `posters`
--

CREATE TABLE `posters` (
  `poster_id` int(11) NOT NULL,
  `show_id` int(11) NOT NULL,
  `poster_image` varchar(255) NOT NULL,
  `is_used` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posters`
--

INSERT INTO `posters` (`poster_id`, `show_id`, `poster_image`, `is_used`) VALUES
(1, 1, 'data/images/evangeline/main.jpg', 1),
(2, 2, 'data/images/anesthesia/main.jpg', 1),
(3, 8, 'data/images/bankkok_mozart/main.jpg', 1),
(4, 11, 'data/images/emelie_proulx/main.jpg', 1),
(6, 3, 'data/images/La_Horde_Ballet/main.jpg', 1),
(7, 25, 'data/images/les_ballet/main.jpg', 1),
(8, 22, 'data/images/les_miserable/main.jpg', 1),
(9, 9, 'data/images/mizroew_hong/main.jpg', 1),
(10, 10, 'data/images/one_more_time/main.jpg', 1),
(11, 5, 'data/images/pinochio/main.jpg', 1),
(12, 26, 'data/images/quebec_comedie_night/main.jpg', 1),
(13, 7, 'data/images/Rock_Orchestra/main.jpg', 1),
(14, 27, 'data/images/symphonic_rock_montreal/main.jpg', 1),
(15, 6, 'data/images/tango_after_dark/main.jpg', 1),
(16, 28, 'data/images/the_phantom_of_the_opera/main.jpg', 1),
(17, 4, 'data/images/tupqan/main.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` int(11) NOT NULL,
  `seat_number` int(11) NOT NULL,
  `row_number` varchar(20) NOT NULL,
  `showing_id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `price` decimal(6,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `user_id` int(11) NOT NULL,
  `show_id` int(11) NOT NULL,
  `rating` int(4) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `showings`
--

CREATE TABLE `showings` (
  `showing_id` int(11) NOT NULL,
  `show_id` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `room` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `showings`
--

INSERT INTO `showings` (`showing_id`, `show_id`, `start_time`, `end_time`, `room`) VALUES
(1, 1, '2026-07-30 19:00:00', '2026-07-30 21:40:00', 'Room A'),
(2, 2, '2026-03-07 19:00:00', '2026-03-07 21:00:00', 'Room B'),
(3, 3, '2026-02-27 20:00:00', '2026-02-27 21:30:00', 'Room C'),
(4, 4, '2026-03-04 19:00:00', '2026-03-04 20:15:00', 'Room D'),
(5, 5, '2026-03-05 10:00:00', '2026-03-05 11:00:00', 'Room E'),
(6, 6, '2026-03-05 19:00:00', '2026-03-05 20:20:00', 'Room F'),
(7, 7, '2026-03-10 20:00:00', '2026-03-10 22:00:00', 'Room G'),
(8, 8, '2026-03-11 19:30:00', '2026-03-11 21:00:00', 'Room A'),
(9, 9, '2026-03-11 20:00:00', '2026-03-11 21:20:00', 'Room B'),
(10, 10, '2026-03-12 20:00:00', '2026-03-12 21:25:00', 'Room C'),
(11, 11, '2026-03-12 19:00:00', '2026-03-12 20:15:00', 'Room D'),
(12, 1, '2026-07-31 19:00:00', '2026-07-31 21:40:00', 'Room E'),
(13, 1, '2026-08-01 14:00:00', '2026-08-01 16:40:00', 'Room F'),
(14, 2, '2026-03-08 19:00:00', '2026-03-08 21:00:00', 'Room G'),
(15, 2, '2026-03-09 20:00:00', '2026-03-09 22:00:00', 'Room A'),
(16, 3, '2026-02-28 20:00:00', '2026-02-28 21:30:00', 'Room B'),
(17, 3, '2026-03-01 19:00:00', '2026-03-01 20:30:00', 'Room C'),
(18, 4, '2026-03-05 19:00:00', '2026-03-05 20:15:00', 'Room D'),
(19, 4, '2026-03-06 19:00:00', '2026-03-06 20:15:00', 'Room E'),
(20, 5, '2026-03-06 10:00:00', '2026-03-06 11:00:00', 'Room F'),
(21, 5, '2026-03-07 10:00:00', '2026-03-07 11:00:00', 'Room G'),
(22, 6, '2026-03-06 19:00:00', '2026-03-06 20:20:00', 'Room A'),
(23, 6, '2026-03-07 20:00:00', '2026-03-07 21:20:00', 'Room B'),
(24, 7, '2026-03-11 20:00:00', '2026-03-11 22:00:00', 'Room C'),
(25, 7, '2026-03-12 20:00:00', '2026-03-12 22:00:00', 'Room D'),
(26, 8, '2026-03-12 19:30:00', '2026-03-12 21:00:00', 'Room E'),
(27, 8, '2026-03-13 19:30:00', '2026-03-13 21:00:00', 'Room F'),
(28, 9, '2026-03-12 20:00:00', '2026-03-12 21:20:00', 'Room G'),
(29, 9, '2026-03-13 20:00:00', '2026-03-13 21:20:00', 'Room A'),
(30, 10, '2026-03-13 20:00:00', '2026-03-13 21:25:00', 'Room B'),
(31, 10, '2026-03-14 20:00:00', '2026-03-14 21:25:00', 'Room C'),
(32, 11, '2026-03-20 19:00:00', '2026-03-20 20:15:00', 'Room D'),
(33, 11, '2026-03-21 19:00:00', '2026-03-21 20:15:00', 'Room E'),
(34, 12, '2026-04-01 19:00:00', '2026-04-01 21:30:00', 'Room F'),
(35, 12, '2026-04-02 19:00:00', '2026-04-02 21:30:00', 'Room G'),
(36, 13, '2026-06-28 20:00:00', '2026-06-28 22:00:00', 'Room A'),
(37, 13, '2026-06-29 20:00:00', '2026-06-29 22:00:00', 'Room B'),
(38, 14, '2026-04-10 20:00:00', '2026-04-10 21:30:00', 'Room C'),
(39, 14, '2026-04-11 20:00:00', '2026-04-11 21:30:00', 'Room D'),
(40, 15, '2026-05-05 19:30:00', '2026-05-05 21:10:00', 'Room E'),
(41, 15, '2026-05-06 19:30:00', '2026-05-06 21:10:00', 'Room F'),
(42, 16, '2026-04-20 20:00:00', '2026-04-20 21:35:00', 'Room G'),
(43, 16, '2026-04-21 20:00:00', '2026-04-21 21:35:00', 'Room A'),
(44, 17, '2026-05-12 20:00:00', '2026-05-12 21:50:00', 'Room B'),
(45, 17, '2026-05-13 20:00:00', '2026-05-13 21:50:00', 'Room C'),
(46, 18, '2026-07-10 19:00:00', '2026-07-10 21:25:00', 'Room D'),
(47, 18, '2026-07-11 14:00:00', '2026-07-11 16:25:00', 'Room E'),
(48, 19, '2026-08-15 21:00:00', '2026-08-15 23:00:00', 'Room F'),
(49, 19, '2026-08-16 21:00:00', '2026-08-16 23:00:00', 'Room G'),
(50, 20, '2026-04-15 19:30:00', '2026-04-15 20:55:00', 'Room A'),
(51, 20, '2026-04-16 19:30:00', '2026-04-16 20:55:00', 'Room B'),
(52, 21, '2026-05-20 19:30:00', '2026-05-20 21:10:00', 'Room C'),
(53, 21, '2026-05-21 19:30:00', '2026-05-21 21:10:00', 'Room D'),
(54, 1, '2026-07-30 19:00:00', '2026-07-30 21:40:00', 'Room A'),
(55, 1, '2026-07-31 19:00:00', '2026-07-31 21:40:00', 'Room A'),
(56, 1, '2026-08-01 14:00:00', '2026-08-01 16:40:00', 'Room A'),
(57, 2, '2026-03-07 19:00:00', '2026-03-07 21:00:00', 'Room B'),
(58, 2, '2026-03-08 19:00:00', '2026-03-08 21:00:00', 'Room B'),
(59, 2, '2026-03-09 20:00:00', '2026-03-09 22:00:00', 'Room B'),
(60, 3, '2026-02-27 20:00:00', '2026-02-27 21:30:00', 'Room C'),
(61, 3, '2026-02-28 20:00:00', '2026-02-28 21:30:00', 'Room C'),
(62, 3, '2026-03-01 19:00:00', '2026-03-01 20:30:00', 'Room C'),
(63, 4, '2026-03-04 19:00:00', '2026-03-04 20:15:00', 'Room D'),
(64, 4, '2026-03-05 19:00:00', '2026-03-05 20:15:00', 'Room D'),
(65, 4, '2026-03-06 19:00:00', '2026-03-06 20:15:00', 'Room D'),
(66, 5, '2026-03-05 10:00:00', '2026-03-05 11:00:00', 'Room E'),
(67, 5, '2026-03-06 10:00:00', '2026-03-06 11:00:00', 'Room E'),
(68, 5, '2026-03-07 10:00:00', '2026-03-07 11:00:00', 'Room E'),
(69, 6, '2026-03-05 19:00:00', '2026-03-05 20:20:00', 'Room F'),
(70, 6, '2026-03-06 19:00:00', '2026-03-06 20:20:00', 'Room F'),
(71, 6, '2026-03-07 20:00:00', '2026-03-07 21:20:00', 'Room F'),
(72, 7, '2026-03-10 20:00:00', '2026-03-10 22:00:00', 'Room G'),
(73, 7, '2026-03-11 20:00:00', '2026-03-11 22:00:00', 'Room G'),
(74, 7, '2026-03-12 20:00:00', '2026-03-12 22:00:00', 'Room G'),
(75, 8, '2026-03-11 19:30:00', '2026-03-11 21:00:00', 'Room A'),
(76, 8, '2026-03-12 19:30:00', '2026-03-12 21:00:00', 'Room A'),
(77, 9, '2026-03-11 20:00:00', '2026-03-11 21:20:00', 'Room B'),
(78, 9, '2026-03-12 20:00:00', '2026-03-12 21:20:00', 'Room B'),
(79, 10, '2026-03-12 20:00:00', '2026-03-12 21:25:00', 'Room C'),
(80, 10, '2026-03-13 20:00:00', '2026-03-13 21:25:00', 'Room C'),
(81, 11, '2026-03-12 19:00:00', '2026-03-12 20:15:00', 'Room D'),
(82, 11, '2026-03-13 19:00:00', '2026-03-13 20:15:00', 'Room D'),
(83, 1, '2026-07-30 19:00:00', '2026-07-30 21:40:00', 'Room A'),
(84, 1, '2026-07-31 19:00:00', '2026-07-31 21:40:00', 'Room A'),
(85, 1, '2026-08-01 14:00:00', '2026-08-01 16:40:00', 'Room A'),
(86, 2, '2026-03-07 19:00:00', '2026-03-07 21:00:00', 'Room B'),
(87, 2, '2026-03-08 19:00:00', '2026-03-08 21:00:00', 'Room B'),
(88, 2, '2026-03-09 20:00:00', '2026-03-09 22:00:00', 'Room B'),
(89, 3, '2026-02-27 20:00:00', '2026-02-27 21:30:00', 'Room C'),
(90, 3, '2026-02-28 20:00:00', '2026-02-28 21:30:00', 'Room C'),
(91, 3, '2026-03-01 19:00:00', '2026-03-01 20:30:00', 'Room C'),
(92, 4, '2026-03-04 19:00:00', '2026-03-04 20:15:00', 'Room D'),
(93, 4, '2026-03-05 19:00:00', '2026-03-05 20:15:00', 'Room D'),
(94, 4, '2026-03-06 19:00:00', '2026-03-06 20:15:00', 'Room D'),
(95, 5, '2026-03-05 10:00:00', '2026-03-05 11:00:00', 'Room E'),
(96, 5, '2026-03-06 10:00:00', '2026-03-06 11:00:00', 'Room E'),
(97, 5, '2026-03-07 10:00:00', '2026-03-07 11:00:00', 'Room E'),
(98, 6, '2026-03-05 19:00:00', '2026-03-05 20:20:00', 'Room F'),
(99, 6, '2026-03-06 19:00:00', '2026-03-06 20:20:00', 'Room F'),
(100, 6, '2026-03-07 20:00:00', '2026-03-07 21:20:00', 'Room F'),
(101, 7, '2026-03-10 20:00:00', '2026-03-10 22:00:00', 'Room G'),
(102, 7, '2026-03-11 20:00:00', '2026-03-11 22:00:00', 'Room G'),
(103, 7, '2026-03-12 20:00:00', '2026-03-12 22:00:00', 'Room G'),
(104, 8, '2026-03-11 19:30:00', '2026-03-11 21:00:00', 'Room A'),
(105, 8, '2026-03-12 19:30:00', '2026-03-12 21:00:00', 'Room A'),
(106, 9, '2026-03-11 20:00:00', '2026-03-11 21:20:00', 'Room B'),
(107, 9, '2026-03-12 20:00:00', '2026-03-12 21:20:00', 'Room B'),
(108, 10, '2026-03-12 20:00:00', '2026-03-12 21:25:00', 'Room C'),
(109, 10, '2026-03-13 20:00:00', '2026-03-13 21:25:00', 'Room C'),
(110, 11, '2026-03-12 19:00:00', '2026-03-12 20:15:00', 'Room D'),
(111, 11, '2026-03-13 19:00:00', '2026-03-13 20:15:00', 'Room D'),
(112, 1, '2026-07-30 19:00:00', '2026-07-30 21:40:00', 'Room A'),
(113, 1, '2026-07-31 19:00:00', '2026-07-31 21:40:00', 'Room A'),
(114, 1, '2026-08-01 14:00:00', '2026-08-01 16:40:00', 'Room A'),
(115, 2, '2026-03-07 19:00:00', '2026-03-07 21:00:00', 'Room B'),
(116, 2, '2026-03-08 19:00:00', '2026-03-08 21:00:00', 'Room B'),
(117, 2, '2026-03-09 20:00:00', '2026-03-09 22:00:00', 'Room B'),
(118, 3, '2026-02-27 20:00:00', '2026-02-27 21:30:00', 'Room C'),
(119, 3, '2026-02-28 20:00:00', '2026-02-28 21:30:00', 'Room C'),
(120, 3, '2026-03-01 19:00:00', '2026-03-01 20:30:00', 'Room C'),
(121, 4, '2026-03-04 19:00:00', '2026-03-04 20:15:00', 'Room D'),
(122, 4, '2026-03-05 19:00:00', '2026-03-05 20:15:00', 'Room D'),
(123, 4, '2026-03-06 19:00:00', '2026-03-06 20:15:00', 'Room D'),
(124, 5, '2026-03-05 10:00:00', '2026-03-05 11:00:00', 'Room E'),
(125, 5, '2026-03-06 10:00:00', '2026-03-06 11:00:00', 'Room E'),
(126, 5, '2026-03-07 10:00:00', '2026-03-07 11:00:00', 'Room E'),
(127, 6, '2026-03-05 19:00:00', '2026-03-05 20:20:00', 'Room F'),
(128, 6, '2026-03-06 19:00:00', '2026-03-06 20:20:00', 'Room F'),
(129, 6, '2026-03-07 20:00:00', '2026-03-07 21:20:00', 'Room F'),
(130, 7, '2026-03-10 20:00:00', '2026-03-10 22:00:00', 'Room G'),
(131, 7, '2026-03-11 20:00:00', '2026-03-11 22:00:00', 'Room G'),
(132, 7, '2026-03-12 20:00:00', '2026-03-12 22:00:00', 'Room G'),
(133, 8, '2026-03-11 19:30:00', '2026-03-11 21:00:00', 'Room A'),
(134, 8, '2026-03-12 19:30:00', '2026-03-12 21:00:00', 'Room A'),
(135, 9, '2026-03-11 20:00:00', '2026-03-11 21:20:00', 'Room B'),
(136, 9, '2026-03-12 20:00:00', '2026-03-12 21:20:00', 'Room B'),
(137, 10, '2026-03-12 20:00:00', '2026-03-12 21:25:00', 'Room C'),
(138, 10, '2026-03-13 20:00:00', '2026-03-13 21:25:00', 'Room C'),
(139, 11, '2026-03-12 19:00:00', '2026-03-12 20:15:00', 'Room D'),
(140, 11, '2026-03-13 19:00:00', '2026-03-13 20:15:00', 'Room D'),
(141, 1, '2026-07-30 19:00:00', '2026-07-30 21:40:00', 'Room A'),
(142, 1, '2026-07-31 19:00:00', '2026-07-31 21:40:00', 'Room A'),
(143, 1, '2026-08-01 14:00:00', '2026-08-01 16:40:00', 'Room A'),
(144, 2, '2026-03-07 19:00:00', '2026-03-07 21:00:00', 'Room B'),
(145, 2, '2026-03-08 19:00:00', '2026-03-08 21:00:00', 'Room B'),
(146, 2, '2026-03-09 20:00:00', '2026-03-09 22:00:00', 'Room B'),
(147, 3, '2026-02-27 20:00:00', '2026-02-27 21:30:00', 'Room C'),
(148, 3, '2026-02-28 20:00:00', '2026-02-28 21:30:00', 'Room C'),
(149, 3, '2026-03-01 19:00:00', '2026-03-01 20:30:00', 'Room C'),
(150, 4, '2026-03-04 19:00:00', '2026-03-04 20:15:00', 'Room D'),
(151, 4, '2026-03-05 19:00:00', '2026-03-05 20:15:00', 'Room D'),
(152, 4, '2026-03-06 19:00:00', '2026-03-06 20:15:00', 'Room D'),
(153, 5, '2026-03-05 10:00:00', '2026-03-05 11:00:00', 'Room E'),
(154, 5, '2026-03-06 10:00:00', '2026-03-06 11:00:00', 'Room E'),
(155, 5, '2026-03-07 10:00:00', '2026-03-07 11:00:00', 'Room E'),
(156, 6, '2026-03-05 19:00:00', '2026-03-05 20:20:00', 'Room F'),
(157, 6, '2026-03-06 19:00:00', '2026-03-06 20:20:00', 'Room F'),
(158, 6, '2026-03-07 20:00:00', '2026-03-07 21:20:00', 'Room F'),
(159, 7, '2026-03-10 20:00:00', '2026-03-10 22:00:00', 'Room G'),
(160, 7, '2026-03-11 20:00:00', '2026-03-11 22:00:00', 'Room G'),
(161, 7, '2026-03-12 20:00:00', '2026-03-12 22:00:00', 'Room G'),
(162, 8, '2026-03-11 19:30:00', '2026-03-11 21:00:00', 'Room A'),
(163, 8, '2026-03-12 19:30:00', '2026-03-12 21:00:00', 'Room A'),
(164, 9, '2026-03-11 20:00:00', '2026-03-11 21:20:00', 'Room B'),
(165, 9, '2026-03-12 20:00:00', '2026-03-12 21:20:00', 'Room B'),
(166, 10, '2026-03-12 20:00:00', '2026-03-12 21:25:00', 'Room C'),
(167, 10, '2026-03-13 20:00:00', '2026-03-13 21:25:00', 'Room C'),
(168, 11, '2026-03-12 19:00:00', '2026-03-12 20:15:00', 'Room D'),
(169, 11, '2026-03-13 19:00:00', '2026-03-13 20:15:00', 'Room D'),
(170, 1, '2026-07-30 19:00:00', '2026-07-30 21:40:00', 'Room A'),
(171, 1, '2026-07-31 19:00:00', '2026-07-31 21:40:00', 'Room A'),
(172, 1, '2026-08-01 14:00:00', '2026-08-01 16:40:00', 'Room A'),
(173, 2, '2026-03-07 19:00:00', '2026-03-07 21:00:00', 'Room B'),
(174, 2, '2026-03-08 19:00:00', '2026-03-08 21:00:00', 'Room B'),
(175, 2, '2026-03-09 19:00:00', '2026-03-09 21:00:00', 'Room B'),
(176, 3, '2026-02-27 20:00:00', '2026-02-27 21:30:00', 'Room C'),
(177, 3, '2026-02-28 20:00:00', '2026-02-28 21:30:00', 'Room C'),
(178, 3, '2026-03-01 19:00:00', '2026-03-01 20:30:00', 'Room C'),
(179, 4, '2026-03-04 19:00:00', '2026-03-04 20:15:00', 'Room D'),
(180, 4, '2026-03-05 19:00:00', '2026-03-05 20:15:00', 'Room D'),
(181, 4, '2026-03-06 19:00:00', '2026-03-06 20:15:00', 'Room D'),
(182, 5, '2026-03-05 10:00:00', '2026-03-05 11:00:00', 'Room E'),
(183, 5, '2026-03-06 10:00:00', '2026-03-06 11:00:00', 'Room E'),
(184, 5, '2026-03-07 10:00:00', '2026-03-07 11:00:00', 'Room E'),
(185, 6, '2026-03-05 19:00:00', '2026-03-05 20:20:00', 'Room F'),
(186, 6, '2026-03-06 19:00:00', '2026-03-06 20:20:00', 'Room F'),
(187, 6, '2026-03-07 19:00:00', '2026-03-07 20:20:00', 'Room F'),
(188, 7, '2026-03-10 20:00:00', '2026-03-10 22:00:00', 'Room G'),
(189, 7, '2026-03-11 20:00:00', '2026-03-11 22:00:00', 'Room G'),
(190, 7, '2026-03-12 20:00:00', '2026-03-12 22:00:00', 'Room G'),
(191, 8, '2026-03-11 19:30:00', '2026-03-11 21:00:00', 'Room A'),
(192, 8, '2026-03-12 19:30:00', '2026-03-12 21:00:00', 'Room A'),
(193, 9, '2026-03-11 20:00:00', '2026-03-11 21:20:00', 'Room B'),
(194, 9, '2026-03-12 20:00:00', '2026-03-12 21:20:00', 'Room B'),
(195, 10, '2026-03-12 20:00:00', '2026-03-12 21:25:00', 'Room C'),
(196, 10, '2026-03-13 20:00:00', '2026-03-13 21:25:00', 'Room C'),
(197, 11, '2026-03-12 19:00:00', '2026-03-12 20:15:00', 'Room D'),
(198, 11, '2026-03-13 19:00:00', '2026-03-13 20:15:00', 'Room D');

-- --------------------------------------------------------

--
-- Table structure for table `shows`
--

CREATE TABLE `shows` (
  `title_fr` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `duration` int(11) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `language` varchar(255) NOT NULL,
  `cast` varchar(255) NOT NULL,
  `show_type` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `description` text NOT NULL,
  `description_fr` text NOT NULL,
  `show_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shows`
--

INSERT INTO `shows` (`title_fr`, `title`, `duration`, `genre`, `language`, `cast`, `show_type`, `is_active`, `description`, `description_fr`, `show_id`) VALUES
('Évangéline – The Musical', 'Evangeline – The Musical', 160, 'Musical Theatre', 'Français', 'Maude Cyr-Deschênes, Olivier Dion, Matthieu Lévesque, Nathalie Simard, Océane Kitura Bohémier-Tootoo, Laurent Lucas', 'Show', 1, 'A sweeping historical musical with a modern twist about love and resilience.', 'Une comédie musicale historique grandiose racontant l’amour et la résilience.', 1),
('AnesthesiA | Hommage à Metallica symphonique', 'AnesthesiA | Symphonic Tribute to Metallica', 120, 'Musique Rock', 'Français', 'AnesthesiA', 'Concert', 1, 'A symphonic tribute blending Metallica’s legendary music with orchestral arrangements.', 'Concert symphonique rendant hommage à Metallica avec des arrangements orchestraux.', 2),
('(LA)HORDE | Ballet national de Marseille | Age of Content', '(LA)HORDE | National Ballet of Marseille | Age of Content', 90, 'Danse contemporaine', 'Français', '(LA)HORDE', 'Danse', 1, 'An innovative contemporary dance performance exploring human connection and society.', 'Spectacle de danse contemporaine innovant explorant la connexion humaine et la société.', 3),
('Tupqan | Nos territoires intérieurs', 'Tupqan | Our Inner Territories', 75, 'Théâtre de création', 'Français', 'Tupqan', 'Théâtre', 1, 'A thought-provoking theatre creation delving into personal and collective identity.', 'Création théâtrale réfléchie explorant l’identité personnelle et collective.', 4),
('Pinocchio', 'Pinocchio', 60, 'Théâtre de marionnettes', 'Français', 'Place des Arts junior', 'Concert', 1, 'A charming puppet theatre performance perfect for young audiences.', 'Spectacle de marionnettes charmant, parfait pour les jeunes publics.', 5),
('Tango After Dark', 'Tango After Dark', 80, 'Danse • Tango', 'Français', 'Tango After Dark', 'Danse', 1, 'A passionate tango dance show showcasing elegance and rhythm.', 'Spectacle de tango passionné mettant en valeur l’élégance et le rythme.', 6),
('The Rock Orchestra', 'The Rock Orchestra', 110, 'Musique Rock • métal', 'Français', 'The Rock Orchestra', 'Concert', 1, 'A thrilling rock and metal concert performed by a full orchestra.', 'Concert rock et métal palpitant interprété par un orchestre complet.', 7),
('De Bartók à Mozart : flûte, improvisation et symphonie', 'From Bartók to Mozart: Flute, Improvisation and Symphony', 90, 'Musique classique', 'Français', 'Orchestre symphonique de Montréal', 'Concert', 1, 'A classical music concert featuring works by Bartók and Mozart with flute solos and improvisation.', 'Concert de musique classique présentant Bartók et Mozart avec solos de flûte et improvisation.', 8),
('Julia Mirzoev & Felix Hong', 'Julia Mirzoev & Felix Hong', 80, 'Musique classique • de chambre • violon et piano', 'Français', 'Julia Mirzoev & Felix Hong', 'Concert', 1, 'A refined chamber music performance for violin and piano enthusiasts.', 'Concert de musique de chambre raffiné pour les amateurs de violon et piano.', 9),
('One More Time | Hommage électro-symphonique à Daft Punk', 'One More Time | Electro-Symphonic Tribute to Daft Punk', 85, 'Musique classique', 'Français', 'One More Time', 'Concert', 1, 'An electrifying electro-symphonic tribute to Daft Punk’s iconic music.', 'Hommage électro-symphonique électrisant à la musique emblématique de Daft Punk.', 10),
('Émile Proulx-Cloutier | Ma main au feu - solo', 'Émile Proulx-Cloutier | My Hand in the Fire – Solo', 75, 'Chanson francophone', 'Français', 'Émile Proulx-Cloutier', 'Concert', 1, 'A compelling solo performance by Émile Proulx-Cloutier combining music and storytelling.', 'Performance solo captivante d’Émile Proulx-Cloutier mêlant musique et narration.', 11),
('Les Misérables en concert', 'Les Misérables in Concert', 150, 'Musical Theatre', 'Français', 'Orchestre symphonique de Montréal', 'Concert', 1, 'A powerful concert version of the famous musical Les Misérables performed with a full orchestra.', 'Version concert du célèbre musical Les Misérables interprétée avec un orchestre complet.', 22),
('Festival Jazz de Montréal : Soirée spéciale', 'Montreal Jazz Festival: Special Night', 120, 'Jazz', 'English', 'Divers artistes invités', 'Concert', 1, 'A special evening celebrating jazz music with internationally renowned artists.', 'Une soirée spéciale célébrant le jazz avec des artistes de renommée internationale.', 23),
('Ballet des saisons', 'Ballet of the Seasons', 100, 'Contemporary Dance', 'Français', 'Compagnie de danse de Montréal', 'Danse', 1, 'A beautiful dance performance inspired by the four seasons.', 'Un magnifique spectacle de danse inspiré des quatre saisons.', 25),
('Soirée humour Québécois', 'Quebec Comedy Night', 95, 'Comedy', 'Français', 'Humoristes invités', 'Show', 1, 'A night of stand-up comedy featuring popular Quebec comedians.', 'Une soirée d’humour mettant en vedette des humoristes québécois populaires.', 26),
('Rock Symphonique Montréal', 'Symphonic Rock Montreal', 110, 'Rock', 'English', 'Orchestre Rock Montréal', 'Concert', 1, 'A symphonic orchestra performs legendary rock classics.', 'Un orchestre symphonique interprète des classiques légendaires du rock.', 27),
('Le Fantôme de l’Opéra', 'The Phantom of the Opera', 145, 'Musical Theatre', 'English', 'Compagnie théâtrale internationale', 'Show', 1, 'A spectacular musical telling the mysterious story of the Phantom.', 'Une comédie musicale spectaculaire racontant l’histoire mystérieuse du Fantôme.', 28);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `ticket_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_used` tinyint(2) NOT NULL,
  `price` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_successful` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `rating` tinyint(4) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `address` varchar(500) NOT NULL,
  `email` varchar(500) NOT NULL,
  `phone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posters`
--
ALTER TABLE `posters`
  ADD PRIMARY KEY (`poster_id`),
  ADD KEY `fk_poster_show_id` (`show_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `fk_reservation_ticket_id` (`ticket_id`),
  ADD KEY `fk_reservation_showing_id` (`showing_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD KEY `fk_review_show_id` (`show_id`),
  ADD KEY `fk_review_user_id` (`user_id`);

--
-- Indexes for table `showings`
--
ALTER TABLE `showings`
  ADD PRIMARY KEY (`showing_id`),
  ADD KEY `fk_showing_show_id` (`show_id`);

--
-- Indexes for table `shows`
--
ALTER TABLE `shows`
  ADD PRIMARY KEY (`show_id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `fk_tickets_transaction_id` (`transaction_id`),
  ADD KEY `fk_tickets_user_id` (`user_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `fk_transactions_users` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `unique_email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posters`
--
ALTER TABLE `posters`
  MODIFY `poster_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `showings`
--
ALTER TABLE `showings`
  MODIFY `showing_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=199;

--
-- AUTO_INCREMENT for table `shows`
--
ALTER TABLE `shows`
  MODIFY `show_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posters`
--
ALTER TABLE `posters`
  ADD CONSTRAINT `fk_poster_show_id` FOREIGN KEY (`show_id`) REFERENCES `shows` (`show_id`);

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `fk_reservation_showing_id` FOREIGN KEY (`showing_id`) REFERENCES `showings` (`showing_id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_review_show_id` FOREIGN KEY (`show_id`) REFERENCES `shows` (`show_id`),
  ADD CONSTRAINT `fk_review_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `showings`
--
ALTER TABLE `showings`
  ADD CONSTRAINT `fk_showing_show_id` FOREIGN KEY (`show_id`) REFERENCES `showings` (`showing_id`);

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `fk_tickets_transaction_id` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`),
  ADD CONSTRAINT `fk_tickets_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `fk_transactions_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
