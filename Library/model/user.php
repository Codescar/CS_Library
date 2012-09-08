<?php
/* User class, in order to use user-account
 * system, we can continue...
 */

class User{
	public $id, $username, $email, $access_level, $banned, $message, $admin, $favorites;
	
	function __constructor(){
	    $admin = null;
	}
	
	private static function pass_encrypt($pass){
		return $pass;
		//return md5($pass);
	}

	public function login($name, $pass){
		global $db;
		
		$name = $db->db_escape_string($name);
		$pass = $db->db_escape_string($pass);
		$pass = $this->pass_encrypt($pass);
		$query = "	SELECT * FROM `{$db->table['users']}`
					WHERE 	`username` = '$name' 
					AND 	`password` = '$pass'
					LIMIT 1 ;";
		$result = $db->query($query);
		$user = $db->db_fetch_object($result);
	    if($user){
	    	$this->id 					= $user->id;
	    	$this->access_level 		= $user->access_lvl;
	    	$this->username				= $user->username;
	    	$this->email				= $user->email;
	    	$this->banned				= $user->banned;
	    	$this->books_lended			= $user->books_lended;
	    	$this->books_requested		= $user->books_requested;

	    	$_SESSION['logged_in']		= 1;
			$_SESSION['cur_page'] 		= $_SERVER['SCRIPT_NAME'];
			$_SESSION['sessionid'] 		= session_id();
	    }
		return $user;
	}
	
	public static function createUser($user, $pass, $mail){
		global $db, $CONFIG;
		$user = $db->db_escape_string($user);
		$pass = $db->db_escape_string($pass);
		$pass = user::pass_encrypt($pass);
		$mail = $db->db_escape_string($mail);
		$query2 = "(";
		if(!empty($_POST['name'])){
		    $x = $db->db_escape_string($_POST['name']);
		    $query2 .= "'".$x."', ";
		}
		else
		    $query2 .= "NULL, ";
		if(!empty($_POST['surname'])){
		    $x = $db->db_escape_string($_POST['surname']);
		    $query2 .= "'".$x."', ";
		}
		else
		    $query2 .= "NULL, ";
		$query2 .= "'".$user."', ";
		if(!empty($_POST['user_type'])){
		    $x = $db->db_escape_string($_POST['user_type']);
		    $query2 .= "'".$x."', ";
		}
		else
		    $query2 .= "'', ";
		$query2 .= " '".$pass."', ";
		if(!empty($_POST['born'])){
		    $x = $db->db_escape_string($_POST['born']);
		    $query2 .= "'".$x."', ";
		}
		else
		    $query2 .= "NULL, ";
		if(!empty($_POST['phone'])){
		    $x = $db->db_escape_string($_POST['phone']);
		    $query2 .= "'".$x."', ";
		}
		else
		    $query2 .= "NULL, ";
		$query2 .= " '".$mail."', '0', NOW(), '".$_SERVER['REMOTE_ADDR']."') ";
		$query = "INSERT INTO `{$db->table['users']}` 
					(`name`, `surname`, `username`, `usertype`, 
					 `password`, `born`, `phone`, `email`, `access_lvl`, 
					 `created_date`, `last_ip`) VALUES";
		$query .= $query2;
        $db->query($query);
		//TODO send an e-mail to user
		return;
	}
	
	public static function delete_user($id){
		global $db, $CONFIG; 
		$query = "	DELETE FROM `{$db->table['users']}`
					WHERE `{$db->table['users']}`.`id` = '$id'
					LIMIT 1";
		echo "<div class=\"success\">Ο χρήστης ".user::get_name($id)." διαγράφηκε.<br />";
		//TODO we should print the username instead of the name
		$db->query($query);
		redirect($CONFIG['url']."?show=admin&more=users", 2000);
	}

	public function show_history(){
	    global $db;
		$query = "	SELECT * FROM `{$db->table['log_lend']}`
					CROSS JOIN `{$db->table['booklist']}`
					ON `{$db->table['booklist']}`.id = `{$db->table['log_lend']}`.book_id
					WHERE `{$db->table['log_lend']}`.`user_id` = '$this->id'
					ORDER BY `{$db->table['log_lend']}`.`returned`";
		$result = $db->query($query);
		echo "<table id=\"history\"><tr><th>Βιβλίο</th><th>Το Πήρες</th><th>Το Έφερες</th></tr>";
		$flag = 0;
		while($row = $db->db_fetch_array($result)){
			if($flag++ % 2 == 0)
				echo "\t\t\t\t<tr class=\"alt\">";
			else
				echo "\t\t\t\t<tr>";
			echo "<td class=\"table-book-title\"><a href=\"index.php?show=book&id={$row['book_id']}\">{$row['title']}</a></td>";
			echo "<td class=\"date\">".date('d-m-Y', strtotime($row['taken']))."</td>\n";
			echo "<td class=\"date\">".date('d-m-Y', strtotime($row['returned']))."</td></tr>\n";
		}
		echo "</table><br />"; 
		return;
	}

	public static function show_info($user_id = -1){
        global $db;
		if($user_id == -1)
			$user_id = $this->id;
		$query = "SELECT * FROM `{$db->table['users']}` WHERE `id` = '$user_id'";
		$result = $db->query($query);
		$user_info = $db->db_fetch_object($result);
		return $user_info;
	}
	
