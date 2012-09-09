<?php
/* MySQLi Connector Driver */
class Lbdb extends DataBase{
	
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

	protected function _connect(){
	    global $CONFIG;
	    
	    if($CONFIG['debug']){
	        $this->connection = new mysqli($this->hostname, $this->username, $this->password, $this->dbname)
	            or die("Δεν μπόρεσε να γίνει σύνδεση με την βάση. Error: ".mysql_error());
	   		if (!empty($this->connection->connect_error)) {
    			die('Connect Error (' . $this->connection->connect_errno . ') '. $this->connection->connect_error);
			}
	    }
	    else{
	        $this->connection = @new mysqli($this->hostname, $this->username, $this->password, $this->dbname);
	    }

	    $this->query("SET NAMES 'utf8';");
	    /* TODO query("SET time_zone = 'Europe/Athens';") 
	     * Have to install timezones in mysql server 
	     */
	   	$this->query("SET time_zone = '+2:00';");
	   	
	    return $this->connection;
	}
	
	protected function _close(){
		global $CONFIG;
		
		if($CONFIG['debug'])
			$this->connection->close();
		else
			@$this->connection->close();
			
		return;
	}
	
	/*
	 * Need some fixing, in order to get protected from harmful queries. 
	 */
	protected function _query($query){
		global $CONFIG;
	    
		if($CONFIG['debug']){
			$results = $this->connection->query($query);
		}else
	        $results = $this->connection->query($query);
	    
		return $results;
	}

	public function db_fetch_object($query_result, $class_name = null, $params = null){
		if($class_name == null)
			return mysqli_fetch_object($query_result);
		else
			if($params == null)
				return mysqli_fetch_object($query_result, $class_name);
			else
				return mysqli_fetch_object($query_result, $class_name, $params);
	}
	
	public function db_fetch_array($query_result, $result_type = MYSQLI_BOTH ){
		return mysqli_fetch_array($query_result, $result_type);
	}
	
	public function db_escape_string($string){
		return $this->connection->real_escape_string($string);
	}
	
	public function db_num_rows($query_result){
		return mysqli_num_rows($query_result);
	}
	
	public function db_affected_rows(){
		return mysqli_affected_rows($this->connection);
	}
	
	public function db_error(){
		
		try{
			
		return mysqli_errno($this->connection);
		}catch(Exception $e){print_r($e);}
	}
};
?>