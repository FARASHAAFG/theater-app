-- ============================================================
-- live_play Database v2
-- Simplified schema with proper seats & purchase logic
-- ============================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
SET FOREIGN_KEY_CHECKS = 0;
/*!40101 SET NAMES utf8mb4 */;

-- ============================================================
-- Drop all tables (children first)
-- ============================================================
DROP TABLE IF EXISTS `reviews`;
DROP TABLE IF EXISTS `reservations`;
DROP TABLE IF EXISTS `transactions`;
DROP TABLE IF EXISTS `seats`;
DROP TABLE IF EXISTS `showings`;
DROP TABLE IF EXISTS `rooms`;
DROP TABLE IF EXISTS `posters`;
DROP TABLE IF EXISTS `shows`;
DROP TABLE IF EXISTS `users`;

-- ============================================================
-- SCHEMA OVERVIEW
--
-- users         → people who buy tickets
-- shows         → the event/performance
-- posters       → image assets linked to a show
-- rooms         → physical venues with fixed seating
-- seats         → every individual seat in a room
-- showings      → a specific show scheduled in a room at a time
-- transactions  → one purchase session per user (groups reservations)
-- reservations  → one row per seat booked in a transaction
-- reviews       → user reviews for shows
--
-- PURCHASE FLOW:
--   1. User picks a showing → sees available seats
--   2. User picks seats → a transaction is created (status = 'pending')
--   3. One reservation row is inserted per seat
--   4. Payment succeeds → transaction status = 'completed'
--   5. Payment fails   → transaction status = 'cancelled'
--
-- SEAT AVAILABILITY CHECK (for a given showing_id):
--   SELECT seat_id FROM reservations
--   JOIN transactions USING (transaction_id)
--   WHERE showing_id = ? AND transactions.status = 'completed'
-- ============================================================


