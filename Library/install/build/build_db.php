<?php

$sql_dir = '../sql/';
require_once('../../include/db.php');

require_once('../../model/db.php');

$db = new Lbdb;

$db->connect();

$sql_dir_h = opendir($sql_dir);

while($sql_file = readdir($sql_dir_h))
{
	if( end(explode('.', $sql_file)) != "sql" )
		continue;
		
	echo "Executing $sql_file ... "; flush();
	
	$queries = explode(';', file_get_contents($sql_dir.$sql_file));
	
	if(count($queries) > 1)
		foreach($queries as $query)
			$db->query($query);
	else
		$db->query(file_get_contents($sql_dir.$sql_file));
	
	echo "DONE<br/>"; flush();
}

closedir($sql_dir_h);

$db->close();

?>