<?php 
	class favorites{
		
		private $favorite_cache, $cached, $user_id;
		
		function __construct(){
			global $user;
			
			$this->favorite_cache = array();
			$this->cached = false;
			
			$this->user_id = $user->id;
			
		}
		
		public function get_favorites(){
			global $db;			
			
			$query = "	SELECT * FROM `{$db->table['booklist']}` 
							WHERE `id` 
								IN (SELECT `book_id` 
										FROM `{$db->table['favorites']}` 
										WHERE `user_id` = '$this->user_id');";
			
			$results = $db->query($query);
			
			return $results;
		}
		
		public function add_favorite($book_id){
			global $db;	
			
			$query = "	INSERT INTO `{$db->table['favorites']}` (`user_id`, `book_id`, `date`)
							SELECT * FROM (SELECT '$user_id', '$book_id', 'NOW()') AS tmp
							WHERE EXISTS (
    							SELECT `id` FROM `{$db->table['booklist']}` WHERE `id` = '$book_id'
							) LIMIT 1;";
			
			$results = $db->query($query);
			$num = mysql_affected_rows();
			
			return $num;
		}
		
		public function delete_favorite($book_id){
			global $db;	
			
			$query = "	DELETE FROM `{$db->table['favorites']}` 
							WHERE `user_id` = '$user_id' 
							AND `book_id` = '$book_id' LIMIT 1;";
			
			$results = $db->query($query);
			$num = mysql_affected_rows();
			
			return $num;
		}
		
		public function cleanup_favorites(){
			global $db;	
			
			$query = "	DELETE FROM `{$db->table['favorites']}` 
							WHERE `user_id` NOT IN(SELECT `id` FROM `{$db->table['users']}`) 
							OR `book_id` NOT IN(SELECT `id` FROM `{$db->table['booklist']}`); ";
			
			$results = $db->query($query);
			$num = mysql_affected_rows();
			
			return $num;
		}
	
			
		public static function show_favorites_button(){
			global $user;
			
			if(!$user->is_logged_in()){ ?>
    			<a onclick="return alert('Πρέπει να συνδεθείτε πρώτα');" href="?show=login">+ Aγαπημένα</a>
    		<?php 
			}else{ 
    		?>
	    		<a onclick="return confirm('Είσαι σίγουρος ότι θέλεις να το προσθέσεις στα αγαπημένα σου;');" href="#">+ Aγαπημένα</a>
    		<?php 
			}
			
		}
	};
?>