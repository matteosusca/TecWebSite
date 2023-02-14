-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 14, 2023 at 12:32 PM
-- Server version: 10.6.11-MariaDB-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tw_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `access`
--

CREATE TABLE `access` (
  `username` varchar(255) NOT NULL,
  `last_access` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `access`
--

INSERT INTO `access` (`username`, `last_access`) VALUES
('dalle', '2023-02-14 12:14:23'),
('fiore', '2023-02-14 12:31:44'),
('panini', '2023-02-14 12:32:21'),
('sysosus', '2023-02-14 12:32:53');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `body` varchar(100) NOT NULL,
  `publication_date` date NOT NULL,
  `username` varchar(30) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `body`, `publication_date`, `username`, `post_id`) VALUES
(20, 'Beautiful image, kudos to you!', '2023-02-14', 'sasandwitches', 30),
(21, 'Beautiful image, kudos to you!', '2023-02-14', 'sasandwitches', 30),
(22, 'bella zuppa', '2023-02-14', 'sysosus', 27),
(23, 'bella zuppa', '2023-02-14', 'sysosus', 27),
(24, 'robot colorato', '2023-02-14', 'sysosus', 33),
(25, 'bel robot', '2023-02-14', 'sysosus', 33);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(300) NOT NULL,
  `creation_date` date NOT NULL,
  `event_date` date NOT NULL,
  `end_event_date` date NOT NULL,
  `type_id` char(1) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `squad_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `name`, `description`, `creation_date`, `event_date`, `end_event_date`, `type_id`, `username`, `squad_id`) VALUES
(20, 'Torneo di CSGO', 'in palio una coppa (del nonno)', '2023-02-14', '2023-03-02', '2023-03-04', '2', 'sysosus', 43),
(21, 'Torneo Fortnite', 'Pinnacoli pendenti', '2023-02-14', '2023-04-20', '2023-04-21', '1', 'sysosus', 43);

-- --------------------------------------------------------

--
-- Table structure for table `event_types`
--

CREATE TABLE `event_types` (
  `type_id` char(1) NOT NULL,
  `type_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_types`
--

INSERT INTO `event_types` (`type_id`, `type_name`) VALUES
('1', 'Evento Pubblico'),
('2', 'Evento Privato');

-- --------------------------------------------------------

--
-- Table structure for table `friendships`
--

CREATE TABLE `friendships` (
  `sender` varchar(30) NOT NULL,
  `recipient` varchar(30) NOT NULL
) ;

--
-- Dumping data for table `friendships`
--

INSERT INTO `friendships` (`sender`, `recipient`) VALUES
('fiore', 'sysosus'),
('panini', 'dalle'),
('panini', 'fiore'),
('panini', 'sysosus'),
('pinc.o', 'sysosus'),
('sasandwitches', 'panini');

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

CREATE TABLE `friend_requests` (
  `sender` varchar(30) NOT NULL,
  `recipient` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `friend_requests`
--

INSERT INTO `friend_requests` (`sender`, `recipient`) VALUES
('dalle', 'panini'),
('dalle', 'sysosus'),
('dalle', 'sasandwitches');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `username` varchar(30) NOT NULL,
  `post_id` int(11) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`username`, `post_id`, `data`) VALUES
('sysosus', 31, '2023-02-14'),
('sysosus', 33, '2023-02-14');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `username` varchar(30) NOT NULL,
  `password` varchar(128) NOT NULL,
  `salt` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`username`, `password`, `salt`) VALUES
('dalle', '538d1b9350e9574b790c407c053b35375120a5bdb1be1471a6d88a84183a4504fa2db03d7b1742cb909317ba405be716c796dd40b021b5547ca1b30339a78f3a', 'c89ec475b6879d482f525b5bd6647cffc454623b1f177ab3002c8110025041b349462a2b638b617b144d8694718ab13b7191ba5428149a7aa70012e5cf8a1529'),
('fiore', 'c44353d704a2dbd6fccf4b5a55eab898e40ee96c8b96c6ca1ce9b2a89559414195f8734c5ca8b8d0f9bf1d28e25528879f021f5f2766bf3cb1d3e5e678bcbde6', 'd24d487ba868521b376f1ce9199a978e2d2d724508d44ad13ffc681537f7eb0ade8aa5a7ee9387a06cf060581372b7a83a7be85efb82872d312992682a988cd0'),
('panini', '40bab0b310d135f7ba0a426ae8d1ee8f42f67be6f20eb4a5e11c22d7f11ca5be7d6dcebde2bfd98077f71ad29729a60bc8fbc613093f2b25b45dfa0b68b71d69', '75bd23dcabe6ac1085035ec7a46daed09f12eeca0d8123f04e152d3a49171b56a81d6b1ddf97dfc90497bffedabc782483ec305f895703693588cbf126996c0e'),
('pinc.o', '83f61e08da72dfd151af4d3984777582754fc58bf4da9a2b68738f980b7289849b8250839085b6c430eb9c10d57999e99653d335ef534211e8687d1307130d0b', 'a7830a61644ac80a9e2ddff0eaf7b6b43b5bc21efa94193bbbc81a9a329d078306c63045e9cf8add6c6e3d970abba1309826476c97b3ba46b6c64678fcd5acd0'),
('sasandwitches', '93965be86bdec8bdef700675a8e35cbf6fa677f5ee0b124d581e8adfccc5061d92b0623a86161e620bca2a4bed4c4a3d2388fd00ecf891fc49960b9f365d0667', '012d1ad7611088cc4f0b68923d6c5e86acca00faf70908963ca4d854a847ad6f07c428c0a6ef99253db35829c11320c838d3b30363cf1cb0d46d64f9304fa4e8'),
('sysosus', 'ed79569316c936bd5ec67946d9027e8bd414ae0492175221dfec7ab1e0f2b602911b528c56403c95693130e9ea000192cfe5040525f0cc05d0521faab533d7b9', 'fa8ade1eb7625b852ea4eb65385e64d4e7024d0a0ef8ed01ecc648735149f2e43a4359a76653d2088ec68bae9a37a3ad8b281856f50a49636900560ff0e1e9f1');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id_media` int(11) NOT NULL,
  `url` varchar(100) NOT NULL,
  `media_type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id_media`, `url`, `media_type`) VALUES
