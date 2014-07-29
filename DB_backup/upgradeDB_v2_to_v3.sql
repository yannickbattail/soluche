-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2014 at 07:12 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

DROP TABLE IF EXISTS `history`;
CREATE TABLE IF NOT EXISTS `history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_player` int(11) NOT NULL,
  `id_congress` int(11) DEFAULT NULL,
  `action_name` varchar(128) NOT NULL,
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
  `remaining_time` int(11) NOT NULL,
  `date_action` int(11) NOT NULL,
  `success` int(11) NOT NULL,
  `message` varchar(1024) NOT NULL,
  `id_opponent` int(11) DEFAULT NULL,
  `id_item` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_congress` (`id_congress`),
  KEY `id_player` (`id_player`),
  KEY `id_opponent` (`id_opponent`),
  KEY `id_item` (`id_item`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=168 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_ibfk_4` FOREIGN KEY (`id_item`) REFERENCES `item` (`id`),
  ADD CONSTRAINT `history_ibfk_1` FOREIGN KEY (`id_player`) REFERENCES `player` (`id`),
  ADD CONSTRAINT `history_ibfk_2` FOREIGN KEY (`id_congress`) REFERENCES `congress` (`id`),
  ADD CONSTRAINT `history_ibfk_3` FOREIGN KEY (`id_opponent`) REFERENCES `player` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
