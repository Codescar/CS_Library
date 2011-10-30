﻿<?php 
	if(!defined('INDEX'))
		die("Invalid request!");
	define('VIEW_INDEX', true);
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
		// εδώ θα πρέπει να φαίνονται οι πληροφορίες και τα σχόλεια για τα βιβλία
		include('book.php');
	else 
		/* The page doesn't found */
		include('404.php');
		 
	/* Footer */
	require_once('footer.php');
?>