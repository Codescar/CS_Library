<?php
class Lbdb{
	private $connection, $hostname, $username, $password, $dbname;
	public $booklist;
	//TODO have to use the arrays for the names of the column/tables everywhere I think... much work!
	public $table = array(
							"booklist" 		=> "booklist",
							"comments" 		=> "comments",
							"departments" 	=> "departments",
							"lend" 			=> "lend",
							"log_lend"		=> "log_lend",
							"requests"		=> "requests",
							"users"			=> "users",
							"history"		=> "history",
							"messages"		=> "messages");
	
/*	public $columns = array("booklist"		=>	array(	"id" 			=> "id", 
														"title" 		=> "title", 
														"availability" 	=> "availability", 
														"writer_or" 	=> "writer_or", 
														"description"	=> "description", 
														"added_on" 		=> "added_on"),
	
							"comments"		=>	array(	"id"			=> "id",
														"book_id"		=> "book_id",
														"comment"		=> "comment"),
	
							"departments"	=>	array(	"id"			=> "id",
														"incharge"		=> "incharge",
														"name"			=> "name", 
														"comments"		=> "comments"),
	
							"lend"			=>	array(	"book_id"		=> "book_id",
														"department_id"	=> "department_id",
														"user_id"		=> "user_id",
														"taken"			=> "taken",
														"returned" 		=> "returned"),
							
							"log_lend"		=>	array(	"id"			=> "id",
														"book_id"		=> "book_id",
														"department_id" => "department_id",
														"user_id"		=> "user_id",
														"taken"			=> "taken",
														"returned"		=> "returned"),
	
							"requests" 		=>	array(	"id"			=> "id",
														"book_id"		=> "book_id",
														"user_id"		=> "user_id",
														"date"			=> "date"),
	
							"users"			=>	array(	"id"			=> "id",
														"dep_id"		=> "dep_id",
														"name"			=> "name",
														"surname"		=> "surname",
														"username"		=> "username",
														"password"		=> "password",
														"born"			=> "born",
														"phone"			=> "phone",
														"email"			=> "email",
														"access_lvl"	=> "access_lvl",
														"last_ip"		=> "last_ip",
														"created_date"	=> "created_date"),
	
							"history"		=>	array(	"book_id"		=> "book_id",
														"title"			=> "title",
														"action"		=> "action",
														"user_id"		=> "user_id",
														"date"			=> "date")
	);*/
	function __construct(){
		global $db_hostname, $db_username, $db_password, $db_name;
		$this->connection = 0;
		$this->hostname = $db_hostname;
		$this->username = $db_username;
		$this->password = $db_password;
		$this->dbname = $db_name;
	}

	function connect(){
	    global $CONFIG;
	    if($CONFIG['debug']){
	        $this->connection = mysql_connect($this->hostname, $this->username, $this->password)
	            or die("Could not connect: ".mysql_error());
	        mysql_select_db($this->dbname, $this->connection)
	            or die("Error selecting database: ".mysql_error());
	        echo "Opening ".$this->connection."<br />";
	    }
	    else{
	        $this->connection = mysql_connect($this->hostname, $this->username, $this->password);
	        mysql_select_db($this->dbname, $this->connection);   
	    }
	    $this->query("SET NAMES 'utf8'");
	    /* query("SET time_zone = 'Europe/Athens'") 
	     * Have to install timezones in mysql server 
	     */
	   	$this->query("SET time_zone = '+2:00'");
	    return;
	}
	
	function close(){
		global $CONFIG;
	    if($CONFIG['debug'])
	        echo "<br />"."Closing ".$this->connection."<br />";
		mysql_close($this->connection);
	}
	
	/*
	 * Need some fixing, in order to get
	 * protected from harmful queries. 
	 */
	function query($query){
		global $CONFIG;
	    if($CONFIG['debug'])
		    $results = mysql_query($query, $this->connection) or die("Query error: ".mysql_error());
	    else
	        $results = mysql_query($query, $this->connection);
		return $results;
	}
	
	/*
	 * Returns an array both numeric and associative
	 * with $items books in it, with $limit_offset.
	 * Also first element book[0] represents how
	 * many books are indexed in our db.
	 * 
	 * Returns FALSE if there are no results
	 */
	function get_books($limit_offset, $items, $query = "SELECT * FROM booklist ORDER BY booklist.id ASC LIMIT "){
		$res = $this->query($query.$limit_offset.",". $items .";");
		for($i = 1; $books[$i] = mysql_fetch_array($res); $i++);
		if($books['1'] == FALSE)	
			return FALSE;
		array_pop($books);
		$a = mysql_fetch_array($this->query("SELECT COUNT(*) FROM booklist;"));
		$books['0'] = $a['0'];
		return $books;
	}
	
	/*
	 * Searches for a specific book or books througth the library
	 * Mode 1 searches only in title
	 * Mode 2 searches only in writer_organization
	 * Mode 3 searches both title and writer_organization
	 */
	function search($string, $mode, $limit_offset, $items){
		$s = mysql_real_escape_string(trim(mysql_real_escape_string($string)));
		$query = "SELECT * FROM `booklist` WHERE ";
		if($mode == '1')
			$query .= " booklist.title LIKE \"%$s%\"";
		else if($mode == '2')
			$query .= " booklist.writer_or LIKE \"%$s%\" ";
		else
			$query .= " booklist.title LIKE \"%$s%\" OR booklist.writer_or LIKE \"%$s%\" ";
		$query .= "ORDER BY booklist.id ASC LIMIT ";
		
		$books = $this->get_books($limit_offset, $items, $query);
		return $books;
	}
	
	function lend_book($bk_id, $usr_id, $dp_id){
        $lend =	"	INSERT INTO `lend` 
					(`book_id`, `user_id`, `department_id`, `taken`) VALUES 
					('$bk_id', '$usr_id', '$dp_id', NOW()) ;
				";
	    $this->query($lend);
	    return;
	}
	
	function return_book($bk_id){
		$return ="	UPDATE lend
					SET returned = NOW()
					WHERE book_id = ".$bk_id."
					LIMIT 1;
				";
		$this->query($return);
	    $log_it ="	DELETE FROM lend
					WHERE lend.book_id = ".$bk_id."
					LIMIT 1;
				";
	    $this->query($log_it);
	    return;
	}
}
?>