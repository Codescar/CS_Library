<?php
/**
 * Options' handler 
 * The options are stored to the database
 * and editable from the control panel
 *
 */

class option{
	public $id, $name, $value, $description, $category;

	public static function list_all($category){
		global $db;
		$query = "SELECT * FROM `{$db->table['options']}`";
		if(isset($category))
			$query .= " WHERE `category` = '$category' ORDER BY `id` ";
		return $db->query($query);
	}

	public static function save($name, $value, $description, $id, $category){
		global $db;
		$save_value = false;
		if($description == "" && $id == -1){
			$save_value = true;
		}
		$query = "INSERT INTO `{$db->table['options']}` 
					SET `name` = '$name', `description` = '$description', `value` = '$value', `category` = '$category'
				  ON DUPLICATE KEY UPDATE 
					`name` = '$name', `description` = '$description', `value` = '$value', `category` = '$category' "; 
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
		while($option = $db->db_fetch_object($results))
			$CONFIG[$option->name] = $option->value;
		return true;
	}
};
?>