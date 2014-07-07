-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2014 at 05:53 PM
-- Server version: 5.6.15-log
-- PHP Version: 5.5.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `soluche`
--

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE IF NOT EXISTS `inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idplayer` int(11) DEFAULT NULL COMMENT 'Player',
  `idobject` int(11) DEFAULT NULL COMMENT 'Object',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `idplayer`, `idobject`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 3),
(4, 2, 4),
(5, 3, 3),
(6, 4, 1),
(7, 4, 2),
(8, 1, 3),
(9, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `objet`
--

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `objet`
--

INSERT INTO `objet` (`id`, `nom`, `permanent`, `notoriete`, `alcoolemie`, `alcoolemie_optimum`, `alcoolemie_max`, `fatigue`, `fatigue_max`, `sex_appeal`, `image`) VALUES
(1, 'poule', 1, 1, 0, 0, 0, 0, -1, 3, NULL),
(2, 'pachi', 1, 1, 0, 0, 0, 0, 0, -1, NULL),
(3, 'bacchus', 1, 1, 0, 2, 2, 0, 0, 0, NULL),
(4, 'Redbull', 0, 0, 0, 0, 0, -2, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `player`
--

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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `player`
--

INSERT INTO `player` (`id`, `nom`, `pass`, `lieu`, `points`, `notoriete`, `alcoolemie`, `alcoolemie_optimum`, `alcoolemie_max`, `fatigue`, `fatigue_max`, `sex_appeal`, `en_pls`, `debut_de_pls`) VALUES
(1, 'yannick', 'toto42', 'pls', 26, 0, 6, 7, 10, 4, 10, 5, 0, 0),
(2, 'tanguy', 'rrerr', 'bar', 65, 14, 11, 7, 9, 0, 8, 4, 0, 0),
(3, 'droit monpeul', 'droit monpeul', 'bar', 0, 5, 5, 7, 10, 4, 10, 5, 0, 0),
(4, 'rose grenoble', 'rose grenoble', '', 0, 8, 2, 6, 8, 1, 12, 8, 0, 0);