(58, 'img/IEbF5XbiU7yCjJ3.png', 'img'),
(59, 'img/HngEAtjMdGJNCme.jpg', 'img'),
(60, 'img/TzxqeqPbhs6j5qU.jpg', 'img'),
(61, 'img/20pquLde5qCp2RH.png', 'img'),
(62, 'img/6QzuY72Cz9Q1YMC.png', 'img'),
(63, 'img/6T23tDsetsk2bua.png', 'img'),
(64, 'img/V8dJlNiGDIhZK7b.png', 'img'),
(65, 'img/bl49DoUAo5Jlbiu.png', 'img'),
(66, 'img/CM4VCWVyQy2TobM.png', 'img'),
(67, 'img/mntoXjZvzAelfZe.png', 'img'),
(68, 'img/BG0tZNaVMjuo8nX.png', 'img'),
(69, 'img/lYEMKQ2wuI5aqMx.png', 'img'),
(70, 'img/EuABHOL9iy4IzQe.jpg', 'img'),
(71, 'img/pNCKVwzUPimdYUY.png', 'img'),
(72, 'img/m2NcogTckd1p8qt.png', 'img'),
(73, 'img/rUUOLMD3WMvaRW8.png', 'img'),
(74, 'img/KabMBHRWsKFuGto.png', 'img');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `recipient` varchar(30) NOT NULL,
  `sender` varchar(30) NOT NULL,
  `type` varchar(20) NOT NULL,
  `isread` tinyint(1) NOT NULL DEFAULT 0,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `post_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `recipient`, `sender`, `type`, `isread`, `date`, `post_id`, `event_id`) VALUES
(83, 'panini', 'sasandwitches', 'post', 0, '2023-02-14 10:52:34', 32, NULL),
(84, 'panini', 'sasandwitches', 'comment', 0, '2023-02-14 10:54:24', 30, NULL),
(85, 'panini', 'sasandwitches', 'comment', 0, '2023-02-14 10:54:24', 30, NULL),
(86, 'panini', 'sysosus', 'like', 0, '2023-02-14 10:55:39', 31, NULL),
(87, 'panini', 'sysosus', 'like', 0, '2023-02-14 10:55:54', 31, NULL),
(88, 'panini', 'sysosus', 'like', 0, '2023-02-14 10:56:41', 31, NULL),
(89, 'panini', 'sysosus', 'like', 0, '2023-02-14 10:56:49', 31, NULL),
(90, 'panini', 'sysosus', 'like', 0, '2023-02-14 10:56:50', 31, NULL),
(91, 'panini', 'sysosus', 'like', 0, '2023-02-14 10:56:50', 31, NULL),
(92, 'panini', 'sysosus', 'like', 0, '2023-02-14 10:56:51', 31, NULL),
(93, 'panini', 'sysosus', 'like', 0, '2023-02-14 10:56:51', 31, NULL),
(94, 'sysosus', 'panini', 'post', 0, '2023-02-14 10:56:54', 33, NULL),
(95, 'sasandwitches', 'panini', 'post', 0, '2023-02-14 10:56:54', 33, NULL),
(96, 'panini', 'sysosus', 'like', 0, '2023-02-14 10:57:14', 33, NULL),
(97, 'panini', 'sysosus', 'comment', 0, '2023-02-14 10:57:56', 27, NULL),
(98, 'panini', 'sysosus', 'comment', 0, '2023-02-14 10:57:56', 27, NULL),
(99, 'panini', 'dalle', 'friend_request', 0, '2023-02-14 10:58:39', NULL, NULL),
(100, 'panini', 'sysosus', 'comment', 0, '2023-02-14 10:59:12', 33, NULL),
(101, 'sysosus', 'dalle', 'friend_request', 0, '2023-02-14 10:59:23', NULL, NULL),
(102, 'panini', 'sysosus', 'comment', 0, '2023-02-14 10:59:24', 33, NULL),
(103, 'sasandwitches', 'dalle', 'friend_request', 0, '2023-02-14 10:59:39', NULL, NULL),
(107, 'panini', 'sysosus', 'event', 0, '2023-02-14 11:11:26', NULL, 20),
(108, 'sysosus', 'sysosus', 'event', 0, '2023-02-14 11:11:26', NULL, 20),
(109, 'fiore', 'sysosus', 'event', 0, '2023-02-14 11:31:26', NULL, 21),
(110, 'panini', 'sysosus', 'event', 0, '2023-02-14 11:31:26', NULL, 21),
(111, 'sysosus', 'sysosus', 'event', 0, '2023-02-14 11:31:26', NULL, 21);

-- --------------------------------------------------------

--
-- Table structure for table `participations`
--

CREATE TABLE `participations` (
  `username` varchar(30) NOT NULL,
  `squad_id` int(11) NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `participations`
--

INSERT INTO `participations` (`username`, `squad_id`, `role`) VALUES
('sysosus', 43, 1),
('panini', 43, 2),
('fiore', 43, 3);

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `username` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`username`, `location`) VALUES
('dalle', '{\"lat\":43.6076544,\"lng\":12.6779392}'),
('fiore', '{\"lat\":43.6171,\"lng\":13.5159}'),
('panini', '{\"lat\":43.6076544,\"lng\":12.6779392}'),
('pinc.o', '{\"lat\":43.7387264,\"lng\":13.18912}'),
('sasandwitches', '{\"lat\":43.6076544,\"lng\":12.6779392}'),
('sysosus', '{\"lat\":43.7387264,\"lng\":13.18912}');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `id_media` int(11) DEFAULT NULL,
  `description` varchar(100) NOT NULL,
  `publication_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `username` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `id_media`, `description`, `publication_date`, `username`) VALUES
