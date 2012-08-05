<?php 
	class favorites{
		
		public static function get_favorites(){
			global $db, $user;
			
			$user_id = $user->id;
			
			$query = "	SELECT FROM `{$db->table['favorites']}` 
							WHERE `user_id` = '$user_id';";
			
			$results = $db->query($query);
			
			return $results;
		}
		
		public static function add_favorite($book_id){
			global $db, $user;
			
			$user_id = $user->id;
			
			$query = "	INSERT INTO `{$db->table['favorites']}` (`user_id`, `book_id`, `date`)
							SELECT * FROM (SELECT '$user_id', '$book_id', 'NOW()') AS tmp
							WHERE EXISTS (
    							SELECT `id` FROM `{$db->table['booklist']}` WHERE `id` = '$book_id'
							) LIMIT 1;";
			
			$results = $db->query($query);
			$num = mysql_affected_rows($results);
			
			return $num;
		}
		
		public static function delete_favorite($book_id){
			global $db, $user;
			
			$user_id = $user->id;
			
			$query = "	DELETE FROM `{$db->table['favorites']}` 
							WHERE `user_id` = '$user_id' 
							AND `book_id` = '$book_id' LIMIT 1;";
			
			$results = $db->query($query);
			$num = mysql_affected_rows($results);
			
			return $num;
		}
		
		public static function cleanup_favorites(){
			global $db;
			
			$query = "	DELETE FROM `{$db->table['favorites']}` 
							WHERE `user_id` NOT IN(SELECT `id` FROM `{$db->table['users']}`) 
							OR `book_id` NOT IN(SELECT `id` FROM `{$db->table['booklist']}`); ";
			
			$results = $db->query($query);
			$num = mysql_affected_rows($results);
			
			return $num;
		}
			
	};
?>