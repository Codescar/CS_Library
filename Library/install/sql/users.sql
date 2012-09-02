CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `usertype` varchar(255) DEFAULT NULL,
  `password` varchar(20) NOT NULL,
  `born` date DEFAULT NULL,
  `phone` varchar(14) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `access_lvl` int(11) NOT NULL,
  `last_ip` varchar(32) NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `books_lended` int(11) NOT NULL DEFAULT '0',
  `books_requested` int(11) NOT NULL DEFAULT '0',
  `banned` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;