<?php

class announcements{
	
	public static function list_all(){
		global $db;
		$query = "SELECT `{$db->table["announcements"]}`.`id` `{$db->table["announcements"]}`.`	title`, 
					`{$db->table["announcements"]}`.`body`, `{$db->table["announcements"]}`.`date`, 
					`{$db->table["users"]}`.`username`					
					FROM `{$db->table["announcements"]}` CROSS JOIN `{$db->table["users"]}` 
						ON `{$db->table["announcements"]}`.author = `{$db->table["users"]}`.id ;";
		return $db->query($query);
	}
	
	/*
	 * Given an id, this function returns an announcement object
	 */
	public static function get($id){
		global $db;
		$query = "SELECT * FROM `{$db->table["announcements"]}` WHERE `id` = '$id' LIMIT 1;";
		$ret = $db->query($query);
		return mysql_fetch_object($ret);
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
		if($announcement = mysql_fetch_object($result)){
			do{ ?>
				<div class="announce">
					<div class="announce-head"><?php echo $announcement->title; ?></div>
					<div class="announce-content"><?php echo $announcement->body; ?></div>
					<p class="announce-footer">Δημιουργήθηκε από το χρήστη <?php echo (strlen($announcement->name) >= 1) ? $announcement->name : "Ανώνυμο"; ?> την <?php echo (strlen($announcement->date) >= 1) ? date('d-m-Y στις H:i', strtotime($announcement->date)) : "";?>.</p>
				</div>
			<?php }while($announcement = mysql_fetch_object($result));
		} else {
			?> <div class="announce">Δεν δημιουργήθηκε ακόμα ανακοίνωση</div> <?php
		}
	}
};
?>