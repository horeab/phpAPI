CREATE TABLE `usergames` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user1Id` int(11) NOT NULL,
  `user2Id` int(11) NOT NULL,
  `date` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usergames_ibfk_1` (`user1Id`),
  KEY `usergames_ibfk_2` (`user2Id`),
  CONSTRAINT `usergames_ibfk_1` FOREIGN KEY (`user1Id`) REFERENCES `users` (`id`),
  CONSTRAINT `usergames_ibfk_2` FOREIGN KEY (`user2Id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;