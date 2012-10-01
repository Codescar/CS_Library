<?php

class backup {
   
   private $dumpfile;
   private $target_host;
   private $target_database;
   private $target_user;
   private $target_password;
   
   private $target_ftp_host;
   private $target_ftp_path;
   private $target_ftp_user;
   private $target_ftp_password;
   
   private $backuppath;
   
   public function __construct() 
   {
   		global $db_hostname, $db_username, $db_password, $db_name;
   		
		$this->target_host = $db_hostname;
		$this->target_database = $db_name;
		$this->target_user = $db_username;
		$this->target_password = $db_password;

		/*$this->target_ftp_host = $res[ftphost];
		$this->target_ftp_path = $res[ftppath];
		$this->target_ftp_user = $res[ftpuser];
		$this->target_ftp_password = $res[ftppass];*/
		
		$this->backuppath = "../dump_sql/";
   } 
	
	public function do_backup()
	{
		
		$this->dumpfile = $this->target_database ."_" .rand(111, 999) ."_" ."output.sql";
		
		$this->write_dump();
		
		//$this->log_backup();
		
		$this->reset_counters();

	}
	
	public function log_backup()
	{
		//$sql = "INSERT INTO logs (dbname, file_name, user_id) VALUES ('$this->target_database', '$this->dumpfile', '0')";
		//$res = $this->query($sql);
				
	}
	
	public function write_dump()
	{
		$output = $this->push_dump();
		
		$backupFile = $this->backuppath .$this->dumpfile;
		$fp = fopen($backupFile, 'w');
		fwrite($fp, $output);
		fclose($fp);
	}
	
	public function push_dump() 
	{ 
		$sql = null;
		$sql_structure = null;
		$sql_data = null;
		$iii = 0;
		
		mysql_connect($this->target_host, $this->target_user, $this->target_password); 
		mysql_select_db($this->target_database); 
		
		//$tables = mysql_list_tables($this->target_database); 
		
		while ($td = mysql_fetch_array($tables)) 
		{ 
			$table = $td[0]; 
			$r = mysql_query("SHOW CREATE TABLE `$table`"); 
			if ($r) 
			{ 
			if($iii++>0) $sql_structure .= ";\n\n";
				$d = mysql_fetch_array($r); 
				$sql_structure .= $d[1];
			} 
	 
				$insert_sql = null;
				$table_query = mysql_query("SELECT * FROM `$table`"); 
	 
				while ($fetch_row = mysql_fetch_row($table_query)) 
				{ 
					$insert_sql .= "INSERT INTO `$table` VALUES("; 
					$iiii = 0;
					foreach ($fetch_row as $qry) 
					{ 
					if ($iiii++>0) $insert_sql .=", ";
					$insert_sql .=  "'" . mysql_real_escape_string($qry) . "'";
					} 
					$insert_sql .= ");\n";
					
					$this->update_progress();
										
					
				} 
				$sql_data .= $insert_sql; 
		}
			 mysql_close ();
			 return $sql_structure . ";\n\n\n" . $sql_data; 
	} 
};

?>