<?php
/* SQLite Connector Driver */
class Lbdb extends DataBase{
	
	public function __construct() {
       parent::__construct();
	}
	
	protected function _connect(){
	    global $CONFIG;
	    if($CONFIG['debug']){
	    	
	    try 
		{
		  //create or open the database
		  $this->connection = new SQLiteDatabase($this->dbname, 0666, $error);
		}
		catch(Exception $e) 
		{
		  die($error);
		}
	    	//$this->connection = new SQLiteDatabase($this->dbname);

	    	//$this->connection = new SQLiteDatabase($this->dbname, 0666, $error);
	        //     or die("Δεν μπόρεσε να γίνει σύνδεση με την βάση.Error: ". sqlite_error_string(sqlite_last_error ($this->connection)));
	            echo $error;
	            print_r($this->connection); 
	    }
	    else{
	        $this->connection = @sqlite_open($this->dbname);
	    }
	   // $this->query("SET NAMES 'utf8';");
	    /* TODO query("SET time_zone = 'Europe/Athens';") 
	     * Have to install timezones in SQLite server 
	     */
	   //	$this->query("SET time_zone = '+2:00';");
	    return;
	}
	
	protected function _close(){
		global $CONFIG;
		
		if($CONFIG['debug'])
			sqlite_close($this->connection) or die("Error closing db.Error: ".sqlite_error_string(sqlite_last_error ($this->connection)));
		else
			@sqlite_close($this->connection);
			
		return;
	}
	
	/*
	 * Need some fixing, in order to get protected from harmful queries. 
	 */
	protected function _query($query){
		global $CONFIG;
	
		if($CONFIG['debug']){
			$results = $this->connection->queryExec($query);//exec($this->connection, $query);//;/($this->connection, $query) or die("Error while executing query. Error: ".sqlite_error_string(sqlite_last_error($this->connection)));
		}else
	        $results = @sqlite_query($this->connection, $query);
	    
		return $results;
	}

	public function db_fetch_object($query_result, $class_name = null, $params = null){
		if($class_name == null)
			return sqlite_fetch_object($query_result);
		else
			if($params == null)
				return sqlite_fetch_object($query_result, $class_name);
			else
				return sqlite_fetch_object($query_result, $class_name, $params);
	}
	
	public function db_fetch_array($query_result, $result_type = null){
		return sqlite_fetch_array($query_result, $result_type);
	}
	
	public function db_escape_string($string){
		return sqlite_escape_string($string, $this->connection);
	}
	
	public function db_num_rows($query_result){
		return sqlite_num_rows($query_result);
	}
	
	public function db_affected_rows(){
		return sqlite_changes();
	}
};
?>