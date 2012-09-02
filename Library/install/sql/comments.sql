CREATE TABLE `comments` (
  `id` int(11) unsigned NOT NULL,
  `book_id` int(11) unsigned NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;