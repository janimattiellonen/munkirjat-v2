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
-- Rakenne taululle `genre`
--

CREATE TABLE IF NOT EXISTS `genre` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=19 ;

--
-- Vedos taulusta `genre`
--

INSERT INTO `genre` (`id`, `name`) VALUES
(3, 'Action'),
(4, 'Adventure'),
(16, 'Biography'),
(13, 'Comedy'),
(7, 'Computer science'),
(10, 'Counter terrorism'),
(5, 'Crime'),
(12, 'Documentary'),
(2, 'Drama'),
(9, 'Fantasy'),
(14, 'Music'),
(15, 'Mystery'),
(18, 'Non-fiction'),
(1, 'Sci-fi'),
(17, 'Science'),
(11, 'Thriller'),
(8, 'War');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
