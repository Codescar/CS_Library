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
	
	function pass_encrypt($pass){
		return $pass;
		//return md5($pass);
	}
	
	function login($user, $pass){
		global $db;
		$db->connect();
		$user = mysql_real_escape_string($user);
		$pass = mysql_real_escape_string($pass);
		$pass = $this->pass_encrypt($pass);
		$query = "SELECT * FROM `users` 
					WHERE 	`username` = '$user' 
					AND 	`password` = '$pass'
					LIMIT 1 ;";
		$result = $db->query($query);
		$row = mysql_fetch_array($result);
		$res = mysql_num_rows($result);
		$db->close();
	    if($res){
			session_login($user, $row['id'], $row['access_lvl']);
		}
		return $res;
	}
	
	function createUser($user, $pass, $mail, $dep_id){
		global $db;
		$db->connect();
		$user = mysql_real_escape_string($user);
		$pass = mysql_real_escape_string($pass);
		$pass = pass_encrypt($pass);
		$mail = mysql_real_escape_string($mail);
		$dep_id = mysql_real_escape_string($dep_id);
		
		$query = "INSERT INTO `users` 
					(`dep_id`, `username`, `password`, `email`, `access_lvl`, created_date`, `last_ip`) VALUES 
					('$dep_id', '$user', '$pass', '$mail', '-1', 'NOW()', '".$_SERVER['REMOTE_ADDR']."') ";
		$db->query($query);
		//TODO add a confirmation link to a table
		$db->close();
		return;
	}
	
	function activateAccount(){
		//TODO have to consider how and where 
		//		will store the activation keys
		return;
	}
	
	function changePassword($user, $pass, $new_pass){
		global $db;
		$db->connect();
		$user = mysql_real_escape_string($user);
		$pass = mysql_real_escape_string($pass);
		$new_pass = mysql_real_escape_string($new_pass);
		$query = "	UPDATE `users` 
					SET `password` = '$new_pass' 
					WHERE `userename` = '$user' AND `password` = '$pass' 
					LIMIT 1; ";
		$ret = $db->query($query);
		$db->close();
		return $ret;
	}
	
	function changeEmail($user, $mail, $pass){
		global $db;
		$db->connect();
		$user = mysql_real_escape_string($user);
		$pass = mysql_real_escape_string($pass);
		$mail = mysql_real_escape_string($mail);
		//TODO have to test the query
		$query = "	UPDATE `users` 
					SET `email` = '$mail' 
					WHERE `userename` = '$user' AND `password` = '$pass' 
					LIMIT 1; ";
		$db->query($query);
		//TODO have to check if it's successful or not
		//		to return error msg.
		$db->close();
		return;
	}
}

?>