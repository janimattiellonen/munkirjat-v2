-- phpMyAdmin SQL Dump
-- version 4.0.2
-- http://www.phpmyadmin.net
--
-- Palvelin: 127.0.0.1
-- Luontiaika: 23.06.2013 klo 13:20
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
-- Rakenne taululle `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) COLLATE utf8_swedish_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_swedish_ci NOT NULL,
  `salt` varchar(40) COLLATE utf8_swedish_ci NOT NULL,
  `firstname` varchar(64) COLLATE utf8_swedish_ci DEFAULT NULL,
  `lastname` varchar(64) COLLATE utf8_swedish_ci DEFAULT NULL,
  `email` varchar(128) COLLATE utf8_swedish_ci NOT NULL,
  `enabled` tinyint(1) DEFAULT '1',
  `role` varchar(45) COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `index3` (`password`),
  KEY `index5` (`enabled`),
  KEY `index_role` (`role`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=2 ;

--
-- Vedos taulusta `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `salt`, `firstname`, `lastname`, `email`, `enabled`, `role`) VALUES
(1, 'jme', '229436487240e019140f79f7c3a402d4507a82788a552899a07604114edafd41', 'pekka', 'Janimatti', 'Ellonen', 'janimatti.ellonen@gmail.com', 1, 'admin');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
