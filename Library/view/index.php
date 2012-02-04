<?php 
	if(!defined('INDEX'))
		die("Invalid request!");
	define('VIEW_INDEX', true);
	
	/* Header File */
	require_once('header.php');
	/* navigation menu */
	if(isset($_GET['show']) && $_GET['show'] == "help");else
		include('nav.php');
		
	/* Load the rest model files*/
	load_model();
	
	/* Load the user's messagebox*/
	$user->message = new message();
	
	/* include the right page to show */
	if(!isset($_GET['show'])) 
		include('show.php');
	elseif($_GET['show'] == "about")
		include('about.php');
	elseif($_GET['show'] == "list")
		include('list.php');
	elseif($_GET['show'] == "search")
		include('search.php');
	elseif($_GET['show'] == "book" && isset($_GET['id']))
		include('book.php');///TODO book view
	elseif($_GET['show'] == "login" && $CONFIG['allow_login'])
		include('login.php');
	elseif($_GET['show'] == "logout")
		include('logout.php');
	elseif($_GET['show'] == "msg" && $CONFIG['allow_login'])
		include('msg.php');//TODO message window
	elseif($_GET['show'] == "cp" && $CONFIG['allow_login'])
		include('cp.php');//TODO User Control Panel
	elseif($_GET['show'] == "feedback")
		include('feedback.php');
	elseif($_GET['show'] == "help")
		include('help.php');
	elseif($_GET['show'] == "admin" && $CONFIG['allow_admin'] && $user->is_admin())
		include('admin.php');
	elseif($_GET['show'] == "info")
		include('info.php');
	else 
		/* The page doesn't found */
		include('404.php');
		
	if(isset($_GET['show']) && $_GET['show'] == "help");else	 
		include ('right_sidebar.php');
	
	/* Footer */
	require_once('footer.php');
?>