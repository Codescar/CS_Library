<?php	
function session_empty(){
	$_SESSION['logged_in']		= 0;
	
	$_SESSION['user']			= "user";
	$_SESSION['access_level']	= -1;
	$_SESSION['is_admin']		= 0;
			
	$_SESSION['cur_page'] 		= $_SERVER['SCRIPT_NAME'];
	$_SESSION['sessionid'] 		= session_id();
	return;
}
?>