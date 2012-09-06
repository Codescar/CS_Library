<?php
/**
 * Message class
 * 
 */

class message{
	var $user_id, $table;
	
	function message(){
		global $user, $db;
		$this->user_id 	= $user->id;
		$this->table 	= $db->table["messages"]; 
	}
	
	public function read($id){
		global $db;
		$query = "	SELECT * FROM `{$this->table}` 
					WHERE `id` = '".$db->db_escape_string($id)."'; ";
		$result = $db->query($query);
		
	} 
	
	public function have_new(){
		global $db;
		$query = "	SELECT COUNT(id) FROM `{$this->table}` 
					WHERE `to` = '{$this->user_id}' AND `unreaded` = '1'; ";
		$result = $db->query($query);
		$array = $db->db_fetch_array($result);
		return $array[0];
	}
	
	public function read_inbox(){
		global $db;
		$query = "	SELECT * FROM `{$this->table}` 
					WHERE `to` = '{$this->user_id}'; ";
		$result = $db->query($query);
	}
	
	public function read_outbox(){
		global $db;
		$query = "	SELECT * FROM `{$this->table}` 
					WHERE `from` = '{$this->user_id}'; ";
		$result = $db->query($query);
	}
	
	public function read_all(){
		global $db;
		$query = "	SELECT * FROM `{$this->table}` 
					WHERE `to` = '{$this->user_id}' OR `from` = '{$this->user_id}'; ";
		$result = $db->query($query);
	}
	
	public function create($to, $subject, $text){
		
	}
	
	public function delete($id){
		global $db;
		$query = "	DELETE FROM `{$this->table}` 
					WHERE `id` = '".$db->db_escape_string($id)."'; ";
		$result = $db->query($query);
	}
	
	
};
?>