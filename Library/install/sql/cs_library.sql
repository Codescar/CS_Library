/* Date: 2012-09-01 04:55:42 */

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `announcements`
-- ----------------------------
DROP TABLE IF EXISTS `announcements`;
CREATE TABLE `announcements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `body` longtext NOT NULL,
  `date` datetime DEFAULT NULL,
  `author` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of announcements
-- ----------------------------
INSERT INTO `announcements` VALUES ('1', 'Δημιουργία Ιστοσελίδας', '<p>\r\n	&Epsilon;ί&mu;&alpha;&sigma;&tau;&epsilon; &sigma;&tau;&eta;&nu; &epsilon;&upsilon;&chi;ά&rho;&iota;&sigma;&tau;&eta; &theta;έ&sigma;&eta; &nu;&alpha; &sigma;&alpha;&sigmaf; &alpha;&nu;&alpha;&phi;ά&rho;&omicron;&upsilon;&mu;&epsilon; &tau;&eta; &delta;&eta;&mu;&iota;&omicron;&upsilon;&rho;&gamma;ί&alpha; &tau;&eta;&sigmaf; &epsilon;&pi;ί&sigma;&iota;&mu;&eta;&sigmaf; &pi;ύ&lambda;&eta;&sigmaf; &tau;&eta;&sigmaf; &beta;&iota;&beta;&lambda;&iota;&omicron;&theta;ή&kappa;&eta;&sigmaf; &mu;&alpha;&sigmaf; &sigma;&tau;&omicron; &delta;&iota;&alpha;&delta;ί&kappa;&tau;&upsilon;&omicron;.&nbsp;&Mu;έ&sigma;&alpha; &alpha;&pi;ό &alpha;&upsilon;&tau;ή &tau;&eta; &pi;&lambda;&alpha;&tau;&phi;ό&rho;&mu;&alpha; &theta;&alpha; &mu;&pi;&omicron;&rho;&epsilon;ί&tau;&epsilon; &nu;&alpha; &epsilon;&nu;&eta;&mu;&epsilon;&rho;ώ&nu;&epsilon;&sigma;&tau;&epsilon; &kappa;&alpha;&iota; &nu;&alpha; &lambda;&alpha;&mu;&beta;ά&nu;&epsilon;&tau;&alpha;&iota; &upsilon;&pi;&eta;&rho;&epsilon;&sigma;ί&epsilon;&sigmaf; &mu;&alpha;&sigmaf; &eta;&lambda;&epsilon;&kappa;&tau;&rho;&omicron;&nu;&iota;&kappa;ά.</p>\r\n<p style=\"text-align: right\">\r\n	<span style=\"color:#a52a2a;\"><u>&Tau;&omicron; &pi;&rho;&omicron;&sigma;&omega;&pi;&iota;&kappa;ό &tau;&eta;&sigmaf; &beta;&iota;&beta;&lambda;&iota;&omicron;&theta;ή&kappa;&eta;&sigmaf;</u></span></p>\r\n', '2012-08-08 02:35:30', '1');

-- ----------------------------
-- Table structure for `avatars`
-- ----------------------------
DROP TABLE IF EXISTS `avatars`;
CREATE TABLE `avatars` (
  `user_id` int(11) NOT NULL,
  `is_file` int(1) NOT NULL DEFAULT '0',
  `avatar_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `book_has_category`
