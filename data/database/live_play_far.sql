-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 20, 2026 at 03:30 AM
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
  `is_primary` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posters`
--

INSERT INTO `posters` (`poster_id`, `show_id`, `poster_image`, `is_primary`) VALUES
(1, 1, 'data/images/evangeline/main.jpg', 1),
(2, 2, 'data/images/anesthesia/main.jpg', 1),
(3, 8, 'data/images/bankkok_mozart/main.jpg', 1),
(4, 11, 'data/images/emelie_proulx/main.jpg', 1),
(5, 3, 'data/images/La_Horde_Ballet/main.jpg', 1),
(6, 25, 'data/images/les_ballet/main.jpg', 1),
(7, 22, 'data/images/les_miserable/main.jpg', 1),
(8, 9, 'data/images/mizroew_hong/main.jpg', 1),
(9, 10, 'data/images/one_more_time/main.jpg', 1),
(10, 5, 'data/images/pinochio/main.jpg', 1),
(11, 26, 'data/images/quebec_comedie_night/main.jpg', 1),
(12, 7, 'data/images/Rock_Orchestra/main.jpg', 1),
(13, 27, 'data/images/symphonic_rock_montreal/main.jpg', 1),
(14, 6, 'data/images/tango_after_dark/main.jpg', 1),
(15, 28, 'data/images/the_phantom_of_the_opera/main.jpg', 1),
(16, 4, 'data/images/tupqan/main.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `showing_id` int(11) NOT NULL,
  `seat_id` int(11) NOT NULL,
  `price` decimal(8,2) NOT NULL DEFAULT 0.00 COMMENT 'Price paid at time of booking'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reservation_id`, `transaction_id`, `showing_id`, `seat_id`, `price`) VALUES
(1, 1, 1, 1, 79.00),
(2, 1, 1, 2, 79.00),
(3, 2, 19, 13, 60.00),
(4, 2, 19, 14, 60.00),
(5, 3, 44, 25, 90.00),
(6, 3, 44, 26, 90.00),
(7, 4, 28, 3, 58.00),
(8, 4, 28, 4, 58.00),
(9, 5, 35, 15, 85.00),
(10, 6, 38, 27, 52.00),
(11, 6, 38, 28, 52.00),
(12, 7, 22, 5, 55.00),
(13, 8, 40, 16, 38.00),
(14, 8, 40, 17, 38.00);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `show_id` int(11) NOT NULL,
  `rating` tinyint(4) NOT NULL COMMENT '1 to 5',
  `comment` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `user_id`, `show_id`, `rating`, `comment`, `created_at`) VALUES
