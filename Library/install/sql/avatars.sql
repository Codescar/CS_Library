CREATE TABLE `avatars` (
  `user_id` int(11) NOT NULL,
  `is_file` int(1) NOT NULL DEFAULT '0',
  `avatar_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;