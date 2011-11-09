<?php

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
	
	function session_login($user, $user_id, $access_lvl){
		$_SESSION['logged_in']		= 1;
		
		$_SESSION['user']			= $user;
		$_SESSION['user_id']		= $user_id;
		$_SESSION['access_level']	= 0;
		
		if($access_lvl >= 100)	$a = 1;
						else	$a = 0;
						
		$_SESSION['is_admin']		= $a;
				
		$_SESSION['cur_page'] 		= $_SERVER['SCRIPT_NAME'];
		$_SESSION['sessionid'] 		= session_id();
		return;
	}
	
	function session_empty(){
		$_SESSION['logged_in']		= 0;
		
		$_SESSION['user']			= "user";
		$_SESSION['access_level']	= -1;
		$_SESSION['is_admin']		= 0;
				
		$_SESSION['cur_page'] 		= $_SERVER['SCRIPT_NAME'];
		$_SESSION['sessionid'] 		= session_id();
		return;
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

?>