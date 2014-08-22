
--
-- Table structure for table `chat`
--

CREATE TABLE IF NOT EXISTS `chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_new` int(11) NOT NULL DEFAULT '1',
  `time_sent` int(11) NOT NULL,
  `sender` int(11) NOT NULL,
  `recipient` int(11) DEFAULT NULL,
  `message` varchar(1024) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sender` (`sender`),
  KEY `recipient` (`recipient`),
  KEY `time_sent` (`time_sent`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=48 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`sender`) REFERENCES `player` (`id`),
  ADD CONSTRAINT `chat_ibfk_2` FOREIGN KEY (`recipient`) REFERENCES `player` (`id`);

ALTER TABLE `item` ADD `description` VARCHAR(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `nom`;

INSERT INTO `soluche`.`item` (`id`, `nom`, `permanent`, `notoriete`, `alcoolemie`, `alcoolemie_optimum`, `alcoolemie_max`, `fatigue`, `fatigue_max`, `sex_appeal`, `image`, `item_type`, `remaining_time`, `money`) VALUES
(NULL, 'cle de fa', '1', '1', '0', '0', '0', '0', '0', '0', 'images/items/cle de fa.png', 'badge', '0', '50'),
(NULL, 'panda', '1', '0', '0', '0', '0', '0', '0', '0', 'images/items/panda.png', 'badge', '0', '50');

