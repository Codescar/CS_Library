<?php
function connect(){
	global $db_hostname, $db_username, $db_password, $db_name;
	$con = mysql_connect($db_hostname, $db_username, $db_password) or die(mysql_error());
	mysql_select_db($db_name, $con) or die(mysql_error());
	mysql_query("SET NAMES 'utf8'", $con) or die(mysql_error());
	return $con;
}
?>