(24, 59, 'Ciao sono in montagna', '2023-02-14 10:41:09', 'sysosus'),
(25, 63, 'A sea otter with a pearl earring - Johannes Vermeer', '2023-02-14 10:45:01', 'panini'),
(26, 64, '3D render of a pink ballon dog in a violet room', '2023-02-14 10:45:30', 'panini'),
(27, 65, 'A bowl of soup that is also a portal to another dimension', '2023-02-14 10:45:51', 'panini'),
(28, 66, 'A cartoon of a monkey in space', '2023-02-14 10:46:09', 'panini'),
(29, 67, 'A pencil and watercolor drawing of a birght city in the future with flying cars', '2023-02-14 10:46:59', 'panini'),
(30, 68, 'A photo of a white fur monster standing in a purple room', '2023-02-14 10:47:36', 'panini'),
(31, 69, 'A photo of Michelangelo\'s scultpture of David wearing headphones', '2023-02-14 10:48:09', 'panini'),
(32, 71, 'picture of a man holding his phone up to his face with a look of excitement or focus on his face. ', '2023-02-14 10:52:34', 'sasandwitches'),
(33, 72, 'A plush toy robot sitting against a yellow wall', '2023-02-14 10:56:54', 'panini');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role` enum('Creatore','Admin','Membro') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`) VALUES
(1, 'Creatore'),
(2, 'Admin'),
(3, 'Membro');

-- --------------------------------------------------------

--
-- Table structure for table `squads`
--

CREATE TABLE `squads` (
  `squad_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(100) NOT NULL,
  `owner` varchar(30) NOT NULL,
  `profile_pic` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `squads`
--

INSERT INTO `squads` (`squad_id`, `name`, `description`, `owner`, `profile_pic`) VALUES
(43, 'Squad syso', 'Un gruppo di persone a cui piacciono i videogiochi', 'sysosus', 74);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(30) NOT NULL,
  `profile_pic` int(11) DEFAULT NULL,
  `birth_date` date NOT NULL,
  `name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `profile_pic`, `birth_date`, `name`, `surname`, `email`) VALUES
('dalle', 73, '1999-02-01', 'Dall', 'Eee', 'dalle@ai.com'),
('fiore', 60, '2001-01-15', 'Riccardo', 'Fiorani', 'riccardofiorani@hotmail.it'),
('panini', 62, '2001-11-28', 'Mattia', 'Panni', 'pnmattia@gmail.com'),
('pinc.o', 61, '2005-08-11', 'Pinco', 'Pallino', 'pinco.pallino@libero.it'),
('sasandwitches', 70, '1997-01-09', 'Sarah', 'Sandwitches', 'sarah@example.com'),
('sysosus', 58, '2001-11-21', 'Matteo', 'Susca', 'matteo.susca@studio.unibo.it');

