<?php
	/* Config File */ 
	$url = "http://" . $_SERVER['HTTP_HOST'] . "/Library/demo/";
	
	$title = "Εθνική Βιβλιοθήκη Αθηνών";

	/* Session Settings, Max IDLE TIME */
	define('MAX_IDLE_TIME', '3600');
	
	global $CONFIG;
	$CONFIG['allow_register'] = true;
	$CONFIG['allow_login'] = true;
	$CONFIG['allow_admin'] = true;
	$CONFIG['allow_compression'] = true;
	$CONFIG['debug'] = true;
	$CONFIG['items_per_page'] = 5;
	$CONFIG['right_sidebar'] = false;
	$CONFIG['maintance'] = false;
	

	$CONFIG['document-root'] = "/var/www/vhosts/l2smiles.com/sites/projects.codescar.eu/Library/demo/"; //Have to put the path here
	$CONFIG['lend_default_days'] = 15;
	
	define(TEMPLATE_PATH, "templates/");
	
	load_options();
	function load_options()
	{
		global $db, $CONFIG;
		$results = $db -> query("SELECT * FROM `{$db -> table['options']}`");
		while($row = mysql_fetch_array($results))
		{
			
			$CONFIG[$row['Name']] = $row['Value'];
		}
		return;
	}
?>
