<?php
	define('INDEX', true);
	
	session_start();
	
	require_once('include/config.php');
	require_once('include/includes.php');
	
	session_check();

	if($compression)
		ob_start();

	if($debug){
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
	}
	
	$page = isset($_GET['page']) ? $_GET['page'] : 0; 
	
	

	require_once('view/index.php');
?>