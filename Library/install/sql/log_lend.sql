CREATE TABLE `log_lend` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) unsigned NOT NULL,
  `department_id` int(11) unsigned DEFAULT '0',
  `user_id` int(11) unsigned NOT NULL,
  `taken` datetime DEFAULT NULL,
  `must_return` datetime DEFAULT NULL,
  `returned` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;