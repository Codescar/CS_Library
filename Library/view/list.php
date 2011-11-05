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
		$i = $page * $items + 1;
		
		foreach($books as $row){
			echo "<tr><td>
					". $i++ ."
					</td><td>";
			if($row['4'] != NULL && $row['4'] != ""){
				echo "<a href=\"index.php?show=book&id=".$row['0']."\">";
				$flag = 1;
			}
			echo 	$row['1'];
			if(isset($flag) && $flag == 1)
				echo "</a>";
			echo 	"</td>";
			if($row['2'] == 0)
				echo "<td>Δανεισμένο</td>";
			else
				echo "<td>Ελεύθερο</td>";
			echo "<td>". $row['3']."&nbsp;</td>";
		}
		$db->db_close()
	?>
	</table>
	<?php if($page >= 1) { ?>
	<span id="prev"><a href="index.php?show=list&page=<?php echo $page - 1; ?>">< Πίσω</a></span>
	<?php } if($i > $page * $items + $items ) { ?>
	<span id="next"><a href="index.php?show=list&page=<?php echo $page + 1; ?>">Μπροστά ></a></span>
	<?php } ?>
</div>