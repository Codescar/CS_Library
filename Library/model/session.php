<?php

	function session_check(){
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
	
	function session_login(){
		$_SESION['logged_in']		= 1;
		
		$_SESSION['user']			= "user";
		$_SESSION['access_level']	= 0;
		$_SESSION['is_admin']		= 0;
				
		$_SESSION['cur_page'] 		= $_SERVER['SCRIPT_NAME'];
		$_SESSION['sessionid'] 		= session_id();
	}


?>