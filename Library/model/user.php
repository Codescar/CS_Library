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
		//TODO have to consider how and where will store the activation keys
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
		$query = "	SELECT * FROM `history`
					WHERE user_id = '". $this->id ."'
					ORDER BY date";
		$result = $db->query($query);
		echo "<table><tr><th>Book</th><th>Action</th><th>Date</th></tr>";
		while($row = mysql_fetch_array($result)){
			echo "<tr><td>".$row['title']."</td>";
			echo "<td>";
            switch($row['action']){
		    case 1:
				echo "Request";
		        break;
		    case 2:
				echo "Lended";
		        break;
		    case 3:
				echo "Have it now";
				break;
            }
            echo "</td>";
			echo  "<td>".$row['date']."</td></tr><tr></tr>";
		}
		echo "</table>";
		return;
	}

	function show_info(){
	    global $db;
 		$query = "SELECT tmp1.username, tmp1.name, tmp1.surname, tmp1.born, tmp1.phone, tmp1.email, tmp1.tmima, tmp2.name as incharge FROM
					(SELECT users.username, users.name, users.surname, users.born, users.phone, users.email, departments.name as tmima, departments.incharge FROM users
						CROSS JOIN departments
							ON users.dep_id = departments.id
					WHERE users.id = '".$this->id."' ) AS tmp1
						CROSS JOIN users AS tmp2
							ON tmp1.incharge = tmp2.id";
 		$result = $db->query($query);
 		$row = mysql_fetch_array($result);
        echo "<table><tr><td>Name: </td><td>".$row['name']."</td><td>Surname: </td><td>".$row['surname']."</td></tr>";
        echo "<tr><td>Username: </td><td>".$row['username']."</td><td>Born: </td><td>".$row['born']."</td>";
        echo "<tr><td>Phone: </td><td>".$row['phone']."</td><td>Email: </td><td>".$row['email']."</td>";
        echo "<tr><td>Department: </td><td>".$row['tmima']."</td><td>Incharge: </td><td>".$row['incharge']."</td>";
        echo "</table>";
		return;
	}

	function change_info(){
        global $db;
        $query = "SELECT tmp1.username, tmp1.name, tmp1.surname, tmp1.born, tmp1.phone, tmp1.email, tmp1.tmima, tmp2.name as incharge FROM
					(SELECT users.username, users.name, users.surname, users.born, users.phone, users.email, departments.name as tmima, departments.incharge FROM users
						CROSS JOIN departments
							ON users.dep_id = departments.id
					WHERE users.id = '".$this->id."' ) AS tmp1
						CROSS JOIN users AS tmp2
							ON tmp1.incharge = tmp2.id";
        $result = $db->query($query);
        $row = mysql_fetch_assoc($result);
        //TODO appearance must be upgraded for sure! 
        echo "<form action=\"change_info.php\" method=\"post\">";
        //TODO some php file must be created to check password and make UPDATE
        echo "Name: 	<input type=\"text\" name=\"name\" value=\"".$row['name']."\">";
        echo "Surname: 	<input type=\"text\" name=\"surname\" value=\"".$row['surname']."\"> <br />";
        echo "Username:	<input type=\"text\" name=\"username\" value=\"".$row['username']."\">";
        echo "Born: 	<input type=\"date\" name=\"born\" value=\"".$row['born']."\"> <br />";
        echo "Phone:	<input type=\"tel\" name=\"phone\" value=\"".$row['phone']."\">";
        echo "Email:	<input type=\"email\" name=\"email\" value=\"".$row['email']."\"> <br />";
        echo "New Password: <input type=\"password\" name=\"new_pass\">";
        echo "Current Password <input type=\"password\" name=\"cur_pass\"> <br />";
        echo "Provide your password in order changes to be saved! <input type=\"submit\" value=\"Save\" />";
        echo "</form>";
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