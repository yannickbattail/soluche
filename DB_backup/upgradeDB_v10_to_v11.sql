
--
-- Table structure for table `transaction`
--

CREATE TABLE IF NOT EXISTS `transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_inventory` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `id_item_exchange` int(11) DEFAULT NULL,
  `done` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_item_exchange` (`id_item_exchange`),
  KEY `id_inventory` (`id_inventory`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`id_inventory`) REFERENCES `inventory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`id_item_exchange`) REFERENCES `item` (`id`);
