<?php
class book{
	private $id, $title, $author, $available, $description, $added;
	
	function __construct($id, $title, $author = "", $available = 1, $description = ""){
		
	}
}
function have_book_rq($book_id)
{
	global $db;
	$db->connect();
	$query = "	SELECT * FROM `requests` 
				WHERE `user_id` = '".$_SESSION['user_id']."'
				AND `book_id` = '$book_id'";
	$result = mysql_num_rows($db->query($query));
	$db->close();
	return $result;
}

function have_book($book_id)
{
	global $db;
	$db->connect();
	$query = "	SELECT * FROM `lend` 
				WHERE `user_id` = '".$_SESSION['user_id']."' 
				AND `book_id` = '$book_id'";
	$result = mysql_num_rows($db->query($query));
	$db->close();
	return $result;
}

?>