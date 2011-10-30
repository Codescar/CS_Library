<?php
	define('INDEX', true);
	require_once('include/config.php');

	if($debug){
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
	}
	
	$page = isset($_GET['page']) ? $_GET['page'] : 0; 
	
	require_once('include/includes.php');

	require_once('view/index.php');
?>