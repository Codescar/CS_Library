<?php
/* User class, in order to use user-account
 * system, we can continue...
 */
class User{
	public $id, $username, $email, $access_level, $department_id, $admin;
	
	function __constructor(){
		$admin = null;
	}
	
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
		$query = "	SELECT * FROM `{$db->table["users"]}`
					WHERE 	`{$db->columns["users"]["username"]}` = '$name' 
					AND 	`{$db->columns["users"]["password"]}` = '$pass'
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
            
	    	//$_SESSION['user']           = serialize($this);
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
		$pass = $this->pass_encrypt($pass);
		$mail = mysql_real_escape_string($mail);
		$dep_id = mysql_real_escape_string($dep_id);
		
		$query = "INSERT INTO `{$db->table["users"]}` 
					(`{$db->columns["users"]["dep_id"]}`, 
					 `{$db->columns["users"]["username"]}`, 
					 `{$db->columns["users"]["password"]}`, 
					 `{$db->columns["users"]["email"]}`, 
					 `{$db->columns["users"]["access_lvl"]}`, 
					 `{$db->columns["users"]["created_date"]}`, 
					 `{$db->columns["users"]["last_ip"]}`) VALUES 
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
		$query = "	UPDATE 	`{$db->table["users"]}` 
					SET 	`{$db->columns["users"]["password"]}` = '$new_pass' 
					WHERE 	`{$db->columns["users"]["id"]}` = '".$this->id."' 
					AND 	`{$db->columns["users"]["password"]}` = '$pass' 
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
		$query = "	UPDATE 	`{$db->table["users"]}` 
					SET 	`{$db->columns["users"]["email"]}` = '$mail' 
					WHERE 	`{$db->columns["users"]["id"]}` = '".$this->id."' 
					AND 	`{$db->columns["users"]["password"]}` = '".$pass."' 
					LIMIT 1; ";
		$ret = $db->query($query);
		$db->close();
		return $ret;
	}
	//TODO replace tale/column names below here
	function show_history($mode = 0){
	    global $db;
	    if($mode)
	    	$query = "	SELECT * FROM `{$db->table["history"]}`
					ORDER BY `{$db->columns["history"]["date"]}`";
	    else
			$query = "	SELECT * FROM `{$db->table["history"]}`
					WHERE `{$db->columns["history"]["user_id"]}` = '". $this->id ."'
					ORDER BY `{$db->columns["history"]["date"]}`";
		$result = $db->query($query);
		echo "<table><tr><th>Book</th>";
		echo $mode ? "<th>User</th>" : "";
		echo "<th>Action</th><th>Date</th></tr>";
		while($row = mysql_fetch_array($result)){
			echo "<tr><td>".$row['title']."</td>";
			echo $mode ? "<td>{$row['user_id']}</td>" : "";
			echo "<td>";
            switch($row['action']){
		    case 1:
		    	echo $mode ? "<a href=\"?show=admin&more=lend&lend={$row['book_id']}&user={$row['user_id']}\" class=\"request-book\">Request</a>"
				: "Request";
		        break;
		    case 2:
				echo "Lended";
		        break;
		    case 3:
		    	echo $mode ? "<a href=\"?show=admin&more=return&return={$row['book_id']}&user={$row['user_id']}\" class=\"return-book\">Have it now</a>"
				: "Have it now";
				break;
            }
            echo "</td>";
			echo  "<td>".$row['date']."</td></tr><tr></tr>";
		}
		echo "</table>";
		//TODO add to javascript informations about the user and the book
		?>
		<script type="text/javascript">
			$('.request-book').click(function (){
				return confirm("Είσαι σίγουρος ότι ο χρήστης έχει παραλάβει το βιβλίο;", "Επιβεβαίωση");
			});
			$('.return-book').click(function (){
				return confirm("Είσαι σίγουρος ότι ο χρήστης έχει επιστρέψει το βιβλίο;", "Επιβεβαίωση");
			});
		</script>
		<?php 
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
        echo "Username:	<input type=\"text\" name=\"username\" value=\"".$row['username']."\" disabled=\"disabled\" >";
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
			$msg .= "<a href=\"?show=cp\">". /*$this->*/$this->username . "</a> |  ";
			if($this->is_admin() /*Trying something with better looing $this instanceof Admin*/)
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