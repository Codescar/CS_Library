<?php
/* User class, in order to use user-account
 * system, we can continue...
 */
class User{
	public $id, $username, $email, $access_level, $department_id;
	
	function pass_encrypt($pass){
		return $pass;
		//return md5($pass);
	}

	function login($name, $pass){
		global $db;
        //TODO shouldn't we create a user class instance which would be global or better place this instance in $_SESSION?
		$db->connect();
		$name = mysql_real_escape_string($name);
		$pass = mysql_real_escape_string($pass);
		$pass = $this->pass_encrypt($pass);
		$query = "	SELECT * FROM `users`
					WHERE 	`username` = '$name' AND `password` = '$pass'
					LIMIT 1 ;";
		$result = $db->query($query);
		$user = mysql_fetch_array($result);
		$db->close();
	    if($user){
	    	$this->id 					= $user['id'];
	    	$this->access_level 		= $user['access_lvl'];
	    	$this->username				= $user['username'];
	    	$this->email				= $user['email'];
	    	$this->department_id		= $user['dep_id'];
            
	    	$_SESSION['user']           = serialize($this);
	    	$_SESSION['logged_in']		= 1;
			$_SESSION['cur_page'] 		= $_SERVER['SCRIPT_NAME'];
			$_SESSION['sessionid'] 		= session_id();
	    }
		return $user;
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
	
	function changePassword($pass, $new_pass){
		global $db;
		$db->connect();
		$pass = mysql_real_escape_string($pass);
		$new_pass = mysql_real_escape_string($new_pass);
		$query = "	UPDATE `users` 
					SET `password` = '$new_pass' 
					WHERE `id` = '".$this->id."' AND `password` = '$pass' 
					LIMIT 1; ";
		$ret = $db->query($query);
		$db->close();
		return $ret;
	}
	
	function changeEmail($mail, $pass){
		global $db;
		$db->connect();
		$pass = mysql_real_escape_string($pass);
		$mail = mysql_real_escape_string($mail);
		$query = "	UPDATE `users` 
					SET `email` = '$mail' 
					WHERE `id` = '".$this->id."' AND `password` = '".$pass."' 
					LIMIT 1; ";
		$ret = $db->query($query);
		$db->close();
		return $ret;
	}
	
	function show_history(){
		global $db;
		$db->connect();
		$query = "	SELECT * FROM 
					`requests` CROSS JOIN `booklist` 
					ON requests.book_id = booklist.id
					WHERE requests.user_id = '". $this->id ."'";
		$result = $db->query($query);
		echo "<table><tr><th>Book</th><th>Action</th><th>Date</th></tr>";
		while($row = mysql_fetch_array($result)){
			echo "<tr><td>".$row['title']
			."</td><td>Request</td><td>".$row['date']."</td><tr>";
		}
		echo "</table>";
		$db->close();
		return;
	}

	function show_info(){
// 		global $db;
// 		$db->connect();
// 		$query = "SELECT * FROM `users` WHERE `id` = '".$this->id."'";
// 		$result = $db->query($query);
// 		$row = mysql_fetch_array($result);
// 		$db->close();
		//TODO list user information but why not from data members of $this?
		echo "Name: ".    $this->username;
		echo "<br />";
		echo "Email: ".   $this->email;
		return;
	}

	function is_logged_in(){
		return isset($_SESSION['logged_in']) 
		&& ($_SESSION['logged_in'] == 1) 
		&& ($this->access_level >= 0);
	}
	
	function show_login_status(){
		global $CONFIG;
		$msg = "";
		if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != 1){
			if($CONFIG['allow_login'])
				$msg .= "<a href=\"?show=login\">Login</a>";
			if($CONFIG['allow_register'])
				$msg .= " | <a href=\"?show=register\">Register</a>";
		}
		elseif($_SESSION['logged_in'] == 1){
			$msg .= "<a href=\"?show=cp\">". $this->username . "</a> |  ";
			if($this->is_admin())
				$msg .= "<a href=\"?show=admin\">Admin</a> | ";
			$msg .= "<a href=\"?show=msg\">Messages</a> | <a href=\"?show=logout\">Logout</a>";
		}
		echo $msg;
	}
	
	function session_check(){
		if(!isset($_SESSION['logged_in']))
			session_empty();
		if(!isset($_SESSION['last_active'])){
	    	$_SESSION['last_active'] = time() + MAX_IDLE_TIME;
		}else{
	    	if($_SESSION['last_active'] < time()){   
		    	session_unset(); 
		        session_destroy();
		    }else{
		        $_SESSION['last_active'] = time() + MAX_IDLE_TIME;
		    }
		}
		$_SESSION['cur_page'] 	= $_SERVER['SCRIPT_NAME'];
		$_SESSION['sessionid'] 	= session_id();
	}

	function is_admin(){
	    return ($this->access_level >= 100) ? true : false;
	}
}

?>