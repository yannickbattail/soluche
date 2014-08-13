ALTER TABLE `congress` ADD `bot_number` INT NOT NULL;
ALTER TABLE `congress` ADD `bot_coef` FLOAT NOT NULL DEFAULT '1' ;
ALTER TABLE `congress` ADD `level` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

UPDATE `congress` SET `id` = 1,`nom` = 'Week-end luche',`action_number` = 42,`bot_number` = 50,`bot_coef` = 1,`level` = 'moldu' WHERE `congress`.`id` = 1;
UPDATE `congress` SET `id` = 2,`nom` = 'Anniversaire',`action_number` = 50,`bot_number` = 40,`bot_coef` = 1.2,`level` = 'impétrent' WHERE `congress`.`id` = 2;
UPDATE `congress` SET `id` = 3,`nom` = 'Apéro fal',`action_number` = 20,`bot_number` = 30,`bot_coef` = 2,`level` = 'faluché' WHERE `congress`.`id` = 3;
UPDATE `congress` SET `id` = 4,`nom` = 'Baptème',`action_number` = 30,`bot_number` = 30,`bot_coef` = 3,`level` = 'ancien' WHERE `congress`.`id` = 4;
