ALTER TABLE `categories`
ADD UNIQUE INDEX `category_name_index` (`category_name`) USING BTREE ;

DROP TABLE IF EXISTS `ratings`;
CREATE TABLE `ratings` (
  `user_id` int(11) NOT NULL,
  `widget_id` int(11) NOT NULL,
  `rating` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`widget_id`),
  KEY `widget_id_index` (`widget_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;