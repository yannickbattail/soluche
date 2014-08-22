-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 05, 2014 at 02:04 PM
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
-- Table structure for table `congress`
--

DROP TABLE IF EXISTS `congress`;
CREATE TABLE IF NOT EXISTS `congress` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(128) NOT NULL,
  `action_number` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `congress`
--

INSERT INTO `congress` (`id`, `nom`, `action_number`) VALUES
(1, 'Week-end luche', 42),
(2, 'Anniversaire', 50),
(3, 'Apéro fal', 20),
(4, 'Baptème', 30);

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
  `money` int(11) NOT NULL DEFAULT '0',
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
CREATE TABLE IF NOT EXISTS `inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_player` int(11) DEFAULT NULL COMMENT 'Player',
  `id_item` int(11) DEFAULT NULL COMMENT 'Item',
  PRIMARY KEY (`id`),
  KEY `id_player` (`id_player`),
  KEY `id_item` (`id_item`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=616 ;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `id_player`, `id_item`) VALUES
(18, -1, 7),
(19, -1, 8),
(20, -1, 9),
(21, -1, 10),
(22, -2, 11),
(23, -2, 12),
(36, 1, 5),
(37, 1, 6),
(513, 1, 8),
(515, 1, 13),
(536, 1, 4),
(538, 1, 11),
(572, 1, 1),
(573, 1, 394),
(598, -3, 4),
(599, -3, 7),
(600, -3, 8),
(601, -3, 11),
(602, -3, 12),
(603, -3, 13),
(604, -3, 13),
(606, 1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
CREATE TABLE IF NOT EXISTS `item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(128) NOT NULL,
  `permanent` int(11) NOT NULL DEFAULT '0',
  `notoriete` int(11) NOT NULL DEFAULT '0',
  `alcoolemie` int(11) NOT NULL DEFAULT '0',
  `alcoolemie_optimum` int(11) NOT NULL DEFAULT '0',
  `alcoolemie_max` int(11) NOT NULL DEFAULT '0',
  `fatigue` int(11) NOT NULL DEFAULT '0',
  `fatigue_max` int(11) NOT NULL DEFAULT '0',
  `sex_appeal` int(11) NOT NULL DEFAULT '0',
  `image` varchar(1024) DEFAULT NULL,
  `item_type` varchar(128) NOT NULL,
  `remaining_time` int(11) NOT NULL DEFAULT '0',
  `money` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=525 ;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `nom`, `permanent`, `notoriete`, `alcoolemie`, `alcoolemie_optimum`, `alcoolemie_max`, `fatigue`, `fatigue_max`, `sex_appeal`, `image`, `item_type`, `remaining_time`, `money`) VALUES
(1, 'poule', 1, 1, 0, 0, 0, 0, -1, 3, 'images/items/poule.png', 'badge', 0, 0),
(2, 'pachi', 1, 1, 0, 0, 0, 0, 0, -1, 'images/items/pachi.png', 'badge', 0, 0),
(3, 'bacchus', 1, 1, 0, 2, 2, 0, 0, 0, 'images/items/bacchus.png', 'badge', 0, 0),
(4, 'Redbull', 0, 0, 0, 0, 0, -2, 0, 0, 'images/items/redbull.png', 'drink', -1, -6),
(5, 'test+1 all', 0, 1, 1, 1, 1, 1, 1, 1, 'images/items/pouce-haut.png', 'test', 1, 0),
(6, 'test-1 all', 0, -1, -1, -1, -1, -1, -1, -1, 'images/items/pouce-bas.png', 'test', -1, 0),
(7, 'Café', 0, 0, 0, 0, 0, -2, 0, 0, 'images/items/cafe.png', 'drink', -1, -6),
(8, 'Sandwish', 0, 0, 0, 0, 0, -3, 0, 0, 'images/items/sandwich.png', 'food', -2, -10),
(9, 'vomi', 0, -8, 0, 0, 0, -1, 0, 0, 'images/items/vomi.png', 'food', -1, 0),
(10, 'Poulet', 0, 0, 0, 0, 0, -3, 0, 0, 'images/items/poulet.png', 'food', -2, 0),
(11, 'treuse', 0, 0, 2, 0, 0, 0, 0, 0, 'images/items/treuse.png', 'alcohol', -1, -18),
(12, 'biere', 0, 0, 1, 0, 0, 0, 0, 0, 'images/items/biere.png', 'alcohol', -1, -4),
(13, 'pin''s', 1, 0, 0, 0, 0, 0, 0, 0, 'images/items/pins.png', 'pins', 0, -10),
(353, '2 sexes', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/2 sexes.jpg', 'test', 0, 0),
(354, '2 sexes', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/2 sexes.jpg', 'test', 0, 0),
(355, '69', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/69.jpg', 'test', 0, 0),
(356, 'abeille', 1, 1, 0, 0, 0, 0, 0, 0, 'images/badges/abeille.jpg', 'badge', 0, 0),
(357, 'aigle germain', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/aigle germain.jpg', 'test', 0, 0),
(358, 'alambic', 1, 0, 0, 0, 1, 0, 0, 0, 'images/badges/alambic.jpg', 'badge', 0, 0),
(359, 'alette vernie', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/alette vernie.jpg', 'test', 0, 0),
(360, 'ancre', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/ancre.jpg', 'test', 0, 0),
(361, 'ane', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/ane.jpg', 'test', 0, 0),
(362, 'anneaux olympiques', 1, 0, 0, 0, 0, 0, 2, 1, 'images/badges/anneaux olympiques.jpg', 'badge', 0, 0),
(363, 'bacchus', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/bacchus.jpg', 'test', 0, 0),
(364, 'balance romaine', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/balance romaine.jpg', 'test', 0, 0),
(365, 'ballon de foot', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/ballon de foot.jpg', 'test', 0, 0),
(366, 'beta', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/beta.jpg', 'test', 0, 0),
(367, 'betterave', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/betterave.jpg', 'test', 0, 0),
(368, 'bobine et eclairs', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/bobine et eclairs.jpg', 'test', 0, 0),
(369, 'bobine', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/bobine.jpg', 'test', 0, 0),
(370, 'boulon argente', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/boulon argente.jpg', 'test', 0, 0),
(371, 'bourse', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/bourse.jpg', 'test', 0, 0),
(372, 'bouteille de champagne', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/bouteille de champagne.jpg', 'test', 0, 0),
(373, 'caducee medecine 2', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/caducee medecine 2.jpg', 'test', 0, 0),
(374, 'caducee medecine', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/caducee medecine.jpg', 'test', 0, 0),
(375, 'caducee mercure', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/caducee mercure.jpg', 'test', 0, 0),
(376, 'caducee pharmacie', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/caducee pharmacie.jpg', 'test', 0, 0),
(377, 'caducee psychologie belge', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/caducee psychologie belge.jpg', 'test', 0, 0),
(378, 'caducee psychologie', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/caducee psychologie.jpg', 'test', 0, 0),
(379, 'caducee veterinaire', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/caducee veterinaire.jpg', 'test', 0, 0),
(380, 'calice', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/calice.jpg', 'test', 0, 0),
(381, 'carotte', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/carotte.jpg', 'test', 0, 0),
(382, 'cartes a jouer', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/cartes a jouer.jpg', 'test', 0, 0),
(383, 'cerf', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/cerf.jpg', 'test', 0, 0),
(384, 'chameau a 2 bosses', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/chameau a 2 bosses.jpg', 'test', 0, 0),
(385, 'chameau', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/chameau.jpg', 'test', 0, 0),
(386, 'chardon lorrain', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/chardon lorrain.jpg', 'test', 0, 0),
(387, 'chauve souris', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/chauve souris.jpg', 'test', 0, 0),
(388, 'chope', 1, 0, 0, 1, 1, 0, 0, 0, 'images/badges/chope.jpg', 'badge', 0, 0),
(389, 'chou fleur', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/chou fleur.jpg', 'test', 0, 0),
(390, 'chouette a deux faces', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/chouette a deux faces.jpg', 'test', 0, 0),
(391, 'chouette', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/chouette.jpg', 'test', 0, 0),
(392, 'cigogne', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/cigogne.jpg', 'test', 0, 0),
(393, 'ciseaux', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/ciseaux.jpg', 'test', 0, 0),
(394, 'cle de sol', 1, 2, 0, 0, 0, 0, 0, 0, 'images/badges/cle de sol.jpg', 'badge', 0, 0),
(395, 'cle', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/cle.jpg', 'test', 0, 0),
(396, 'cochon', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/cochon.jpg', 'test', 0, 0),
(397, 'cocotte en papier', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/cocotte en papier.jpg', 'test', 0, 0),
(398, 'coq wallon', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/coq wallon.jpg', 'test', 0, 0),
(399, 'coq', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/coq.jpg', 'test', 0, 0),
(400, 'cor de chasse', 1, 1, 0, 0, 0, 0, 0, 1, 'images/badges/cor de chasse.jpg', 'badge', 0, 0),
(401, 'cornue et ballon', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/cornue et ballon.jpg', 'test', 0, 0),
(402, 'couronne argentee', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/couronne argentee.jpg', 'test', 0, 0),
(403, 'couronne doree', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/couronne doree.jpg', 'test', 0, 0),
(404, 'crabe', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/crabe.jpg', 'test', 0, 0),
(405, 'croissant de lune', 1, 5, 0, 0, 0, 0, 0, 0, 'images/badges/croissant de lune.jpg', 'cros', 0, 0),
(406, 'croix de grand chambellan', 1, 5, 0, 0, 0, 0, 0, 0, 'images/badges/croix de grand chambellan.jpg', 'cros', 0, 0),
(407, 'croix de grand maitre', 1, 5, 0, 0, 0, 0, 0, 0, 'images/badges/croix de grand maitre.jpg', 'cros', 0, 0),
(408, 'croix egyptienne', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/croix egyptienne.jpg', 'test', 0, 0),
(409, 'de a jouer', 1, 0, 2, 0, 2, 0, 0, 0, 'images/badges/de a jouer.jpg', 'badge', 0, 0),
(410, 'ecureuil', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/ecureuil.jpg', 'test', 0, 0),
(411, 'epee', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/epee.jpg', 'test', 0, 0),
(412, 'epi de ble', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/epi de ble.jpg', 'test', 0, 0),
(413, 'epi et faucille', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/epi et faucille.jpg', 'test', 0, 0),
(414, 'epsilon', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/epsilon.jpg', 'test', 0, 0),
(415, 'equerre et compas', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/equerre et compas.jpg', 'test', 0, 0),
(416, 'escargot', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/escargot.jpg', 'test', 0, 0),
(417, 'etoile argent grande', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/etoile argent grande.jpg', 'test', 0, 0),
(418, 'etoile argent petite', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/etoile argent petite.jpg', 'test', 0, 0),
(419, 'etoile argentee belge', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/etoile argentee belge.jpg', 'test', 0, 0),
(420, 'etoile argentee2', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/etoile argentee2.jpg', 'test', 0, 0),
(421, 'etoile doree belge', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/etoile doree belge.jpg', 'test', 0, 0),
(422, 'etoile et foudre', 1, 1, 0, 0, 0, 0, 0, 0, 'images/badges/etoile et foudre.jpg', 'test', 0, 0),
(423, 'etoile or grande', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/etoile or grande.jpg', 'test', 0, 0),
(424, 'etoile or petite', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/etoile or petite.jpg', 'test', 0, 0),
(425, 'faux', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/faux.jpg', 'test', 0, 0),
(426, 'fer a cheval', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/fer a cheval.jpg', 'test', 0, 0),
(427, 'feuille de vigne', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/feuille de vigne.jpg', 'test', 0, 0),
(428, 'flambeaux entrecroises', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/flambeaux entrecroises.jpg', 'test', 0, 0),
(429, 'fleche', 1, 0, 0, 0, 0, 0, 0, -2, 'images/badges/fleche.jpg', 'badge', 0, 0),
(430, 'fleur de lys', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/fleur de lys.jpg', 'test', 0, 0),
(431, 'flying foufoune', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/flying foufoune.jpg', 'test', 0, 0),
(432, 'flying penis', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/flying penis.jpg', 'test', 0, 0),
(433, 'fourchette & epi de ble', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/fourchette & epi de ble.jpg', 'test', 0, 0),
(434, 'fourchette', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/fourchette.jpg', 'test', 0, 0),
(435, 'fourchettes croisees', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/fourchettes croisees.jpg', 'test', 0, 0),
(436, 'gazelles', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/gazelles.jpg', 'test', 0, 0),
(437, 'girafe', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/girafe.jpg', 'test', 0, 0),
(438, 'globe', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/globe.jpg', 'test', 0, 0),
(439, 'grappe de raisin', 1, 0, 0, 1, 1, 0, 0, 0, 'images/badges/grappe de raisin.jpg', 'badge', 0, 0),
(440, 'grenouille argent', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/grenouille argent.jpg', 'test', 0, 0),
(441, 'grenouille or', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/grenouille or.jpg', 'test', 0, 0),
(443, 'hache', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/hache.jpg', 'test', 0, 0),
(444, 'hermine', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/hermine.jpg', 'test', 0, 0),
(445, 'homard', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/homard.jpg', 'test', 0, 0),
(446, 'hure', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/hure.jpg', 'test', 0, 0),
(447, 'kangourou', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/kangourou.jpg', 'test', 0, 0),
(448, 'koala', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/koala.jpg', 'test', 0, 0),
(449, 'lime', 1, -1, 0, 0, 0, 0, 0, -1, 'images/badges/lime.jpg', 'badge', 0, 0),
(450, 'lion dresse', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/lion dresse.jpg', 'test', 0, 0),
(451, 'livre ouvert et plume', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/livre ouvert et plume.jpg', 'test', 0, 0),
(452, 'locomotive', 1, -2, 0, 0, 0, 0, 0, 0, 'images/badges/locomotive.jpg', 'badge', 0, 0),
(453, 'lyre', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/lyre.jpg', 'test', 0, 0),
(454, 'mammouth', 1, 3, 0, 0, 0, 0, 0, 0, 'images/badges/mammouth.jpg', 'badge', 0, 0),
(455, 'marteau et maillet', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/marteau et maillet.jpg', 'test', 0, 0),
(456, 'molaire', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/molaire.jpg', 'test', 0, 0),
(457, 'nounours', 1, 0, 0, 0, 0, 0, -2, 0, 'images/badges/nounours.jpg', 'badge', 0, 0),
(458, 'orchidee', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/orchidee.jpg', 'badge', 0, 0),
(459, 'ouvert et plume', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/ouvert et plume.jpg', 'test', 0, 0),
(460, 'pachyderme', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/pachyderme.jpg', 'test', 0, 0),
(461, 'paire de ski', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/paire de ski.jpg', 'test', 0, 0),
(462, 'palette et pinceau', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/palette et pinceau.jpg', 'test', 0, 0),
(463, 'palme double', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/palme double.jpg', 'test', 0, 0),
(464, 'palme simple grande', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/palme simple grande.jpg', 'test', 0, 0),
(465, 'palmes croisees', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/palmes croisees.jpg', 'test', 0, 0),
(466, 'palmier', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/palmier.jpg', 'test', 0, 0),
(467, 'papillon', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/papillon.jpg', 'test', 0, 0),
(468, 'parapluie ferme', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/parapluie ferme.jpg', 'test', 0, 0),
(469, 'parapluie ouvert', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/parapluie ouvert.jpg', 'test', 0, 0),
(470, 'pendu', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/pendu.jpg', 'test', 0, 0),
(471, 'pericles', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/pericles.jpg', 'test', 0, 0),
(472, 'perron liegeois', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/perron liegeois.jpg', 'test', 0, 0),
(473, 'perroquet sur perchoir', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/perroquet sur perchoir.jpg', 'test', 0, 0),
(474, 'phi', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/phi.jpg', 'test', 0, 0),
(475, 'plume', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/plume.jpg', 'test', 0, 0),
(476, 'poireau', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/poireau.jpg', 'test', 0, 0),
(477, 'polytechnique argente', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/polytechnique argente.jpg', 'test', 0, 0),
(478, 'polytechnique dore', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/polytechnique dore.jpg', 'test', 0, 0),
(479, 'potager navet', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/potager navet.jpg', 'test', 0, 0),
(480, 'poule', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/poule.jpg', 'test', 0, 0),
(481, 'president', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/president.jpg', 'test', 0, 0),
(482, 'psi', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/psi.jpg', 'test', 0, 0),
(483, 'raquette de tennis', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/raquette de tennis.jpg', 'test', 0, 0),
(484, 'rose', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/rose.jpg', 'test', 0, 0),
(485, 'sabot', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/sabot.jpg', 'test', 0, 0),
(486, 'sanglier', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/sanglier.jpg', 'test', 0, 0),
(487, 'secretaire', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/secretaire.jpg', 'test', 0, 0),
(488, 'singe du grand garde', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/singe du grand garde.jpg', 'test', 0, 0),
(489, 'singe', 1, -1, 0, 0, 0, 0, 0, 0, 'images/badges/singe.jpg', 'badge', 0, 0),
(490, 'soleil', 1, 5, 0, 0, 0, 0, 0, 0, 'images/badges/soleil.jpg', 'cros', 0, 0),
(491, 'solvay', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/solvay.jpg', 'test', 0, 0),
(492, 'sou troue', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/sou troue.jpg', 'test', 0, 0),
(493, 'sphinx', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/sphinx.jpg', 'test', 0, 0),
(494, 'squelette', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/squelette.jpg', 'test', 0, 0),
(495, 'tambour', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/tambour.jpg', 'test', 0, 0),
(496, 'taste vin', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/taste vin.jpg', 'test', 0, 0),
(497, 'telephone', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/telephone.jpg', 'test', 0, 0),
(498, 'tete d''indien', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/tete d''indien.jpg', 'test', 0, 0),
(499, 'tete de cheval', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/tete de cheval.jpg', 'test', 0, 0),
(500, 'tete de loup vue de face', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/tete de loup vue de face.jpg', 'test', 0, 0),
(501, 'tete de loup vue de profil', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/tete de loup vue de profil.jpg', 'test', 0, 0),
(502, 'tete de mort sur femurs', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/tete de mort sur femurs.jpg', 'test', 0, 0),
(503, 'tete de mort', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/tete de mort.jpg', 'test', 0, 0),
(504, 'tete de vache', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/tete de vache.jpg', 'test', 0, 0),
(505, 'tomate', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/tomate.jpg', 'test', 0, 0),
(506, 'tore', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/tore.jpg', 'test', 0, 0),
(507, 'tortue or', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/tortue or.jpg', 'test', 0, 0),
(508, 'trefle a 4 feuilles', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/trefle a 4 feuilles.jpg', 'test', 0, 0),
(509, 'tresorier', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/tresorier.jpg', 'test', 0, 0),
(510, 'valise', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/valise.jpg', 'test', 0, 0),
(511, 'vice president', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/vice president.jpg', 'test', 0, 0),
(512, 'voilier', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/voilier.jpg', 'test', 0, 0),
(513, 'volant', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/volant.jpg', 'test', 0, 0),
(514, 'zodiaque balance', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/zodiaque balance.jpg', 'test', 0, 0),
(515, 'zodiaque belier', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/zodiaque belier.jpg', 'test', 0, 0),
(516, 'zodiaque capricorne', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/zodiaque capricorne.jpg', 'test', 0, 0),
(517, 'zodiaque gemeaux', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/zodiaque gemeaux.jpg', 'test', 0, 0),
(518, 'zodiaque lion', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/zodiaque lion.jpg', 'test', 0, 0),
(519, 'zodiaque poisson', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/zodiaque poisson.jpg', 'test', 0, 0),
(520, 'zodiaque sagittaire', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/zodiaque sagittaire.jpg', 'test', 0, 0),
(521, 'zodiaque scorpion', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/zodiaque scorpion.jpg', 'test', 0, 0),
(522, 'zodiaque taureau', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/zodiaque taureau.jpg', 'test', 0, 0),
(523, 'zodiaque vierge', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/zodiaque vierge.jpg', 'test', 0, 0),
(524, 'pins exigeons la dignité', 1, 0, 0, 0, 0, 0, 0, 0, 'images/items/pin-s-exigeons-la-dignité.png', 'pins', 0, 0);

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
  `remaining_time` int(11) NOT NULL,
  `money` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_congress` (`id_congress`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=125 ;

--
-- Dumping data for table `player`
--

INSERT INTO `player` (`id`, `nom`, `pass`, `lieu`, `points`, `notoriete`, `alcoolemie`, `alcoolemie_optimum`, `alcoolemie_max`, `fatigue`, `fatigue_max`, `sex_appeal`, `en_pls`, `debut_de_pls`, `sex`, `photo`, `pnj`, `id_congress`, `remaining_time`, `money`) VALUES
(-3, 'orga', '', '', 0, 0, 0, 0, 10, 0, 0, 0, 0, 0, 1, 'images/tete_faluche_bleu.jpg', 2, 2, 0, 50),
(-2, 'bar', '', '', 0, 0, 0, 0, 10, 0, 0, 0, 0, 0, 1, 'images/tete_faluche_bleu.jpg', 2, 2, 0, 50),
(-1, 'cuisine', '', '', 0, 0, 0, 0, 10, 0, 0, 0, 0, 0, 0, 'images/tete_faluche_rose.jpg', 2, 2, 0, 50),
(1, 'yannick', 'yannick', 'orga', 10, 10, 3, 7, 10, 0, 10, 5, 0, 0, 1, 'upload/photo_players/1.gif', 0, 2, 6, 50),
(61, 'rose Annecy', '', 'danse', 0, 10, 5, 6, 11, 3, 9, 8, 0, 0, 1, 'images/tete_faluche_bleu.jpg', 1, 2, 0, 50),
(62, 'ingé Annecy', '', 'danse', 0, 8, 7, 5, 11, 2, 9, 5, 0, 0, 1, 'images/tete_faluche_bleu.jpg', 1, 2, 0, 50),
(63, 'droit Annecy', '', 'danse', 5, 11, 6, 5, 12, 2, 10, 8, 0, 0, 0, 'images/tete_faluche_rose.jpg', 1, 2, 0, 50),
(64, 'sciences Annecy', '', 'bar', 0, 4, 3, 7, 12, 6, 7, 5, 0, 0, 1, 'images/tete_faluche_bleu.jpg', 1, 2, 0, 50),
(65, 'sage-pouf Annecy', '', 'camping', 0, 9, 4, 5, 10, 3, 8, 7, 0, 0, 0, 'images/tete_faluche_rose.jpg', 1, 2, 0, 50),
(66, 'jaune Annecy', '', 'camping', 0, 4, 6, 7, 9, 3, 9, 7, 0, 0, 0, 'images/tete_faluche_rose.jpg', 1, 2, 0, 50),
(67, 'Pharma Annecy', '', 'cuisine', 0, 4, 2, 7, 12, 2, 7, 10, 0, 0, 0, 'images/tete_faluche_rose.jpg', 1, 2, 0, 50),
(68, 'Médecine Annecy', '', 'bar', 0, 9, 6, 7, 9, 7, 7, 6, 0, 0, 0, 'images/tete_faluche_rose.jpg', 1, 2, 0, 50),
(69, 'rose Grenoble', '', 'cuisine', 0, 7, 6, 6, 11, 7, 7, 5, 0, 0, 0, 'images/tete_faluche_rose.jpg', 1, 2, 0, 50),
(70, 'ingé Grenoble', '', 'bar', 0, 10, 3, 7, 9, 2, 7, 6, 0, 0, 0, 'images/tete_faluche_rose.jpg', 1, 2, 0, 50),
(71, 'droit Grenoble', '', 'bar', 0, 9, 4, 8, 12, 7, 7, 6, 0, 0, 0, 'images/tete_faluche_rose.jpg', 1, 2, 0, 50),
(72, 'sciences Grenoble', '', 'cuisine', 0, 7, 5, 8, 12, 5, 10, 10, 0, 0, 1, 'images/tete_faluche_bleu.jpg', 1, 2, 0, 50),
(73, 'sage-pouf Grenoble', '', 'camping', 0, 4, 3, 5, 10, 4, 10, 5, 0, 0, 0, 'images/tete_faluche_rose.jpg', 1, 2, 0, 50),
(74, 'jaune Grenoble', '', 'camping', 0, 9, 2, 5, 10, 3, 10, 8, 0, 0, 1, 'images/tete_faluche_bleu.jpg', 1, 2, 0, 50),
(75, 'Pharma Grenoble', '', 'cuisine', 0, 10, 2, 6, 11, 2, 7, 9, 0, 0, 1, 'images/tete_faluche_bleu.jpg', 1, 2, 0, 50),
(76, 'Médecine Grenoble', '', 'camping', 0, 8, 5, 7, 11, 7, 9, 8, 0, 0, 1, 'images/tete_faluche_bleu.jpg', 1, 2, 0, 50),
(77, 'rose Lyon', '', 'bar', 0, 7, 5, 6, 9, 6, 10, 5, 0, 0, 1, 'images/tete_faluche_bleu.jpg', 1, 2, 0, 50),
(78, 'ingé Lyon', '', 'camping', 0, 10, 5, 7, 12, 4, 8, 5, 0, 0, 0, 'images/tete_faluche_rose.jpg', 1, 2, 0, 50),
(79, 'droit Lyon', '', 'camping', 0, 9, 2, 6, 11, 7, 8, 7, 0, 0, 1, 'images/tete_faluche_bleu.jpg', 1, 2, 0, 50),
(80, 'sciences Lyon', '', 'bar', 0, 8, 5, 7, 10, 6, 10, 9, 0, 0, 0, 'images/tete_faluche_rose.jpg', 1, 2, 0, 50),
(81, 'sage-pouf Lyon', '', 'bar', 0, 8, 6, 6, 12, 3, 10, 10, 0, 0, 1, 'images/tete_faluche_bleu.jpg', 1, 2, 0, 50),
(82, 'jaune Lyon', '', 'camping', 0, 7, 4, 8, 10, 3, 9, 9, 0, 0, 0, 'images/tete_faluche_rose.jpg', 1, 2, 0, 50),
(83, 'Pharma Lyon', '', 'cuisine', 0, 8, 4, 6, 9, 7, 7, 6, 0, 0, 1, 'images/tete_faluche_bleu.jpg', 1, 2, 0, 50),
(84, 'Médecine Lyon', '', 'cuisine', 0, 8, 2, 8, 10, 2, 9, 6, 0, 0, 1, 'images/tete_faluche_bleu.jpg', 1, 2, 0, 50),
(85, 'rose Monpeul', '', 'danse', 0, 7, 5, 5, 9, 7, 10, 7, 0, 0, 1, 'images/tete_faluche_bleu.jpg', 1, 2, 0, 50),
(86, 'ingé Monpeul', '', 'bar', 0, 8, 6, 7, 11, 5, 9, 6, 0, 0, 1, 'images/tete_faluche_bleu.jpg', 1, 2, 0, 50),
(87, 'droit Monpeul', '', 'bar', 0, 8, 3, 7, 11, 7, 8, 5, 0, 0, 0, 'images/tete_faluche_rose.jpg', 1, 2, 0, 50),
(88, 'sciences Monpeul', '', 'danse', 0, 4, 2, 7, 10, 1, 9, 6, 0, 0, 0, 'images/tete_faluche_rose.jpg', 1, 2, 0, 50),
(89, 'sage-pouf Monpeul', '', 'danse', 0, 5, 6, 8, 11, 7, 9, 10, 0, 0, 1, 'images/tete_faluche_bleu.jpg', 1, 2, 0, 50),
(90, 'jaune Monpeul', '', 'camping', 0, 5, 3, 7, 11, 1, 10, 9, 0, 0, 0, 'images/tete_faluche_rose.jpg', 1, 2, 0, 50),
(91, 'Pharma Monpeul', '', 'bar', 0, 4, 7, 7, 12, 1, 9, 10, 0, 0, 0, 'images/tete_faluche_rose.jpg', 1, 2, 0, 50),
(92, 'Médecine Monpeul', '', 'bar', 0, 7, 7, 6, 12, 3, 9, 10, 0, 0, 1, 'images/tete_faluche_bleu.jpg', 1, 2, 0, 50),
(93, 'rose Valence', '', 'camping', 0, 6, 5, 6, 12, 7, 8, 7, 0, 0, 0, 'images/tete_faluche_rose.jpg', 1, 2, 0, 50),
(94, 'ingé Valence', '', 'cuisine', 0, 7, 3, 6, 9, 4, 9, 8, 0, 0, 1, 'images/tete_faluche_bleu.jpg', 1, 2, 0, 50),
(95, 'droit Valence', '', 'cuisine', 0, 4, 7, 6, 9, 6, 9, 9, 0, 0, 1, 'images/tete_faluche_bleu.jpg', 1, 2, 0, 50),
(96, 'sciences Valence', '', 'cuisine', 0, 10, 5, 7, 11, 1, 10, 7, 0, 0, 1, 'images/tete_faluche_bleu.jpg', 1, 2, 0, 50),
(97, 'sage-pouf Valence', '', 'cuisine', 0, 6, 3, 5, 9, 5, 10, 8, 0, 0, 1, 'images/tete_faluche_bleu.jpg', 1, 2, 0, 50),
(98, 'jaune Valence', '', 'bar', 0, 7, 4, 8, 12, 4, 10, 5, 0, 0, 0, 'images/tete_faluche_rose.jpg', 1, 2, 0, 50),
(99, 'Pharma Valence', '', 'bar', 0, 9, 2, 7, 12, 3, 8, 8, 0, 0, 0, 'images/tete_faluche_rose.jpg', 1, 2, 0, 50),
(100, 'Médecine Valence', '', 'cuisine', 0, 10, 6, 8, 12, 3, 10, 8, 0, 0, 1, 'images/tete_faluche_bleu.jpg', 1, 2, 0, 50),
(101, 'rose Aix', '', 'camping', 0, 10, 4, 5, 12, 6, 8, 8, 0, 0, 1, 'images/tete_faluche_bleu.jpg', 1, 1, 0, 50),
(102, 'ingé Aix', '', 'bar', 0, 6, 4, 7, 12, 4, 10, 5, 0, 0, 0, 'images/tete_faluche_rose.jpg', 1, 1, 0, 50),
(103, 'droit Aix', '', 'camping', 0, 5, 5, 5, 11, 1, 8, 10, 0, 0, 1, 'images/tete_faluche_bleu.jpg', 1, 1, 0, 50),
(104, 'sciences Aix', '', 'camping', 0, 10, 2, 8, 9, 5, 8, 9, 0, 0, 0, 'images/tete_faluche_rose.jpg', 1, 1, 0, 50),
(105, 'sage-pouf Aix', '', 'cuisine', 0, 6, 6, 7, 10, 3, 8, 6, 0, 0, 0, 'images/tete_faluche_rose.jpg', 1, 1, 0, 50),
(106, 'jaune Aix', '', 'bar', 0, 9, 6, 8, 12, 7, 9, 10, 0, 0, 0, 'images/tete_faluche_rose.jpg', 1, 1, 0, 50),
(107, 'Pharma Aix', '', 'bar', 0, 6, 7, 7, 11, 6, 7, 7, 0, 0, 0, 'images/tete_faluche_rose.jpg', 1, 1, 0, 50),
(108, 'Médecine Aix', '', 'cuisine', 0, 7, 3, 8, 9, 6, 10, 8, 0, 0, 0, 'images/tete_faluche_rose.jpg', 1, 1, 0, 50),
(109, 'rose Marseille', '', 'cuisine', 0, 9, 7, 6, 10, 5, 9, 8, 0, 0, 0, 'images/tete_faluche_rose.jpg', 1, 1, 0, 50),
(110, 'ingé Marseille', '', 'cuisine', 0, 10, 5, 5, 11, 5, 7, 9, 0, 0, 1, 'images/tete_faluche_bleu.jpg', 1, 1, 0, 50),
(111, 'droit Marseille', '', 'cuisine', 0, 5, 6, 7, 10, 4, 9, 6, 0, 0, 1, 'images/tete_faluche_bleu.jpg', 1, 1, 0, 50),
(112, 'sciences Marseille', '', 'cuisine', 0, 10, 7, 7, 9, 5, 8, 5, 0, 0, 1, 'images/tete_faluche_bleu.jpg', 1, 1, 0, 50),
(113, 'sage-pouf Marseille', '', 'camping', 0, 6, 7, 6, 11, 2, 10, 8, 0, 0, 1, 'images/tete_faluche_bleu.jpg', 1, 1, 0, 50),
(114, 'jaune Marseille', '', 'camping', 0, 9, 4, 6, 9, 6, 8, 6, 0, 0, 1, 'images/tete_faluche_bleu.jpg', 1, 1, 0, 50),
(115, 'Pharma Marseille', '', 'bar', 0, 9, 6, 6, 9, 6, 7, 9, 0, 0, 1, 'images/tete_faluche_bleu.jpg', 1, 1, 0, 50),
(116, 'Médecine Marseille', '', 'danse', 0, 10, 5, 8, 12, 3, 7, 9, 0, 0, 0, 'images/tete_faluche_rose.jpg', 1, 1, 0, 50),
(117, 'rose Dijon', '', 'bar', 0, 6, 3, 6, 10, 2, 10, 7, 0, 0, 0, 'images/tete_faluche_rose.jpg', 1, 1, 0, 50),
(118, 'ingé Dijon', '', 'bar', 0, 4, 4, 8, 12, 3, 10, 6, 0, 0, 0, 'images/tete_faluche_rose.jpg', 1, 1, 0, 50),
(119, 'droit Dijon', '', 'danse', 0, 6, 3, 7, 10, 4, 7, 8, 0, 0, 0, 'images/tete_faluche_rose.jpg', 1, 1, 0, 50),
(120, 'sciences Dijon', '', 'cuisine', 0, 5, 7, 7, 9, 3, 8, 6, 0, 0, 1, 'images/tete_faluche_bleu.jpg', 1, 1, 0, 50),
(121, 'sage-pouf Dijon', '', 'cuisine', 0, 5, 2, 7, 12, 4, 9, 5, 0, 0, 0, 'images/tete_faluche_rose.jpg', 1, 1, 0, 50),
(122, 'jaune Dijon', '', 'bar', 0, 4, 2, 6, 12, 6, 10, 6, 0, 0, 0, 'images/tete_faluche_rose.jpg', 1, 1, 0, 50),
(123, 'Pharma Dijon', '', 'bar', 0, 8, 6, 8, 10, 1, 7, 7, 0, 0, 0, 'images/tete_faluche_rose.jpg', 1, 1, 0, 50),
(124, 'Médecine Dijon', '', 'camping', 0, 8, 4, 7, 9, 6, 9, 9, 0, 0, 1, 'images/tete_faluche_bleu.jpg', 1, 1, 0, 50);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_ibfk_1` FOREIGN KEY (`id_player`) REFERENCES `player` (`id`),
  ADD CONSTRAINT `history_ibfk_2` FOREIGN KEY (`id_congress`) REFERENCES `congress` (`id`),
  ADD CONSTRAINT `history_ibfk_3` FOREIGN KEY (`id_opponent`) REFERENCES `player` (`id`),
  ADD CONSTRAINT `history_ibfk_4` FOREIGN KEY (`id_item`) REFERENCES `item` (`id`);

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`id_item`) REFERENCES `item` (`id`),
  ADD CONSTRAINT `inventory_ibfk_2` FOREIGN KEY (`id_player`) REFERENCES `player` (`id`);

--
-- Constraints for table `player`
--
ALTER TABLE `player`
  ADD CONSTRAINT `player_ibfk_1` FOREIGN KEY (`id_congress`) REFERENCES `congress` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
