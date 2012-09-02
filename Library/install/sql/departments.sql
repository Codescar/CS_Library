CREATE TABLE `departments` (
  `id` int(11) unsigned NOT NULL,
  `incharge` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `comments` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;