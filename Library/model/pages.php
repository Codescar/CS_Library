<?php

class pages{
	
	
	
	public static function get_body($id){
		global $db;
		$query = "SELECT `body` FROM `{$db->table["pages"]}` WHERE `{$db->table["pages"]}`.`id` = '".$db->db_escape_string($id)."' LIMIT 1;";
		$result = $db->query($query);
		$page = $db->db_fetch_object($result);
		echo $page->body;
		return 1;
	}
	
	public static function list_all(){
	    global $db;
	    $query = "SELECT * FROM `{$db->table["pages"]}` ;";
	    return $db->query($query);
	}
	
	public static function get($id){
	    global $db;
	    $query = "SELECT * FROM `{$db->table["pages"]}` WHERE `{$db->table["pages"]}`.`id` = '".$db->db_escape_string($id)."' LIMIT 1;";
	    return $db->query($query);
	}
	
	public static function update($id, $body){
		global $db, $user;
		$query = "	UPDATE `{$db->table["pages"]}` 
					SET `{$db->table["pages"]}`.`body` = '".$db->db_escape_string($body)."' 
					WHERE `{$db->table["pages"]}`.`id` = '".$db->db_escape_string($id)."';";
		$db->query($query);
		return ;
	}
	
	/*
	* 		This two functions are not needed!
	*
	* public static function add($title, $body){
	global $db, $user;
	$query = "	INSERT INTO `{$db->table["pages"]}` (`title`, `body`, `date`, `author`)
	VALUES ('".$db->db_escape_string($title)."', '".$db->db_escape_string($body)."', NOW(), '{$user->id}') ;";
	$db->query($query);
	return ;
	}
	
	public static function delete($id){
	global $db;
	$query = "DELETE FROM `{$db->table["pages"]}` WHERE `id` = '".$db->db_escape_string($id)."' LIMIT 1;";
	$db->query($query);
	return ;
	}
	
	public static function show($page = 0){
		global $db;
		$query = "SELECT * FROM `{$db->table["pages"]}` ORDER BY `date` desc;";
		$result = $db->query($query);
		while($row = $db->db_fetch_array($result)){
			?>
			<div class="announce">
				<div class="announce-head"><?php echo $row['title']; ?></div>
				<div class="announce-content"><?php echo $row['body']; ?></div>
				<p class="announce-footer">Δημιουργήηκε από το χρήστη <?php echo (strlen($row['author']) >= 1) ? user::get_name($row['author']) : "Ανώνυμο"; ?> την <?php echo (strlen($row['date']) >= 1) ? date('d-m-Y στις H:i', strtotime($row['date'])) : ""; ?>.</p>
			</div><br />
			<?php 
		}
	}
	
	public static function num(){
		global $db;
		$query = "SELECT id FROM `{$db->table["pages"]}`;";
		$result = $db->query($query);
		$num = $db->db_num_rows($result);
		return $num;
	}*/
};
?>