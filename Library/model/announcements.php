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
					SET `body` = '".mysql_real_escape_string($body)."' , `title` = '".mysql_real_escape_string($title)."', `date` = NOW() , `author` = '{$user->id}' 
					WHERE `id` = '".mysql_real_escape_string($id)."';";
		$db->query($query);
		return ;
	}
	
	public static function show($page = 0){
		global $db;
		$query = "SELECT * FROM `{$db->table["announcements"]}` 
					CROSS JOIN `{$db->table["users"]}` ON `{$db->table["announcements"]}`.author = `{$db->table["users"]}`.id
					ORDER BY `date` desc;";
		$result = $db->query($query);
		if($row = mysql_fetch_array($result)){
			do{ ?>
				<div class="announce">
					<div class="announce-head"><?php echo $row['title']; ?></div>
					<div class="announce-content"><?php echo $row['body']; ?></div>
					<p class="announce-footer">Δημιουργήθηκε από το χρήστη <?php echo (strlen($row['name']) >= 1) ? $row['name'] : "Ανώνυμο"; ?> την <?php echo (strlen($row['date']) >= 1) ? date('d-m-Y στις H:i', strtotime($row['date'])) : "";?>.</p>
				</div>
			<?php }while($row = mysql_fetch_array($result));
		} else {
			?> <div class="announce">Δεν δημιουργήθηκε ακόμα ανακοίνωση</div> <?php
		}
	}
};
?>