<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	
	global $db; ?>
	<div id="direction"><a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;Αγαπημένα Βιβλία</div>
	<?php
	if(!$user->is_logged_in()){ ?>
		<div class="content"><div class="error">Πρέπει να συνδεθείτε πρώτα.</div></div>	
	<?php }else{
		$books = $db->get_books($user->favorites->get_favorites());
		echo "<div class=\"content\">";
		list_books($books);
		echo "</div>";
	}
?>