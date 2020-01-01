CREATE TABLE `gamestats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `tournamentsStarted` int(11) NOT NULL DEFAULT '0',
  `tournamentsWon` int(11) NOT NULL DEFAULT '0',
  `questionsStarted` int(11) NOT NULL DEFAULT '0',
  `questionsWon` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `userId_2` (`userId`),
  KEY `userId` (`userId`),
  CONSTRAINT `gamestats_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

