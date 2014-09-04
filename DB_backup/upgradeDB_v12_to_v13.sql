--
-- Table structure for table `game`
--

CREATE TABLE IF NOT EXISTS `game` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(128) DEFAULT NULL,
  `game_type` varchar(128) NOT NULL,
  `date_start` int(11) NOT NULL,
  `game_data` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


ALTER TABLE `player` ADD `notification` VARCHAR(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'notification type separated by coma' ;

ALTER TABLE `notification` ADD `short_message` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'short message without html (128 char)' ;

ALTER TABLE `notification` ADD `notification_type` VARCHAR(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;
