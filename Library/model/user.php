<?php
/* User class, in order to use user-account
 * system, we can continue...
 */
class User{
	private $id, $username, $password, $email, $access_level, $department_id, $created;
	
	function __construct(){
		/* load the date for the user */
		
	} 
	
	function __destruct(){
		$this->id 				= NULL;
		$this->username 		= NULL;
		$this->password 		= NULL;
		$this->access_level 	= 0;
		$this->department_id 	= NULL;
		$this->created			= 0;
	}
	
	function login($user, $pass){
		global $db;
		$db->db_connect();
		$user = mysql_real_escape_string($user);
		$pass = mysql_real_escape_string($pass);
		$pass = pass_encrypt($pass);
		$query = "SELECT * FROM `users` 
					WHERE 	`username` = '$user' 
					AND 	`password` = '$pass'
					LIMIT 1 ;";
		$result = $db->db_query($query);
		$res = mysql_num_rows($result);
		$db->db_close();
		return $res;
	}
	
	function createUser($user, $pass, $mail, $dep_id){
		global $db;
		$db->db_connect();
		$user = mysql_real_escape_string($user);
		$pass = mysql_real_escape_string($pass);
		$pass = pass_encrypt($pass);
		$mail = mysql_real_escape_string($mail);
		$dep_id = mysql_real_escape_string($dep_id);
		//TODO create the `users` table
		$query = "INSERT INTO `users` 
					(`username`, `password`, `email`, `dep_id`, `access_level`, created_date`, `last_ip`) VALUES 
					('$user', '$pass', '$mail', '$dep_id', '-1', 'NOW()', '".$_SERVER['REMOTE_ADDR']."') ";
		$db->db_query($query);
		//TODO add a confirmation link to a table
		$db->db_close();
		return;
	}
	
	function activateAccount(){
		//TODO have to consider how and where 
		//		will store the activation keys
		return;
	}
	
	function changePassword($user, $pass, $new_pass){
		global $db;
		$db->db_connect();
		$user = mysql_real_escape_string($user);
		$pass = mysql_real_escape_string($pass);
		$new_pass = mysql_real_escape_string($new_pass);
		//TODO have to test the query
		$query = "UPDATE `users` 
					set `password` = '$new_pass' 
					WHERE `userename` = '$user' 
					AND `password` = '$pass' 
					LIMIT 1;";
		$db->db_query($query);
		//TODO have to check if it's successful or not
		//		to return error msg.
		$db->db_close();
		return;
	}
	
	function changeEmail($user, $mail, $pass){
		global $db;
		$db->db_connect();
		$user = mysql_real_escape_string($user);
		$pass = mysql_real_escape_string($pass);
		$mail = mysql_real_escape_string($mail);
		//TODO have to test the query
		$query = "UPDATE `users` 
					set `email` = '$mail' 
					WHERE `userename` = '$user' 
					AND `password` = '$pass' 
					LIMIT 1;";
		$db->db_query($query);
		//TODO have to check if it's successful or not
		//		to return error msg.
		$db->db_close();
		return;
	}
	
	function pass_encrypt($pass){
		return md5($pass);
	}
}

?>