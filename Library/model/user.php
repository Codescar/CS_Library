<?php
/* User class, in order to use user-account
 * system, we can continue...
 */
class User{
	public $id, $username, $email, $access_level, $admin, $message;
	
	function __constructor(){
		$admin = null;
	}
	
	private static function pass_encrypt($pass){
		return $pass;
		//return md5($pass);
	}

	public function login($name, $pass){
		global $db;
		
		$name = mysql_real_escape_string($name);
		$pass = mysql_real_escape_string($pass);
		$pass = $this->pass_encrypt($pass);
		$query = "	SELECT * FROM `{$db->table["users"]}`
					WHERE 	`username` = '$name' 
					AND 	`password` = '$pass'
					LIMIT 1 ;";
		$result = $db->query($query);
		$user = mysql_fetch_array($result);
	    if($user){
	    	$this->id 					= $user['id'];
	    	$this->access_level 		= $user['access_lvl'];
	    	$this->username				= $user['username'];
	    	$this->email				= $user['email'];
            
	    	//$_SESSION['user']           = serialize($this);
	    	$_SESSION['logged_in']		= 1;
			$_SESSION['cur_page'] 		= $_SERVER['SCRIPT_NAME'];
			$_SESSION['sessionid'] 		= session_id();
	    }
		return $user;
	}
	
	public static function createUser($user, $pass, $mail){
		global $db;
		$user = mysql_real_escape_string($user);
		$pass = mysql_real_escape_string($pass);
		$pass = user::pass_encrypt($pass);
		$mail = mysql_real_escape_string($mail);
		
		$query = "INSERT INTO `{$db->table["users"]}` 
					(`username`, 
					 `password`, 
					 `email`, 
					 `access_lvl`, 
					 `created_date`, 
					 `last_ip`) VALUES 
					('$user', '$pass', '$mail', '0', NOW(), '".$_SERVER['REMOTE_ADDR']."') ";
		$db->query($query);
		//TODO send an e-mail to user 
		return;
	}
	
	//TODO replace tale/column names below here
	public function show_history($mode = 0, $user_id = -1){
		/**
		 * $mode values:
		 * default: 0, normal user mode, see the history of 1 user
		 * 1, admin, show all the histories
		 * 2, admin, show pendings only....
		 */
	    global $db;
	    if($user_id == -1)
	    	$user_id = $this->id;
	    if($mode == 1) 
	    	$query = "	SELECT * FROM `{$db->table["history"]}`
	    				CROSS JOIN `{$db->table["users"]}` 
	    				ON {$db->table["users"]}.id = {$db->table["history"]}.user_id 
						ORDER BY `date`";
	    elseif($mode == 2)
	    	$query = "	SELECT * FROM `{$db->table["history"]}`
	    				CROSS JOIN `{$db->table["users"]}` 
	    				ON {$db->table["users"]}.id = {$db->table["history"]}.user_id 
						GROUP BY `book_id`, `action` 
	    				ORDER BY `date`";
	    else
			$query = "	SELECT * FROM `{$db->table["history"]}`
						WHERE `user_id` = '$user_id'
						ORDER BY `date`";	    
		$result = $db->query($query);
		echo "<table><tr><th>Book</th>";
		echo ($mode ) ? "<th>User</th>" : "";
		echo "<th>Action</th><th>Date</th></tr>";
		while($row = mysql_fetch_array($result)){
			echo "<tr><td>".$row['title']."</td>";
			echo ($mode) ? "<td>{$row['name']} ({$row['user_id']})</td>" : "";
			echo "<td>";
            switch($row['action']){
		    case 1:
		    	echo ($mode) && book_avail($row['book_id'])
		    	? "<a href=\"?show=admin&more=lend&lend={$row['book_id']}&user={$row['user_id']}\" class=\"request-book\">Request</a>"
				: "Request (<a href=\"?show=cp&more=remove_request&id={$row['id']}\" class=\"cansel-request\">Delete</a>)";
		        break;
		    case 2:
		    	//TODO Change the actions to know if lended is now lended and if were lended in the past
				echo "Lended";
		        break;
		    case 3:
		    	//TODO return or back is the correct action for an admin?
		    	echo ($mode ) 
		    	? "<a href=\"?show=admin&more=return&return={$row['book_id']}&user={$row['user_id']}\" class=\"return-book\">Have it now</a>"
				: "Have it now";
				break;
            }
            echo "</td>";
			echo  "<td>".$row['date']."</td></tr><tr></tr>";
		}
		echo "</table>";
		return;
	}