(1, 2, 1, 5, 'Absolutely breathtaking production. The performances and music were unforgettable.', '2026-05-10 19:45:00'),
(2, 2, 1, 4, 'Beautiful costumes and emotional storytelling. A little long but worth it.', '2026-05-11 20:12:00'),
(3, 2, 2, 5, 'The orchestra mixed perfectly with the metal arrangements. Incredible energy all night.', '2026-05-12 21:10:00'),
(4, 2, 2, 4, 'A unique tribute to Metallica with amazing symphonic sound.', '2026-05-12 21:35:00'),
(5, 2, 3, 4, 'Creative choreography and stunning visuals throughout the performance.', '2026-05-08 18:22:00'),
(6, 2, 3, 5, 'One of the most innovative dance productions I have seen this year.', '2026-05-08 19:01:00'),
(7, 2, 4, 4, 'Very thought-provoking and emotionally powerful theatre experience.', '2026-05-07 20:18:00'),
(8, 2, 4, 3, 'Interesting themes and performances, though some scenes felt slow.', '2026-05-07 20:55:00'),
(9, 2, 5, 5, 'Perfect for families. The puppets were adorable and the kids loved it.', '2026-05-06 11:22:00'),
(10, 2, 5, 4, 'Fun and charming adaptation of Pinocchio with excellent stage design.', '2026-05-06 11:48:00'),
(11, 2, 6, 5, 'The tango dancers had incredible chemistry and elegance.', '2026-05-09 22:14:00'),
(12, 2, 6, 4, 'Beautiful music and passionate performances from start to finish.', '2026-05-09 22:40:00'),
(13, 2, 7, 5, 'The Rock Orchestra delivered a powerful and cinematic experience.', '2026-05-13 23:05:00'),
(14, 2, 7, 4, 'Amazing blend of classical orchestration and rock classics.', '2026-05-13 23:30:00'),
(15, 2, 8, 5, 'The flute solos were mesmerizing and the orchestra sounded phenomenal.', '2026-05-14 21:00:00'),
(16, 2, 8, 4, 'Elegant and relaxing evening of classical music.', '2026-05-14 21:25:00'),
(17, 2, 9, 4, 'A very refined chamber music performance with excellent musicianship.', '2026-05-15 20:17:00'),
(18, 2, 9, 5, 'Julia Mirzoev and Felix Hong performed beautifully together.', '2026-05-15 20:50:00'),
(19, 2, 10, 5, 'This Daft Punk tribute was absolutely electric. The crowd loved it.', '2026-05-16 22:12:00'),
(20, 2, 10, 4, 'Fantastic visuals and orchestral arrangements of iconic songs.', '2026-05-16 22:45:00'),
(21, 2, 11, 5, 'Émile Proulx-Cloutier delivered an emotional and intimate performance.', '2026-05-17 20:30:00'),
(22, 2, 11, 4, 'Strong storytelling mixed with beautiful music.', '2026-05-17 20:58:00'),
(23, 2, 22, 5, 'Les Misérables in concert was absolutely stunning with the live orchestra.', '2026-05-18 22:10:00'),
(24, 2, 22, 5, 'Powerful vocals and emotional performances made this unforgettable.', '2026-05-18 22:42:00'),
(25, 2, 25, 4, 'The choreography captured each season beautifully.', '2026-05-10 21:08:00'),
(26, 2, 25, 5, 'A visually gorgeous ballet performance with incredible dancers.', '2026-05-10 21:40:00'),
(27, 2, 26, 5, 'Non-stop laughter from beginning to end. Great lineup of comedians.', '2026-05-11 22:00:00'),
(28, 2, 26, 4, 'Very entertaining comedy night with excellent audience interaction.', '2026-05-11 22:26:00'),
(29, 2, 27, 5, 'Symphonic Rock Montreal exceeded expectations. Amazing atmosphere.', '2026-05-12 23:18:00'),
(30, 2, 27, 4, 'Classic rock songs sounded incredible with a full orchestra.', '2026-05-12 23:44:00'),
(31, 2, 28, 5, 'The Phantom of the Opera was visually spectacular and emotionally gripping.', '2026-05-18 23:15:00'),
(32, 2, 28, 5, 'Outstanding vocals, costumes, and stage production. A must-see musical.', '2026-05-18 23:52:00'),
(33, 3, 1, 5, 'An emotional and beautifully staged musical. The cast performances were outstanding.', '2026-05-18 19:15:00'),
(34, 3, 7, 4, 'Loved hearing classic rock songs performed with orchestral arrangements.', '2026-05-18 21:20:00'),
(35, 3, 10, 5, 'The Daft Punk tribute had amazing energy and visuals throughout the show.', '2026-05-18 22:10:00'),
(36, 3, 22, 5, 'Les Misérables in concert was one of the best live performances I have attended.', '2026-05-18 22:55:00'),
(37, 3, 26, 4, 'Funny comedians and great crowd interaction made for a fun night.', '2026-05-18 23:30:00'),
(38, 4, 5, 5, 'My kids absolutely loved Pinocchio. Very fun and family-friendly performance.', '2026-05-17 11:05:00'),
(39, 4, 6, 4, 'Elegant dancing and passionate performances made this show memorable.', '2026-05-17 20:45:00'),
(40, 4, 8, 5, 'The orchestra sounded phenomenal and the flute solos were beautiful.', '2026-05-17 21:30:00'),
(41, 4, 25, 4, 'Beautiful choreography and creative stage presentation.', '2026-05-17 22:12:00'),
(42, 4, 28, 5, 'The Phantom of the Opera was absolutely breathtaking from start to finish.', '2026-05-18 23:40:00'),
(43, 1, 3, 2, 'The choreography was creative, but the pacing felt too slow at times.', '2026-05-15 20:10:00'),
(44, 1, 4, 3, 'Interesting themes, though some scenes were difficult to follow.', '2026-05-15 21:05:00'),
(45, 2, 8, 2, 'Talented musicians, but the performance felt a bit too long for my taste.', '2026-05-16 20:30:00'),
(46, 2, 26, 3, 'Some comedians were hilarious, but others did not really connect with the audience.', '2026-05-16 22:05:00'),
(47, 3, 10, 2, 'The visuals were impressive, but the sound mix was too loud during parts of the show.', '2026-05-17 22:40:00'),
(48, 3, 6, 3, 'The dancers were talented, but I expected more variety in the choreography.', '2026-05-17 20:55:00'),
(49, 4, 22, 2, 'Great orchestra, but the concert version lacked some of the emotional impact of the full production.', '2026-05-18 21:50:00'),
(50, 4, 7, 3, 'Good performance overall, though a few songs felt repetitive.', '2026-05-18 22:25:00');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `total_rows` int(11) NOT NULL COMMENT 'Number of rows (e.g. 5 → rows A–E)',
  `seats_per_row` int(11) NOT NULL COMMENT 'Seats per row'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `name`, `total_rows`, `seats_per_row`) VALUES
