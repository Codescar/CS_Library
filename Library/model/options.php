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
		$save_only_value = false;
		if($description == "" && $id == -1){
			$save_only_value = true;
		}
		$query = "INSERT INTO `{$db->table['options']}` 
					SET `name` = '$name', `value` = '$value' ";
		if($save_only_value){ 
			$extra = "ON DUPLICATE KEY UPDATE SET `value` = '$value' ";
		} else { 
			$extra = ", `description` = '$description'
					WHERE `id` = '$id' 
					ON DUPLICATE KEY UPDATE
					SET `name` = '$name', `description` = '$description', `value` = '$value' ";
		}
		$db->query($query.$extra);
	}

	public static function delete($id){
		global $db;
		//TODO Or maybe deleting by name will be more secure?
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