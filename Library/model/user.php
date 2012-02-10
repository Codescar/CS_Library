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
		$query2 = "(";
		if(!empty($_POST['name'])){
		    $x = mysql_real_escape_string($_POST['name']);
		    $query2 .= " $x,";
		}
		else
		    $query2 .= " ,";
		if(!empty($_POST['surname'])){
		    $x = mysql_real_escape_string($_POST['surname']);
		    $query2 .= " $x,";
		}
		else
		    $query2 .= " ,";
		$query2 .= $user;
		if(!empty($_POST['user_type'])){
		    $x = mysql_real_escape_string($_POST['user_type']);
		    $query2 .= " $x,";
		}
		else
		    $query2 .= " ,";
		$query2 .= " ".$pass.",";
		if(!empty($_POST['born'])){
		    $x = mysql_real_escape_string($_POST['born']);
		    $query2 .= " $x,";
		}
		else
		    $query2 .= " ,";
		if(!empty($_POST['phone'])){
		    $x = mysql_real_escape_string($_POST['phone']);
		    $query2 .= " $x,";
		}
		else
		    $query2 .= " ,";
		$query2 .= $mail.", '0', NOW(), '".$_SERVER['REMOTE_ADDR']."') ";
		$query = "INSERT INTO `{$db->table["users"]}` 
					(`name`, `surname`, `username`, `usertype`, 
					 `password`, `phone`, `email`, `access_lvl`, 
					 `created_date`, `last_ip`) VALUES";
		$query .= $query2;
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
		echo "<table id=\"history\"><tr><th>Βιβλίο</th>";
		echo ($mode ) ? "<th>Χρήστης</th>" : "";
		echo "<th>Κατάσταση</th><th>Ημερομηνία Τελευταίας Αλλαγής</th></tr>";
		$flag = 0;
		while($row = mysql_fetch_array($result)){
			if($flag++ % 2 == 0)
				echo "\t\t\t\t<tr class=\"alt\">";
			else
				echo "\t\t\t\t<tr>";
			echo "<td><a href=\"index.php?show=book&id={$row['book_id']}\">{$row['title']}</a></td>";
			echo ($mode) ? "<td>{$row['name']} ({$row['user_id']})</td>" : "";
			echo "<td class=\"action\">";
            switch($row['action']){
		    case 1:
		    	echo ($mode) && book_avail($row['book_id'])
		    	? "<a href=\"?show=admin&more=lend&lend={$row['book_id']}&user={$row['user_id']}\" class=\"request-book\">Request</a>"
				: "Request (<a href=\"?show=cp&more=remove_request&id={$row['id']}\" class=\"cansel-request\">Delete</a>)";
		        break;
		    case 2:
		    	//TODO Change the actions to know if lended is now lended and if were lended in the past
				echo "Το έχεις πάρει";
		        break;
		    case 3:
		    	//TODO return or back is the correct action for an admin?
		    	echo ($mode ) 
		    	? "<a href=\"?show=admin&more=return&return={$row['book_id']}&user={$row['user_id']}\" class=\"return-book\">Have it now</a>"
				: "Το έχεις τώρα";
				break;
            }
            echo "</td>";
			echo  "<td class=\"date\">".date('d-m-Y', strtotime($row['date']))."</td></tr><tr></tr>\n";
		}
		echo "</table><br />"; 
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
                echo "<div class=\"success\">Οι αλλαγές σας αποθηκεύτηκαν.</div>";
            }
            else
                echo "<div class=\"error\">Δώσατε λάθος κωδικό.</div>";
        }
        else{
            //$query = "SELECT tmp1.username, tmp1.name, tmp1.surname, tmp1.born, tmp1.phone, tmp1.email, tmp1.usertype FROM
    		//			(SELECT users.username, users.name, users.surname, users.born, users.phone, users.email, users.usertype FROM users
    						
    		//			WHERE users.id = '$user_id' ) AS tmp1
    		//				";
        }
            $query = "SELECT users.username, users.name, users.surname, users.born, users.phone, users.email, users.usertype, users.books_lended 
            			FROM users
            			WHERE users.id = '$user_id'";
            $result = $db->query($query);
            $row = mysql_fetch_assoc($result);
            return $row;
	}
	
	public function is_logged_in(){
		return isset($_SESSION['logged_in']) 
		&& ($_SESSION['logged_in'] == 1) 
		&& ($this->access_level >= 0);
	}
	
	public function show_login_status(){
		global $CONFIG, $url;
		$code = "<span>";
		$more = " | <a id=\"lnkFeedback\" href=\"?show=feedback\"><span class=\"icon\"></span><span class=\"tooltip\">Επικοινωνία</span></a> | <a id=\"lnkHelp\" href=\"javascript: pop_up('$url?show=help')\"><span class=\"icon\"></span><span class=\"tooltip\">Βοήθεια</span></a>";
		if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != 1){
			if($CONFIG['allow_login'])
				$code .= "<a id=\"lnkLogin\" href=\"?show=login\"><span class=\"icon\"></span><span class=\"tooltip\">Είσοδος";
			if($CONFIG['allow_register'])
				//TODO $code .= "/Εγγραφή ";
			$code.= "</span></a>".$more;
		}
		elseif($_SESSION['logged_in'] == 1){
			$code .= "<a id=\"lnkAccount\" href=\"?show=cp\"><span class=\"icon\"></span><span class=\"tooltip\">Προφίλ</span></a>";
			if($this->is_admin() /*Trying something with better looing $this instanceof Admin*/)
			    $code .= " | <a id=\"lnkAdmin\" href=\"?show=admin&more=history\"><span class=\"icon\"></span><span class=\"tooltip\">Admin</span></a>";
				//$code .= " | <a id=\"\" href=\"?show=admin\"><span class=\"icon\"></span><span class=\"tooltip\">Admin</span></a> | <a id=\"\" href=\"?show=msg\"><span class=\"icon\"></span><span class=\"tooltip\">Μηνύματα</span></a>";
		    $code.= $more;
		    $code .= " | <a id=\"lnkLogout\" href=\"?show=logout\"><span class=\"icon\"></span><span class=\"tooltip\">Έξοδος</span></a>";
		}
		return $code . "</span>";
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

	function show_lended(){
		global $CONFIG, $db;
		$books = $db->get_books("SELECT * FROM `{$db->table['booklist']}` CROSS JOIN `{$db->table['lend']}` ON {$db->table['booklist']}.id = {$db->table['lend']}.book_id 
		WHERE {$db->table['lend']}.user_id = '{$this->id}' ");
		if($books == FALSE){ ?>
			<div class="error">Δεν έχετε δανειστεί κανένα βιβλίο</div>
		<?php }
		list_books($books); 
		return;
	}
};

