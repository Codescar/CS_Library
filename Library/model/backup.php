<?php

class backup {
   
   private $dumpfile; 
   private $path = array("avatars/", "book_images/", "include/"); 
   private $backuppath;
   
   public function __construct() 
   {

		$this->backuppath = "backups/";
   } 
	
	public function do_backup($type = "all")
	{
		if($type == "all" || $type == "database")
		{
			global $db_name; 
			$this->dumpfile = $db_name ."_" . date('Y.m.d_h.i') ."_" ."BACKUP.sql";
			$this->write_dump();
		}
		if($type == "all" || $type == "files")
		{
			$count = 0;
			foreach($this->path as $dir)
				$count += count(glob($dir."*", GLOB_MARK));
						
			$this->Zip($this->path, $this->backuppath ."Files_" . date('Y.m.d_h.i') ."_" ."BACKUP.zip");
		}
		$this->log_backup();
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
		if(!is_dir($this->backuppath))
			mkdir($this->backuppath);
		$fp = fopen($backupFile, 'w');
		fwrite($fp, $output);
		fclose($fp);
	}
	
	public function push_dump() 
	{ 
		global $db, $db_hostname, $db_username, $db_password, $db_name;
		
		$sql = null;
		$sql_structure = null;
		$sql_data = null;
		$iii = 0;
		
		$head = "-- SQL Data For CodeScar Library Project\n-- Generated on " . date('d-m-Y h:i') ."\n-- http://projects.codescar.eu \n\n";
		
		foreach($db->table as $table) 
		{ 
			$r = $db->query("SHOW CREATE TABLE `$table`;"); 
			if ($r) 
			{ 
				if($iii++>0) 
					$sql_structure .= ";\n\n";
				
				$d = $db->db_fetch_array($r); 
				$sql_structure .= $d[1];
			}
				$insert_sql = null;
				$table_query = $db->query("SELECT * FROM `$table`;"); 
				
				while($table_query && $fetch_row = $db->db_fetch_array($table_query)) 
				{ 
					$insert_sql .= "INSERT INTO `$table` VALUES("; 
					$iiii = 0;
					foreach ($fetch_row as $qry) 
					{ 
						if ($iiii++>0) 
							$insert_sql .=", ";
					
						$insert_sql .=  "'" . $db->db_escape_string($qry) . "'";
					}
					$insert_sql .= ");\n";
					$this->update_progress();
				}
				$sql_data .= $insert_sql; 
		}
			 
		return $head . $sql_structure . ";\n\n\n" . $sql_data; 
	}
	
	function update_progress(){
		//TODO
	}
	
	function Zip($source_arr, $destination)
	{
		if (!extension_loaded('zip')) 
			return false;
		
		foreach($source_arr as $source)
			if(!file_exists($source))
				return false;
	
		$zip = new ZipArchive();
		if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
			return false;
		}
		foreach($source_arr as $source){
			$source = str_replace('\\', '/', realpath($source));
	
			if (is_dir($source) === true)
			{
				$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);
		
				foreach ($files as $file)
				{
					$file = str_replace('\\', '/', $file);
		
					// Ignore "." and ".." folders
					if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
						continue;
		
					$file = realpath($file);
		
					if (is_dir($file) === true)
					{
						$zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
					}
					else if (is_file($file) === true)
					{
						$zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
					}
				}
			}
			else if (is_file($source) === true)
			{
				$zip->addFromString(basename($source), file_get_contents($source));
			}
		}
		return $zip->close();
	}
	
	function backups_array(){
		$ret = array();
		$handler = opendir($this->backuppath);
		while($file = readdir($handler)){
			if($file == "." || $file == "..")
				continue;
			$ret = array_merge($ret, array($file => $this->backuppath.$file));
		}
		
		closedir($handler);
		return $ret;
	}
};

?>