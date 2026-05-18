-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 16, 2026 at 10:48 PM
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
(16, 4, 'data/images/tupqan/main.jpg', 1),
(17, 23, 'data/images/jazz_festival/main.jpg', 1);

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
(36, 23, 'Room G', 10, 20, '2026-06-28 20:00:00', '2026-06-28 22:00:00', 70.00),
(37, 23, 'Room G', 10, 20, '2026-06-29 20:00:00', '2026-06-29 22:00:00', 70.00),
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
(23, 'Montreal Jazz Festival: Special Night', 'Festival Jazz de Montréal : Soirée spéciale', 120, 'Jazz', 'English', 'Various invited artists', 'Concert', 1, 'A special evening celebrating jazz with internationally renowned artists.', 'Une soirée jazz avec des artistes de renommée internationale.'),
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

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_available_seats`
-- See below for the actual view
--
CREATE TABLE `v_available_seats` (
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_booking_summary`
-- (See below for the actual view)
--
CREATE TABLE `v_booking_summary` (
);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posters`
--
ALTER TABLE `posters`
  ADD PRIMARY KEY (`poster_id`),
  ADD KEY `fk_posters_show_id` (`show_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`),
  ADD UNIQUE KEY `uq_reservation_seat` (`showing_id`,`seat_id`),
  ADD KEY `fk_reservations_transaction_id` (`transaction_id`),
  ADD KEY `fk_reservations_seat_id` (`seat_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD UNIQUE KEY `uq_review_user_show` (`user_id`,`show_id`),
  ADD KEY `fk_reviews_show_id` (`show_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`),
  ADD UNIQUE KEY `uq_room_name` (`name`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`seat_id`),
  ADD UNIQUE KEY `uq_seat_position` (`room_id`,`row_label`,`seat_number`),
  ADD KEY `fk_seats_room_id` (`room_id`);

--
-- Indexes for table `showings`
--
ALTER TABLE `showings`
  ADD PRIMARY KEY (`showing_id`),
  ADD KEY `fk_showings_show_id` (`show_id`);

--
-- Indexes for table `shows`
--
ALTER TABLE `shows`
  ADD PRIMARY KEY (`show_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `fk_transactions_user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `uq_users_email` (`email`),
  ADD UNIQUE KEY `uq_users_phone` (`phone`);

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
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `seat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=597;

--
-- AUTO_INCREMENT for table `showings`
--
ALTER TABLE `showings`
  MODIFY `showing_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `shows`
--
ALTER TABLE `shows`
  MODIFY `show_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------

--
-- Structure for view `v_available_seats`
--
DROP TABLE IF EXISTS `v_available_seats`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`::1` SQL SECURITY DEFINER VIEW `v_available_seats`  AS SELECT `sh`.`showing_id` AS `showing_id`, `s`.`seat_id` AS `seat_id`, `s`.`room_id` AS `room_id`, `s`.`row_label` AS `row_label`, `s`.`seat_number` AS `seat_number`, `sh`.`base_price` AS `base_price` FROM (`showings` `sh` join `seats` `s` on(`s`.`room_id` = `sh`.`room_id`)) WHERE !(`s`.`seat_id` in (select `r`.`seat_id` from (`reservations` `r` join `transactions` `t` on(`t`.`transaction_id` = `r`.`transaction_id`)) where `r`.`showing_id` = `sh`.`showing_id` AND `t`.`status` = 'completed')) ;

-- --------------------------------------------------------

--
-- Structure for view `v_booking_summary`
--
DROP TABLE IF EXISTS `v_booking_summary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`::1` SQL SECURITY DEFINER VIEW `v_booking_summary`  AS SELECT `t`.`transaction_id` AS `transaction_id`, `t`.`status` AS `transaction_status`, `t`.`created_at` AS `booked_at`, `u`.`user_id` AS `user_id`, concat(`u`.`first_name`,' ',`u`.`last_name`) AS `customer_name`, `u`.`email` AS `email`, `sh`.`show_id` AS `show_id`, `sh`.`title` AS `show_title`, `sg`.`start_time` AS `start_time`, `sg`.`end_time` AS `end_time`, `rm`.`name` AS `room_name`, `s`.`row_label` AS `row_label`, `s`.`seat_number` AS `seat_number`, `r`.`price` AS `seat_price` FROM ((((((`transactions` `t` join `users` `u` on(`u`.`user_id` = `t`.`user_id`)) join `reservations` `r` on(`r`.`transaction_id` = `t`.`transaction_id`)) join `showings` `sg` on(`sg`.`showing_id` = `r`.`showing_id`)) join `shows` `sh` on(`sh`.`show_id` = `sg`.`show_id`)) join `rooms` `rm` on(`rm`.`room_id` = `sg`.`room_id`)) join `seats` `s` on(`s`.`seat_id` = `r`.`seat_id`)) ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posters`
--
ALTER TABLE `posters`
  ADD CONSTRAINT `fk_posters_show_id` FOREIGN KEY (`show_id`) REFERENCES `shows` (`show_id`);

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `fk_reservations_seat_id` FOREIGN KEY (`seat_id`) REFERENCES `seats` (`seat_id`),
  ADD CONSTRAINT `fk_reservations_showing_id` FOREIGN KEY (`showing_id`) REFERENCES `showings` (`showing_id`),
  ADD CONSTRAINT `fk_reservations_transaction_id` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_reviews_show_id` FOREIGN KEY (`show_id`) REFERENCES `shows` (`show_id`),
  ADD CONSTRAINT `fk_reviews_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `seats`
--
ALTER TABLE `seats`
  ADD CONSTRAINT `fk_seats_room_id` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`);

--
-- Constraints for table `showings`
--
ALTER TABLE `showings`
  ADD CONSTRAINT `fk_showings_show_id` FOREIGN KEY (`show_id`) REFERENCES `shows` (`show_id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `fk_transactions_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
