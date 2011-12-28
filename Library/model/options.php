<?php
/**
 * Options' handler 
 * The options are stored to the database  //TODO it
 * and editable from the control panel //TODO it
 *
 */

class option{
	var $name, $value, $default;
	
	public function load(){
		unserialize($res);
		
	}
	
	public function value(){
		
		
	}
	
	public function save($val){
		serialize($val);
	}
	
};
?>