<?php 
	if(!defined('INDEX'))
		die("Invalid request!");
	define('VIEW_INDEX', true);
	
	global $db;
	/* Header File */
	require_once('header.php');

	/* navigation menu */
	include('nav.php');
	
	/* include the right page to show */
	if(!isset($_GET['show'])) 
		include('show.php');
	elseif($_GET['show'] == "list")
		include('list.php');
	elseif($_GET['show'] == "search")
		include('search.php');
	elseif($_GET['show'] == "results")
		include('results.php');
	elseif($_GET['show'] == "book" && isset($_GET['id']))
		///TODO book view
		include('book.php');
	elseif($_GET['show'] == "login" && $CONFIG['allow_login'])
		include('login.php');
	elseif($_GET['show'] == "register" && $CONFIG['allow_register'])
		include('register.php');
	elseif($_GET['show'] == "logout")
		include('logout.php');
	elseif($_GET['show'] == "msg" && $CONFIG['allow_login'])
		include('msg.php');//TODO message window
	elseif($_GET['show'] == "cp" && $CONFIG['allow_login'])
		include('cp.php');//TODO User Control Panel
	elseif($_GET['show'] == "admin" && $CONFIG['allow_admin']) //TODO check if have admin rights
		include('admin.php');//TODO Admin User Panel
	else 
		/* The page doesn't found */
		include('404.php');
		 
	/* Footer */
	require_once('footer.php');
?>