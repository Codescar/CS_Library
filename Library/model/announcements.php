<?php

class announcements{
	
	public $id, $title, $body, $author, $date, $username;
	
	public static function list_all($mode = 0){
		global $db;
		$query = "SELECT `{$db->table["announcements"]}`.`id`, `{$db->table["announcements"]}`.`title`, 
					`{$db->table["announcements"]}`.`body`, `{$db->table["announcements"]}`.`date`, 
					`{$db->table["users"]}`.`username`					
					FROM `{$db->table["announcements"]}` CROSS JOIN `{$db->table["users"]}` 
						ON `{$db->table["announcements"]}`.author = `{$db->table["users"]}`.id 
					ORDER BY `{$db->table["announcements"]}`.`date` DESC ; ";
		if($mode){
			$db->query($query);
			return $db->db_affected_rows();
		}
		return $db->query($query);
	}
	
	/*
	 * Given an id, this function returns an announcement object
	 */
	public static function get($id){
		global $db;
		$query = "SELECT * FROM `{$db->table["announcements"]}` WHERE `id` = '$id' LIMIT 1;";
		$ret = $db->query($query);
		return $db->db_fetch_object($ret);
	}
	
	public static function add($title, $body){
		global $db, $user;
		$query = "	INSERT INTO `{$db->table["announcements"]}` (`title`, `body`, `date`, `author`) 
					VALUES ('".$db->db_escape_string($title)."', '".$db->db_escape_string($body)."', NOW(), '{$user->id}') ;";
		$db->query($query);
		return ;
	}
	
	public static function delete($id){
		global $db;
		$query = "DELETE FROM `{$db->table["announcements"]}` WHERE `id` = '".$db->db_escape_string($id)."' LIMIT 1;";
		$db->query($query);
		return ;
	}	
	
	public static function update($id, $title, $body){
		global $db, $user;
		$query = "	UPDATE `{$db->table["announcements"]}` 
					SET `body` = '".$db->db_escape_string($body)."' , `title` = '".$db->db_escape_string($title)."', `date` = NOW() , `author` = '{$user->id}' 
					WHERE `id` = '".$db->db_escape_string($id)."';";
		$db->query($query);
		return ;
	}
	
	public static function show($offset = 0){
		global $db, $CONFIG;
		$query = "SELECT * FROM `{$db->table["announcements"]}` 
					CROSS JOIN `{$db->table["users"]}` ON `{$db->table["announcements"]}`.author = `{$db->table["users"]}`.id
					ORDER BY `date` DESC
					LIMIT ".$offset*$CONFIG['announ_num'].", {$CONFIG['announ_num']} ;";
		//echo $query."<br />";
		$result = $db->query($query);
		if($announcement = $db->db_fetch_object($result)){
			do{ ?>
				<div class="announce">
					<div class="announce-head"><?php echo $announcement->title; ?></div>
					<div class="announce-content"><?php echo $announcement->body; ?></div>
					<p class="announce-footer">Δημιουργήθηκε από το χρήστη <?php echo (strlen($announcement->name) >= 1) ? $announcement->name : "Ανώνυμο"; ?> την <?php echo (strlen($announcement->date) >= 1) ? date('d-m-Y στις H:i', strtotime($announcement->date)) : ""; ?>.</p>
				</div>
			<?php 
			}while($announcement = $db->db_fetch_object($result));
		} else {
			?> <div class="announce">Δεν δημιουργήθηκε ακόμα ανακοίνωση</div> <?php
		}
	}
};
?>