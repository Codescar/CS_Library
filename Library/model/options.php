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
		$query = "SELECT * FROM `{$db->table['options']}` WHERE `Name` = '$name' LIMIT 1";
		$res = $db->query($query);
		$value = mysql_fetch_array($res);
		return $value['Value'];
	}

	public static function save($name, $val){
		global $db;
		$query = "INSERT INTO `{$db->table['options']}` 
					SET `Name` = '$name' , `Value` = '$val' 
					ON DUPLICATE KEY UPDATE
						`Value` = '$val' ";
		$db->query($query);
	}

	public static function delete($name){
		global $db;
		$query = "DELETE FROM `{$db->table['options']}`
					WHERE `Name` = '$name' ";
		$db->query($query);
	}
	
	public static function load_options(){
		global $db, $CONFIG;
		$results = $db -> query("SELECT * FROM `{$db -> table['options']}`");
		while($row = mysql_fetch_array($results))
			$CONFIG[$row['Name']] = $row['Value'];
		
		return true;
	}
};
?>