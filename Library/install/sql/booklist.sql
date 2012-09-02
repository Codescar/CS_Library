CREATE TABLE `booklist` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `isbn` varchar(13) NOT NULL,
  `availability` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `writer` varchar(255) DEFAULT '',
  `publisher` varchar(255) DEFAULT NULL,
  `description` text,
  `pages` int(11) DEFAULT NULL,
  `publish_year` int(11) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `added_on` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;