	public function update($user_id, $name, $surname, $born, $phone, $email, $new_pass, $r_new_pass){
		global $db;

		$q = "UPDATE `{$db->table['users']}` SET
			`name` = '$name', `surname` = '$surname',
			`born` = '$born', `phone` = '$phone',
			`email` = '$email' ";
		if($new_pass != "" && $new_pass = $r_new_pass){
			/*if(check_password($_POST['n_pass']))*/
			$new_pass = $this->pass_encrypt($new_pass);
			$q .= ", `password` = '$new_pass' ";
		}
		$q .= " WHERE `{$db->table['users']}`.id = '$user_id' ;";
		$db->query($q);
		echo "<div class=\"success\">Οι αλλαγές σας αποθηκεύτηκαν.</div>";
	}
	
	public function is_logged_in(){
		return isset($_SESSION['logged_in']) && ($_SESSION['logged_in'] == 1) && ($this->access_level >= 0);
	}
	
	public function show_login_status(){
		global $CONFIG;
		$code = "<span>";
		$more = " | <a id=\"lnkFeedback\" href=\"?show=feedback\"><span class=\"icon\"></span><span class=\"tooltip\">Επικοινωνία</span></a> | <a id=\"lnkHelp\" href=\"javascript: pop_up('{$CONFIG['url']}?show=help')\"><span class=\"icon\"></span><span class=\"tooltip\">Βοήθεια</span></a>";
		if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != 1){
			if($CONFIG['allow_login'])
				$code .= "<a id=\"lnkLogin\" href=\"?show=login\"><span class=\"icon\"></span><span class=\"tooltip\">Είσοδος";
			if($CONFIG['allow_register'])
				//TODO $code .= "/Εγγραφή ";
			$code.= "</span></a>".$more;
		}
		elseif($_SESSION['logged_in'] == 1){
			$code .= "	<a id=\"lnkAccount\" href=\"?show=cp\"><span class=\"icon\"></span><span class=\"tooltip\">Προφίλ</span></a>|
						<a id=\"lnkFavorites\" href=\"?show=favorites\"><span class=\"icon\"></span><span class=\"tooltip\">Αγαπημένα</span></a>";
			if($this->is_admin() /*Trying something with better looing $this instanceof Admin*/)
			    $code .= " | <a id=\"lnkAdmin\" href=\"?show=admin\"><span class=\"icon\"></span><span class=\"tooltip\">Admin</span></a>";
				//$code .= " | <a id=\"\" href=\"?show=admin\"><span class=\"icon\"></span><span class=\"tooltip\">Admin</span></a> | <a id=\"\" href=\"?show=msg\"><span class=\"icon\"></span><span class=\"tooltip\">Μηνύματα</span></a>";
		    $code.= $more;
		    $code .= " | <a id=\"lnkLogout\" href=\"?show=logout\"><span class=\"icon\"></span><span class=\"tooltip\">Έξοδος</span></a>";
		}
		return $code . "</span>";
	}
	
	public function session_check(){
		global $CONFIG;
		if(!isset($_SESSION['logged_in']))
			session_empty();
		if(!isset($_SESSION['last_active'])){
	    	$_SESSION['last_active'] = time() + $CONFIG['max_idle_time'];
		}else{
	    	if($_SESSION['last_active'] < time()){   
		    	session_unset(); 
		        session_destroy();
		    }else{
		        $_SESSION['last_active'] = time() + $CONFIG['max_idle_time'];
		    }
		}
		$_SESSION['cur_page'] 	= $_SERVER['SCRIPT_NAME'];
		$_SESSION['sessionid'] 	= session_id();
	}

	public function is_admin(){
		if(!$this->is_logged_in()) return false;
	    return ($this->access_level >= 100) ? true : false;
	}
	
	public function cansel_request($id, $current_url){
		global $db;	

		$query = "DELETE FROM `requests` WHERE `id` = '$id' AND `user_id` = '{$this->id}'; ";
		$db->query($query);
		echo "<div class=\"success\">Η αίτηση δανεισμού σου ακυρώθηκε!<br />";
		redirect($current_url);
	}	
	
	public static function get_name($id){
		global $db;
		$query = "SELECT username FROM {$db->table['users']} WHERE `id` = '".$db->db_escape_string($id)."';";
		$result = $db->query($query);
		$ret = $db->db_fetch_array($result);
		return $ret[0];
	}
	
	public static function username_check($username){
		global $db;
		$query = "SELECT * FROM `{$db->table['users']}` WHERE `username` = '".$db->db_escape_string($username)."' LIMIT 1;";
		$result = $db->query($query);
		$num = $db->db_num_rows($result);
		return ($num == 1);	
	}

	function show_lended($id = -1){
		global $CONFIG, $db;
		$user_id = $this->id;
		if($id != -1)
			$user_id = $id;
		$query = "SELECT * FROM `{$db->table['booklist']}` CROSS JOIN `{$db->table['lend']}` 
					ON {$db->table['booklist']}.id = {$db->table['lend']}.book_id 
				  WHERE {$db->table['lend']}.user_id = '$user_id' ";
		$books = $db->get_books($query);
		if(!$books)
			echo "<div class=\"error\">Δεν έχετε δανειστεί κανένα βιβλίο.</div><br />";
		list_books($books); 
		return;
	}
};

?>