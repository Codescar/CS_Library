<?php
/* Database infos */
global $db_hostname, $db_username, $db_password, $db_name, $db_tables_prefix;
	$db_hostname = "127.0.0.1";
	$db_username = "root";
	$db_password = "some_pass";
	$db_tables_prefix = "";
	$db_name = "codescar";
	
	/* With what database driver / database the installation works 
	 * options are: MySQLDriver
	 * 				MySQLiDriver
	 * */
	$CONFIG['dbDriver'] = "MySQLiDriver";
?>