-- ============================================================
-- Table: users
-- ============================================================
CREATE TABLE `users` (
  `user_id`    INT          NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(100) NOT NULL,
  `last_name`  VARCHAR(100) NOT NULL,
  `email`      VARCHAR(255) NOT NULL,
  `phone`      VARCHAR(20)  NOT NULL,
  `password`   VARCHAR(255) NOT NULL,
  `is_admin`   TINYINT(1)   NOT NULL DEFAULT 0,
  `created_at` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `uq_users_email` (`email`),
  UNIQUE KEY `uq_users_phone` (`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- Table: shows
-- ============================================================
CREATE TABLE `shows` (
  `show_id`        INT          NOT NULL AUTO_INCREMENT,
  `title`          VARCHAR(255) NOT NULL,
  `title_fr`       VARCHAR(255) NOT NULL,
  `duration`       INT          NOT NULL COMMENT 'Duration in minutes',
  `genre`          VARCHAR(100) NOT NULL,
  `language`       VARCHAR(50)  NOT NULL,
  `cast`           VARCHAR(500) NOT NULL,
  `show_type`      VARCHAR(100) NOT NULL,
  `is_active`      TINYINT(1)   NOT NULL DEFAULT 1,
  `description`    TEXT         NOT NULL,
  `description_fr` TEXT         NOT NULL,
  PRIMARY KEY (`show_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- Table: posters
-- ============================================================
CREATE TABLE `posters` (
  `poster_id`    INT          NOT NULL AUTO_INCREMENT,
  `show_id`      INT          NOT NULL,
  `poster_image` VARCHAR(255) NOT NULL,
  `is_primary`   TINYINT(1)   NOT NULL DEFAULT 0,
  PRIMARY KEY (`poster_id`),
  KEY `fk_posters_show_id` (`show_id`),
  CONSTRAINT `fk_posters_show_id` FOREIGN KEY (`show_id`) REFERENCES `shows` (`show_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- Table: rooms
-- Each room has a fixed grid of rows × seats_per_row.
-- Seats are pre-populated in the `seats` table.
-- ============================================================
CREATE TABLE `rooms` (
  `room_id`       INT         NOT NULL AUTO_INCREMENT,
  `name`          VARCHAR(50) NOT NULL,
  `total_rows`    INT         NOT NULL COMMENT 'Number of rows (e.g. 5 → rows A–E)',
  `seats_per_row` INT         NOT NULL COMMENT 'Seats per row',
  PRIMARY KEY (`room_id`),
  UNIQUE KEY `uq_room_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- Table: seats
-- One row per physical seat. row_label is a letter (A, B, …).
-- (room_id, row_label, seat_number) must be unique.
-- ============================================================
CREATE TABLE `seats` (
  `seat_id`     INT         NOT NULL AUTO_INCREMENT,
  `room_id`     INT         NOT NULL,
  `row_label`   CHAR(1)     NOT NULL COMMENT 'A, B, C, …',
  `seat_number` INT         NOT NULL,
  PRIMARY KEY (`seat_id`),
  UNIQUE KEY `uq_seat_position` (`room_id`, `row_label`, `seat_number`),
  KEY `fk_seats_room_id` (`room_id`),
  CONSTRAINT `fk_seats_room_id` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- Table: showings
-- Links a show to a room + time slot. Stores the base ticket price.
-- ============================================================
CREATE TABLE `showings` (
  `showing_id` INT           NOT NULL AUTO_INCREMENT,
  `show_id`    INT           NOT NULL,
  `room_id`    INT           NOT NULL,
  `start_time` DATETIME      NOT NULL,
  `end_time`   DATETIME      NOT NULL,
  `base_price` DECIMAL(8,2)  NOT NULL DEFAULT 0.00 COMMENT 'Default ticket price for this showing',
  PRIMARY KEY (`showing_id`),
  KEY `fk_showings_show_id` (`show_id`),
  KEY `fk_showings_room_id` (`room_id`),
  CONSTRAINT `fk_showings_show_id` FOREIGN KEY (`show_id`) REFERENCES `shows` (`show_id`),
  CONSTRAINT `fk_showings_room_id` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- Table: transactions
-- One transaction per purchase attempt. Groups multiple reservations.
-- status: 'pending' → awaiting payment, 'completed' → paid, 'cancelled' → failed/refunded
-- ============================================================
CREATE TABLE `transactions` (
  `transaction_id` INT                                      NOT NULL AUTO_INCREMENT,
  `user_id`        INT                                      NOT NULL,
  `status`         ENUM('pending','completed','cancelled')  NOT NULL DEFAULT 'pending',
  `created_at`     DATETIME                                 NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`     DATETIME                                 NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`transaction_id`),
  KEY `fk_transactions_user_id` (`user_id`),
  CONSTRAINT `fk_transactions_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- Table: reservations
-- One row per seat per transaction.
-- price is locked in at booking time (so future price changes don't affect old bookings).
-- UNIQUE on (showing_id, seat_id) prevents two confirmed bookings for the same seat.
-- ============================================================
CREATE TABLE `reservations` (
  `reservation_id` INT          NOT NULL AUTO_INCREMENT,
  `transaction_id` INT          NOT NULL,
  `showing_id`     INT          NOT NULL,
  `seat_id`        INT          NOT NULL,
  `price`          DECIMAL(8,2) NOT NULL DEFAULT 0.00 COMMENT 'Price paid at time of booking',
  PRIMARY KEY (`reservation_id`),
  -- Prevents double-booking the same seat for the same showing
  UNIQUE KEY `uq_reservation_seat` (`showing_id`, `seat_id`),
  KEY `fk_reservations_transaction_id` (`transaction_id`),
  KEY `fk_reservations_seat_id` (`seat_id`),
  CONSTRAINT `fk_reservations_transaction_id` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`),
  CONSTRAINT `fk_reservations_showing_id`     FOREIGN KEY (`showing_id`)     REFERENCES `showings` (`showing_id`),
  CONSTRAINT `fk_reservations_seat_id`        FOREIGN KEY (`seat_id`)        REFERENCES `seats` (`seat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- Table: reviews
-- ============================================================
CREATE TABLE `reviews` (
  `review_id`  INT      NOT NULL AUTO_INCREMENT,
  `user_id`    INT      NOT NULL,
  `show_id`    INT      NOT NULL,
  `rating`     TINYINT  NOT NULL COMMENT '1 to 5',
  `comment`    TEXT     NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`review_id`),
  -- One review per user per show
  UNIQUE KEY `uq_review_user_show` (`user_id`, `show_id`),
  KEY `fk_reviews_show_id` (`show_id`),
  CONSTRAINT `fk_reviews_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `fk_reviews_show_id` FOREIGN KEY (`show_id`) REFERENCES `shows` (`show_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ============================================================
-- Data: shows
-- ============================================================
INSERT INTO `shows` (`show_id`, `title`, `title_fr`, `duration`, `genre`, `language`, `cast`, `show_type`, `is_active`, `description`, `description_fr`) VALUES
(1,  'Evangeline – The Musical',                        'Évangéline – The Musical',                              160, 'Musical Theatre',                        'Français', 'Maude Cyr-Deschênes, Olivier Dion, Matthieu Lévesque, Nathalie Simard', 'Show',    1, 'A sweeping historical musical about love and resilience.',                       'Une comédie musicale historique sur l\'amour et la résilience.'),
(2,  'AnesthesiA | Symphonic Tribute to Metallica',     'AnesthesiA | Hommage à Metallica symphonique',          120, 'Rock Music',                             'Français', 'AnesthesiA',                                                            'Concert', 1, 'Metallica\'s legendary music blended with orchestral arrangements.',             'La musique légendaire de Metallica avec des arrangements orchestraux.'),
(3,  '(LA)HORDE | Age of Content',                     '(LA)HORDE | Age of Content',                             90, 'Contemporary Dance',                     'Français', '(LA)HORDE | Ballet national de Marseille',                              'Danse',   1, 'Innovative contemporary dance exploring human connection and society.',           'Danse contemporaine innovante explorant la connexion humaine et la société.'),
(4,  'Tupqan | Our Inner Territories',                  'Tupqan | Nos territoires intérieurs',                    75, 'Théâtre de création',                    'Français', 'Tupqan',                                                                'Théâtre', 1, 'A thought-provoking theatre piece on personal and collective identity.',          'Création théâtrale sur l\'identité personnelle et collective.'),
(5,  'Pinocchio',                                       'Pinocchio',                                              60, 'Puppet Theatre',                         'Français', 'Place des Arts junior',                                                 'Show',    1, 'A charming puppet theatre performance perfect for young audiences.',              'Spectacle de marionnettes charmant pour les jeunes publics.'),
(6,  'Tango After Dark',                                'Tango After Dark',                                       80, 'Dance – Tango',                          'Français', 'Tango After Dark',                                                      'Danse',   1, 'A passionate tango show showcasing elegance and rhythm.',                        'Spectacle de tango passionné mettant en valeur l\'élégance et le rythme.'),
(7,  'The Rock Orchestra',                              'The Rock Orchestra',                                    110, 'Rock Music',                             'Français', 'The Rock Orchestra',                                                    'Concert', 1, 'A thrilling rock and metal concert performed by a full orchestra.',              'Concert rock et métal interprété par un orchestre complet.'),
(8,  'From Bartók to Mozart',                           'De Bartók à Mozart : flûte, improvisation et symphonie', 90, 'Classical Music',                        'Français', 'Orchestre symphonique de Montréal',                                     'Concert', 1, 'Classical works by Bartók and Mozart with flute solos and improvisation.',       'Œuvres de Bartók et Mozart avec solos de flûte et improvisation.'),
(9,  'Julia Mirzoev & Felix Hong',                      'Julia Mirzoev & Felix Hong',                             80, 'Chamber Music',                          'Français', 'Julia Mirzoev & Felix Hong',                                            'Concert', 1, 'A refined chamber music performance for violin and piano.',                      'Concert de musique de chambre pour violon et piano.'),
(10, 'One More Time | Electro-Symphonic Tribute to Daft Punk', 'One More Time | Hommage électro-symphonique à Daft Punk', 85, 'Electro-Symphonic',             'Français', 'One More Time',                                                         'Concert', 1, 'An electrifying symphonic tribute to Daft Punk\'s iconic music.',               'Hommage électro-symphonique à la musique emblématique de Daft Punk.'),
(11, 'Émile Proulx-Cloutier | My Hand in the Fire',    'Émile Proulx-Cloutier | Ma main au feu – solo',          75, 'Chanson francophone',                    'Français', 'Émile Proulx-Cloutier',                                                 'Concert', 1, 'A compelling solo performance combining music and storytelling.',                 'Performance solo mêlant musique et narration.'),
(22, 'Les Misérables in Concert',                       'Les Misérables en concert',                             150, 'Musical Theatre',                        'Français', 'Orchestre symphonique de Montréal',                                     'Concert', 1, 'A powerful concert version of Les Misérables with a full orchestra.',           'Version concert des Misérables avec un orchestre complet.'),
(23, 'Montreal Jazz Festival: Special Night',           'Festival Jazz de Montréal : Soirée spéciale',           120, 'Jazz',                                   'English',  'Various invited artists',                                               'Concert', 1, 'A special evening celebrating jazz with internationally renowned artists.',       'Une soirée jazz avec des artistes de renommée internationale.'),
(25, 'Ballet of the Seasons',                           'Ballet des saisons',                                    100, 'Contemporary Dance',                     'Français', 'Compagnie de danse de Montréal',                                        'Danse',   1, 'A beautiful dance performance inspired by the four seasons.',                    'Spectacle de danse inspiré des quatre saisons.'),
(26, 'Quebec Comedy Night',                             'Soirée humour Québécois',                                95, 'Comedy',                                 'Français', 'Humoristes invités',                                                    'Show',    1, 'Stand-up comedy featuring popular Quebec comedians.',                            'Soirée d\'humour avec des humoristes québécois populaires.'),
(27, 'Symphonic Rock Montreal',                         'Rock Symphonique Montréal',                             110, 'Rock',                                   'English',  'Orchestre Rock Montréal',                                               'Concert', 1, 'A symphonic orchestra performs legendary rock classics.',                        'Un orchestre symphonique interprète des classiques du rock.'),
(28, 'The Phantom of the Opera',                        'Le Fantôme de l\'Opéra',                                145, 'Musical Theatre',                        'English',  'Compagnie théâtrale internationale',                                    'Show',    1, 'A spectacular musical telling the mysterious story of the Phantom.',             'Comédie musicale sur l\'histoire mystérieuse du Fantôme.');


-- ============================================================
-- Data: posters
-- ============================================================
INSERT INTO `posters` (`poster_id`, `show_id`, `poster_image`, `is_primary`) VALUES
(1,  1,  'data/images/evangeline/main.jpg',               1),
(2,  2,  'data/images/anesthesia/main.jpg',               1),
(3,  8,  'data/images/bankkok_mozart/main.jpg',           1),
(4,  11, 'data/images/emelie_proulx/main.jpg',            1),
(5,  3,  'data/images/La_Horde_Ballet/main.jpg',          1),
(6,  25, 'data/images/les_ballet/main.jpg',               1),
(7,  22, 'data/images/les_miserable/main.jpg',            1),
(8,  9,  'data/images/mizroew_hong/main.jpg',             1),
(9,  10, 'data/images/one_more_time/main.jpg',            1),
(10, 5,  'data/images/pinochio/main.jpg',                 1),
(11, 26, 'data/images/quebec_comedie_night/main.jpg',     1),
(12, 7,  'data/images/Rock_Orchestra/main.jpg',           1),
(13, 27, 'data/images/symphonic_rock_montreal/main.jpg',  1),
(14, 6,  'data/images/tango_after_dark/main.jpg',         1),
(15, 28, 'data/images/the_phantom_of_the_opera/main.jpg', 1),
(16, 4,  'data/images/tupqan/main.jpg',                   1),
(17, 23, 'data/images/jazz_festival/main.jpg',            1);


-- ============================================================
-- Data: rooms
-- 7 rooms with different capacities
-- total_rows × seats_per_row = total capacity
--
--   Room A: 6 rows × 12 seats =  72 seats  (intimate)
--   Room B: 5 rows × 10 seats =  50 seats  (small)
--   Room C: 8 rows × 15 seats = 120 seats  (medium)
--   Room D: 4 rows ×  8 seats =  32 seats  (studio)
--   Room E: 6 rows × 12 seats =  72 seats  (intimate)
--   Room F: 5 rows × 10 seats =  50 seats  (small)
--   Room G: 10 rows × 20 seats = 200 seats (large)
-- ============================================================
INSERT INTO `rooms` (`room_id`, `name`, `total_rows`, `seats_per_row`) VALUES
(1, 'Room A', 6,  12),
(2, 'Room B', 5,  10),
(3, 'Room C', 8,  15),
(4, 'Room D', 4,  8),
(5, 'Room E', 6,  12),
(6, 'Room F', 5,  10),
(7, 'Room G', 10, 20);


-- ============================================================
-- Data: seats
-- Generated via stored procedure to avoid thousands of INSERT lines.
-- The procedure loops over each room and inserts one row per seat.
-- It is dropped immediately after use.
-- ============================================================
DROP PROCEDURE IF EXISTS `sp_generate_seats`;

DELIMITER $$
CREATE PROCEDURE `sp_generate_seats`()
BEGIN
  DECLARE v_room_id     INT;
  DECLARE v_total_rows  INT;
  DECLARE v_seats_row   INT;
  DECLARE v_row_idx     INT;
  DECLARE v_seat_num    INT;

  -- Cursor over all rooms
  DECLARE done INT DEFAULT FALSE;
  DECLARE cur CURSOR FOR
    SELECT room_id, total_rows, seats_per_row FROM rooms ORDER BY room_id;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

  OPEN cur;
  read_loop: LOOP
    FETCH cur INTO v_room_id, v_total_rows, v_seats_row;
    IF done THEN LEAVE read_loop; END IF;

    SET v_row_idx = 0;
    WHILE v_row_idx < v_total_rows DO
      SET v_seat_num = 1;
      WHILE v_seat_num <= v_seats_row DO
        INSERT INTO seats (room_id, row_label, seat_number)
        VALUES (v_room_id, CHAR(65 + v_row_idx), v_seat_num);
        SET v_seat_num = v_seat_num + 1;
      END WHILE;
      SET v_row_idx = v_row_idx + 1;
    END WHILE;
  END LOOP;
  CLOSE cur;
END$$
DELIMITER ;

CALL `sp_generate_seats`();
DROP PROCEDURE IF EXISTS `sp_generate_seats`;


-- ============================================================
-- Data: showings
-- Columns: showing_id, show_id, room_id, start_time, end_time, base_price
-- ============================================================
INSERT INTO `showings` (`showing_id`, `show_id`, `room_id`, `start_time`, `end_time`, `base_price`) VALUES
-- Evangeline – The Musical (show 1) → Room A (72 seats), large show → Room G
(1,  1,  7, '2026-07-30 19:00:00', '2026-07-30 21:40:00', 79.00),
(2,  1,  7, '2026-07-31 19:00:00', '2026-07-31 21:40:00', 79.00),
(3,  1,  7, '2026-08-01 14:00:00', '2026-08-01 16:40:00', 65.00),

-- AnesthesiA (show 2) → Room C (120 seats)
(4,  2,  3, '2026-03-07 19:00:00', '2026-03-07 21:00:00', 55.00),
(5,  2,  3, '2026-03-08 19:00:00', '2026-03-08 21:00:00', 55.00),
(6,  2,  3, '2026-03-09 20:00:00', '2026-03-09 22:00:00', 55.00),

-- (LA)HORDE | Age of Content (show 3) → Room C
(7,  3,  3, '2026-02-27 20:00:00', '2026-02-27 21:30:00', 50.00),
(8,  3,  3, '2026-02-28 20:00:00', '2026-02-28 21:30:00', 50.00),
(9,  3,  3, '2026-03-01 19:00:00', '2026-03-01 20:30:00', 50.00),

-- Tupqan (show 4) → Room D (32 seats, intimate)
(10, 4,  4, '2026-03-04 19:00:00', '2026-03-04 20:15:00', 35.00),
(11, 4,  4, '2026-03-05 19:00:00', '2026-03-05 20:15:00', 35.00),
(12, 4,  4, '2026-03-06 19:00:00', '2026-03-06 20:15:00', 35.00),

-- Pinocchio (show 5) → Room B (50 seats, family show)
(13, 5,  2, '2026-03-05 10:00:00', '2026-03-05 11:00:00', 20.00),
(14, 5,  2, '2026-03-06 10:00:00', '2026-03-06 11:00:00', 20.00),
(15, 5,  2, '2026-03-07 10:00:00', '2026-03-07 11:00:00', 20.00),

-- Tango After Dark (show 6) → Room A (72 seats)
(16, 6,  1, '2026-03-05 19:00:00', '2026-03-05 20:20:00', 45.00),
(17, 6,  1, '2026-03-06 19:00:00', '2026-03-06 20:20:00', 45.00),
(18, 6,  1, '2026-03-07 20:00:00', '2026-03-07 21:20:00', 45.00),

-- The Rock Orchestra (show 7) → Room G (200 seats)
(19, 7,  7, '2026-03-10 20:00:00', '2026-03-10 22:00:00', 60.00),
(20, 7,  7, '2026-03-11 20:00:00', '2026-03-11 22:00:00', 60.00),
(21, 7,  7, '2026-03-12 20:00:00', '2026-03-12 22:00:00', 60.00),

-- From Bartók to Mozart (show 8) → Room A
(22, 8,  1, '2026-03-11 19:30:00', '2026-03-11 21:00:00', 55.00),
(23, 8,  1, '2026-03-12 19:30:00', '2026-03-12 21:00:00', 55.00),
(24, 8,  1, '2026-03-13 19:30:00', '2026-03-13 21:00:00', 55.00),

-- Julia Mirzoev & Felix Hong (show 9) → Room B (50 seats, chamber)
(25, 9,  2, '2026-03-11 20:00:00', '2026-03-11 21:20:00', 40.00),
(26, 9,  2, '2026-03-12 20:00:00', '2026-03-12 21:20:00', 40.00),
(27, 9,  2, '2026-03-13 20:00:00', '2026-03-13 21:20:00', 40.00),

-- One More Time | Daft Punk (show 10) → Room C
(28, 10, 3, '2026-03-12 20:00:00', '2026-03-12 21:25:00', 58.00),
(29, 10, 3, '2026-03-13 20:00:00', '2026-03-13 21:25:00', 58.00),
(30, 10, 3, '2026-03-14 20:00:00', '2026-03-14 21:25:00', 58.00),

-- Émile Proulx-Cloutier (show 11) → Room E (72 seats)
(31, 11, 5, '2026-03-12 19:00:00', '2026-03-12 20:15:00', 42.00),
(32, 11, 5, '2026-03-20 19:00:00', '2026-03-20 20:15:00', 42.00),
(33, 11, 5, '2026-03-21 19:00:00', '2026-03-21 20:15:00', 42.00),

-- Les Misérables in Concert (show 22) → Room G
(34, 22, 7, '2026-04-01 19:00:00', '2026-04-01 21:30:00', 85.00),
(35, 22, 7, '2026-04-02 19:00:00', '2026-04-02 21:30:00', 85.00),

-- Montreal Jazz Festival (show 23) → Room G
(36, 23, 7, '2026-06-28 20:00:00', '2026-06-28 22:00:00', 70.00),
(37, 23, 7, '2026-06-29 20:00:00', '2026-06-29 22:00:00', 70.00),

-- Ballet of the Seasons (show 25) → Room C
(38, 25, 3, '2026-04-10 20:00:00', '2026-04-10 21:30:00', 52.00),
(39, 25, 3, '2026-04-11 20:00:00', '2026-04-11 21:30:00', 52.00),

-- Quebec Comedy Night (show 26) → Room E
(40, 26, 5, '2026-05-05 19:30:00', '2026-05-05 21:10:00', 38.00),
(41, 26, 5, '2026-05-06 19:30:00', '2026-05-06 21:10:00', 38.00),

-- Symphonic Rock Montreal (show 27) → Room G
(42, 27, 7, '2026-04-20 20:00:00', '2026-04-20 21:35:00', 62.00),
(43, 27, 7, '2026-04-21 20:00:00', '2026-04-21 21:35:00', 62.00),

-- The Phantom of the Opera (show 28) → Room G
(44, 28, 7, '2026-05-12 20:00:00', '2026-05-12 21:50:00', 90.00),
(45, 28, 7, '2026-05-13 20:00:00', '2026-05-13 21:50:00', 90.00);


-- ============================================================
-- Auto-increment resets
-- ============================================================
ALTER TABLE `users`        AUTO_INCREMENT = 1;
ALTER TABLE `shows`        AUTO_INCREMENT = 32;
ALTER TABLE `posters`      AUTO_INCREMENT = 18;
ALTER TABLE `rooms`        AUTO_INCREMENT = 8;
-- seats AUTO_INCREMENT is set by the procedure output
ALTER TABLE `showings`     AUTO_INCREMENT = 46;
ALTER TABLE `transactions` AUTO_INCREMENT = 1;
ALTER TABLE `reservations` AUTO_INCREMENT = 1;
ALTER TABLE `reviews`      AUTO_INCREMENT = 1;


-- ============================================================
-- Useful views (optional helpers)
-- ============================================================

-- View: available seats for a given showing
-- Usage: SELECT * FROM v_available_seats WHERE showing_id = 4;
CREATE OR REPLACE VIEW `v_available_seats` AS
SELECT
  sh.showing_id,
  s.seat_id,
  s.room_id,
  s.row_label,
  s.seat_number,
  sh.base_price
FROM showings sh
JOIN seats s ON s.room_id = sh.room_id
WHERE s.seat_id NOT IN (
  SELECT r.seat_id
  FROM reservations r
  JOIN transactions t ON t.transaction_id = r.transaction_id
  WHERE r.showing_id = sh.showing_id
    AND t.status = 'completed'
);

-- View: full booking summary
CREATE OR REPLACE VIEW `v_booking_summary` AS
SELECT
  t.transaction_id,
  t.status             AS transaction_status,
  t.created_at         AS booked_at,
  u.user_id,
  CONCAT(u.first_name, ' ', u.last_name) AS customer_name,
  u.email,
  sh.show_id,
  sh.title             AS show_title,
  sg.start_time,
  sg.end_time,
  rm.name              AS room_name,
  s.row_label,
  s.seat_number,
  r.price              AS seat_price
FROM transactions t
JOIN users        u  ON u.user_id        = t.user_id
JOIN reservations r  ON r.transaction_id = t.transaction_id
JOIN showings     sg ON sg.showing_id    = r.showing_id
JOIN shows        sh ON sh.show_id       = sg.show_id
JOIN rooms        rm ON rm.room_id       = sg.room_id
JOIN seats        s  ON s.seat_id        = r.seat_id;


SET FOREIGN_KEY_CHECKS = 1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;