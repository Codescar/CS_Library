<?php
class Lbdb{
	private $connection, $hostname, $username, $password, $dbname;
	//TODO try to handle the table names and the collumn names in variables/arrays 
	public $booklist;
	function __construct()
	{
		global $db_hostname, $db_username, $db_password, $db_name;
		$this->hostname = $db_hostname;
		$this->username = $db_username;
		$this->password = $db_password;
		$this->dbname = $db_name;
		//$this->db_connect();
	}
	
	function __destruct(){
		$this->db_close();
	}
	
	function db_connect(){
		$this->connection = mysql_connect($this->hostname, $this->username, $this->password) 
			or die("Could not connect: ".mysql_error());
		mysql_select_db($this->dbname, $this->connection)
			or die("Error selecting database: ".mysql_error());
		mysql_query("SET NAMES 'utf8'", $this->connection)
			or die(mysql_error());
	}
	
	function db_close(){
		@mysql_close($this->connection);
	}
	
	/*
	 * Need some fixing, in order to get
	 * protected from harmful queries. 
	 */
	function db_query($query){
		$results = mysql_query($query, $this->connection) or die("Query error: ".mysql_error());
		return $results;
	}
	
	function get_books($limit_offset, $items){
		$res = $this->db_query("SELECT * FROM booklist ORDER BY booklist.id ASC LIMIT ".$limit_offset.",". $items .";");
		for($i = 0; $books[$i] = mysql_fetch_array($res); $i++);
		array_pop($books);
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
		$query .= "ORDER BY booklist.id ASC LIMIT ".$limit_offset.",". $items ." ;";
		
		$res = $this->db_query($query);
		for($i = 0; $books[$i] = mysql_fetch_array($res); $i++);
		array_pop($books);
		return $books;
	}
}
global $db;
$db = new Lbdb();
?>