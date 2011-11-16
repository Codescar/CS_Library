<?php
	define('INDEX', true);
	
	session_start();
	
	require_once('include/includes.php');
	
	global $db, $user, $page;
	if(isset($_SESSION['user']) && $_SESSION['user'] != "user")
	    $user = unserialize($_SESSION['user']);
	else
	    $user = new User;
	
	$db = new Lbdb();
	$page = isset($_GET['page']) ? $_GET['page'] : 0;
	$user->session_check();
	
	if($CONFIG['allow_compression'])
		ob_start();

	if($CONFIG['debug']){
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
	}
	 
	
	require_once('view/index.php');
?>