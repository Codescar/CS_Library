CREATE TABLE `lend` (
  `book_id` int(11) unsigned NOT NULL,
  `department_id` int(11) unsigned DEFAULT '0',
  `user_id` int(11) unsigned NOT NULL,
  `taken` datetime DEFAULT NULL,
  `must_return` datetime DEFAULT NULL,
  `returned` datetime DEFAULT NULL,
  PRIMARY KEY (`book_id`),
  KEY `fk2` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;