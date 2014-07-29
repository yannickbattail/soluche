-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2014 at 07:19 PM
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `congress`
--

INSERT INTO `congress` (`id`, `nom`, `action_number`) VALUES
(1, 'Week-end luche', 30),
(2, 'Anniversaire', 20);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=557 ;

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
(516, 1, 13),
(517, 1, 13),
(518, 1, 4),
(519, 1, 8),
(521, 1, 13),
(522, 1, 13),
(523, 1, 13),
(524, 1, 4),
(525, 1, 8),
(526, 1, 11),
(527, 1, 13),
(528, 1, 13),
(529, 1, 13),
(530, 1, 4),
(531, 1, 8),
(532, 1, 11),
(533, 1, 13),
(534, 1, 13),
(535, 1, 13),
(536, 1, 4),
(537, 1, 8),
(538, 1, 11),
(539, 1, 13),
(540, 1, 13),
(541, 1, 13),
(542, 1, 4),
(543, 1, 8),
(544, 1, 11),
(545, 1, 13),
(546, 1, 13),
(547, 1, 13),
(548, 1, 4),
(549, 1, 8),
(550, 1, 11),
(551, 1, 13),
(552, 1, 13),
(553, 1, 13);

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=524 ;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `nom`, `permanent`, `notoriete`, `alcoolemie`, `alcoolemie_optimum`, `alcoolemie_max`, `fatigue`, `fatigue_max`, `sex_appeal`, `image`, `item_type`) VALUES
(1, 'poule', 1, 1, 0, 0, 0, 0, -1, 3, 'images/items/poule.png', 'badge'),
(2, 'pachi', 1, 1, 0, 0, 0, 0, 0, -1, 'images/items/pachi.png', 'badge'),
(3, 'bacchus', 1, 1, 0, 2, 2, 0, 0, 0, 'images/items/bacchus.png', 'badge'),
(4, 'Redbull', 0, 0, 0, 0, 0, -2, 0, 0, 'images/items/redbull.png', 'drink'),
(5, 'test+1 all', 0, 1, 1, 1, 1, 1, 1, 1, 'images/items/pouce-haut.png', 'test'),
(6, 'test-1 all', 0, -1, -1, -1, -1, -1, -1, -1, 'images/items/pouce-bas.png', 'test'),
(7, 'Café', 0, 0, 0, 0, 0, -2, 0, 0, 'images/items/cafe.png', 'drink'),
(8, 'Sandwish', 0, 0, 0, 0, 0, -3, 0, 0, 'images/items/sandwich.png', 'food'),
(9, 'vomi', 0, -8, 0, 0, 0, -1, 0, 0, 'images/items/vomi.png', 'food'),
(10, 'Poulet', 0, 0, 0, 0, 0, -3, 0, 0, 'images/items/poulet.png', 'food'),
(11, 'treuse', 0, 0, 2, 0, 0, 0, 0, 0, 'images/items/treuse.png', 'alcohol'),
(12, 'biere', 0, 0, 1, 0, 0, 0, 0, 0, 'images/items/biere.png', 'alcohol'),
(13, 'pin''s', 1, 0, 0, 0, 0, 0, 0, 0, 'images/items/pins.png', 'pins'),
(353, '2 sexes.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/2 sexes.jpg', 'test'),
(354, '2 sexes.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/2 sexes.jpg', 'test'),
(355, '69.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/69.jpg', 'test'),
(356, 'abeille.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/abeille.jpg', 'test'),
(357, 'aigle germain.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/aigle germain.jpg', 'test'),
(358, 'alambic.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/alambic.jpg', 'test'),
(359, 'alette vernie.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/alette vernie.jpg', 'test'),
(360, 'ancre.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/ancre.jpg', 'test'),
(361, 'ane.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/ane.jpg', 'test'),
(362, 'anneaux olympiques.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/anneaux olympiques.jpg', 'test'),
(363, 'bacchus.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/bacchus.jpg', 'test'),
(364, 'balance romaine.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/balance romaine.jpg', 'test'),
(365, 'ballon de foot.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/ballon de foot.jpg', 'test'),
(366, 'beta.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/beta.jpg', 'test'),
(367, 'betterave.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/betterave.jpg', 'test'),
(368, 'bobine et eclairs.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/bobine et eclairs.jpg', 'test'),
(369, 'bobine.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/bobine.jpg', 'test'),
(370, 'boulon argente.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/boulon argente.jpg', 'test'),
(371, 'bourse.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/bourse.jpg', 'test'),
(372, 'bouteille de champagne.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/bouteille de champagne.jpg', 'test'),
(373, 'caducee medecine 2.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/caducee medecine 2.jpg', 'test'),
(374, 'caducee medecine.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/caducee medecine.jpg', 'test'),
(375, 'caducee mercure.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/caducee mercure.jpg', 'test'),
(376, 'caducee pharmacie.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/caducee pharmacie.jpg', 'test'),
(377, 'caducee psychologie belge.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/caducee psychologie belge.jpg', 'test'),
(378, 'caducee psychologie.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/caducee psychologie.jpg', 'test'),
(379, 'caducee veterinaire.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/caducee veterinaire.jpg', 'test'),
(380, 'calice.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/calice.jpg', 'test'),
(381, 'carotte.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/carotte.jpg', 'test'),
(382, 'cartes a jouer.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/cartes a jouer.jpg', 'test'),
(383, 'cerf.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/cerf.jpg', 'test'),
(384, 'chameau a 2 bosses.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/chameau a 2 bosses.jpg', 'test'),
(385, 'chameau.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/chameau.jpg', 'test'),
(386, 'chardon lorrain.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/chardon lorrain.jpg', 'test'),
(387, 'chauve souris.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/chauve souris.jpg', 'test'),
(388, 'chope.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/chope.jpg', 'test'),
(389, 'chou fleur.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/chou fleur.jpg', 'test'),
(390, 'chouette a deux faces.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/chouette a deux faces.jpg', 'test'),
(391, 'chouette.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/chouette.jpg', 'test'),
(392, 'cigogne.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/cigogne.jpg', 'test'),
(393, 'ciseaux.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/ciseaux.jpg', 'test'),
(394, 'cle de sol.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/cle de sol.jpg', 'test'),
(395, 'cle.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/cle.jpg', 'test'),
(396, 'cochon.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/cochon.jpg', 'test'),
(397, 'cocotte en papier.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/cocotte en papier.jpg', 'test'),
(398, 'coq wallon.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/coq wallon.jpg', 'test'),
(399, 'coq.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/coq.jpg', 'test'),
(400, 'cor de chasse.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/cor de chasse.jpg', 'test'),
(401, 'cornue et ballon.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/cornue et ballon.jpg', 'test'),
(402, 'couronne argentee.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/couronne argentee.jpg', 'test'),
(403, 'couronne doree.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/couronne doree.jpg', 'test'),
(404, 'crabe.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/crabe.jpg', 'test'),
(405, 'croissant de lune.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/croissant de lune.jpg', 'test'),
(406, 'croix de grand chambellan.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/croix de grand chambellan.jpg', 'test'),
(407, 'croix de grand maitre.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/croix de grand maitre.jpg', 'test'),
(408, 'croix egyptienne.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/croix egyptienne.jpg', 'test'),
(409, 'de a jouer.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/de a jouer.jpg', 'test'),
(410, 'ecureuil.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/ecureuil.jpg', 'test'),
(411, 'epee.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/epee.jpg', 'test'),
(412, 'epi de ble.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/epi de ble.jpg', 'test'),
(413, 'epi et faucille.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/epi et faucille.jpg', 'test'),
(414, 'epsilon.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/epsilon.jpg', 'test'),
(415, 'equerre et compas.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/equerre et compas.jpg', 'test'),
(416, 'escargot.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/escargot.jpg', 'test'),
(417, 'etoile argent grande.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/etoile argent grande.jpg', 'test'),
(418, 'etoile argent petite.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/etoile argent petite.jpg', 'test'),
(419, 'etoile argentee belge.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/etoile argentee belge.jpg', 'test'),
(420, 'etoile argentee2.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/etoile argentee2.jpg', 'test'),
(421, 'etoile doree belge.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/etoile doree belge.jpg', 'test'),
(422, 'etoile et foudre.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/etoile et foudre.jpg', 'test'),
(423, 'etoile or grande.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/etoile or grande.jpg', 'test'),
(424, 'etoile or petite.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/etoile or petite.jpg', 'test'),
(425, 'faux.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/faux.jpg', 'test'),
(426, 'fer a cheval.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/fer a cheval.jpg', 'test'),
(427, 'feuille de vigne.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/feuille de vigne.jpg', 'test'),
(428, 'flambeaux entrecroises.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/flambeaux entrecroises.jpg', 'test'),
(429, 'fleche.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/fleche.jpg', 'test'),
(430, 'fleur de lys.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/fleur de lys.jpg', 'test'),
(431, 'flying foufoune.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/flying foufoune.jpg', 'test'),
(432, 'flying penis.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/flying penis.jpg', 'test'),
(433, 'fourchette & epi de ble.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/fourchette & epi de ble.jpg', 'test'),
(434, 'fourchette.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/fourchette.jpg', 'test'),
(435, 'fourchettes croisees.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/fourchettes croisees.jpg', 'test'),
(436, 'gazelles.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/gazelles.jpg', 'test'),
(437, 'girafe.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/girafe.jpg', 'test'),
(438, 'globe.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/globe.jpg', 'test'),
(439, 'grappe de raisin.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/grappe de raisin.jpg', 'test'),
(440, 'grenouille argent.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/grenouille argent.jpg', 'test'),
(441, 'grenouille or.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/grenouille or.jpg', 'test'),
(442, 'grenouille.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/grenouille.jpg', 'test'),
(443, 'hache.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/hache.jpg', 'test'),
(444, 'hermine.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/hermine.jpg', 'test'),
(445, 'homard.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/homard.jpg', 'test'),
(446, 'hure.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/hure.jpg', 'test'),
(447, 'kangourou.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/kangourou.jpg', 'test'),
(448, 'koala.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/koala.jpg', 'test'),
(449, 'lime.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/lime.jpg', 'test'),
(450, 'lion dresse.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/lion dresse.jpg', 'test'),
(451, 'livre ouvert et plume.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/livre ouvert et plume.jpg', 'test'),
(452, 'locomotive.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/locomotive.jpg', 'test'),
(453, 'lyre.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/lyre.jpg', 'test'),
(454, 'mammouth.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/mammouth.jpg', 'test'),
(455, 'marteau et maillet.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/marteau et maillet.jpg', 'test'),
(456, 'molaire.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/molaire.jpg', 'test'),
(457, 'nounours.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/nounours.jpg', 'test'),
(458, 'orchidee.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/orchidee.jpg', 'test'),
(459, 'ouvert et plume.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/ouvert et plume.jpg', 'test'),
(460, 'pachyderme.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/pachyderme.jpg', 'test'),
(461, 'paire de ski.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/paire de ski.jpg', 'test'),
(462, 'palette et pinceau.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/palette et pinceau.jpg', 'test'),
(463, 'palme double.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/palme double.jpg', 'test'),
(464, 'palme simple grande.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/palme simple grande.jpg', 'test'),
(465, 'palmes croisees.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/palmes croisees.jpg', 'test'),
(466, 'palmier.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/palmier.jpg', 'test'),
(467, 'papillon.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/papillon.jpg', 'test'),
(468, 'parapluie ferme.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/parapluie ferme.jpg', 'test'),
(469, 'parapluie ouvert.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/parapluie ouvert.jpg', 'test'),
(470, 'pendu.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/pendu.jpg', 'test'),
(471, 'pericles.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/pericles.jpg', 'test'),
(472, 'perron liegeois.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/perron liegeois.jpg', 'test'),
(473, 'perroquet sur perchoir.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/perroquet sur perchoir.jpg', 'test'),
(474, 'phi.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/phi.jpg', 'test'),
(475, 'plume.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/plume.jpg', 'test'),
(476, 'poireau.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/poireau.jpg', 'test'),
(477, 'polytechnique argente.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/polytechnique argente.jpg', 'test'),
(478, 'polytechnique dore.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/polytechnique dore.jpg', 'test'),
(479, 'potager navet.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/potager navet.jpg', 'test'),
(480, 'poule.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/poule.jpg', 'test'),
(481, 'president.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/president.jpg', 'test'),
(482, 'psi.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/psi.jpg', 'test'),
(483, 'raquette de tennis.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/raquette de tennis.jpg', 'test'),
(484, 'rose.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/rose.jpg', 'test'),
(485, 'sabot.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/sabot.jpg', 'test'),
(486, 'sanglier.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/sanglier.jpg', 'test'),
(487, 'secretaire.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/secretaire.jpg', 'test'),
(488, 'singe du grand garde.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/singe du grand garde.jpg', 'test'),
(489, 'singe.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/singe.jpg', 'test'),
(490, 'soleil.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/soleil.jpg', 'test'),
(491, 'solvay.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/solvay.jpg', 'test'),
(492, 'sou troue.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/sou troue.jpg', 'test'),
(493, 'sphinx.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/sphinx.jpg', 'test'),
(494, 'squelette.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/squelette.jpg', 'test'),
(495, 'tambour.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/tambour.jpg', 'test'),
(496, 'taste vin.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/taste vin.jpg', 'test'),
(497, 'telephone.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/telephone.jpg', 'test'),
(498, 'tete d''indien.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/tete d''indien.jpg', 'test'),
(499, 'tete de cheval.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/tete de cheval.jpg', 'test'),
(500, 'tete de loup vue de face.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/tete de loup vue de face.jpg', 'test'),
(501, 'tete de loup vue de profil.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/tete de loup vue de profil.jpg', 'test'),
(502, 'tete de mort sur femurs.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/tete de mort sur femurs.jpg', 'test'),
(503, 'tete de mort.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/tete de mort.jpg', 'test'),
(504, 'tete de vache.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/tete de vache.jpg', 'test'),
(505, 'tomate.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/tomate.jpg', 'test'),
(506, 'tore.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/tore.jpg', 'test'),
(507, 'tortue or.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/tortue or.jpg', 'test'),
(508, 'trefle a 4 feuilles.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/trefle a 4 feuilles.jpg', 'test'),
(509, 'tresorier.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/tresorier.jpg', 'test'),
(510, 'valise.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/valise.jpg', 'test'),
(511, 'vice president.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/vice president.jpg', 'test'),
(512, 'voilier.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/voilier.jpg', 'test'),
(513, 'volant.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/volant.jpg', 'test'),
(514, 'zodiaque balance.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/zodiaque balance.jpg', 'test'),
(515, 'zodiaque belier.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/zodiaque belier.jpg', 'test'),
(516, 'zodiaque capricorne.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/zodiaque capricorne.jpg', 'test'),
(517, 'zodiaque gemeaux.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/zodiaque gemeaux.jpg', 'test'),
(518, 'zodiaque lion.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/zodiaque lion.jpg', 'test'),
(519, 'zodiaque poisson.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/zodiaque poisson.jpg', 'test'),
(520, 'zodiaque sagittaire.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/zodiaque sagittaire.jpg', 'test'),
(521, 'zodiaque scorpion.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/zodiaque scorpion.jpg', 'test'),
(522, 'zodiaque taureau.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/zodiaque taureau.jpg', 'test'),
(523, 'zodiaque vierge.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/zodiaque vierge.jpg', 'test');

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
  PRIMARY KEY (`id`),
  KEY `id_congress` (`id_congress`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=132 ;

--
-- Dumping data for table `player`
--

INSERT INTO `player` (`id`, `nom`, `pass`, `lieu`, `points`, `notoriete`, `alcoolemie`, `alcoolemie_optimum`, `alcoolemie_max`, `fatigue`, `fatigue_max`, `sex_appeal`, `en_pls`, `debut_de_pls`, `sex`, `photo`, `pnj`, `id_congress`, `remaining_time`) VALUES
(-2, 'bar', '', '', 0, 0, 0, 0, 10, 0, 0, 0, 0, 0, 1, 'images/tete_faluche_bleu.jpg', 2, 2, 0),
(-1, 'cuisine', '', '', 0, 0, 0, 0, 10, 0, 0, 0, 0, 0, 0, 'images/tete_faluche_rose.jpg', 2, 2, 0),
(1, 'yannick', 'yannick', 'congress', 114, 13, 8, 7, 10, 6, 10, 5, 0, 0, 1, 'upload/photo_players/1.gif', 0, NULL, 0),
(61, 'rose Annecy', '', 'cuisine', 0, 9, 2, 8, 12, 7, 8, 7, 0, 0, 0, 'images/tete_faluche_grise_rose.jpg', 1, 2, 0),
(62, 'ingé Annecy', '', 'cuisine', 2, 5, 3, 5, 12, 6, 7, 7, 0, 0, 1, 'images/tete_faluche_grise_bleu.jpg', 1, 2, 0),
(63, 'droit Annecy', '', 'danse', 29, 20, 6, 7, 12, 10, 10, 8, 0, 0, 0, 'images/tete_faluche_grise_rose.jpg', 1, 2, 0),
(64, 'sciences Annecy', '', 'danse', 0, 10, 4, 7, 10, 3, 7, 5, 0, 0, 1, 'images/tete_faluche_grise_bleu.jpg', 1, 2, 0),
(65, 'sage-pouf Annecy', '', 'bar', 6, 9, 6, 6, 11, 5, 9, 6, 0, 0, 0, 'images/tete_faluche_grise_rose.jpg', 1, 2, 0),
(66, 'jaune Annecy', '', 'bar', 5, 9, 6, 6, 11, 4, 7, 9, 0, 0, 0, 'images/tete_faluche_grise_rose.jpg', 1, 2, 0),
(67, 'Pharma Annecy', '', 'bar', 0, 8, 7, 6, 10, 8, 9, 9, 0, 0, 1, 'images/tete_faluche_grise_bleu.jpg', 1, 2, 0),
(68, 'Médecine Annecy', '', 'danse', 0, 4, 5, 7, 11, 1, 7, 8, 0, 0, 1, 'images/tete_faluche_grise_bleu.jpg', 1, 2, 0),
(69, 'rose Grenoble', '', 'bar', 0, 6, 6, 5, 10, 4, 9, 6, 0, 0, 0, 'images/tete_faluche_grise_rose.jpg', 1, 2, 0),
(70, 'ingé Grenoble', '', 'bar', 0, 9, 4, 7, 9, 2, 10, 7, 0, 0, 0, 'images/tete_faluche_grise_rose.jpg', 1, 2, 0),
(71, 'droit Grenoble', '', 'bar', 0, 4, 10, 5, 9, 5, 7, 10, 0, 0, 1, 'images/tete_faluche_grise_bleu.jpg', 1, 2, 0),
(72, 'sciences Grenoble', '', 'bar', 0, 6, 6, 5, 9, 2, 7, 5, 0, 0, 0, 'images/tete_faluche_grise_rose.jpg', 1, 2, 0),
(73, 'sage-pouf Grenoble', '', 'danse', 0, 9, 4, 7, 9, 9, 9, 9, 0, 0, 1, 'images/tete_faluche_grise_bleu.jpg', 1, 2, 0),
(74, 'jaune Grenoble', '', 'bar', 0, 8, 7, 7, 12, 5, 10, 9, 0, 0, 0, 'images/tete_faluche_grise_rose.jpg', 1, 2, 0),
(75, 'Pharma Grenoble', '', 'bar', 0, 5, 6, 5, 9, 10, 10, 6, 0, 0, 0, 'images/tete_faluche_grise_rose.jpg', 1, 2, 0),
(76, 'Médecine Grenoble', '', 'bar', 0, 5, 3, 8, 10, 8, 7, 5, 0, 0, 1, 'images/tete_faluche_grise_bleu.jpg', 1, 2, 0),
(77, 'rose Lyon', '', 'danse', 2, 8, 4, 6, 12, 8, 8, 10, 0, 0, 1, 'images/tete_faluche_grise_bleu.jpg', 1, 2, 0),
(78, 'ingé Lyon', '', 'bar', 0, 7, 7, 7, 12, 2, 7, 6, 0, 0, 0, 'images/tete_faluche_grise_rose.jpg', 1, 2, 0),
(79, 'droit Lyon', '', 'bar', 0, 7, 4, 8, 9, 8, 8, 6, 0, 0, 0, 'images/tete_faluche_grise_rose.jpg', 1, 2, 0),
(80, 'sciences Lyon', '', 'danse', 0, 10, 2, 7, 9, 7, 9, 6, 0, 0, 1, 'images/tete_faluche_grise_bleu.jpg', 1, 2, 0),
(81, 'sage-pouf Lyon', '', 'danse', 10, 10, 6, 6, 9, 7, 7, 10, 0, 0, 0, 'images/tete_faluche_grise_rose.jpg', 1, 2, 0),
(82, 'jaune Lyon', '', 'danse', 0, 4, 2, 5, 12, 9, 9, 5, 0, 0, 1, 'images/tete_faluche_grise_bleu.jpg', 1, 2, 0),
(83, 'Pharma Lyon', '', 'camping', 2, 10, 4, 7, 11, 10, 9, 7, 0, 0, 0, 'images/tete_faluche_grise_rose.jpg', 1, 2, 0),
(84, 'Médecine Lyon', '', 'bar', 0, 9, 5, 7, 10, 10, 9, 6, 0, 0, 0, 'images/tete_faluche_grise_rose.jpg', 1, 2, 0),
(85, 'rose Monpeul', '', 'camping', 2, 6, 3, 7, 12, 6, 8, 10, 0, 0, 1, 'images/tete_faluche_grise_bleu.jpg', 1, 2, 0),
(86, 'ingé Monpeul', '', 'danse', 0, 10, 5, 5, 11, 5, 8, 9, 0, 0, 1, 'images/tete_faluche_grise_bleu.jpg', 1, 2, 0),
(87, 'droit Monpeul', '', 'danse', 15, 10, 7, 6, 9, 9, 9, 6, 0, 0, 0, 'images/tete_faluche_grise_rose.jpg', 1, 2, 0),
(88, 'sciences Monpeul', '', 'bar', 5, 5, 6, 7, 10, 6, 7, 7, 0, 0, 1, 'images/tete_faluche_grise_bleu.jpg', 1, 2, 0),
(89, 'sage-pouf Monpeul', '', 'camping', 0, 4, 6, 6, 10, 7, 9, 6, 0, 0, 1, 'images/tete_faluche_grise_bleu.jpg', 1, 2, 0),
(90, 'jaune Monpeul', '', 'camping', 0, 9, 2, 8, 10, 4, 9, 6, 0, 0, 1, 'images/tete_faluche_grise_bleu.jpg', 1, 2, 0),
(91, 'Pharma Monpeul', '', 'camping', 0, 8, 7, 5, 12, 8, 10, 5, 0, 0, 0, 'images/tete_faluche_grise_rose.jpg', 1, 2, 0),
(92, 'Médecine Monpeul', '', 'danse', 15, 12, 5, 7, 10, 10, 10, 9, 0, 0, 0, 'images/tete_faluche_grise_rose.jpg', 1, 2, 0),
(93, 'rose Valence', '', 'bar', 0, 4, 2, 8, 9, 6, 8, 5, 0, 0, 0, 'images/tete_faluche_grise_rose.jpg', 1, 2, 0),
(94, 'ingé Valence', '', 'camping', 0, 10, 7, 7, 11, 6, 8, 7, 0, 0, 0, 'images/tete_faluche_grise_rose.jpg', 1, 2, 0),
(95, 'droit Valence', '', 'bar', 0, 6, 2, 8, 10, 10, 8, 8, 0, 0, 1, 'images/tete_faluche_grise_bleu.jpg', 1, 2, 0),
(96, 'sciences Valence', '', 'bar', 0, 8, 4, 8, 10, 6, 8, 7, 0, 0, 0, 'images/tete_faluche_grise_rose.jpg', 1, 2, 0),
(97, 'sage-pouf Valence', '', 'danse', 10, 13, 5, 7, 9, 9, 10, 8, 0, 0, 0, 'images/tete_faluche_grise_rose.jpg', 1, 2, 0),
(98, 'jaune Valence', '', 'camping', 0, 5, 5, 6, 9, 7, 7, 6, 0, 0, 1, 'images/tete_faluche_grise_bleu.jpg', 1, 2, 0),
(99, 'Pharma Valence', '', 'bar', 0, 4, 6, 8, 10, 10, 10, 10, 0, 0, 0, 'images/tete_faluche_grise_rose.jpg', 1, 2, 0),
(100, 'Médecine Valence', '', 'bar', 0, 9, 7, 8, 10, 9, 7, 6, 0, 0, 0, 'images/tete_faluche_grise_rose.jpg', 1, 2, 0),
(101, 'rose Aix', '', 'camping', 0, 9, 2, 6, 11, 4, 7, 5, 0, 0, 0, 'images/tete_faluche_grise_rose.jpg', 1, 1, 0),
(102, 'ingé Aix', '', 'danse', 0, 4, 6, 8, 9, 5, 7, 7, 0, 0, 0, 'images/tete_faluche_grise_rose.jpg', 1, 1, 0),
(103, 'droit Aix', '', 'danse', 0, 5, 5, 7, 12, 5, 10, 10, 0, 0, 1, 'images/tete_faluche_grise_bleu.jpg', 1, 1, 0),
(104, 'sciences Aix', '', 'bar', 0, 7, 7, 8, 10, 4, 8, 10, 0, 0, 0, 'images/tete_faluche_grise_rose.jpg', 1, 1, 0),
(105, 'sage-pouf Aix', '', 'cuisine', 0, 5, 5, 8, 11, 6, 10, 10, 0, 0, 0, 'images/tete_faluche_grise_rose.jpg', 1, 1, 0),
(106, 'jaune Aix', '', 'cuisine', 0, 6, 5, 7, 9, 5, 8, 9, 0, 0, 1, 'images/tete_faluche_grise_bleu.jpg', 1, 1, 0),
(107, 'Pharma Aix', '', 'bar', 0, 9, 3, 7, 12, 5, 10, 9, 0, 0, 1, 'images/tete_faluche_grise_bleu.jpg', 1, 1, 0),
(108, 'Médecine Aix', '', 'cuisine', 0, 9, 3, 8, 11, 1, 8, 10, 0, 0, 0, 'images/tete_faluche_grise_rose.jpg', 1, 1, 0),
(109, 'rose Marseille', '', 'bar', 0, 10, 7, 6, 12, 9, 8, 10, 0, 0, 0, 'images/tete_faluche_grise_rose.jpg', 1, 1, 0),
(110, 'ingé Marseille', '', 'camping', 0, 6, 6, 7, 9, 8, 8, 5, 0, 0, 1, 'images/tete_faluche_grise_bleu.jpg', 1, 1, 0),
(111, 'droit Marseille', '', 'camping', 0, 6, 3, 7, 11, 6, 8, 6, 0, 0, 1, 'images/tete_faluche_grise_bleu.jpg', 1, 1, 0),
(112, 'sciences Marseille', '', 'danse', 0, 6, 4, 8, 9, 9, 9, 8, 0, 0, 1, 'images/tete_faluche_grise_bleu.jpg', 1, 1, 0),
(113, 'sage-pouf Marseille', '', 'danse', 0, 5, 6, 8, 12, 7, 8, 8, 0, 0, 1, 'images/tete_faluche_grise_bleu.jpg', 1, 1, 0),
(114, 'jaune Marseille', '', 'bar', 0, 10, 6, 6, 12, 7, 9, 7, 0, 0, 0, 'images/tete_faluche_grise_rose.jpg', 1, 1, 0),
(115, 'Pharma Marseille', '', 'bar', 0, 9, 3, 7, 10, 9, 7, 7, 0, 0, 1, 'images/tete_faluche_grise_bleu.jpg', 1, 1, 0),
(116, 'Médecine Marseille', '', 'cuisine', 0, 4, 3, 7, 9, 8, 7, 5, 0, 0, 1, 'images/tete_faluche_grise_bleu.jpg', 1, 1, 0),
(117, 'rose Dijon', '', 'cuisine', 0, 8, 2, 6, 11, 8, 10, 5, 0, 0, 0, 'images/tete_faluche_grise_rose.jpg', 1, 1, 0),
(118, 'ingé Dijon', '', 'bar', 0, 6, 6, 7, 10, 2, 10, 6, 0, 0, 1, 'images/tete_faluche_grise_bleu.jpg', 1, 1, 0),
(119, 'droit Dijon', '', 'camping', 0, 8, 7, 7, 12, 10, 10, 5, 0, 0, 0, 'images/tete_faluche_grise_rose.jpg', 1, 1, 0),
(120, 'sciences Dijon', '', 'danse', 0, 10, 5, 5, 11, 7, 10, 7, 0, 0, 0, 'images/tete_faluche_grise_rose.jpg', 1, 1, 0),
(121, 'sage-pouf Dijon', '', 'cuisine', 0, 6, 6, 5, 11, 6, 10, 9, 0, 0, 1, 'images/tete_faluche_grise_bleu.jpg', 1, 1, 0),
(122, 'jaune Dijon', '', 'camping', 0, 8, 5, 6, 9, 9, 8, 10, 0, 0, 0, 'images/tete_faluche_grise_rose.jpg', 1, 1, 0),
(123, 'Pharma Dijon', '', 'bar', 0, 8, 5, 6, 11, 10, 8, 8, 0, 0, 1, 'images/tete_faluche_grise_bleu.jpg', 1, 1, 0),
(124, 'Médecine Dijon', '', 'bar', 0, 7, 7, 7, 12, 7, 9, 8, 0, 0, 0, 'images/tete_faluche_grise_rose.jpg', 1, 1, 0);

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

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_2` FOREIGN KEY (`id_player`) REFERENCES `player` (`id`),
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`id_item`) REFERENCES `item` (`id`);

--
-- Constraints for table `player`
--
ALTER TABLE `player`
  ADD CONSTRAINT `player_ibfk_1` FOREIGN KEY (`id_congress`) REFERENCES `congress` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
