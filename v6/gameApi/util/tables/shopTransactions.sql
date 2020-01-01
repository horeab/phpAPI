CREATE TABLE `shoptransactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `transactionDate` bigint(20) NOT NULL,
  `coinsAmount` int(11) NOT NULL,
  `transactionType` varchar(100) NOT NULL,
  `experienceGain` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `shoptransactions_ibfk_1` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=812 DEFAULT CHARSET=latin1;