-- ----------------------------
DROP TABLE IF EXISTS `book_has_category`;
CREATE TABLE `book_has_category` (
  `book_id` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`book_id`,`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `booklist`
-- ----------------------------
DROP TABLE IF EXISTS `booklist`;
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

-- ----------------------------
-- Table structure for `categories`
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `comments`
-- ----------------------------
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(11) unsigned NOT NULL,
  `book_id` int(11) unsigned NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `departments`
-- ----------------------------
DROP TABLE IF EXISTS `departments`;
CREATE TABLE `departments` (
  `id` int(11) unsigned NOT NULL,
  `incharge` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `comments` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of departments
-- ----------------------------
INSERT INTO `departments` VALUES ('1', '2', 'Πρώτο Τμήμα', null);

-- ----------------------------
-- Table structure for `favorites`
-- ----------------------------
DROP TABLE IF EXISTS `favorites`;
CREATE TABLE `favorites` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `book_id` int(11) NOT NULL DEFAULT '0',
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`,`book_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `lend`
-- ----------------------------
DROP TABLE IF EXISTS `lend`;
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

-- ----------------------------
-- Table structure for `log_lend`
-- ----------------------------
DROP TABLE IF EXISTS `log_lend`;
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

-- ----------------------------
-- Table structure for `messages`
-- ----------------------------
DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from` int(11) NOT NULL DEFAULT '0',
  `to` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL DEFAULT '',
  `text` varchar(255) NOT NULL DEFAULT '',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `unreaded` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `options`
-- ----------------------------
DROP TABLE IF EXISTS `options`;
CREATE TABLE `options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `value` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of options
-- ----------------------------
INSERT INTO `options` VALUES ('1', 'Version', 'Η έκδοση του συστήματος', '1.00');
INSERT INTO `options` VALUES ('2', 'document-root', 'Η μεταβλητή αυτή ορίζει που είναι αποθηκευμένο το σύστημα στον server', '/var/www/vhosts/l2smiles.com/sites/projects.codescar.eu/Library/demo/');
INSERT INTO `options` VALUES ('3', 'update-prefix', '', 'CS_Library_update_');
INSERT INTO `options` VALUES ('4', 'admin_email', 'Το email του διαχειριστή', 'info@codescar.eu');
INSERT INTO `options` VALUES ('5', 'lendings', 'Πόσα βιβλία μπορεί κάποιος να δανειστεί', '10');
INSERT INTO `options` VALUES ('6', 'requests', 'Πόσα αιτήματα μπορεί να κάνει κάποιος', '5');
INSERT INTO `options` VALUES ('7', 'request_life', 'Πόσες μέρες \"ισχύει\" το αίτημα', '2');
INSERT INTO `options` VALUES ('8', 'debug', 'Μεταβλητή για developers ώστε να εμφανίζονται τα errors', 'true');
INSERT INTO `options` VALUES ('9', 'maintance', 'Enables maintenance mode', '');
INSERT INTO `options` VALUES ('10', 'allow_register', '', 'true');
INSERT INTO `options` VALUES ('11', 'allow_login', '', 'true');
INSERT INTO `options` VALUES ('12', 'allow_admin', '', 'true');
INSERT INTO `options` VALUES ('13', 'allow_compression', '', 'true');
INSERT INTO `options` VALUES ('14', 'items_per_page', '', '5');

-- ----------------------------
-- Table structure for `pages`
-- ----------------------------
DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desc` longtext NOT NULL,
  `body` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pages
-- ----------------------------
INSERT INTO `pages` VALUES ('1', 'Αρχική', '<p>\r\n	Some Information about your library</p>\r\n');
INSERT INTO `pages` VALUES ('2', 'Πληροφορίες', '<p>\r\n	&Mu;&iota;&alpha; &nu;έ&alpha; &delta;&upsilon;&nu;&alpha;&tau;ό&tau;&eta;&tau;&alpha; &sigma;&tau;&eta;&nu; &eta;&lambda;&epsilon;&kappa;&tau;&rho;&omicron;&nu;&iota;&kappa;ή &mu;&alpha;&sigmaf; &pi;ύ&lambda;&eta; έ&chi;&epsilon;&iota; &pi;&rho;&omicron;&sigma;&tau;&epsilon;&theta;&epsilon;ί. &Alpha;&upsilon;&tau;ή &epsilon;ί&nu;&alpha;&iota; &eta; &pi;&rho;&omicron;&beta;&omicron;&lambda;ή &kappa;&alpha;&iota; &pi;&alpha;&rho;&omicron;&upsilon;&sigma;ί&alpha;&sigma;&eta; &tau;&omega;&nu; &delta;&iota;&alpha;&theta;έ&sigma;&iota;&mu;&omega;&nu; &beta;&iota;&beta;&lambda;ί&omega;&nu; &tau;&eta;&sigmaf; &delta;&alpha;&nu;&epsilon;&iota;&sigma;&tau;&iota;&kappa;ή&sigmaf; &mu;&alpha;&sigmaf; &beta;&iota;&beta;&lambda;&iota;&omicron;&theta;ή&kappa;&eta;&sigmaf;. &Mu;&pi;&omicron;&rho;&epsilon;ί&tau;&epsilon; &nu;&alpha; &delta;&epsilon;ί&tau;&epsilon; &alpha;&upsilon;&tau;ή &tau;&eta; &nu;έ&alpha; &delta;&upsilon;&nu;&alpha;&tau;ό&tau;&eta;&tau;&alpha; &sigma;&tau;&eta;&nu; &kappa;&alpha;&tau;&eta;&gamma;&omicron;&rho;ί&alpha; &quot;&Kappa;&alpha;&tau;ά&lambda;&omicron;&gamma;&omicron;&sigmaf;-&Beta;&iota;&beta;&lambda;ί&omega;&nu;&quot; &alpha;&pi;ό &tau;&omicron; &kappa;&epsilon;&nu;&tau;&rho;&iota;&kappa;ό &mu;&epsilon;&nu;&omicron;ύ &pi;&lambda;&omicron;ή&gamma;&eta;&sigma;&eta;&sigmaf;.</p>\r\n');
INSERT INTO `pages` VALUES ('3', 'Πάνω δεξί banner', '&Delta;&epsilon;&upsilon;&tau;έ&rho;&alpha; &omega;&sigmaf; &Pi;&alpha;&rho;&alpha;&sigma;&kappa;&epsilon;&upsilon;ή 9:00-20:00 210 33.82.601\r\n');

-- ----------------------------
-- Table structure for `requests`
-- ----------------------------
DROP TABLE IF EXISTS `requests`;
CREATE TABLE `requests` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `book_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
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

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'Admin', 'CodeScar', 'Library', 'Αναγνώστης', 'Admin', '0000-00-00', '0000000000', 'info@codescar.eu', '100', '', '0000-00-00 00:00:00', '0', '0', '0');
