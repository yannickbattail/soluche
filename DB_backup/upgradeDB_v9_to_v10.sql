ALTER TABLE `congress` ADD `budget` INT NOT NULL ;
UPDATE `congress` SET `budget`=action_number WHERE 1;
INSERT INTO `soluche`.`item` (`id`, `nom`, `description`, `permanent`, `notoriete`, `alcoolemie`, `alcoolemie_optimum`, `alcoolemie_max`, `fatigue`, `fatigue_max`, `sex_appeal`, `image`, `item_type`, `remaining_time`, `money`) VALUES
(NULL, 'Eau Evian', 'de l''eau d''Evian', '0', '0', '0', '0', '0', '-1', '0', '0', 'images/items/evian.png', 'alcohol', '0', '5'),
(NULL, 'bambou', 'grand traquenardeur de pandas', '1', '0', '0', '0', '1', '0', '0', '0', 'images/items/bambou.png', 'badge', '0', '40');
