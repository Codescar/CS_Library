<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);

if(!isset($_GET['search']) || $_GET['search'] == "" || (!isset($_GET['title']) && !isset($_GET['writer_or'])))
{
	echo "Λάθος αναζήτηση";
}
else {
	if(isset($_GET['title']))
		$mode = 1;
	else if(isset($_GET['writer_or']))
		$mode = 2;
	else if(isset($_GET['writer_or']) && isset($_GET['title']))
		$mode = 3;
	$db->connect();
	$books = $db->search($_GET['search'], $mode, $page*$CONFIG['items_per_page'], $CONFIG['items_per_page']);
?>
<div class="list">
	Αποτελέσματα αναζήτησης για "<?php echo $_GET['search']; ?>"<br/>
	
	&nbsp;
	<table>
	<tr>
		<th>ID</th><th>Τίτλος</th><th>Διαθεσιμότητα</th><th>Συγγραφέας/Εκδόσεις</th>
	</tr>
	<?php
		$x = 0;
		foreach($books as $row){
			$x++;
			if($row == $books['0']) continue;	
			echo "<tr>";
			echo "<!-- ID -->
				  <td>". $row['0'] ."</td>";
			echo "<!-- Title -->
				  <td class=\"title\">";
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
				echo "Διαθέσιμο";
			echo "</td>";
			
			echo "<!-- Writer -->
				  <td>". $row['3']."&nbsp;</td>";
		}
		$db->close();
	?>
	</table>
	<?php if($page >= 1) { ?>
	<span id="prev"><a href="index.php?show=results&search=<?php echo $_GET['search']; echo isset($_GET['title']) ? "&title=on" : ""; echo isset($_GET['writer_or']) ? "&writer_or=on" : ""; ?>&page=<?php echo $page - 1; ?>">&lt; Πίσω</a></span>
	<?php } if($x >= $CONFIG['items_per_page']) if($books['0'] > $page * $CONFIG['items_per_page'] + $CONFIG['items_per_page'] ) { ?>
	<span id="next"><a href="index.php?show=results&search=<?php echo $_GET['search']; echo isset($_GET['title']) ? "&title=on" : ""; echo isset($_GET['writer_or']) ? "&writer_or=on" : "";?>&page=<?php echo $page + 1; ?>">Μπροστά &gt;</a></span>
	<?php } 
} ?>
</div>