	public function show_info($user_id = -1){
        global $db;
        if($user_id == -1)
        	$user_id = $this->id;
        if(isset($_POST['hidden'])){
            $query = "	SELECT * FROM `{$db->table["users"]}`
            					WHERE 	`id` = '$user_id' 
            					AND 	`password` = '".mysql_real_escape_string($_POST['password'])."'
            					LIMIT 1 ;";
            $result = $db->query($query);
            if(mysql_num_rows($result)){
                $q = "UPDATE `{$db->table["users"]}` SET 
                    	  `name` = '".mysql_real_escape_string($_POST['name'])."',
                    	  `surname` = '".mysql_real_escape_string($_POST['surname'])."',
                    	  `born` = '".mysql_real_escape_string($_POST['born'])."',
                    	  `phone` = '".mysql_real_escape_string($_POST['phone'])."',
                    	  `email` = '".mysql_real_escape_string($_POST['email'])."'";
                if(isset($_POST['n_pass']) && $_POST['n_pass'] != ""){
                    if($_POST['n_pass'] == $_POST['r_n_pass'] /*&& check_password($_POST['n_pass'])*/)
                        $q .= ", `password` = '".mysql_real_escape_string($_POST['n_pass'])."'";
                }
                $q .= " WHERE users.id = '$user_id' AND users.password = '".mysql_real_escape_string($this->pass_encrypt($_POST['password']))."';";
                $db->query($q);
                echo "<span class=\"success\">Οι αλλαγές σας αποθηκεύτηκαν.</span>";
            }
            else
                echo "<span class=\"error\">Δώσατε λάθος κωδικό.</span>";
        }
        else{
            $query = "SELECT tmp1.username, tmp1.name, tmp1.surname, tmp1.born, tmp1.phone, tmp1.email FROM
    					(SELECT users.username, users.name, users.surname, users.born, users.phone, users.email FROM users
    						
    					WHERE users.id = '$user_id' ) AS tmp1
    						";
            $result = $db->query($query);
            $row = mysql_fetch_assoc($result); ?>
            <form action="" method="post" id="change-info">
            <label for="username">Username: </label><input type="text" id="username" name="username" disabled="disabled" value="<?php echo $row['username']; ?>" /><br />
            <label for="name">Name: </label><input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" /><br />
            <label for="surname">Surname: </label><input type="text" id="surname" name="surname" value="<?php echo $row['surname']; ?>" /><br />
            <label for="email">E-mail: </label><input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" /><br />
            <label for="born">Born: </label><input type="date" id="born" name="born" value="<?php echo $row['born']; ?>" /><br />
            <label for="phone">Phone: </label><input type="tel" id="phone" name="phone" value="<?php echo $row['phone']; ?>" /><br />
            <label for="n_pass">New Password: </label><input type="password" id="n_pass" name="n_pass" /><br />
            <label for="r_n_pass">Repeat New Password: </label><input type="password" id="r_n_pass" name="r_n_pass" /><br />
            <label for="password">Your Password: </label><input type="password" id="password" name="password" /><br />
    			<input type="hidden" name="hidden" value="1" />   
    			<?php if($user_id == $this->id) {?>     
            		<input type="submit" value="Update" />
            	<?php } ?>
            </form><?php
        }
	}
	
	public function is_logged_in(){
		return isset($_SESSION['logged_in']) 
		&& ($_SESSION['logged_in'] == 1) 
		&& ($this->access_level >= 0);
	}
	
	public function show_login_status(){
		global $CONFIG, $url;
		$code = "";
		$more = " | <a id=\"\" href=\"?show=feedback\"><span class=\"icon\"></span><span class=\"tooltip\">Feedback</span></a> | <a id=\"lnkHelp\" href=\"javascript: pop_up('$url?show=help')\"><span class=\"icon\"></span><span class=\"tooltip\">Βοήθεια</span></a>";
		if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != 1){
			if($CONFIG['allow_login'])
				$code .= "<a id=\"lnkLogin\" href=\"?show=login\"><span class=\"icon\"></span><span class=\"tooltip\">Είσοδος";
			if($CONFIG['allow_register'])
				//TODO $code .= "/Εγγραφή ";
			$code.= "</span></a>".$more;
		}
		elseif($_SESSION['logged_in'] == 1){
			$code .= "<a id=\"lnkAccount\" href=\"?show=cp\"><span class=\"icon\"></span><span class=\"tooltip\">". /*$this->*/$this->username . "</span></a> |  ";
			if($this->is_admin() /*Trying something with better looing $this instanceof Admin*/)
				$code .= "<a id=\"\" href=\"?show=admin\"><span class=\"icon\"></span><span class=\"tooltip\">Admin</span></a>"; /* |  <a id=\"\" href=\"?show=msg\"><span class=\"icon\"></span><span class=\"tooltip\">Μηνύματα</span></a>"; */
		    $code.= $more;
		    $code .= " | <a id=\"lnkLogout\" href=\"?show=logout\"><span class=\"icon\"></span><span class=\"tooltip\">Έξοδος</span></a>";
		}
		return $code;
	}
	
	public function session_check(){
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

	public function is_admin(){
	    return ($this->access_level >= 100) ? true : false;
	}
	
	public function cansel_request($id){
		global $db;	
		
		$query = "DELETE FROM `requests` WHERE `id` = '$id' AND `user_id` = '{$this->id}'; ";
		$db->query($query);
		?>
		<p class="success">Your request have been deleted!</p>
		<?php 		
	}	
	
	public static function get_name($id){
		global $db;
		$query = "SELECT name FROM {$db->table['users']} WHERE `id` = '".mysql_real_escape_string($id)."';";
		$result = $db->query($query);
		$ret = mysql_fetch_row($result);
		return $ret[0];
	}
	
	public static function username_check($username){
		global $db;
		$query = "SELECT * FROM `{$db->table['users']}` WHERE `username` = '".mysql_real_escape_string($username)."' LIMIT 1;";
		$result = $db->query($query);
		$num = mysql_num_rows($result);
		return ($num == 1);	
	}
};

?>