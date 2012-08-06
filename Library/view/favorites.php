<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	
	global $db;
	
	if(!$user->is_logged_in()){
	?>
		<div class="content"><p class="error">Πρέπει να συνδεθείτε πρώτα.</p></div>	
	<?php 
	} else {
		
	
		$books = $db->get_books($user->favorites->get_favorites());
		
		echo '<div class="content">';
		
		list_books($books);
		
		echo '</div>';
	}
?>