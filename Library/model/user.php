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
		//are the next two lines usefull?
		$row = mysql_fetch_array($result);
		$res = mysql_num_rows($result);
		$db->close();
	    if($res)
	    {
	    	$this->id 					= $row['id'];
	    	$this->access_level 		= $row['access_lvl'];
	    	$this->username				= $name;
	    	$this->email				= $row['email'];
	    	$this->department_id		= $row['dep_id'];
	    	
	    	$_SESSION['logged_in']		= 1;
		
			$_SESSION['user']			= $name;
			$_SESSION['user_id']		= $row['id'];
			$_SESSION['access_level']	= 0;
			
			if($row['access_lvl'] >= 100)	$a = 1;
									else	$a = 0;
							
			$_SESSION['is_admin']		= $a;
					
			$_SESSION['cur_page'] 		= $_SERVER['SCRIPT_NAME'];
			$_SESSION['sessionid'] 		= session_id();
	    }
			//session_login($name, $row['id'], $row['access_lvl']);
	        //session_login($user); where $user is an user class instance
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
		$query = "	UPDATE `users` 
					SET `email` = '$mail' 
					WHERE `userename` = '$user' AND `password` = '$pass' 
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
		echo $query;
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
		global $db;
		$db->connect();
		$query = "SELECT * FROM `users` WHERE `id` = ''";
		$result = $db->query($query);
		$row = mysql_fetch_array($result);
		
		$db->close();
		return;
	}

	function is_logged_in(){
		return isset($_SESSION['logged_in']) 
		&& ($_SESSION['logged_in'] == 1) 
		&& ($_SESSION['access_level'] >= 0);
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
			$msg .= "<a href=\"?show=cp\">". $_SESSION['user'] . "</a> |  ";
			if($_SESSION['is_admin'])
				$msg .= "<a href=\"?show=admin\">Admin</a> | ";
			$msg .= "<a href=\"?show=msg\">Messages</a> | <a href=\"?show=logout\">Logout</a>";
		}
		echo $msg;
	}
	
	function session_check(){
		/*if(!isset($_SESSION['logged_in']))
			session_empty();*/
		if(!isset($_SESSION['last_active'])) {
	    	$_SESSION['last_active'] = time() + MAX_IDLE_TIME;
		}else{
	    	if($_SESSION['last_active'] < time()) {   
		    	session_unset(); 
		        session_destroy();
		    }else{
		        $_SESSION['last_active'] = time() + MAX_IDLE_TIME;
		    }
		}
		$_SESSION['cur_page'] 	= $_SERVER['SCRIPT_NAME'];
		$_SESSION['sessionid'] 	= session_id();
	}
}

?>