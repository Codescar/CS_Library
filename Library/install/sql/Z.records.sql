
INSERT INTO `announcements` VALUES ('1', 'Δημιουργία Ιστοσελίδας', '<p>\r\n	&Epsilon;ί&mu;&alpha;&sigma;&tau;&epsilon; &sigma;&tau;&eta;&nu; &epsilon;&upsilon;&chi;ά&rho;&iota;&sigma;&tau;&eta; &theta;έ&sigma;&eta; &nu;&alpha; &sigma;&alpha;&sigmaf; &alpha;&nu;&alpha;&phi;ά&rho;&omicron;&upsilon;&mu;&epsilon; &tau;&eta; &delta;&eta;&mu;&iota;&omicron;&upsilon;&rho;&gamma;ί&alpha; &tau;&eta;&sigmaf; &epsilon;&pi;ί&sigma;&iota;&mu;&eta;&sigmaf; &pi;ύ&lambda;&eta;&sigmaf; &tau;&eta;&sigmaf; &beta;&iota;&beta;&lambda;&iota;&omicron;&theta;ή&kappa;&eta;&sigmaf; &mu;&alpha;&sigmaf; &sigma;&tau;&omicron; &delta;&iota;&alpha;&delta;ί&kappa;&tau;&upsilon;&omicron;.&nbsp;&Mu;έ&sigma;&alpha; &alpha;&pi;ό &alpha;&upsilon;&tau;ή &tau;&eta; &pi;&lambda;&alpha;&tau;&phi;ό&rho;&mu;&alpha; &theta;&alpha; &mu;&pi;&omicron;&rho;&epsilon;ί&tau;&epsilon; &nu;&alpha; &epsilon;&nu;&eta;&mu;&epsilon;&rho;ώ&nu;&epsilon;&sigma;&tau;&epsilon; &kappa;&alpha;&iota; &nu;&alpha; &lambda;&alpha;&mu;&beta;ά&nu;&epsilon;&tau;&alpha;&iota; &upsilon;&pi;&eta;&rho;&epsilon;&sigma;ί&epsilon;&sigmaf; &mu;&alpha;&sigmaf; &eta;&lambda;&epsilon;&kappa;&tau;&rho;&omicron;&nu;&iota;&kappa;ά.</p>\r\n<p style=\"text-align: right\">\r\n	<span style=\"color:#a52a2a;\"><u>&Tau;&omicron; &pi;&rho;&omicron;&sigma;&omega;&pi;&iota;&kappa;ό &tau;&eta;&sigmaf; &beta;&iota;&beta;&lambda;&iota;&omicron;&theta;ή&kappa;&eta;&sigmaf;</u></span></p>\r\n', '2012-08-08 02:35:30', '1');

INSERT INTO `departments` VALUES ('1', '2', 'Πρώτο Τμήμα', null);

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

INSERT INTO `pages` VALUES ('1', 'Αρχική', '<p>\r\n	Some Information about your library</p>\r\n');
INSERT INTO `pages` VALUES ('2', 'Πληροφορίες', '<p>\r\n	&Mu;&iota;&alpha; &nu;έ&alpha; &delta;&upsilon;&nu;&alpha;&tau;ό&tau;&eta;&tau;&alpha; &sigma;&tau;&eta;&nu; &eta;&lambda;&epsilon;&kappa;&tau;&rho;&omicron;&nu;&iota;&kappa;ή &mu;&alpha;&sigmaf; &pi;ύ&lambda;&eta; έ&chi;&epsilon;&iota; &pi;&rho;&omicron;&sigma;&tau;&epsilon;&theta;&epsilon;ί. &Alpha;&upsilon;&tau;ή &epsilon;ί&nu;&alpha;&iota; &eta; &pi;&rho;&omicron;&beta;&omicron;&lambda;ή &kappa;&alpha;&iota; &pi;&alpha;&rho;&omicron;&upsilon;&sigma;ί&alpha;&sigma;&eta; &tau;&omega;&nu; &delta;&iota;&alpha;&theta;έ&sigma;&iota;&mu;&omega;&nu; &beta;&iota;&beta;&lambda;ί&omega;&nu; &tau;&eta;&sigmaf; &delta;&alpha;&nu;&epsilon;&iota;&sigma;&tau;&iota;&kappa;ή&sigmaf; &mu;&alpha;&sigmaf; &beta;&iota;&beta;&lambda;&iota;&omicron;&theta;ή&kappa;&eta;&sigmaf;. &Mu;&pi;&omicron;&rho;&epsilon;ί&tau;&epsilon; &nu;&alpha; &delta;&epsilon;ί&tau;&epsilon; &alpha;&upsilon;&tau;ή &tau;&eta; &nu;έ&alpha; &delta;&upsilon;&nu;&alpha;&tau;ό&tau;&eta;&tau;&alpha; &sigma;&tau;&eta;&nu; &kappa;&alpha;&tau;&eta;&gamma;&omicron;&rho;ί&alpha; &quot;&Kappa;&alpha;&tau;ά&lambda;&omicron;&gamma;&omicron;&sigmaf;-&Beta;&iota;&beta;&lambda;ί&omega;&nu;&quot; &alpha;&pi;ό &tau;&omicron; &kappa;&epsilon;&nu;&tau;&rho;&iota;&kappa;ό &mu;&epsilon;&nu;&omicron;ύ &pi;&lambda;&omicron;ή&gamma;&eta;&sigma;&eta;&sigmaf;.</p>\r\n');
INSERT INTO `pages` VALUES ('3', 'Πάνω δεξί banner', '&Delta;&epsilon;&upsilon;&tau;έ&rho;&alpha; &omega;&sigmaf; &Pi;&alpha;&rho;&alpha;&sigma;&kappa;&epsilon;&upsilon;ή 9:00-20:00 210 33.82.601\r\n');

INSERT INTO `users` VALUES ('1', 'Admin', 'CodeScar', 'Library', 'Αναγνώστης', 'Admin', '0000-00-00', '0000000000', 'info@codescar.eu', '100', '', '0000-00-00 00:00:00', '0', '0', '0');