(1, 'Room A', 6, 12),
(2, 'Room B', 5, 10),
(3, 'Room C', 8, 15),
(4, 'Room D', 4, 8),
(5, 'Room E', 6, 12),
(6, 'Room F', 5, 10),
(7, 'Room G', 10, 20);

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `seat_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `row_label` char(1) NOT NULL COMMENT 'A, B, C, …',
  `seat_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`seat_id`, `room_id`, `row_label`, `seat_number`) VALUES
(1, 1, 'A', 1),
(2, 1, 'A', 2),
(3, 1, 'A', 3),
(4, 1, 'A', 4),
(5, 1, 'A', 5),
(6, 1, 'A', 6),
(7, 1, 'A', 7),
(8, 1, 'A', 8),
(9, 1, 'A', 9),
(10, 1, 'A', 10),
(11, 1, 'A', 11),
(12, 1, 'A', 12),
(13, 1, 'B', 1),
(14, 1, 'B', 2),
(15, 1, 'B', 3),
(16, 1, 'B', 4),
(17, 1, 'B', 5),
(18, 1, 'B', 6),
(19, 1, 'B', 7),
(20, 1, 'B', 8),
(21, 1, 'B', 9),
(22, 1, 'B', 10),
(23, 1, 'B', 11),
(24, 1, 'B', 12),
(25, 1, 'C', 1),
(26, 1, 'C', 2),
(27, 1, 'C', 3),
(28, 1, 'C', 4),
(29, 1, 'C', 5),
(30, 1, 'C', 6),
(31, 1, 'C', 7),
(32, 1, 'C', 8),
(33, 1, 'C', 9),
(34, 1, 'C', 10),
(35, 1, 'C', 11),
(36, 1, 'C', 12);

-- --------------------------------------------------------

--
-- Table structure for table `showings`
--

