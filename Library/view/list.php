<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
$link = connect();
$query = "SELECT * FROM booklist ORDER BY booklist.id ASC LIMIT ".$page*$items.",". $items ." ;";
$results = mysql_query($query, $link) or die(mysql_error());
?>
<div class="list">
	<table>
	<tr>
		<th>ID</th><th>Τίτλος</th><th>Συγγραφέας/Εκδόσεις</th><th>Διαθεσιμότητα</th>
	</tr>
	<?php
		$i = $page * $items + 1;
		while($row = mysql_fetch_row($results)){
			echo "<tr><td>
					". $i++ ."
					</td><td>";
			if($row['4'] != NULL && $row['4'] != ""){
				echo "<a href=\"index.php?show=book&id=".$row['0']."\">";
				$flag = 1;
			}
			echo 		$row['1'];
			if($flag == 1)
				echo "</a>";
			echo 	"</td><td>
					". $row['2'];
			if($row['5'] == 1)
				echo "<td>Δανεισμένο</td>";
			else
				echo "<td>Ελεύθερο</td>";
		}
		mysql_close($link);
	?>
	</table>
	<?php if($page >= 1) { ?>
	<span id="prev"><a href="index.php?show=list&page=<?php echo $page - 1; ?>">< Πίσω</a></span>
	<?php } if($i > $page * $items + $items ) { ?>
	<span id="next"><a href="index.php?show=list&page=<?php echo $page + 1; ?>">Μπροστά ></a></span>
	<?php } ?>
</div>