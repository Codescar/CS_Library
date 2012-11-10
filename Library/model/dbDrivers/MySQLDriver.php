<?php
/* MySQL Connector Driver */
class Lbdb extends DataBase{
	
	public function __construct() {
       parent::__construct();
	}

	protected function _connect(){
	    global $CONFIG;
	    if($CONFIG['debug']){
	        $this->connection = mysql_connect($this->hostname, $this->username, $this->password)
	            or die("Δεν μπόρεσε να γίνει σύνδεση με την βάση. Error: ".mysql_error());
	        mysql_select_db($this->dbname, $this->connection)
	            or die("Πρόβλημα με την επιλογή βάσης: ".mysql_error());
	    }
	    else{
	        $this->connection = mysql_connect($this->hostname, $this->username, $this->password);
	        mysql_select_db($this->dbname, $this->connection);   
	    }
	    $this->query("SET NAMES '{$CONFIG['charset']}';");
	    /* TODO query("SET time_zone = 'Europe/Athens';") 
	     * Have to install timezones in mysql server 
	     */
	   	$this->query("SET time_zone = '+2:00';");
	    return $this->connection;
	}
	
	protected function _close(){
		global $CONFIG;
		
		if($CONFIG['debug'])
			mysql_close($this->connection) or die(mysql_error());
		else
			@mysql_close($this->connection);
			
		return;
	}
	
	/*
	 * Need some fixing, in order to get protected from harmful queries. 
	 */
	protected function _query($query){
		global $CONFIG;
	    
		if($CONFIG['debug']){
	    	
			$results = mysql_query($query, $this->connection) or die("Error κατά την εκτέλεση query: ".mysql_error());
		}else
	        $results = mysql_query($query, $this->connection);
	    
		return $results;
	}

	public function db_fetch_object($query_result, $class_name = null, $params = null){
		if($class_name == null)
			return mysql_fetch_object($query_result);
		else
			if($params == null)
				return mysql_fetch_object($query_result, $class_name);
			else
				return mysql_fetch_object($query_result, $class_name, $params);
	}
	
	public function db_fetch_array($query_result, $result_type = null){
		return mysql_fetch_array($query_result, $result_type);
	}
	
	public function db_escape_string($string){
		return mysql_real_escape_string($string, $this->connection);
	}
	
	public function db_num_rows($query_result){
		return mysql_num_rows($query_result);
	}
	
	public function db_affected_rows(){
		return mysql_affected_rows($this->connection);
	}
	
	public function db_error(){
		return mysql_error($this->connection);
	}
};
?>