CREATE TABLE `showings` (
  `showing_id` int(11) NOT NULL,
  `show_id` int(11) NOT NULL,
  `room` varchar(50) NOT NULL,
  `total_rows` tinyint(4) NOT NULL,
  `seats_per_row` tinyint(4) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `base_price` decimal(8,2) NOT NULL DEFAULT 0.00 COMMENT 'Default ticket price for this showing'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `showings`
--

INSERT INTO `showings` (`showing_id`, `show_id`, `room`, `total_rows`, `seats_per_row`, `start_time`, `end_time`, `base_price`) VALUES
(1, 1, 'Room G', 10, 20, '2026-07-30 19:00:00', '2026-07-30 21:40:00', 79.00),
(2, 1, 'Room G', 10, 20, '2026-07-31 19:00:00', '2026-07-31 21:40:00', 79.00),
(3, 1, 'Room G', 10, 20, '2026-08-01 14:00:00', '2026-08-01 16:40:00', 65.00),
(4, 2, 'Room C', 8, 15, '2026-03-07 19:00:00', '2026-03-07 21:00:00', 55.00),
(5, 2, 'Room C', 8, 15, '2026-03-08 19:00:00', '2026-03-08 21:00:00', 55.00),
(6, 2, 'Room C', 8, 15, '2026-03-09 20:00:00', '2026-03-09 22:00:00', 55.00),
(7, 3, 'Room C', 8, 15, '2026-02-27 20:00:00', '2026-02-27 21:30:00', 50.00),
(8, 3, 'Room C', 8, 15, '2026-02-28 20:00:00', '2026-02-28 21:30:00', 50.00),
(9, 3, 'Room C', 8, 15, '2026-03-01 19:00:00', '2026-03-01 20:30:00', 50.00),
(10, 4, 'Room D', 4, 8, '2026-03-04 19:00:00', '2026-03-04 20:15:00', 35.00),
(11, 4, 'Room D', 4, 8, '2026-03-05 19:00:00', '2026-03-05 20:15:00', 35.00),
(12, 4, 'Room D', 4, 8, '2026-03-06 19:00:00', '2026-03-06 20:15:00', 35.00),
(13, 5, 'Room B', 5, 10, '2026-03-05 10:00:00', '2026-03-05 11:00:00', 20.00),
(14, 5, 'Room B', 5, 10, '2026-03-06 10:00:00', '2026-03-06 11:00:00', 20.00),
(15, 5, 'Room B', 5, 10, '2026-03-07 10:00:00', '2026-03-07 11:00:00', 20.00),
(16, 6, 'Room A', 6, 12, '2026-03-05 19:00:00', '2026-03-05 20:20:00', 45.00),
(17, 6, 'Room A', 6, 12, '2026-03-06 19:00:00', '2026-03-06 20:20:00', 45.00),
(18, 6, 'Room A', 6, 12, '2026-03-07 20:00:00', '2026-03-07 21:20:00', 45.00),
(19, 7, 'Room G', 10, 20, '2026-03-10 20:00:00', '2026-03-10 22:00:00', 60.00),
(20, 7, 'Room G', 10, 20, '2026-03-11 20:00:00', '2026-03-11 22:00:00', 60.00),
(21, 7, 'Room G', 10, 20, '2026-03-12 20:00:00', '2026-03-12 22:00:00', 60.00),
(22, 8, 'Room A', 6, 12, '2026-03-11 19:30:00', '2026-03-11 21:00:00', 55.00),
(23, 8, 'Room A', 6, 12, '2026-03-12 19:30:00', '2026-03-12 21:00:00', 55.00),
(24, 8, 'Room A', 6, 12, '2026-03-13 19:30:00', '2026-03-13 21:00:00', 55.00),
(25, 9, 'Room B', 5, 10, '2026-03-11 20:00:00', '2026-03-11 21:20:00', 40.00),
(26, 9, 'Room B', 5, 10, '2026-03-12 20:00:00', '2026-03-12 21:20:00', 40.00),
(27, 9, 'Room B', 5, 10, '2026-03-13 20:00:00', '2026-03-13 21:20:00', 40.00),
(28, 10, 'Room C', 8, 15, '2026-03-12 20:00:00', '2026-03-12 21:25:00', 58.00),
(29, 10, 'Room C', 8, 15, '2026-03-13 20:00:00', '2026-03-13 21:25:00', 58.00),
(30, 10, 'Room C', 8, 15, '2026-03-14 20:00:00', '2026-03-14 21:25:00', 58.00),
(31, 11, 'Room E', 6, 12, '2026-03-12 19:00:00', '2026-03-12 20:15:00', 42.00),
(32, 11, 'Room E', 6, 12, '2026-03-20 19:00:00', '2026-03-20 20:15:00', 42.00),
(33, 11, 'Room E', 6, 12, '2026-03-21 19:00:00', '2026-03-21 20:15:00', 42.00),
(34, 22, 'Room G', 10, 20, '2026-04-01 19:00:00', '2026-04-01 21:30:00', 85.00),
(35, 22, 'Room G', 10, 20, '2026-04-02 19:00:00', '2026-04-02 21:30:00', 85.00),
(38, 25, 'Room C', 8, 15, '2026-04-10 20:00:00', '2026-04-10 21:30:00', 52.00),
(39, 25, 'Room C', 8, 15, '2026-04-11 20:00:00', '2026-04-11 21:30:00', 52.00),
(40, 26, 'Room E', 6, 12, '2026-05-05 19:30:00', '2026-05-05 21:10:00', 38.00),
(41, 26, 'Room E', 6, 12, '2026-05-06 19:30:00', '2026-05-06 21:10:00', 38.00),
(42, 27, 'Room G', 10, 20, '2026-04-20 20:00:00', '2026-04-20 21:35:00', 62.00),
(43, 27, 'Room G', 10, 20, '2026-04-21 20:00:00', '2026-04-21 21:35:00', 62.00),
(44, 28, 'Room G', 10, 20, '2026-05-12 20:00:00', '2026-05-12 21:50:00', 90.00),
(45, 28, 'Room G', 10, 20, '2026-05-13 20:00:00', '2026-05-13 21:50:00', 90.00);

-- --------------------------------------------------------

--
-- Table structure for table `shows`
--

CREATE TABLE `shows` (
  `show_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `title_fr` varchar(255) NOT NULL,
  `duration` int(11) NOT NULL COMMENT 'Duration in minutes',
  `genre` varchar(100) NOT NULL,
  `language` varchar(50) NOT NULL,
  `cast` varchar(500) NOT NULL,
  `show_type` varchar(100) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `description` text NOT NULL,
  `description_fr` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shows`
--

INSERT INTO `shows` (`show_id`, `title`, `title_fr`, `duration`, `genre`, `language`, `cast`, `show_type`, `is_active`, `description`, `description_fr`) VALUES
(1, 'Evangeline – The Musical', 'Évangéline – The Musical', 160, 'Musical Theatre', 'Français', 'Maude Cyr-Deschênes, Olivier Dion, Matthieu Lévesque, Nathalie Simard', 'Show', 1, 'A sweeping historical musical about love and resilience.', 'Une comédie musicale historique sur l\'amour et la résilience.'),
(2, 'AnesthesiA | Symphonic Tribute to Metallica', 'AnesthesiA | Hommage à Metallica symphonique', 120, 'Rock Music', 'Français', 'AnesthesiA', 'Concert', 1, 'Metallica\'s legendary music blended with orchestral arrangements.', 'La musique légendaire de Metallica avec des arrangements orchestraux.'),
(3, '(LA)HORDE | Age of Content', '(LA)HORDE | Age of Content', 90, 'Contemporary Dance', 'Français', '(LA)HORDE | Ballet national de Marseille', 'Danse', 1, 'Innovative contemporary dance exploring human connection and society.', 'Danse contemporaine innovante explorant la connexion humaine et la société.'),
(4, 'Tupqan | Our Inner Territories', 'Tupqan | Nos territoires intérieurs', 75, 'Théâtre de création', 'Français', 'Tupqan', 'Théâtre', 1, 'A thought-provoking theatre piece on personal and collective identity.', 'Création théâtrale sur l\'identité personnelle et collective.'),
(5, 'Pinocchio', 'Pinocchio', 60, 'Puppet Theatre', 'Français', 'Place des Arts junior', 'Show', 1, 'A charming puppet theatre performance perfect for young audiences.', 'Spectacle de marionnettes charmant pour les jeunes publics.'),
(6, 'Tango After Dark', 'Tango After Dark', 80, 'Dance – Tango', 'Français', 'Tango After Dark', 'Danse', 1, 'A passionate tango show showcasing elegance and rhythm.', 'Spectacle de tango passionné mettant en valeur l\'élégance et le rythme.'),
(7, 'The Rock Orchestra', 'The Rock Orchestra', 110, 'Rock Music', 'Français', 'The Rock Orchestra', 'Concert', 1, 'A thrilling rock and metal concert performed by a full orchestra.', 'Concert rock et métal interprété par un orchestre complet.'),
(8, 'From Bartók to Mozart', 'De Bartók à Mozart : flûte, improvisation et symphonie', 90, 'Classical Music', 'Français', 'Orchestre symphonique de Montréal', 'Concert', 1, 'Classical works by Bartók and Mozart with flute solos and improvisation.', 'Œuvres de Bartók et Mozart avec solos de flûte et improvisation.'),
(9, 'Julia Mirzoev & Felix Hong', 'Julia Mirzoev & Felix Hong', 80, 'Chamber Music', 'Français', 'Julia Mirzoev & Felix Hong', 'Concert', 1, 'A refined chamber music performance for violin and piano.', 'Concert de musique de chambre pour violon et piano.'),
(10, 'One More Time | Electro-Symphonic Tribute to Daft Punk', 'One More Time | Hommage électro-symphonique à Daft Punk', 85, 'Electro-Symphonic', 'Français', 'One More Time', 'Concert', 1, 'An electrifying symphonic tribute to Daft Punk\'s iconic music.', 'Hommage électro-symphonique à la musique emblématique de Daft Punk.'),
(11, 'Émile Proulx-Cloutier | My Hand in the Fire', 'Émile Proulx-Cloutier | Ma main au feu – solo', 75, 'Chanson francophone', 'Français', 'Émile Proulx-Cloutier', 'Concert', 1, 'A compelling solo performance combining music and storytelling.', 'Performance solo mêlant musique et narration.'),
(22, 'Les Misérables in Concert', 'Les Misérables en concert', 150, 'Musical Theatre', 'Français', 'Orchestre symphonique de Montréal', 'Concert', 1, 'A powerful concert version of Les Misérables with a full orchestra.', 'Version concert des Misérables avec un orchestre complet.'),
(25, 'Ballet of the Seasons', 'Ballet des saisons', 100, 'Contemporary Dance', 'Français', 'Compagnie de danse de Montréal', 'Danse', 1, 'A beautiful dance performance inspired by the four seasons.', 'Spectacle de danse inspiré des quatre saisons.'),
(26, 'Quebec Comedy Night', 'Soirée humour Québécois', 95, 'Comedy', 'Français', 'Humoristes invités', 'Show', 1, 'Stand-up comedy featuring popular Quebec comedians.', 'Soirée d\'humour avec des humoristes québécois populaires.'),
(27, 'Symphonic Rock Montreal', 'Rock Symphonique Montréal', 110, 'Rock', 'English', 'Orchestre Rock Montréal', 'Concert', 1, 'A symphonic orchestra performs legendary rock classics.', 'Un orchestre symphonique interprète des classiques du rock.'),
(28, 'The Phantom of the Opera', 'Le Fantôme de l\'Opéra', 145, 'Musical Theatre', 'English', 'Compagnie théâtrale internationale', 'Show', 1, 'A spectacular musical telling the mysterious story of the Phantom.', 'Comédie musicale sur l\'histoire mystérieuse du Fantôme.');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('pending','completed','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'completed', '2026-05-10 18:30:00', '2026-05-10 18:35:00'),
(2, 3, 'completed', '2026-05-11 19:10:00', '2026-05-11 19:12:00'),
(3, 4, 'completed', '2026-05-12 17:45:00', '2026-05-12 17:50:00'),
(4, 2, 'completed', '2026-05-13 20:15:00', '2026-05-13 20:18:00'),
(5, 3, 'pending', '2026-05-14 14:20:00', '2026-05-14 14:20:00'),
(6, 4, 'completed', '2026-05-15 18:05:00', '2026-05-15 18:10:00'),
(7, 2, 'cancelled', '2026-05-16 16:40:00', '2026-05-16 17:00:00'),
(8, 3, 'completed', '2026-05-17 19:30:00', '2026-05-17 19:34:00');

-- --------------------------------------------------------

--
-- Table structure for table `trusted_devices`
--

CREATE TABLE `trusted_devices` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `device_token` varchar(255) NOT NULL,
  `device_name` varchar(100) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT current_timestamp(),
  `expires_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trusted_devices`
--

INSERT INTO `trusted_devices` (`id`, `user_id`, `device_token`, `device_name`, `user_agent`, `ip_address`, `last_used_at`, `expires_at`, `created_at`) VALUES
(1, 1, '6cedba0b1e2a84a44838edd9faa07654e7c3a50898d6192a4f116838457ce108', 'Windows PC', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '::1', '2026-05-20 03:20:41', '2026-06-19 02:40:41', '2026-05-20 02:40:41');

-- --------------------------------------------------------

--
-- Table structure for table `two_factor_auth`
--

CREATE TABLE `two_factor_auth` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `secret` varchar(255) NOT NULL,
  `enabled` tinyint(1) DEFAULT 0,
  `enabled_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `two_factor_auth`
--

INSERT INTO `two_factor_auth` (`id`, `user_id`, `secret`, `enabled`, `enabled_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'BO7IXSXTZMWRHRBAH55RXQXCKDF4G7BV', 1, '2026-05-20 03:08:50', '2026-05-20 02:40:20', '2026-05-20 03:08:50');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','customer') DEFAULT 'customer',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password_hash`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Farwah', 'Bakhsh', 'farwah123', 'kirk@gmail.com', '$2y$12$CDZC5McRPPLAYOl3p39PfeXaZFFajEUNTUKgezoK1OFbbRRLZthmu', 'admin', '2026-05-17 18:03:39', '2026-05-18 17:29:38'),
(2, 'Vic', 'Fuentes', 'piercetheveil', 'ptv@email.com', '$2y$12$U0H/uBTmjWp804cnentlmeQp2nntdzo9I6LkzcdHXgnmvJMlBQojG', 'customer', '2026-05-18 17:30:33', '2026-05-18 17:30:33'),
(3, 'Tony', 'Perry', 'tonyperry', 'tony@email.com', '$2y$12$BnJcpWGVxkNKxx7kf6sa0OFyNPvOpXV/yB6z7Q6nBR/wRZdRMQgLm', 'customer', '2026-05-18 21:54:37', '2026-05-18 21:54:37'),
(4, 'Jaime', 'Preciado', 'jaimepreciado', 'jaime@email.com', '$2y$12$rB5gt9n6hIpbDDQcByA5zOFUFkR/UyCQ6FHO3PFL79cVVMQSXJABy', 'customer', '2026-05-18 21:55:35', '2026-05-18 21:55:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `trusted_devices`
--
ALTER TABLE `trusted_devices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `device_token` (`device_token`),
  ADD KEY `idx_device_token` (`device_token`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `two_factor_auth`
--
ALTER TABLE `two_factor_auth`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `trusted_devices`
--
ALTER TABLE `trusted_devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `two_factor_auth`
--
ALTER TABLE `two_factor_auth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `trusted_devices`
--
ALTER TABLE `trusted_devices`
  ADD CONSTRAINT `trusted_devices_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `two_factor_auth`
--
ALTER TABLE `two_factor_auth`
  ADD CONSTRAINT `two_factor_auth_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
