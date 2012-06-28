<?php
	/* Config File */ 
	$url = "http://" . $_SERVER['HTTP_HOST'] . "/Library/";
	
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

	$CONFIG['document-root'] = "P:\\xampp\\htdocs\\Library\\"; //Have to put the path here
	$CONFIG['lend_default_days'] = 15;
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
