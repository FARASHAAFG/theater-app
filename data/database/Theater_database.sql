-- phpMyAdmin SQL Dump (FIXED VERSION)
-- Database: `live_play`

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
SET FOREIGN_KEY_CHECKS = 0;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- ============================================================
-- Drop tables in correct order (children first, parent last)
-- ============================================================
DROP TABLE IF EXISTS `reservations`;
DROP TABLE IF EXISTS `reviews`;
DROP TABLE IF EXISTS `showings`;
DROP TABLE IF EXISTS `posters`;
DROP TABLE IF EXISTS `tickets`;
DROP TABLE IF EXISTS `transactions`;
DROP TABLE IF EXISTS `shows`;
DROP TABLE IF EXISTS `users`;

-- ============================================================
-- Table: users
-- ============================================================
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `rating` tinyint(4) NOT NULL DEFAULT 0,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `address` varchar(500) NOT NULL,
  `email` varchar(500) NOT NULL,
  `phone` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `unique_email` (`email`),
  UNIQUE KEY `unique_phone` (`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: shows
-- ============================================================
CREATE TABLE `shows` (
  `show_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `title_fr` varchar(255) NOT NULL,
  `duration` int(11) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `language` varchar(255) NOT NULL,
  `cast` varchar(255) NOT NULL,
  `show_type` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `description` text NOT NULL,
  `description_fr` text NOT NULL,
  PRIMARY KEY (`show_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: posters
-- ============================================================
CREATE TABLE `posters` (
  `poster_id` int(11) NOT NULL AUTO_INCREMENT,
  `show_id` int(11) NOT NULL,
  `poster_image` varchar(255) NOT NULL,
  `is_used` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`poster_id`),
  KEY `fk_poster_show_id` (`show_id`),
  CONSTRAINT `fk_poster_show_id` FOREIGN KEY (`show_id`) REFERENCES `shows` (`show_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: showings
-- FIX: Was referencing showings(showing_id) instead of shows(show_id)
-- ============================================================
CREATE TABLE `showings` (
  `showing_id` int(11) NOT NULL AUTO_INCREMENT,
  `show_id` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `room` varchar(50) NOT NULL,
  PRIMARY KEY (`showing_id`),
  KEY `fk_showing_show_id` (`show_id`),
  CONSTRAINT `fk_showing_show_id` FOREIGN KEY (`show_id`) REFERENCES `shows` (`show_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: transactions
-- ============================================================
CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `is_successful` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`transaction_id`),
  KEY `fk_transactions_users` (`user_id`),
  CONSTRAINT `fk_transactions_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: tickets
-- ============================================================
CREATE TABLE `tickets` (
  `ticket_id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_used` tinyint(2) NOT NULL DEFAULT 0,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`ticket_id`),
  KEY `fk_tickets_transaction_id` (`transaction_id`),
  KEY `fk_tickets_user_id` (`user_id`),
  CONSTRAINT `fk_tickets_transaction_id` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`),
  CONSTRAINT `fk_tickets_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: reservations
-- ============================================================
CREATE TABLE `reservations` (
  `reservation_id` int(11) NOT NULL AUTO_INCREMENT,
  `seat_number` int(11) NOT NULL,
  `row_number` varchar(20) NOT NULL,
  `showing_id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `price` decimal(6,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`reservation_id`),
  KEY `fk_reservation_showing_id` (`showing_id`),
  KEY `fk_reservation_ticket_id` (`ticket_id`),
  CONSTRAINT `fk_reservation_showing_id` FOREIGN KEY (`showing_id`) REFERENCES `showings` (`showing_id`),
  CONSTRAINT `fk_reservation_ticket_id` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`ticket_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: reviews
-- FIX: Added missing PRIMARY KEY (review_id)
-- ============================================================
CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `show_id` int(11) NOT NULL,
  `rating` int(4) NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`review_id`),
  KEY `fk_review_show_id` (`show_id`),
  KEY `fk_review_user_id` (`user_id`),
  CONSTRAINT `fk_review_show_id` FOREIGN KEY (`show_id`) REFERENCES `shows` (`show_id`),
  CONSTRAINT `fk_review_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Data: shows
-- ============================================================
INSERT INTO `shows` (`show_id`, `title`, `title_fr`, `duration`, `genre`, `language`, `cast`, `show_type`, `is_active`, `description`, `description_fr`) VALUES
(1, 'Evangeline – The Musical', 'Évangéline – The Musical', 160, 'Musical Theatre', 'Français', 'Maude Cyr-Deschênes, Olivier Dion, Matthieu Lévesque, Nathalie Simard, Océane Kitura Bohémier-Tootoo, Laurent Lucas', 'Show', 1, 'A sweeping historical musical with a modern twist about love and resilience.', 'Une comédie musicale historique grandiose racontant l\'amour et la résilience.'),
(2, 'AnesthesiA | Symphonic Tribute to Metallica', 'AnesthesiA | Hommage à Metallica symphonique', 120, 'Musique Rock', 'Français', 'AnesthesiA', 'Concert', 1, 'A symphonic tribute blending Metallica\'s legendary music with orchestral arrangements.', 'Concert symphonique rendant hommage à Metallica avec des arrangements orchestraux.'),
(3, '(LA)HORDE | National Ballet of Marseille | Age of Content', '(LA)HORDE | Ballet national de Marseille | Age of Content', 90, 'Danse contemporaine', 'Français', '(LA)HORDE', 'Danse', 1, 'An innovative contemporary dance performance exploring human connection and society.', 'Spectacle de danse contemporaine innovant explorant la connexion humaine et la société.'),
(4, 'Tupqan | Our Inner Territories', 'Tupqan | Nos territoires intérieurs', 75, 'Théâtre de création', 'Français', 'Tupqan', 'Théâtre', 1, 'A thought-provoking theatre creation delving into personal and collective identity.', 'Création théâtrale réfléchie explorant l\'identité personnelle et collective.'),
(5, 'Pinocchio', 'Pinocchio', 60, 'Théâtre de marionnettes', 'Français', 'Place des Arts junior', 'Concert', 1, 'A charming puppet theatre performance perfect for young audiences.', 'Spectacle de marionnettes charmant, parfait pour les jeunes publics.'),
(6, 'Tango After Dark', 'Tango After Dark', 80, 'Danse • Tango', 'Français', 'Tango After Dark', 'Danse', 1, 'A passionate tango dance show showcasing elegance and rhythm.', 'Spectacle de tango passionné mettant en valeur l\'élégance et le rythme.'),
(7, 'The Rock Orchestra', 'The Rock Orchestra', 110, 'Musique Rock • métal', 'Français', 'The Rock Orchestra', 'Concert', 1, 'A thrilling rock and metal concert performed by a full orchestra.', 'Concert rock et métal palpitant interprété par un orchestre complet.'),
(8, 'From Bartók to Mozart: Flute, Improvisation and Symphony', 'De Bartók à Mozart : flûte, improvisation et symphonie', 90, 'Musique classique', 'Français', 'Orchestre symphonique de Montréal', 'Concert', 1, 'A classical music concert featuring works by Bartók and Mozart with flute solos and improvisation.', 'Concert de musique classique présentant Bartók et Mozart avec solos de flûte et improvisation.'),
(9, 'Julia Mirzoev & Felix Hong', 'Julia Mirzoev & Felix Hong', 80, 'Musique classique • de chambre • violon et piano', 'Français', 'Julia Mirzoev & Felix Hong', 'Concert', 1, 'A refined chamber music performance for violin and piano enthusiasts.', 'Concert de musique de chambre raffiné pour les amateurs de violon et piano.'),
(10, 'One More Time | Electro-Symphonic Tribute to Daft Punk', 'One More Time | Hommage électro-symphonique à Daft Punk', 85, 'Musique classique', 'Français', 'One More Time', 'Concert', 1, 'An electrifying electro-symphonic tribute to Daft Punk\'s iconic music.', 'Hommage électro-symphonique électrisant à la musique emblématique de Daft Punk.'),
(11, 'Émile Proulx-Cloutier | My Hand in the Fire – Solo', 'Émile Proulx-Cloutier | Ma main au feu - solo', 75, 'Chanson francophone', 'Français', 'Émile Proulx-Cloutier', 'Concert', 1, 'A compelling solo performance by Émile Proulx-Cloutier combining music and storytelling.', 'Performance solo captivante d\'Émile Proulx-Cloutier mêlant musique et narration.'),
(22, 'Les Misérables in Concert', 'Les Misérables en concert', 150, 'Musical Theatre', 'Français', 'Orchestre symphonique de Montréal', 'Concert', 1, 'A powerful concert version of the famous musical Les Misérables performed with a full orchestra.', 'Version concert du célèbre musical Les Misérables interprétée avec un orchestre complet.'),
(23, 'Montreal Jazz Festival: Special Night', 'Festival Jazz de Montréal : Soirée spéciale', 120, 'Jazz', 'English', 'Divers artistes invités', 'Concert', 1, 'A special evening celebrating jazz music with internationally renowned artists.', 'Une soirée spéciale célébrant le jazz avec des artistes de renommée internationale.'),
(25, 'Ballet of the Seasons', 'Ballet des saisons', 100, 'Contemporary Dance', 'Français', 'Compagnie de danse de Montréal', 'Danse', 1, 'A beautiful dance performance inspired by the four seasons.', 'Un magnifique spectacle de danse inspiré des quatre saisons.'),
(26, 'Quebec Comedy Night', 'Soirée humour Québécois', 95, 'Comedy', 'Français', 'Humoristes invités', 'Show', 1, 'A night of stand-up comedy featuring popular Quebec comedians.', 'Une soirée d\'humour mettant en vedette des humoristes québécois populaires.'),
(27, 'Symphonic Rock Montreal', 'Rock Symphonique Montréal', 110, 'Rock', 'English', 'Orchestre Rock Montréal', 'Concert', 1, 'A symphonic orchestra performs legendary rock classics.', 'Un orchestre symphonique interprète des classiques légendaires du rock.'),
(28, 'The Phantom of the Opera', 'Le Fantôme de l\'Opéra', 145, 'Musical Theatre', 'English', 'Compagnie théâtrale internationale', 'Show', 1, 'A spectacular musical telling the mysterious story of the Phantom.', 'Une comédie musicale spectaculaire racontant l\'histoire mystérieuse du Fantôme.');

-- ============================================================
-- Data: posters
-- ============================================================
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

-- ============================================================
-- Data: showings
-- FIX: Removed all duplicate rows, kept only unique entries
-- ============================================================
INSERT INTO `showings` (`showing_id`, `show_id`, `start_time`, `end_time`, `room`) VALUES
(1,  1,  '2026-07-30 19:00:00', '2026-07-30 21:40:00', 'Room A'),
(2,  2,  '2026-03-07 19:00:00', '2026-03-07 21:00:00', 'Room B'),
(3,  3,  '2026-02-27 20:00:00', '2026-02-27 21:30:00', 'Room C'),
(4,  4,  '2026-03-04 19:00:00', '2026-03-04 20:15:00', 'Room D'),
(5,  5,  '2026-03-05 10:00:00', '2026-03-05 11:00:00', 'Room E'),
(6,  6,  '2026-03-05 19:00:00', '2026-03-05 20:20:00', 'Room F'),
(7,  7,  '2026-03-10 20:00:00', '2026-03-10 22:00:00', 'Room G'),
(8,  8,  '2026-03-11 19:30:00', '2026-03-11 21:00:00', 'Room A'),
(9,  9,  '2026-03-11 20:00:00', '2026-03-11 21:20:00', 'Room B'),
(10, 10, '2026-03-12 20:00:00', '2026-03-12 21:25:00', 'Room C'),
(11, 11, '2026-03-12 19:00:00', '2026-03-12 20:15:00', 'Room D'),
(12, 1,  '2026-07-31 19:00:00', '2026-07-31 21:40:00', 'Room E'),
(13, 1,  '2026-08-01 14:00:00', '2026-08-01 16:40:00', 'Room F'),
(14, 2,  '2026-03-08 19:00:00', '2026-03-08 21:00:00', 'Room G'),
(15, 2,  '2026-03-09 20:00:00', '2026-03-09 22:00:00', 'Room A'),
(16, 3,  '2026-02-28 20:00:00', '2026-02-28 21:30:00', 'Room B'),
(17, 3,  '2026-03-01 19:00:00', '2026-03-01 20:30:00', 'Room C'),
(18, 4,  '2026-03-05 19:00:00', '2026-03-05 20:15:00', 'Room D'),
(19, 4,  '2026-03-06 19:00:00', '2026-03-06 20:15:00', 'Room E'),
(20, 5,  '2026-03-06 10:00:00', '2026-03-06 11:00:00', 'Room F'),
(21, 5,  '2026-03-07 10:00:00', '2026-03-07 11:00:00', 'Room G'),
(22, 6,  '2026-03-06 19:00:00', '2026-03-06 20:20:00', 'Room A'),
(23, 6,  '2026-03-07 20:00:00', '2026-03-07 21:20:00', 'Room B'),
(24, 7,  '2026-03-11 20:00:00', '2026-03-11 22:00:00', 'Room C'),
(25, 7,  '2026-03-12 20:00:00', '2026-03-12 22:00:00', 'Room D'),
(26, 8,  '2026-03-12 19:30:00', '2026-03-12 21:00:00', 'Room E'),
(27, 8,  '2026-03-13 19:30:00', '2026-03-13 21:00:00', 'Room F'),
(28, 9,  '2026-03-12 20:00:00', '2026-03-12 21:20:00', 'Room G'),
(29, 9,  '2026-03-13 20:00:00', '2026-03-13 21:20:00', 'Room A'),
(30, 10, '2026-03-13 20:00:00', '2026-03-13 21:25:00', 'Room B'),
(31, 10, '2026-03-14 20:00:00', '2026-03-14 21:25:00', 'Room C'),
(32, 11, '2026-03-20 19:00:00', '2026-03-20 20:15:00', 'Room D'),
(33, 11, '2026-03-21 19:00:00', '2026-03-21 20:15:00', 'Room E'),
(34, 22, '2026-04-01 19:00:00', '2026-04-01 21:30:00', 'Room F'),
(35, 22, '2026-04-02 19:00:00', '2026-04-02 21:30:00', 'Room G'),
(36, 23, '2026-06-28 20:00:00', '2026-06-28 22:00:00', 'Room A'),
(37, 23, '2026-06-29 20:00:00', '2026-06-29 22:00:00', 'Room B'),
(38, 25, '2026-04-10 20:00:00', '2026-04-10 21:30:00', 'Room C'),
(39, 25, '2026-04-11 20:00:00', '2026-04-11 21:30:00', 'Room D'),
(40, 26, '2026-05-05 19:30:00', '2026-05-05 21:10:00', 'Room E'),
(41, 26, '2026-05-06 19:30:00', '2026-05-06 21:10:00', 'Room F'),
(42, 27, '2026-04-20 20:00:00', '2026-04-20 21:35:00', 'Room G'),
(43, 27, '2026-04-21 20:00:00', '2026-04-21 21:35:00', 'Room A'),
(44, 28, '2026-05-12 20:00:00', '2026-05-12 21:50:00', 'Room B'),
(45, 28, '2026-05-13 20:00:00', '2026-05-13 21:50:00', 'Room C');

-- ============================================================
-- Reset AUTO_INCREMENT values
-- ============================================================
ALTER TABLE `posters`      AUTO_INCREMENT = 18;
ALTER TABLE `reservations` AUTO_INCREMENT = 1;
ALTER TABLE `reviews`      AUTO_INCREMENT = 1;
ALTER TABLE `showings`     AUTO_INCREMENT = 46;
ALTER TABLE `shows`        AUTO_INCREMENT = 32;
ALTER TABLE `tickets`      AUTO_INCREMENT = 1;
ALTER TABLE `transactions` AUTO_INCREMENT = 1;
ALTER TABLE `users`        AUTO_INCREMENT = 1;

SET FOREIGN_KEY_CHECKS = 1;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;