-- --------------------------------------------------------

--
-- Table structure for table `u_invitations`
--

CREATE TABLE `u_invitations` (
  `username` varchar(30) NOT NULL,
  `event_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `u_registration`
--

CREATE TABLE `u_registration` (
  `event_id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `u_registration`
--

INSERT INTO `u_registration` (`event_id`, `username`) VALUES
(21, 'fiore'),
(20, 'panini'),
(21, 'panini'),
(20, 'sysosus'),
(21, 'sysosus');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access`
--
ALTER TABLE `access`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `FKscrittura` (`username`),
  ADD KEY `FKper` (`post_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `FKtipo` (`type_id`),
  ADD KEY `FKorganizzazione_u` (`username`),
  ADD KEY `FKorganizzazione_c` (`squad_id`);

--
-- Indexes for table `event_types`
--
ALTER TABLE `event_types`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `friendships`
--
ALTER TABLE `friendships`
  ADD PRIMARY KEY (`sender`,`recipient`),
  ADD KEY `FKaccettante` (`recipient`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`post_id`,`username`),
  ADD KEY `FKuser` (`username`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id_media`) USING BTREE;

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `participations`
--
ALTER TABLE `participations`
  ADD PRIMARY KEY (`username`,`squad_id`),
  ADD KEY `FKpar_COM` (`squad_id`),
  ADD KEY `ruolo` (`role`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD UNIQUE KEY `FKcontenuto_ID` (`id_media`),
  ADD KEY `FKpubblicazione` (`username`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ruolo` (`role`);

--
-- Indexes for table `squads`
--
ALTER TABLE `squads`
  ADD PRIMARY KEY (`squad_id`),
  ADD KEY `FKcreazione` (`owner`),
  ADD KEY `profile_pic` (`profile_pic`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `profile_pic` (`profile_pic`);

--
-- Indexes for table `u_invitations`
--
ALTER TABLE `u_invitations`
  ADD PRIMARY KEY (`event_id`,`username`),
  ADD KEY `FKinv_u_UTE` (`username`);

--
-- Indexes for table `u_registration`
--
ALTER TABLE `u_registration`
  ADD PRIMARY KEY (`username`,`event_id`),
  ADD KEY `FKisc_EVE` (`event_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id_media` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `squads`
--
ALTER TABLE `squads`
  MODIFY `squad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `access`
--
ALTER TABLE `access`
  ADD CONSTRAINT `access_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `FKper` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`),
  ADD CONSTRAINT `FKscrittura` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `FKorganizzazione_c` FOREIGN KEY (`squad_id`) REFERENCES `squads` (`squad_id`),
  ADD CONSTRAINT `FKorganizzazione_u` FOREIGN KEY (`username`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `FKtipo` FOREIGN KEY (`type_id`) REFERENCES `event_types` (`type_id`);

--
-- Constraints for table `friendships`
--
ALTER TABLE `friendships`
  ADD CONSTRAINT `FKaccettante` FOREIGN KEY (`recipient`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `FKrichiedente` FOREIGN KEY (`sender`) REFERENCES `users` (`username`);

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `FKid_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`),
  ADD CONSTRAINT `FKuser` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

--
-- Constraints for table `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `FKlogin_FK` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

--
-- Constraints for table `participations`
--
ALTER TABLE `participations`
  ADD CONSTRAINT `FKpar_COM` FOREIGN KEY (`squad_id`) REFERENCES `squads` (`squad_id`),
  ADD CONSTRAINT `FKpar_UTE` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

--
-- Constraints for table `positions`
--
ALTER TABLE `positions`
  ADD CONSTRAINT `positions_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `FKcontenuto_FK` FOREIGN KEY (`id_media`) REFERENCES `media` (`id_media`),
  ADD CONSTRAINT `FKpubblicazione` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

--
-- Constraints for table `squads`
--
ALTER TABLE `squads`
  ADD CONSTRAINT `FKcreazione` FOREIGN KEY (`owner`) REFERENCES `users` (`username`);

--
-- Constraints for table `u_invitations`
--
ALTER TABLE `u_invitations`
  ADD CONSTRAINT `FKinv_u_EVE` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`),
  ADD CONSTRAINT `FKinv_u_UTE` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

--
-- Constraints for table `u_registration`
--
ALTER TABLE `u_registration`
  ADD CONSTRAINT `FKisc_EVE` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`),
  ADD CONSTRAINT `FKisc_UTE` FOREIGN KEY (`username`) REFERENCES `users` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
