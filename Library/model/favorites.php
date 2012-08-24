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
			global $db, $CONFIG, $page;			
			
			$query = "	SELECT * FROM `{$db->table['booklist']}` 
							WHERE `id` 
								IN (SELECT `book_id` 
										FROM `{$db->table['favorites']}` 
										WHERE `user_id` = '$this->user_id') 
							ORDER BY id ASC LIMIT ".$page*$CONFIG['items_per_page'].", {$CONFIG['items_per_page']}; ";
			
			return $query;
		}
		
		public function add_favorite($book_id){
			global $db;	
			
			$query = "	INSERT INTO `{$db->table['favorites']}` (`user_id`, `book_id`, `date`)
							SELECT * FROM (SELECT '{$this->user_id}' AS a, '$book_id' AS b, NOW() AS c) AS tmp
							WHERE EXISTS (
    							SELECT `id` FROM `{$db->table['booklist']}` WHERE `id` = '$book_id'
							) LIMIT 1;";
			
			$results = $db->query($query);
			$num = mysql_affected_rows();
			
			$this->cached = false;
			
			return $num;
		}
		
		public function delete_favorite($book_id){
			global $db;	
			
			$query = "	DELETE FROM `{$db->table['favorites']}` 
							WHERE `user_id` = '{$this->user_id}' 
							AND `book_id` = '$book_id' LIMIT 1;";
			
			$results = $db->query($query);
			$num = mysql_affected_rows();
			
			$this->cached = false;
			
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
	
		private function build_cache(){
			global $db;
			
			$tmp = array();
						
			$res = $db->query($this->get_favorites());
			
			while($row = mysql_fetch_array($res)){
				array_push($tmp, $row['id']);
			}
			
			$this->cached = true;
			$this->favorite_cache = $tmp;
			return true;
		}
		
		private function get_cache(){
			if($this->cached)
				return $this->favorite_cache;
			else{
				$this->build_cache();
				return $this->favorite_cache;
			}		
		}
			
		public static function show_favorites_button($id){
			global $user;
			
			if(!$user->is_logged_in()){ 
				?> <a class="must-login" href="?show=login" >+ Aγαπημένα</a> <?php 
			}else{ 
				$favorites = $user->favorites->get_cache();
				
				if(in_array($id, $favorites)){
					?> <a class="fav-remove" href="index.php?show=favorites&action=remove&id=<?php echo $id; ?>">- Aγαπημένα</a> <?php 
				}else{ 
					?> <a class="fav-add" href="index.php?show=favorites&action=add&id=<?php echo $id; ?>">+ Aγαπημένα</a> <?php 
				}
			}
			
		}
	};
?>