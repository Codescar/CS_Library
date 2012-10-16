<?php
	/* Config File */ 

	/* Session Settings, Max IDLE TIME */
	//define('MAX_IDLE_TIME', 3600);
	//define('TEMPLATE_PATH', "/usr/sites/Library/templates/");
	
	global $CONFIG;
	
	/* Basic installation configs */
	$CONFIG['title'] 					= "CodeScar Library Management System";
	$CONFIG['document-root'] 			= "/var/www/vhosts/l2smiles.com/sites/projects.codescar.eu/Library/demo/"; //Have to put the path here
	$CONFIG['url'] 						= "http://" . $_SERVER['HTTP_HOST'] . "/Library/demo/";
	$CONFIG['max_idle_time'] 			=  3600;
	$CONFIG['template_path'] 			=  $CONFIG['document-root']."templates/";
	
	/* Modules configs*/
	$CONFIG['allow_register'] 			= true;
	$CONFIG['allow_login']				= true;
	$CONFIG['allow_admin'] 				= true;
	$CONFIG['allow_compression'] 		= true;
	
	/* developer options */
	$CONFIG['debug']					= true;
	$CONFIG['maintenance'] 				= false;
	$CONFIG['charset']					= "utf8";
	$CONFIG['debug'] 					= true;
	
	/* Update Options */
	$CONFIG['UPDATE']['dir'] 			= 'UPDATE-PACKAGES/';
	$CONFIG['UPDATE']['URL'] 			= "http://projects.codescar.eu/Library/UPDATES/";
	
	/* visuals */
	$CONFIG['items_per_page'] 			= 5;
	$CONFIG['history_items_per_page']	= 20;
	$CONFIG['num_of_pages_to_navigate'] = 8;
	$CONFIG['right_sidebar'] 			= false;
	
	/* lending procedure */
	$CONFIG['lendings'] 				= 3;
	$CONFIG['requests'] 				= 2;
	$CONFIG['request_life'] 			= 2;
	$CONFIG['lend_days'] 				= 15;
	$CONFIG['extra_days_lend'] 			= 15;
	
	$CONFIG['MAIL']['USE_SMTP']			= false;
	$CONFIG['MAIL']['SMTP']['HOSTNAME']	= "smtp.example.com";
	$CONFIG['MAIL']['SMTP']['PORT']		= 25;
	$CONFIG['MAIL']['SMTP']['USERNAME']	= "username";	
	$CONFIG['MAIL']['SMTP']['PASSWORD'] = "password";

	$local_config_file = "include/myconfig.php";
	
	if(file_exists($local_config_file))
		require $local_config_file;
	
?>
