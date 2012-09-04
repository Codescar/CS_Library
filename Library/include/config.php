<?php
	/* Config File */ 

	/* Session Settings, Max IDLE TIME */
	//define('MAX_IDLE_TIME', 3600);
	//define('TEMPLATE_PATH', "/usr/sites/Library/templates/");
	
	global $CONFIG;
	
	/* Basic installation configs */
	$CONFIG['title'] = "CodeScar Library Management System";
	$CONFIG['document-root'] = "/var/www/vhosts/l2smiles.com/sites/projects.codescar.eu/Library/demo/"; //Have to put the path here
	$CONFIG['url'] = "http://" . $_SERVER['HTTP_HOST'] . "/Library/demo/";
	$CONFIG['max_idle_time'] =  3600;
	$CONFIG['template_path'] =  $CONFIG['document-root']."templates/";
	
	/* Modules configs*/
	$CONFIG['allow_register'] = true;
	$CONFIG['allow_login'] = true;
	$CONFIG['allow_admin'] = true;
	$CONFIG['allow_compression'] = true;
	
	/* developer options */
	$CONFIG['debug'] = true;
	$CONFIG['maintenance'] = false;
	
	/* visuals */
	$CONFIG['items_per_page'] = 5;
	$CONFIG['right_sidebar'] = false;
	$CONFIG['num_of_pages_to_navigate'] = 8;
	
	/* lending procedure */
	$CONFIG['lendings'] = 3;
	$CONFIG['requests'] = 2;
	$CONFIG['request_life'] = 2;
	$CONFIG['lend_days'] = 15;
	$CONFIG['extra_days_lend'] = 15;
	
	$local_config_file = "myconfig.php";
	
	if(file_exists($local_config_file))
		include $local_config_file;
	/*
	 * Load the config from the database, 
	 * if there are same, it overides them.
	 */
	option::load_options();	
?>
