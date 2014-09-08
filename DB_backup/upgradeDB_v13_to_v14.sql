--
-- Table structure for table `invitation`
--

CREATE TABLE IF NOT EXISTS `invitation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invitation_date` int(11) NOT NULL,
  `host` int(11) NOT NULL COMMENT 'reference to player',
  `guest` int(11) NOT NULL COMMENT 'reference to player',
  `id_congress` int(11) DEFAULT NULL,
  `location` varchar(128) DEFAULT NULL,
  `id_game` int(11) DEFAULT NULL,
  `message` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `host` (`host`),
  KEY `guest` (`guest`),
  KEY `id_congres` (`id_congress`),
  KEY `id_game` (`id_game`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invitation`
--
ALTER TABLE `invitation`
  ADD CONSTRAINT `invitation_ibfk_4` FOREIGN KEY (`id_game`) REFERENCES `game` (`id`),
  ADD CONSTRAINT `invitation_ibfk_1` FOREIGN KEY (`host`) REFERENCES `player` (`id`),
  ADD CONSTRAINT `invitation_ibfk_2` FOREIGN KEY (`guest`) REFERENCES `player` (`id`),
  ADD CONSTRAINT `invitation_ibfk_3` FOREIGN KEY (`id_congress`) REFERENCES `congress` (`id`);

UPDATE `player` SET `notification` = 'Chopper,Duel,Pins,Purchase,Share,Chat,GlobalMessage,Invite,AcceptInvite'
