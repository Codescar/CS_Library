<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	
	global $db, $user; ?>
	<div id="direction"><a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;Αγαπημένα Βιβλία</div>
	<?php
	if(!$user->is_logged_in()){ 
		echo "<div class=\"content\"><div class=\"error\">Πρέπει να συνδεθείτε πρώτα.<br />";
		redirect("index.php?show=login");
	}else{
		if(isset($_GET['action']) && $_GET['action'] == "add"){
			if(!isset($_GET['id']))
				echo '<div class="error">Invalid request.</div>';
			else
				$user->favorites->add_favorite($db->db_escape_string($_GET['id']));
		}elseif(isset($_GET['action']) && $_GET['action'] == "remove"){
			if(!isset($_GET['id']))
				echo '<div class="error">Invalid request.</div>';
			else
				$user->favorites->delete_favorite($db->db_escape_string($_GET['id']));
		}
		$admin_view = !empty($_GET['user_id']);
		$user_id = $admin_view ? $db->db_escape_string($_GET['user_id']) : $user->id; 
		$count_query =  "SELECT COUNT(*) FROM `{$db->table['favorites']}` WHERE `user_id` = '$user_id' ; ";
		$books = $db->get_books($user->favorites->get_favorites($admin_view ? $db->db_escape_string($_GET['user_id']) : -1), $count_query);
		echo "<div class=\"content\">";
			list_books($books, $admin_view ? 1 : 0);
		echo "</div>";
	}
?>