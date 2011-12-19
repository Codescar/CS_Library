<?php
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
				echo "<span class=\"avail_no\">Δανεισμένο</span>";
			else
				echo "<span class=\"avail\">Διαθέσιμο</span>";
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
	$query = "	SELECT * FROM `{$db->table["requests"]}`
				WHERE `{$db->columns["requests"]["user_id"]}` = '".$user_id."'
				AND `{$db->columns["requests"]["book_id"]}` = '$book_id'";
	$result = mysql_num_rows($db->query($query));
	return $result;
}

function have_book($book_id, $user_id){
	global $db;
	$query = "	SELECT * FROM `{$db->table["lend"]}` 
				WHERE `{$db->columns["lend"]["user_id"]}` = '".$user_id."' 
				AND `{$db->columns["lend"]["book_id"]}` = '$book_id'";
	$result = mysql_num_rows($db->query($query));
	return $result;
}

function lend_request($id){
	global $db, $user;
	$query = "	INSERT INTO `{$db->table["requests"]}` (
					`{$db->columns["requests"]["book_id"]}`, 
					`{$db->columns["requests"]["user_id"]}`, 
					`{$db->columns["requests"]["date"]}`)
			 		VALUES ('$id', '".$user->id."', NOW());";
	$db->query($query);
	?><p>Το αίτημά σας κατοχυρώθηκε και θα εξεταστεί από το διαχειριστή.</p><?php 
}

function book_avail($book_id){
	global $db;
	$query = "	SELECT `{$db->columns["booklist"]["availability"]}` from `{$db->table["booklist"]}` 
				WHERE `{$db->columns["booklist"]["id"]}` = '$book_id'";
	$res = $db->query($query);
	return mysql_fetch_object($res)->{$db->columns["booklist"]["availability"]};
	
}
?>