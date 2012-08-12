<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	
	global $db, $user; ?>
	<div id="direction"><a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;Αγαπημένα Βιβλία</div>
	<?php
	if(!$user->is_logged_in()){ ?>
		<div class="content"><div class="error">Πρέπει να συνδεθείτε πρώτα.</div></div>	
	<?php }else{
		
		if(isset($_GET['action']) && $_GET['action'] == "add"){
			if(!isset($_GET['id']))
				echo '<div class="error">Invalid request.</div>';
			else
				$user->favorites->add_favorite(mysql_real_escape_string($_GET['id']));
		}elseif(isset($_GET['action']) && $_GET['action'] == "remove"){
			if(!isset($_GET['id']))
				echo '<div class="error">Invalid request.</div>';
			else
				$user->favorites->delete_favorite(mysql_real_escape_string($_GET['id']));
		}
		
		$books = $db->get_books($user->favorites->get_favorites(), 
								"SELECT COUNT(*) FROM `{$db->table['favorites']}` WHERE `user_id` = '{$user->id}';");
		echo "<div class=\"content\">";
			list_books($books);
		echo "</div>";
	}
?>