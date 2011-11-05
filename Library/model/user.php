<?php
/* User class, in order to use user-account
 * system, we can continue...
 */
class User{
	private $id, $username, $password, $email, $access_level, $department_id, $created;
	
	function __construct(){
		/* load the date for the user */
		
	} 
	
	function __destruct(){
		$this->id 				= NULL;
		$this->username 		= NULL;
		$this->password 		= NULL;
		$this->access_level 	= 0;
		$this->department_id 	= NULL;
		$this->created			= 0;
	}
	
	function login($user, $pass){
		
	}
	
	function createUser($user, $pass, $mail, $dep_id){
		
		
	}
	
	function activateAccount(){
		
		
	}
	
	function changePassword($id, $pass, $new_pass){
		
		
	}
	
	function changeEmail($id, $mail, $pass){
		
	}
}

?>