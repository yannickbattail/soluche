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
CREATE DATABASE IF NOT EXISTS `soluche` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `soluche`;

-- --------------------------------------------------------

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
(16, 1, 5),
(17, 1, 6),
(24, 1, 4),
(25, 1, 8),
(27, 1, 4),
(28, 1, 8),
(29, 1, 11);

-- --------------------------------------------------------

--
-- Dumping data for table `player`
--

INSERT INTO `player` (`id`, `nom`, `pass`, `lieu`, `points`, `notoriete`, `alcoolemie`, `alcoolemie_optimum`, `alcoolemie_max`, `fatigue`, `fatigue_max`, `sex_appeal`, `en_pls`, `debut_de_pls`, `sex`, `photo`, `pnj`, `id_congress`) VALUES
(1, 'yannick', 'toto42', 'camping', 11, 0, 9, 7, 10, 0, 10, 5, 0, 0, 1, 'images/tete_faluche_noir.jpg', 0, 2),
(2, 'tanguy', 'rrerr', 'bar', 5, 5, 13, 7, 10, 0, 8, 4, 1, 0, 0, 'images/tete_faluche_grise.jpg', 0, NULL),
(3, 'droit monpeul', 'droit monpeul', 'cuisine', 6, 5, 5, 7, 10, 4, 10, 5, 0, 0, 0, 'images/tete_faluche_blanc.jpg', 0, NULL),
(4, 'rose grenoble', 'rose grenoble', 'danse', 5, 5, 3, 6, 10, 1, 12, 8, 0, 0, 0, 'images/tete_faluche_rose.jpg', 0, NULL),
(5, 'pelotik', 'toto42', 'camping', 0, 0, 0, 7, 10, 0, 10, 5, 0, 0, 0, 'images/tete_faluche_noir.jpg', 0, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
