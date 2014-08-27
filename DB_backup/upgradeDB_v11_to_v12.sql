
ALTER TABLE `player` ADD `email` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `pass`;

--
-- Table structure for table `notification`
--
CREATE TABLE IF NOT EXISTS `notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_new` int(11) NOT NULL DEFAULT '1',
  `time_sent` int(11) NOT NULL,
  `id_player` int(11) NOT NULL,
  `message` varchar(1024) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_player` (`id_player`),
  KEY `time_sent` (`time_sent`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=71 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`id_player`) REFERENCES `player` (`id`);
