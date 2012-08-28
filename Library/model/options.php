<?php
/**
 * Options' handler 
 * The options are stored to the database
 * and editable from the control panel
 *
 */

class option{
	public static function list_all(){
		global $db;
		$query = "SELECT * FROM `{$db->table['options']}`";
		return $db->query($query);
	}

	public static function load($name){
		global $db;
		$query = "SELECT * FROM `{$db->table['options']}` WHERE `name` = '$name' LIMIT 1";
		$res = $db->query($query);
		$option = mysql_fetch_object($res);
		return $option->value;
	}

	public static function save($name, $value, $description, $id){
		global $db;
		$save_value = false;
		if($description == "" && $id == -1){
			$save_value = true;
		}
		$query = "INSERT INTO `{$db->table['options']}` 
					SET `name` = '$name', `description` = '$description', `value` = '$value'
				  ON DUPLICATE KEY UPDATE 
					`name` = '$name', `description` = '$description', `value` = '$value' "; 
		if($save_value){ 
			$query = "UPDATE `{$db->table['options']}`
						SET `value` = '$value'
					  WHERE `name` = '$name' ";
		}
		$db->query($query);
	}

	public static function delete($id){
		global $db;
		$query = "DELETE FROM `{$db->table['options']}`
					WHERE `id` = '$id' ";
		$db->query($query);
	}
	
	public static function load_options(){
		global $db, $CONFIG;
		$results = $db -> query("SELECT * FROM `{$db -> table['options']}`");
		while($option = mysql_fetch_object($results))
			$CONFIG[$option->name] = $option->value;
		return true;
	}
};
?>