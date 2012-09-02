CREATE TABLE `book_has_category` (
  `book_id` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`book_id`,`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;