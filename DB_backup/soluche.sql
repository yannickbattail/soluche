-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2014 at 08:09 PM
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
-- Table structure for table `inventory`
--

CREATE TABLE IF NOT EXISTS `inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idplayer` int(11) DEFAULT NULL COMMENT 'Player',
  `idobject` int(11) DEFAULT NULL COMMENT 'Object',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `idplayer`, `idobject`) VALUES
(18, -1, 7),
(19, -1, 8),
(20, -1, 9),
(21, -1, 10);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `objet`
--

INSERT INTO `objet` (`id`, `nom`, `permanent`, `notoriete`, `alcoolemie`, `alcoolemie_optimum`, `alcoolemie_max`, `fatigue`, `fatigue_max`, `sex_appeal`, `image`) VALUES
(1, 'poule', 1, 1, 0, 0, 0, 0, -1, 3, 'http://www.folygraphie.com/Files/30421/Img/11/V_FI36.jpg'),
(2, 'pachi', 1, 1, 0, 0, 0, 0, 0, -1, 'http://www.folygraphie.com/Files/30421/Img/23/V_FI32.jpg'),
(3, 'bacchus', 1, 1, 0, 2, 2, 0, 0, 0, 'http://www.folygraphie.com/Files/30421/Img/16/V_FI03.jpg'),
(4, 'Redbull', 0, 0, 0, 0, 0, -2, 0, 0, 'https://pbs.twimg.com/profile_images/3279882170/000d6bd25d03108d79a678c17a4fe52b_normal.jpeg'),
(5, 'test+1 all', 0, 1, 1, 1, 1, 1, 1, 1, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQu5QpMqs1PupQHFP1O2Jy9WsdtUJ79Mfijx9kZmkWGbBt5cN6J'),
(6, 'test-1 all', 0, -1, -1, -1, -1, -1, -1, -1, 'https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcTz4kOJHKWBQOGv1jWyAGH6OnM5idwHXm0u5xNv8RIk0fDU6_F52Q'),
(7, 'Café', 0, 0, 0, 0, 0, -2, 0, 0, 'http://www.auberge-des-fees.ch/images/pipo_espresso.png'),
(8, 'Sandwish', 0, 0, 0, 0, 0, -3, 0, 0, 'http://images.clipartpanda.com/sandwich-clipart-sandwich-4.gif'),
(9, 'vomi', 0, -8, 0, 0, 0, -1, 0, 0, 'http://www.soimmature.com/images/foamy_vomit.gif'),
(10, 'Poulet', 0, 0, 0, 0, 0, -3, 0, 0, 'http://www.jonathan-menet.fr/blog/wp-content/uploads/2013/11/idee-cadeau-bonet-poulet-roti_1.jpg');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `player`
--

INSERT INTO `player` (`id`, `nom`, `pass`, `lieu`, `points`, `notoriete`, `alcoolemie`, `alcoolemie_optimum`, `alcoolemie_max`, `fatigue`, `fatigue_max`, `sex_appeal`, `en_pls`, `debut_de_pls`) VALUES
(-1, 'cuisine', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
