<?php

class announcements{
	
	public static function list_all(){
		global $db;
		$query = "SELECT * FROM `{$db->table["announcements"]}` ;";
		return $db->query($query);
	}
	
	public static function get($id){
		global $db;
		$query = "SELECT * FROM `{$db->table["announcements"]}` WHERE `id` = '".mysql_real_escape_string($id)."' LIMIT 1;";
		return $db->query($query);
	}
	
	public static function add($title, $body){
		global $db, $user;
		$query = "	INSERT INTO `{$db->table["announcements"]}` (`title`, `body`, `date`, `author`) 
					VALUES ('".mysql_real_escape_string($title)."', '".mysql_real_escape_string($body)."', NOW(), '{$user->id}') ;";
		$db->query($query);
		return ;
	}
	
	public static function delete($id){
		global $db;
		$query = "DELETE FROM `{$db->table["announcements"]}` WHERE `id` = '".mysql_real_escape_string($id)."' LIMIT 1;";
		$db->query($query);
		return ;
	}	
	
	public static function update($id, $title, $body){
		global $db, $user;
		$query = "	UPDATE `{$db->table["announcements"]}` 
					SET `title` = '".mysql_real_escape_string($title)."' , `body` = '".mysql_real_escape_string($body)."' , `date` = NOW() , `author` = '{$user->id}' 
					WHERE `id` = '".mysql_real_escape_string($id)."';";
		$db->query($query);
		return ;
	}
	
	public static function show($page = 0){
		global $db;
		$query = "SELECT * FROM `{$db->table["announcements"]}` ORDER BY `date` desc;";
		$result = $db->query($query);
		while($row = mysql_fetch_array($result)){
			?>
			<div class="announce">
				<div class="announce-head"><?php echo $row['title']; ?></div>
				<div class="announce-content"><?php echo $row['body']; ?></div>
				<p class="announce-footer">Δημιουργήηκε από το χρήστη <?php echo (strlen($row['author']) >= 1) ? user::get_name($row['author']) : "Ανώνυμο"; ?> την <?php echo (strlen($row['date']) >= 1) ? date('d-m-Y στις H:i', strtotime($row['date'])) : "";?>.</p>
			</div><br />
			<?php 
		}
	}
	
	public static function num(){
		global $db;
		$query = "SELECT id FROM `{$db->table["announcements"]}`;";
		$result = $db->query($query);
		$num = mysql_num_rows($result);
		return $num;
	}
};
?>