﻿<?php
class book{
	private $id, $title, $author, $available, $description, $added;
	
	function __construct($id, $title, $author = "", $available = 1, $description = ""){
		
	}
}

function list_books($books){
	global $CONFIG, $page, $user;
	?>
	<div class="list">
	<table>
	<tr>
		<th>ID</th><th>Τίτλος</th><th>Διαθεσιμότητα</th><th>Συγγραφέας/Εκδόσεις</th>
	</tr>
	<?php
		foreach($books as $row){
			if($row == $books['0']) continue;	
			echo "<tr>";
			echo "<!-- ID -->
				  <td>". $row['id'] ."</td>";
			echo "<!-- Title -->
				  <td class=\"title\">";
			echo "<a href=\"index.php?show=book&id=".$row['id']."\">";
			echo  $row['title'];
			echo "</a></td>";
			echo "<!-- Availability -->
				  <td class=\"avail\">";
			if($row['availability'] == 0)
				echo "Δανεισμένο";
			else
				echo "Διαθέσιμο";
			if($user->is_logged_in())
				echo " <a href=\"index.php?show=book&id=".$row['id']."\">Ζήτησέ το</a>";
			echo "</td>";
			
			echo "<!-- Writer -->
				  <td class=\"writer\">". $row['writer_or']."&nbsp;</td>";
		}
	?>
	</table>
	<?php if($page >= 1) { ?>
	<span id="prev"><a href="index.php?show=list&page=<?php echo $page - 1; ?>">&lt; Πίσω</a></span>
	<?php } if($books['0'] > $page * $CONFIG['items_per_page'] + $CONFIG['items_per_page'] ) { ?>
	<span id="next"><a href="index.php?show=list&page=<?php echo $page + 1; ?>">Μπροστά &gt;</a></span>
	<?php } ?>
	</div>
	<?php
}

function have_book_rq($book_id, $user_id){
	global $db;
	$query = "	SELECT * FROM `requests` 
				WHERE `user_id` = '".$user_id."'
				AND `book_id` = '$book_id'";
	$result = mysql_num_rows($db->query($query));
	return $result;
}

function have_book($book_id, $user_id){
	global $db;
	$query = "	SELECT * FROM `lend` 
				WHERE `user_id` = '".$user_id."' 
				AND `book_id` = '$book_id'";
	$result = mysql_num_rows($db->query($query));
	return $result;
}

function lend_request($id){
	global $db, $user;
	$query = "	INSERT INTO `requests` (`book_id`, `user_id`, `date`)
			 		VALUES ('$id', '".$user->id."', NOW());";
	$db->query($query);
	?><p>Το αίτημά σας κατοχυρώθηκε και θα εξεταστεί από το διαχειριστή.</p><?php 
}

?>