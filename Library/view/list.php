<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	$db->db_connect();
	$books = $db->get_books($page*$items, $items);

?>
<div class="list">
	<table>
	<tr>
		<th>ID</th><th>Τίτλος</th><th>Διαθεσιμότητα</th><th>Συγγραφέας/Εκδόσεις</th>
	</tr>
	<?php
		foreach($books as $row){
			
			echo "<tr>";
			echo "<!-- ID -->
				  <td>". $row['0'] ."</td>";
			echo "<!-- Title -->
				  <td>";
			if($row['4'] != NULL && $row['4'] != ""){
				echo "<a href=\"index.php?show=book&id=".$row['0']."\">";
				$flag = 1;
			}
			echo  $row['1'];
			if(isset($flag) && $flag == 1)
				echo "</a></td>";
			else
				echo "</td>";
			
			echo "<!-- Availability -->
				  <td>";
			if($row['2'] == 0)
				echo "Δανεισμένο";
			else
				echo "Ελεύθερο";
			echo "</td>";
			
			echo "<!-- Writer -->
				  <td>". $row['3']."&nbsp;</td>";
		}
		$db->db_close()
	?>
	</table>
	<?php if($page >= 1) { ?>
	<span id="prev"><a href="index.php?show=list&page=<?php echo $page - 1; ?>">&lt; Πίσω</a></span>
	<?php } if($i > $page * $items + $items ) { ?>
	<span id="next"><a href="index.php?show=list&page=<?php echo $page + 1; ?>">Μπροστά &gt;</a></span>
	<?php } ?>
</div>