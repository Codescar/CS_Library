<?php
class Lbdb{
	private $connection, $hostname, $username, $password, $dbname, $queries;
	public $booklist, $query_time;
	//TODO have to use the arrays for the names of the column/tables everywhere I think... much work!
	public $table = array(
							"booklist" 		    => "booklist",
							"comments" 		    => "comments",
							"departments" 	    => "departments",
							"lend" 			    => "lend",
							"log_lend"		    => "log_lend",
							"requests"		    => "requests",
							"users"			    => "users",
							"history"		    => "history",
							"messages"		    => "messages",
							"announcements"	    => "announcements",
							"categories"	    => "categories",
							"options"		    => "options",
	                        "pages"       	    => "pages", 
	                        "book_has_category" => "book_has_category",
							"avatars"			=> "avatars",
							"favorites"			=> "favorites" );
	
/*	public $columns = array("booklist"		=>	array(	"id" 			=> "id", 
														"title" 		=> "title", 
														"availability" 	=> "availability", 
														"writer" 	=> "writer", 
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
	public function __construct(){
		global $db_hostname, $db_username, $db_password, $db_name;
		$this->queries = 0;
		$this->connection = 0;
		$this->hostname = $db_hostname;
		$this->username = $db_username;
		$this->password = $db_password;
		$this->dbname = $db_name;
		$this->query_time = 0;
	}

	public function connect(){
	    global $CONFIG;
	    if($CONFIG['debug']){
	    	$start = microtime(true);
	        $this->connection = mysql_connect($this->hostname, $this->username, $this->password)
	            or die("Δεν μπόρεσε να γίνει σύνδεση με την βάση. Error: ".mysql_error());
	        mysql_select_db($this->dbname, $this->connection)
	            or die("Πρόβλημα με την επιλογή βάσης: ".mysql_error());
	         $this->query_time += microtime(true) - $start;
	    }
	    else{
	        $this->connection = mysql_connect($this->hostname, $this->username, $this->password);
	        mysql_select_db($this->dbname, $this->connection);   
	    }
	    $this->query("SET NAMES 'utf8'");
	    /* TODO query("SET time_zone = 'Europe/Athens'") 
	     * Have to install timezones in mysql server 
	     */
	   	$this->query("SET time_zone = '+2:00'");
	    return;
	}
	
	public function close(){
		global $CONFIG;
		if($CONFIG['debug'])
	    	$start = microtime(true);
		mysql_close($this->connection);
		if($CONFIG['debug'])
			$this->query_time += microtime(true) - $start;
	}
	
	/*
	 * Need some fixing, in order to get protected from harmful queries. 
	 */
	public function query($query){
		global $CONFIG;
	    
		if($CONFIG['debug']){
	    	$start = microtime(true);
			$results = mysql_query($query, $this->connection) or die("Error κατά την εκτέλεση query: ".mysql_error());
		}else
	        $results = mysql_query($query, $this->connection);
	        
	    if($CONFIG['debug'])
			$this->query_time += microtime(true) - $start;
	    $this->queries++;
	    
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
	public function get_books($query, $query2 = null){
		$res = $this->query($query);
		for($i = 1; $books[$i] = mysql_fetch_array($res); $i++);
		if($books['1'] == FALSE)	
			return FALSE;
		array_pop($books);
		if($query2 != null){
			$r = $this->query($query2);
			$b = mysql_fetch_array($r);
			$books['0'] = $b[0];
		}
		else
			$books['0'] = -1;
		return $books;
	}
	
	public function user_change_attr($user_id, $attribute, $change){	
		$query = "UPDATE `{$this->table['users']}`
					SET `$attribute` = `$attribute` $change
				 WHERE `id` = '$user_id' LIMIT 1";
		$this->query($query);
	}
	
	public function lend_book($book_id, $user_id){
		global $CONFIG;
        $lend =	"	INSERT INTO `{$this->table['lend']}` 
					(`book_id`, `user_id`, `taken`, `must_return`) VALUES 
					('$book_id', '$user_id', NOW(), ADDDATE(NOW(), {$CONFIG['lend_days']}) ) ;";
	    $this->query($lend);
	    return;
	}
	
	public function delete_request($book_id, $user_id){
		$query = "DELETE FROM `{$this->table['requests']}`
					WHERE `book_id` = '$book_id' AND `user_id` = '$user_id' LIMIT 1; ";
		$this->query($query);
		$this->user_change_attr($user_id, "books_requested", " - 1 ");
		return;
	}
	
	public function return_book($book_id){
		$return ="	UPDATE `{$this->table['lend']}`
					SET `returned` = NOW()
					WHERE book_id = '$book_id'
					LIMIT 1;";
		$this->query($return);
	    return;
	}
	
	public function log_the_lend($book_id){
		$log_it ="	INSERT INTO `{$this->table['log_lend']}`
					(book_id, user_id, taken, must_return, returned)
						SELECT book_id, user_id, taken, must_return, returned 
						FROM `{$this->table['lend']}`
							WHERE book_id = '$book_id'; ";
		$this->query($log_it);
		$delete ="	DELETE FROM `{$this->table['lend']}`
						WHERE book_id = '$book_id'
					LIMIT 1; ";
		$this->query($delete);
	}

	public function change_avail($book_id, $status){
		$query ="	UPDATE `{$this->table['booklist']}`
						SET `availability` = '$status'
					WHERE `id` = '$book_id'
					LIMIT 1;";
		$this->query($query);
	}

	public function get_queries_num(){
		return $this->queries;
	}
	
	public function reset_database(){
		//TODO maybe take a dump of those tables or whole mysql just in case
		$book_availability = 
			"UPDATE `{$this->table['booklist']}`
				SET `availability` = 1";
		$clear_requests =
			"DELETE `{$this->table['requests']}`";
		$clear_lend =
			"DELETE `{$this->table['lend']}`";
		$clear_log_lend = 
			"DELETE `{$this->table['log_lend']}`";
		$this->query($book_availability);
		$this->query($clear_requests);
		$this->query($clear_lend);
		$this->query($clear_log_lend);
	}
};