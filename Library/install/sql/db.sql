
-- ----------------------------
-- Table structure for `booklist`
-- ----------------------------
DROP TABLE IF EXISTS `booklist`;
CREATE TABLE `booklist` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `writer_or` varchar(255) DEFAULT '',
  `added_on` date DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=239 DEFAULT CHARSET=greek;


-- ----------------------------
-- Table structure for `comments`
-- ----------------------------
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `book_id` int(11) unsigned NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of comments
-- ----------------------------

-- ----------------------------
-- Table structure for `departments`
-- ----------------------------
DROP TABLE IF EXISTS `departments`;
CREATE TABLE `departments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `incharge` varchar(255) NOT NULL,
  `name` varchar(255) CHARACTER SET greek NOT NULL DEFAULT '',
  `comments` varchar(255) CHARACTER SET greek DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of departments
-- ----------------------------

-- ----------------------------
-- Table structure for `lend`
-- ----------------------------
DROP TABLE IF EXISTS `lend`;
CREATE TABLE `lend` (
  `book_id` int(11) unsigned NOT NULL,
  `department_id` int(11) unsigned DEFAULT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `taken` date DEFAULT NULL,
  `returned` date DEFAULT '0000-00-00',
  PRIMARY KEY (`book_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


-- ----------------------------
-- Table structure for `log_lend`
-- ----------------------------
DROP TABLE IF EXISTS `log_lend`;
CREATE TABLE `log_lend` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) unsigned NOT NULL,
  `department_id` int(11) unsigned DEFAULT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `taken` date DEFAULT NULL,
  `returned` date DEFAULT '0000-00-00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;


-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `department_id` int(11) unsigned DEFAULT NULL,
  `name` varchar(255) CHARACTER SET greek NOT NULL,
  `surname` varchar(255) CHARACTER SET greek DEFAULT NULL,
  `nickname` varchar(255) CHARACTER SET greek DEFAULT NULL,
  `born` date DEFAULT NULL,
  `phone` decimal(14,0) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users
-- ----------------------------
DELIMITER ;;
CREATE TRIGGER `logging` AFTER UPDATE ON `lend` FOR EACH ROW BEGIN
	IF NEW.returned != NULL THEN
		SET @id = NEW.book_id ;
		INSERT INTO log_lend (book_id, department_id, user_id, taken, returned)
			SELECT * FROM lend WHERE book_id = @id ;
		DELETE FROM lend WHERE book_id = @id;
	END IF ;
END
;;
DELIMITER ;