function date_gr($timestamp, $mode) {

    $result = "";
    $dval = date("N",$timestamp);
    $nval = (int) date("d",$timestamp);
    $mval = date("n",$timestamp);
    $myer = date("Y",$timestamp);
    
    // Feel free to personalize arrays for your mothertongue :-)
    // ---------------------------------------------------------
    $day = array("","Δευτέρα","Τρίτη","Τετάρτη","Πέμπτη","Παρασκευή","Σαββάτο","Κυριακή");

    $sday = array("","Δευ","Τρι","Τετ","Πεμ","Παρ","Σαβ","Κυρ");

    $month = array("","Ιανουαρίου","Φεβρουαρίου","Μαρτίου",
				"Απριλίου","Μαΐου","Ιουνίου","Ιουλίου",
				"Αυγούστου","Σεπτεμβρίου","Οκτωβρίου",
				"Νοεμβρίου","Δεκεμβρίου");

    $smonth = array("","Ιαν","Φεβ","Μαρ","Απρ","Μαι","Ιουν",
				"Ιουλ","Αύγ","Σεπτ","Οκτ","Νοέμ","Δεκ");

    // outputs the date with caps or not, long or short
    // ------------------------------------------------
    switch ($mode) {
        case "Long":
            $result = ucfirst($day[$dval])." $nval ".ucfirst($month[$mval]);
            break;		// Mardi 30 Juin
        case "long":
            $result = "$day[$dval] $nval $month[$mval]";
            break;		// mardi 30 juin
        case "mine":
            $result = $day[$dval]." $nval ".$month[$mval-1]." $myer";
            break;
        case "mine2":
            $result = $day[$dval];
            break;
        case "Short":
            $result = ucfirst($sday[$dval])." $nval ".ucfirst($smonth[$mval]);
            break;		// Mar 30 Juin
        default:
            $result = $day[$dval]." $nval-$mval";
    }
    return $result;
}

?>