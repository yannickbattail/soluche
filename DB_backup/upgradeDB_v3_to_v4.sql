
INSERT INTO `item` (`id`, `nom`, `permanent`, `notoriete`, `alcoolemie`, `alcoolemie_optimum`, `alcoolemie_max`, `fatigue`, `fatigue_max`, `sex_appeal`, `image`, `item_type`) VALUES
(524, 'pins exigeons la dignité', 1, 0, 0, 0, 0, 0, 0, 0, 'images/items/pin-s-exigeons-la-dignité.png', 'pins');

UPDATE `item` SET `nom`= SUBSTRING_INDEX(`nom`, '.', 1) WHERE `nom` LIKE '%.jpg';

DELETE FROM `item` WHERE `id` > 13 ;

INSERT INTO `item` (`id`, `nom`, `permanent`, `notoriete`, `alcoolemie`, `alcoolemie_optimum`, `alcoolemie_max`, `fatigue`, `fatigue_max`, `sex_appeal`, `image`, `item_type`) VALUES
(353, '2 sexes', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/2 sexes.jpg', 'test'),
(354, '2 sexes', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/2 sexes.jpg', 'test'),
(355, '69', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/69.jpg', 'test'),
(356, 'abeille', 1, 1, 0, 0, 0, 0, 0, 0, 'images/badges/abeille.jpg', 'badge'),
(357, 'aigle germain', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/aigle germain.jpg', 'test'),
(358, 'alambic', 1, 0, 0, 0, 1, 0, 0, 0, 'images/badges/alambic.jpg', 'badge'),
(359, 'alette vernie', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/alette vernie.jpg', 'test'),
(360, 'ancre', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/ancre.jpg', 'test'),
(361, 'ane', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/ane.jpg', 'test'),
(362, 'anneaux olympiques', 1, 0, 0, 0, 0, 0, 2, 1, 'images/badges/anneaux olympiques.jpg', 'badge'),
(363, 'bacchus', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/bacchus.jpg', 'test'),
(364, 'balance romaine', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/balance romaine.jpg', 'test'),
(365, 'ballon de foot', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/ballon de foot.jpg', 'test'),
(366, 'beta', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/beta.jpg', 'test'),
(367, 'betterave', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/betterave.jpg', 'test'),
(368, 'bobine et eclairs', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/bobine et eclairs.jpg', 'test'),
(369, 'bobine', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/bobine.jpg', 'test'),
(370, 'boulon argente', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/boulon argente.jpg', 'test'),
(371, 'bourse', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/bourse.jpg', 'test'),
(372, 'bouteille de champagne', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/bouteille de champagne.jpg', 'test'),
(373, 'caducee medecine 2', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/caducee medecine 2.jpg', 'test'),
(374, 'caducee medecine', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/caducee medecine.jpg', 'test'),
(375, 'caducee mercure', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/caducee mercure.jpg', 'test'),
(376, 'caducee pharmacie', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/caducee pharmacie.jpg', 'test'),
(377, 'caducee psychologie belge', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/caducee psychologie belge.jpg', 'test'),
(378, 'caducee psychologie', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/caducee psychologie.jpg', 'test'),
(379, 'caducee veterinaire', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/caducee veterinaire.jpg', 'test'),
(380, 'calice', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/calice.jpg', 'test'),
(381, 'carotte', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/carotte.jpg', 'test'),
(382, 'cartes a jouer', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/cartes a jouer.jpg', 'test'),
(383, 'cerf', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/cerf.jpg', 'test'),
(384, 'chameau a 2 bosses', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/chameau a 2 bosses.jpg', 'test'),
(385, 'chameau', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/chameau.jpg', 'test'),
(386, 'chardon lorrain', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/chardon lorrain.jpg', 'test'),
(387, 'chauve souris', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/chauve souris.jpg', 'test'),
(388, 'chope', 1, 0, 0, 1, 1, 0, 0, 0, 'images/badges/chope.jpg', 'badge'),
(389, 'chou fleur', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/chou fleur.jpg', 'test'),
(390, 'chouette a deux faces', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/chouette a deux faces.jpg', 'test'),
(391, 'chouette', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/chouette.jpg', 'test'),
(392, 'cigogne', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/cigogne.jpg', 'test'),
(393, 'ciseaux', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/ciseaux.jpg', 'test'),
(394, 'cle de sol', 1, 2, 0, 0, 0, 0, 0, 0, 'images/badges/cle de sol.jpg', 'badge'),
(395, 'cle', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/cle.jpg', 'test'),
(396, 'cochon', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/cochon.jpg', 'test'),
(397, 'cocotte en papier', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/cocotte en papier.jpg', 'test'),
(398, 'coq wallon', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/coq wallon.jpg', 'test'),
(399, 'coq', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/coq.jpg', 'test'),
(400, 'cor de chasse', 1, 1, 0, 0, 0, 0, 0, 1, 'images/badges/cor de chasse.jpg', 'badge'),
(401, 'cornue et ballon', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/cornue et ballon.jpg', 'test'),
(402, 'couronne argentee', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/couronne argentee.jpg', 'test'),
(403, 'couronne doree', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/couronne doree.jpg', 'test'),
(404, 'crabe', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/crabe.jpg', 'test'),
(405, 'croissant de lune', 1, 5, 0, 0, 0, 0, 0, 0, 'images/badges/croissant de lune.jpg', 'cros'),
(406, 'croix de grand chambellan', 1, 5, 0, 0, 0, 0, 0, 0, 'images/badges/croix de grand chambellan.jpg', 'cros'),
(407, 'croix de grand maitre', 1, 5, 0, 0, 0, 0, 0, 0, 'images/badges/croix de grand maitre.jpg', 'cros'),
(408, 'croix egyptienne', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/croix egyptienne.jpg', 'test'),
(409, 'de a jouer', 1, 0, 2, 0, 2, 0, 0, 0, 'images/badges/de a jouer.jpg', 'badge'),
(410, 'ecureuil', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/ecureuil.jpg', 'test'),
(411, 'epee', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/epee.jpg', 'test'),
(412, 'epi de ble', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/epi de ble.jpg', 'test'),
(413, 'epi et faucille', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/epi et faucille.jpg', 'test'),
(414, 'epsilon', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/epsilon.jpg', 'test'),
(415, 'equerre et compas', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/equerre et compas.jpg', 'test'),
(416, 'escargot', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/escargot.jpg', 'test'),
(417, 'etoile argent grande', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/etoile argent grande.jpg', 'test'),
(418, 'etoile argent petite', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/etoile argent petite.jpg', 'test'),
(419, 'etoile argentee belge', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/etoile argentee belge.jpg', 'test'),
(420, 'etoile argentee2', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/etoile argentee2.jpg', 'test'),
(421, 'etoile doree belge', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/etoile doree belge.jpg', 'test'),
(422, 'etoile et foudre', 1, 1, 0, 0, 0, 0, 0, 0, 'images/badges/etoile et foudre.jpg', 'test'),
(423, 'etoile or grande', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/etoile or grande.jpg', 'test'),
(424, 'etoile or petite', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/etoile or petite.jpg', 'test'),
(425, 'faux', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/faux.jpg', 'test'),
(426, 'fer a cheval', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/fer a cheval.jpg', 'test'),
(427, 'feuille de vigne', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/feuille de vigne.jpg', 'test'),
(428, 'flambeaux entrecroises', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/flambeaux entrecroises.jpg', 'test'),
(429, 'fleche', 1, 0, 0, 0, 0, 0, 0, -2, 'images/badges/fleche.jpg', 'badge'),
(430, 'fleur de lys', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/fleur de lys.jpg', 'test'),
(431, 'flying foufoune', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/flying foufoune.jpg', 'test'),
(432, 'flying penis', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/flying penis.jpg', 'test'),
(433, 'fourchette & epi de ble', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/fourchette & epi de ble.jpg', 'test'),
(434, 'fourchette', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/fourchette.jpg', 'test'),
(435, 'fourchettes croisees', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/fourchettes croisees.jpg', 'test'),
(436, 'gazelles', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/gazelles.jpg', 'test'),
(437, 'girafe', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/girafe.jpg', 'test'),
(438, 'globe', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/globe.jpg', 'test'),
(439, 'grappe de raisin', 1, 0, 0, 1, 1, 0, 0, 0, 'images/badges/grappe de raisin.jpg', 'badge'),
(440, 'grenouille argent', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/grenouille argent.jpg', 'test'),
(441, 'grenouille or', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/grenouille or.jpg', 'test'),
(443, 'hache', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/hache.jpg', 'test'),
(444, 'hermine', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/hermine.jpg', 'test'),
(445, 'homard', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/homard.jpg', 'test'),
(446, 'hure', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/hure.jpg', 'test'),
(447, 'kangourou', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/kangourou.jpg', 'test'),
(448, 'koala', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/koala.jpg', 'test'),
(449, 'lime', 1, -1, 0, 0, 0, 0, 0, -1, 'images/badges/lime.jpg', 'badge'),
(450, 'lion dresse', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/lion dresse.jpg', 'test'),
(451, 'livre ouvert et plume', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/livre ouvert et plume.jpg', 'test'),
(452, 'locomotive', 1, -2, 0, 0, 0, 0, 0, 0, 'images/badges/locomotive.jpg', 'badge'),
(453, 'lyre', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/lyre.jpg', 'test'),
(454, 'mammouth', 1, 3, 0, 0, 0, 0, 0, 0, 'images/badges/mammouth.jpg', 'badge'),
(455, 'marteau et maillet', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/marteau et maillet.jpg', 'test'),
(456, 'molaire', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/molaire.jpg', 'test'),
(457, 'nounours', 1, 0, 0, 0, 0, 0, -2, 0, 'images/badges/nounours.jpg', 'badge'),
(458, 'orchidee', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/orchidee.jpg', 'badge'),
(459, 'ouvert et plume', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/ouvert et plume.jpg', 'test'),
(460, 'pachyderme', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/pachyderme.jpg', 'test'),
(461, 'paire de ski', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/paire de ski.jpg', 'test'),
(462, 'palette et pinceau', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/palette et pinceau.jpg', 'test'),
(463, 'palme double', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/palme double.jpg', 'test'),
(464, 'palme simple grande', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/palme simple grande.jpg', 'test'),
(465, 'palmes croisees', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/palmes croisees.jpg', 'test'),
(466, 'palmier', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/palmier.jpg', 'test'),
(467, 'papillon', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/papillon.jpg', 'test'),
(468, 'parapluie ferme', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/parapluie ferme.jpg', 'test'),
(469, 'parapluie ouvert', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/parapluie ouvert.jpg', 'test'),
(470, 'pendu', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/pendu.jpg', 'test'),
(471, 'pericles', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/pericles.jpg', 'test'),
(472, 'perron liegeois', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/perron liegeois.jpg', 'test'),
(473, 'perroquet sur perchoir', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/perroquet sur perchoir.jpg', 'test'),
(474, 'phi', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/phi.jpg', 'test'),
(475, 'plume', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/plume.jpg', 'test'),
(476, 'poireau', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/poireau.jpg', 'test'),
(477, 'polytechnique argente', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/polytechnique argente.jpg', 'test'),
(478, 'polytechnique dore', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/polytechnique dore.jpg', 'test'),
(479, 'potager navet', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/potager navet.jpg', 'test'),
(480, 'poule', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/poule.jpg', 'test'),
(481, 'president', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/president.jpg', 'test'),
(482, 'psi', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/psi.jpg', 'test'),
(483, 'raquette de tennis', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/raquette de tennis.jpg', 'test'),
(484, 'rose', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/rose.jpg', 'test'),
(485, 'sabot', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/sabot.jpg', 'test'),
(486, 'sanglier', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/sanglier.jpg', 'test'),
(487, 'secretaire', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/secretaire.jpg', 'test'),
(488, 'singe du grand garde', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/singe du grand garde.jpg', 'test'),
(489, 'singe', 1, -1, 0, 0, 0, 0, 0, 0, 'images/badges/singe.jpg', 'badge'),
(490, 'soleil', 1, 5, 0, 0, 0, 0, 0, 0, 'images/badges/soleil.jpg', 'cros'),
(491, 'solvay', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/solvay.jpg', 'test'),
(492, 'sou troue', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/sou troue.jpg', 'test'),
(493, 'sphinx', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/sphinx.jpg', 'test'),
(494, 'squelette', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/squelette.jpg', 'test'),
(495, 'tambour', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/tambour.jpg', 'test'),
(496, 'taste vin', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/taste vin.jpg', 'test'),
(497, 'telephone', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/telephone.jpg', 'test'),
(498, 'tete d''indien', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/tete d''indien.jpg', 'test'),
(499, 'tete de cheval', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/tete de cheval.jpg', 'test'),
(500, 'tete de loup vue de face', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/tete de loup vue de face.jpg', 'test'),
(501, 'tete de loup vue de profil', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/tete de loup vue de profil.jpg', 'test'),
(502, 'tete de mort sur femurs', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/tete de mort sur femurs.jpg', 'test'),
(503, 'tete de mort', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/tete de mort.jpg', 'test'),
(504, 'tete de vache', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/tete de vache.jpg', 'test'),
(505, 'tomate', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/tomate.jpg', 'test'),
(506, 'tore', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/tore.jpg', 'test'),
(507, 'tortue or', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/tortue or.jpg', 'test'),
(508, 'trefle a 4 feuilles', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/trefle a 4 feuilles.jpg', 'test'),
(509, 'tresorier', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/tresorier.jpg', 'test'),
(510, 'valise', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/valise.jpg', 'test'),
(511, 'vice president', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/vice president.jpg', 'test'),
(512, 'voilier', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/voilier.jpg', 'test'),
(513, 'volant', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/volant.jpg', 'test'),
(514, 'zodiaque balance', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/zodiaque balance.jpg', 'test'),
(515, 'zodiaque belier', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/zodiaque belier.jpg', 'test'),
(516, 'zodiaque capricorne', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/zodiaque capricorne.jpg', 'test'),
(517, 'zodiaque gemeaux', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/zodiaque gemeaux.jpg', 'test'),
(518, 'zodiaque lion', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/zodiaque lion.jpg', 'test'),
(519, 'zodiaque poisson', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/zodiaque poisson.jpg', 'test'),
(520, 'zodiaque sagittaire', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/zodiaque sagittaire.jpg', 'test'),
(521, 'zodiaque scorpion', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/zodiaque scorpion.jpg', 'test'),
(522, 'zodiaque taureau', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/zodiaque taureau.jpg', 'test'),
(523, 'zodiaque vierge', 1, 0, 0, 0, 0, 0, 0, 0, 'images/badges/zodiaque vierge.jpg', 'test'),
(524, 'pins exigeons la dignité', 1, 0, 0, 0, 0, 0, 0, 0, 'images/items/pin-s-exigeons-la-dignité.png', 'pins');