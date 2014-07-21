-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 21, 2014 at 08:41 PM
-- Server version: 5.6.15-log
-- PHP Version: 5.5.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `soluche`
--
CREATE DATABASE IF NOT EXISTS `soluche` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `soluche`;

-- --------------------------------------------------------

--
-- Table structure for table `congress`
--

DROP TABLE IF EXISTS `congress`;
CREATE TABLE IF NOT EXISTS `congress` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(128) NOT NULL,
  `action_number` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `congress`
--

INSERT INTO `congress` (`id`, `nom`, `action_number`) VALUES
(1, 'Week-end luche', 30),
(2, 'Anniversaire', 20);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
CREATE TABLE IF NOT EXISTS `inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idplayer` int(11) DEFAULT NULL COMMENT 'Player',
  `idobject` int(11) DEFAULT NULL COMMENT 'Object',
  PRIMARY KEY (`id`),
  KEY `idplayer` (`idplayer`),
  KEY `idobject` (`idobject`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `idplayer`, `idobject`) VALUES
(18, -1, 7),
(19, -1, 8),
(20, -1, 9),
(21, -1, 10),
(22, -2, 11),
(23, -2, 12);

-- --------------------------------------------------------

--
-- Table structure for table `objet`
--

DROP TABLE IF EXISTS `objet`;
CREATE TABLE IF NOT EXISTS `objet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(128) NOT NULL,
  `permanent` int(11) NOT NULL DEFAULT '0',
  `notoriete` int(11) NOT NULL DEFAULT '0',
  `alcoolemie` int(11) NOT NULL DEFAULT '0',
  `alcoolemie_optimum` int(11) NOT NULL DEFAULT '0',
  `alcoolemie_max` int(11) NOT NULL DEFAULT '0',
  `fatigue` int(11) NOT NULL DEFAULT '0',
  `fatigue_max` int(11) NOT NULL DEFAULT '0',
  `sex_appeal` int(11) NOT NULL,
  `image` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `objet`
--

INSERT INTO `objet` (`id`, `nom`, `permanent`, `notoriete`, `alcoolemie`, `alcoolemie_optimum`, `alcoolemie_max`, `fatigue`, `fatigue_max`, `sex_appeal`, `image`) VALUES
(1, 'poule', 1, 1, 0, 0, 0, 0, -1, 3, 'images/objets/poule.png'),
(2, 'pachi', 1, 1, 0, 0, 0, 0, 0, -1, 'images/objets/pachi.png'),
(3, 'bacchus', 1, 1, 0, 2, 2, 0, 0, 0, 'images/objets/bacchus.png'),
(4, 'Redbull', 0, 0, 0, 0, 0, -2, 0, 0, 'images/objets/redbull.png'),
(5, 'test+1 all', 0, 1, 1, 1, 1, 1, 1, 1, 'images/objets/pouce-haut.png'),
(6, 'test-1 all', 0, -1, -1, -1, -1, -1, -1, -1, 'images/objets/pouce-bas.png'),
(7, 'Café', 0, 0, 0, 0, 0, -2, 0, 0, 'images/objets/cafe.png'),
(8, 'Sandwish', 0, 0, 0, 0, 0, -3, 0, 0, 'images/objets/sandwich.png'),
(9, 'vomi', 0, -8, 0, 0, 0, -1, 0, 0, 'images/objets/vomi.png'),
(10, 'Poulet', 0, 0, 0, 0, 0, -3, 0, 0, 'images/objets/poulet.png'),
(11, 'treuse', 0, 0, 2, 0, 0, 0, 0, 0, 'images/objets/treuse.png'),
(12, 'biere', 0, 0, 1, 0, 0, 0, 0, 0, 'images/objets/biere.png');

-- --------------------------------------------------------

--
-- Table structure for table `player`
--

DROP TABLE IF EXISTS `player`;
CREATE TABLE IF NOT EXISTS `player` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(128) NOT NULL,
  `pass` varchar(128) NOT NULL,
  `lieu` varchar(128) NOT NULL,
  `points` int(11) NOT NULL,
  `notoriete` int(11) NOT NULL,
  `alcoolemie` int(11) NOT NULL,
  `alcoolemie_optimum` int(11) NOT NULL,
  `alcoolemie_max` int(11) NOT NULL,
  `fatigue` int(11) NOT NULL,
  `fatigue_max` int(11) NOT NULL,
  `sex_appeal` int(11) NOT NULL,
  `en_pls` tinyint(1) NOT NULL,
  `debut_de_pls` int(11) NOT NULL,
  `sex` int(11) NOT NULL,
  `photo` varchar(1024) DEFAULT NULL,
  `pnj` int(11) NOT NULL DEFAULT '0',
  `id_congress` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_congress` (`id_congress`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `player`
--

INSERT INTO `player` (`id`, `nom`, `pass`, `lieu`, `points`, `notoriete`, `alcoolemie`, `alcoolemie_optimum`, `alcoolemie_max`, `fatigue`, `fatigue_max`, `sex_appeal`, `en_pls`, `debut_de_pls`, `sex`, `photo`, `pnj`, `id_congress`) VALUES
(-2, 'bar', '', '', 0, 0, 0, 0, 10, 0, 0, 0, 0, 0, 0, NULL, 1, NULL),
(-1, 'cuisine', '', '', 0, 0, 0, 0, 10, 0, 0, 0, 0, 0, 0, NULL, 1, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
