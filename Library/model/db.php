<?php
class Lbdb{
	private $connection, $hostname, $username, $password, $dbname;
	function __construct()
	{
		global $db_hostname, $db_username, $db_password, $db_name;
		$this->hostname = $db_hostname;
		$this->username = $db_username;
		$this->password = $db_password;
		$this->dbname = $db_name;
		$this->db_connect();
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
		mysql_close($this->connection);
	}
	
	/*
	 * Need some fixing, in order to get
	 * protected from harmful queries. 
	 */
	function db_query($query){
		return mysql_query($query, $this->connection) or die(mysql_error());	
	}
	
	function get_books($limit_offset, $items){
		$res = $this->db_query("SELECT * FROM booklist ORDER BY booklist.id ASC LIMIT ".$limit_offset.",". $items .";");
		for($i = 0; $books[$i] = mysql_fetch_array($res); $i++);
		array_pop($books);
		return $books;
	}
}

$db = new Lbdb();
?>