<?php
	define('INDEX', true);
	session_start();
	global $db, $user, $page;
	require_once('include/includes.php');
	
	if(isset($_SESSION['user']) && $_SESSION['user'] != "user")
	    $user = unserialize($_SESSION['user']);
	else
	    $user = new User;
	
	$page = isset($_GET['page']) ? intval($_GET['page']) : 0;
	$user->session_check();
	if($CONFIG['allow_compression'])
		ob_start();
	if($CONFIG['debug']){
		error_reporting(E_ALL | E_NOTICE | E_STRICT);
		ini_set('display_errors', '1');
		//define('DISPLAY_XPM4_ERRORS', true);
	}else{
		ini_set('display_errors', '0');
		define('DISPLAY_XPM4_ERRORS', false);
	}
	require_once('view/index.php');
?>