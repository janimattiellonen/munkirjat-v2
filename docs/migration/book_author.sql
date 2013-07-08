-- phpMyAdmin SQL Dump
-- version 4.0.2
-- http://www.phpmyadmin.net
--
-- Palvelin: 127.0.0.1
-- Luontiaika: 23.06.2013 klo 13:17
-- Palvelimen versio: 5.6.10
-- PHP:n versio: 5.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Tietokanta: `munkirjat-production`
--

-- --------------------------------------------------------

--
-- Rakenne taululle `book_author`
--

CREATE TABLE IF NOT EXISTS `book_author` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `book_id` int(10) unsigned DEFAULT NULL,
  `author_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `index2` (`book_id`,`author_id`),
  KEY `fk_ba_book` (`book_id`),
  KEY `fk_ba_author` (`author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=420 ;

--
-- Vedos taulusta `book_author`
--

INSERT INTO `book_author` (`id`, `book_id`, `author_id`) VALUES
(1, 1, 1),
(314, 2, 2),
(3, 3, 2),
(4, 4, 2),
(5, 5, 2),
(6, 6, 2),
(7, 7, 2),
(8, 8, 2),
(9, 9, 2),
(10, 10, 2),
(11, 11, 2),
(12, 12, 4),
(13, 13, 4),
(14, 14, 4),
(15, 15, 4),
(16, 16, 4),
(17, 17, 5),
(18, 18, 5),
(19, 19, 5),
(20, 20, 5),
(21, 21, 6),
(22, 22, 6),
(23, 23, 6),
(24, 24, 6),
(25, 25, 6),
(26, 26, 6),
(27, 27, 6),
(28, 28, 6),
(29, 29, 7),
(30, 30, 7),
(31, 31, 7),
(32, 33, 9),
(33, 34, 10),
(34, 35, 11),
(35, 36, 12),
(36, 37, 13),
(37, 38, 6),
(38, 39, 6),
(39, 40, 14),
(40, 41, 14),
(41, 42, 14),
(42, 43, 14),
(43, 44, 14),
(44, 45, 14),
(45, 46, 15),
(46, 47, 15),
(47, 48, 15),
(48, 49, 15),
(49, 50, 15),
(50, 51, 15),
(51, 52, 15),
(52, 53, 16),
(53, 54, 17),
(54, 55, 18),
(55, 56, 12),
(56, 57, 12),
(57, 58, 12),
(58, 59, 12),
(59, 60, 19),
(60, 61, 20),
(61, 62, 21),
(62, 63, 22),
(63, 64, 12),
(64, 65, 12),
(65, 66, 23),
(66, 67, 24),
(67, 68, 25),
(68, 69, 26),
(69, 70, 26),
(70, 71, 27),
(71, 72, 27),
(72, 73, 28),
(73, 74, 28),
(74, 75, 29),
(75, 76, 28),
(76, 77, 30),
(77, 78, 31),
(78, 79, 32),
(79, 80, 15),
(80, 81, 33),
(81, 82, 33),
(82, 83, 34),
(83, 84, 35),
(84, 85, 11),
(85, 86, 1),
(86, 87, 1),
(87, 88, 1),
(88, 89, 16),
(89, 90, 42),
(90, 91, 37),
(91, 92, 12),
(92, 93, 2),
(93, 94, 2),
(94, 95, 2),
(95, 96, 2),
(96, 97, 38),
(97, 98, 39),
(98, 99, 40),
(99, 100, 41),
(100, 101, 2),
(101, 102, 1),
(102, 104, 4),
(103, 105, 43),
(104, 106, 45),
(105, 107, 44),
(106, 108, 12),
(107, 109, 2),
(108, 110, 2),
(201, 111, 2),
(110, 112, 33),
(111, 113, 14),
(112, 114, 45),
(113, 115, 46),
(114, 116, 46),
(115, 117, 46),
(116, 118, 45),
(117, 119, 36),
(118, 120, 29),
(119, 122, 47),
(120, 123, 48),
(121, 124, 48),
(122, 125, 47),
(123, 126, 2),
(124, 127, 2),
(125, 128, 2),
(126, 129, 50),
(127, 131, 52),
(128, 132, 53),
(129, 135, 58),
(130, 137, 47),
(131, 138, 4),
(306, 139, 10),
(305, 139, 56),
(227, 140, 33),
(134, 141, 2),
(166, 142, 2),
(136, 143, 15),
(137, 144, 59),
(138, 145, 59),
(139, 146, 59),
(140, 147, 59),
(141, 148, 5),
(142, 149, 60),
(143, 150, 15),
(144, 151, 15),
(145, 152, 61),
(146, 153, 62),
(147, 154, 15),
(148, 155, 15),
(224, 156, 1),
(215, 157, 63),
(151, 158, 64),
(207, 159, 2),
(153, 160, 45),
(154, 161, 65),
(232, 162, 66),
(299, 164, 45),
(300, 164, 85),
(291, 165, 45),
(380, 166, 67),
(204, 167, 61),
(160, 168, 61),
(167, 169, 61),
(250, 171, 2),
(341, 172, 68),
(164, 173, 69),
(169, 174, 70),
(170, 175, 70),
(171, 176, 70),
(172, 177, 70),
(173, 178, 70),
(174, 179, 70),
(175, 180, 70),
(176, 181, 70),
(177, 182, 62),
(178, 183, 62),
(179, 184, 62),
(180, 185, 62),
(181, 186, 62),
(182, 187, 62),
(183, 188, 62),
(184, 189, 62),
(185, 190, 62),
(186, 191, 71),
(187, 192, 40),
(188, 193, 72),
(189, 194, 30),
(190, 195, 63),
(191, 196, 74),
(193, 197, 75),
(194, 198, 19),
(195, 198, 76),
(196, 199, 19),
(197, 200, 19),
(198, 200, 77),
(199, 201, 19),
(200, 202, 78),
(203, 203, 29),
(218, 204, 2),
(219, 204, 79),
(210, 205, 38),
(211, 206, 37),
(212, 207, 80),
(221, 208, 16),
(229, 209, 33),
(230, 210, 11),
(237, 211, 81),
(234, 212, 82),
(239, 213, 83),
(241, 214, 84),
(242, 215, 45),
(243, 215, 85),
(275, 216, 83),
(273, 217, 42),
(263, 218, 26),
(248, 219, 86),
(254, 220, 62),
(252, 221, 15),
(253, 222, 15),
(256, 223, 2),
(257, 223, 87),
(284, 224, 2),
(395, 225, 2),
(396, 225, 88),
(282, 226, 89),
(265, 227, 2),
(266, 227, 87),
(403, 228, 2),
(347, 229, 2),
(351, 230, 2),
(271, 231, 2),
(290, 232, 2),
(277, 233, 90),
(279, 234, 15),
(333, 235, 15),
(281, 236, 91),
(366, 237, 92),
(321, 238, 64),
(320, 239, 47),
(311, 240, 12),
(308, 241, 56),
(303, 242, 15),
(312, 243, 6),
(327, 244, 93),
(328, 244, 94),
(324, 245, 95),
(343, 246, 96),
(336, 247, 61),
(331, 248, 15),
(329, 249, 68),
(382, 250, 67),
(385, 251, 39),
(356, 252, 2),
(357, 252, 97),
(378, 253, 89),
(350, 254, 15),
(361, 255, 98),
(375, 256, 4),
(370, 257, 38),
(363, 258, 44),
(368, 259, 6),
(373, 260, 62),
(377, 261, 38),
(384, 262, 99),
(386, 263, 45),
(387, 263, 85),
(388, 264, 100),
(389, 265, 101),
(410, 266, 2),
(411, 266, 102),
(394, 267, 4),
(400, 268, 11),
(419, 269, 103),
(407, 270, 103),
(405, 271, 61),
(406, 272, 47),
(416, 273, 5),
(409, 274, 38),
(418, 275, 103),
(413, 276, 103),
(414, 277, 2),
(415, 277, 87);

--
-- Rajoitteet vedostauluille
--

--
-- Rajoitteet taululle `book_author`
--
ALTER TABLE `book_author`
  ADD CONSTRAINT `fk_ba_author` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ba_book` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;