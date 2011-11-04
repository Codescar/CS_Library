<?php
require_once('include/includes.php');

class admin_db extends Lbdb{

	public function __construct();
	public function __destruct(){
		parent::__destruct();
	}
	
	function lend_book($bk_id, $usr_id, $dp_id) {
		parent::db_query(
			"INSERT INTO lend 
				SET lend.book_id = ".$bk_id.", lend.user_id = ".$usr_id.",
					lend.department_id = ".$dp_id.", lend.taken = NOW();
			");
	}
	
	function return_book($bk_id){
		parent::db_query(
			"UPDATE lend
				SET returned = NOW()
				WHERE book_id = ".$bk_id.";
			");
		parent::db_query(
			"DELETE FROM lend
				WHERE lend.book_id = ".$bk_id.";
			");
	}
	
}



?>