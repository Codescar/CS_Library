<?php 
	if(!defined('INDEX'))
		die("Invalid request!");
	define('VIEW_INDEX', true);
	
	/* Load the rest model files*/
	load_model();	
	/* Load the user's messagebox*/
	$user->message = new message();
	
	/* Header File */
	require_once('header.php');
	/* navigation menu */
	if(isset($_GET['show']) && $_GET['show'] == "help");else
		include('nav.php');
		
	
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
		include('book.php');
	elseif($_GET['show'] == "login" && $CONFIG['allow_login'])
		include('login.php');
	elseif($_GET['show'] == "logout")
		include('logout.php');
	elseif($_GET['show'] == "msg" && $CONFIG['allow_login'])
		include('msg.php');//TODO message window
	elseif($_GET['show'] == "cp" && $CONFIG['allow_login'])
		include('cp.php');
	elseif($_GET['show'] == "feedback")
		include('feedback.php');
	elseif($_GET['show'] == "help")
		include('help.php');
	elseif($_GET['show'] == "admin" && $CONFIG['allow_admin'] && $user->is_admin())
		include('admin.php');
	elseif($_GET['show'] == "info")
		include('info.php');
	elseif($_GET['show'] == "update")
		include('update.php');
	else 
		/* The page doesn't found */
		include('404.php');
	if($CONFIG['right_sidebar']){	
		if(isset($_GET['show']) && ($_GET['show'] == "help" || $_GET['show'] == "feedback"));else	 
			include ('right_sidebar.php');
	}
	
	/* Footer */
	require_once('footer.php');
?>