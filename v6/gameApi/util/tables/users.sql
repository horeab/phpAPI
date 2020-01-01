CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entityCreationDate` bigint(20) NOT NULL,
  `externalId` varchar(50) NOT NULL,
  `accountCreationSource` varchar(20) NOT NULL,
  `lastTimeActiveDate` bigint(20) NOT NULL,
  `fullName` varchar(100) NOT NULL DEFAULT 'Name',
  `gameId` varchar(50) NOT NULL DEFAULT 'ro',
  PRIMARY KEY (`id`),
  UNIQUE KEY `externalId` (`externalId`,`accountCreationSource`,`gameId`)
) ENGINE=InnoDB AUTO_INCREMENT=188 DEFAULT CHARSET=latin1;

