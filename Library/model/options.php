<?php
/**
 * Options' handler 
 * The options are stored to the database  //TODO it
 * and editable from the control panel //TODO it
 *
 */

class option{
	var $default;
	
	public static function list_all(){
		global $db;
		$query = "SELECT * FROM `{$db->table['options']}` ;";
		return $db->query($query);
	}
	
	public static function load($name){
		global $db;
		$query = "SELECT * FROM `{$db->table['options']}` WHERE `Name` = $name LIMIT 1";
		$res = $db->query($query);
		$value = mysql_fetch_array($res);
		return $value[0];
	}
	
	public static function save($name, $val){
		global $db;
		$query = "INSERT INTO `{$db->table['options']}` 
					(`Name`, `Value`) VALUES '$name', '$val' ";
		$db->query($query);
	}
};
?>