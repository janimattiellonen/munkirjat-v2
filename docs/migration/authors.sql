-- phpMyAdmin SQL Dump
-- version 4.0.2
-- http://www.phpmyadmin.net
--
-- Palvelin: 127.0.0.1
-- Luontiaika: 23.06.2013 klo 13:15
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
-- Rakenne taululle `author`
--

CREATE TABLE IF NOT EXISTS `author` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(45) COLLATE utf8_swedish_ci NOT NULL,
  `lastname` varchar(45) COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index2` (`firstname`,`lastname`),
  KEY `index3` (`lastname`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=104 ;

--
-- Vedos taulusta `author`
--

INSERT INTO `author` (`id`, `firstname`, `lastname`) VALUES
(54, 'Aaron', 'Hillegass'),
(101, 'Andy', 'McDermott'),
(6, 'Arne', 'Dahl'),
(86, 'Bengt', 'Liljegren'),
(81, 'Björn', 'Hellberg'),
(69, 'Carin', 'Gerhardsen'),
(16, 'Chris', 'Kuzneski'),
(49, 'Clive', 'Cuss'),
(2, 'Clive', 'Cussler'),
(43, 'Craig', 'Russell'),
(5, 'Dan', 'Brown'),
(33, 'David', 'Baldacci'),
(25, 'Dennis', 'Lehane'),
(79, 'Dirk', 'Cussler'),
(19, 'Douglas', 'Adams'),
(45, 'Douglas', 'Preston'),
(66, 'Duncan', 'Falconer'),
(53, 'Eric', 'Gamma'),
(64, 'Glenn', 'Cooper'),
(102, 'Graham', 'Brown'),
(87, 'Grant', 'Blackwood'),
(28, 'Hans', 'Holmér'),
(84, 'Hans', 'Koppel'),
(60, 'Heikki', 'Hietala'),
(12, 'Henning', 'Mankell'),
(68, 'Hjort', 'Rosenfeldt'),
(11, 'Håkan', 'Nesser'),
(13, 'Ian', 'Caldwell'),
(62, 'Ilkka', 'Remes'),
(44, 'J.R.R', 'Tolkien'),
(97, 'Jack', 'Du Brul'),
(71, 'Jack', 'Higgins'),
(10, 'James', 'Patterson'),
(1, 'James', 'Rollins'),
(40, 'Jan', 'Guillou'),
(32, 'Jarkko', 'Sipilä'),
(63, 'Jeffery', 'Deaver'),
(26, 'Jens', 'Lapidus'),
(39, 'John', 'Grisham'),
(36, 'John', 'Irving'),
(65, 'Jon', 'Trace'),
(92, 'Jonas', 'Jonasson'),
(98, 'Jonas', 'Moström'),
(75, 'Jonathan', 'Kellerman'),
(9, 'Juan', 'Goméz-Jurado'),
(103, 'Jussi', 'Adler-Olsen'),
(17, 'Karin', 'Fossum'),
(48, 'Kate', 'Mosse'),
(20, 'Ken', 'Follett'),
(51, 'Kent', 'Beck'),
(90, 'Kristina', 'Ohlsson'),
(89, 'Lars', 'Kepler'),
(59, 'Lars Bill', 'Lundholm'),
(38, 'Lee', 'Child'),
(29, 'Leif', 'GW'),
(85, 'Lincoln', 'Child'),
(56, 'Liza', 'Marklund'),
(23, 'Lothar', 'Günther'),
(82, 'Luis Miguel', 'Rocha'),
(76, 'Mark', 'Carwardine'),
(91, 'Marko', 'Kilpi'),
(50, 'Martin', 'Fowler'),
(4, 'Matthew', 'Reilly'),
(94, 'Michael', 'Crichton'),
(30, 'Michael', 'Palmer'),
(34, 'Michael', 'White'),
(61, 'Mons', 'Kallentoft'),
(78, 'Nick', 'Mason'),
(72, 'Niklas', 'Ekdal'),
(41, 'Nuri', 'Kino'),
(31, 'P.D.', 'James'),
(70, 'Patricia', 'Cornwell'),
(88, 'Paul', 'Kemprecos'),
(35, 'Paulo', 'Coelho'),
(46, 'Raymond', 'Khoury'),
(15, 'Reijo', 'Mäki'),
(93, 'Richard', 'Preston'),
(52, 'Robert C.', 'Martin'),
(74, 'Robert Penn', 'Warren'),
(47, 'Roslund &', 'Hellström'),
(21, 'Sam', 'Bourne'),
(67, 'Stefan', 'Tegenfalk'),
(99, 'Stephen', 'Hawking'),
(55, 'Stephen G.', 'Kochan'),
(42, 'Steve', 'Berry'),
(57, 'Steve', 'Souders'),
(58, 'Steve', 'Souders'),
(7, 'Stieg', 'Larsson'),
(100, 'Taavi', 'Soininvaara'),
(77, 'Terry', 'Jones'),
(96, 'Thomas', 'Ringstedt'),
(22, 'Tom', 'Clancy'),
(80, 'Tom', 'Knox'),
(18, 'Tove', 'Klackenberg'),
(27, 'Val', 'McDermid'),
(37, 'Vince', 'Flynn'),
(83, 'Viveca', 'Sten'),
(95, 'Walter', 'Isaacson'),
(14, 'Åke', 'Edwardson'),
(24, 'Åsa', 'Nilsonne');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
