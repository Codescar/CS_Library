<?php
	/* Config File */ 

	/* Session Settings, Max IDLE TIME */
	define(MAX_IDLE_TIME, 3600);
	define(TEMPLATE_PATH, "templates/");
	
	global $CONFIG;
	
	/* Basic installation configs */
	$CONFIG['title'] = "CodeScar Library Managment System";
	$CONFIG['document-root'] = "/var/www/vhosts/l2smiles.com/sites/projects.codescar.eu/Library/demo/"; //Have to put the path here
	$CONFIG['url'] = "http://" . $_SERVER['HTTP_HOST'] . "/Library/demo/";
	
	/* Modules configs*/
	$CONFIG['allow_register'] = true;
	$CONFIG['allow_login'] = true;
	$CONFIG['allow_admin'] = true;
	$CONFIG['allow_compression'] = true;
	
	/* developer options */
	$CONFIG['debug'] = true;
	$CONFIG['maintance'] = false;
	
	/* visuals - costumisations */
	$CONFIG['items_per_page'] = 5;
	$CONFIG['right_sidebar'] = false;
	$CONFIG['lend_default_days'] = 15;
	
	/*
	 * Load the config from the database, 
	 * if there are same, 
	 * it overides them. //TODO do we want that or the opposite?
	 */
	option::load_options();
	
?>
