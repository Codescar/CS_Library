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
	$books = $db->search($_GET['search'], $mode, $page*$items, $items);
?>
<div class="list">
	Αποτελέσματα αναζήτησης για "<?php echo $_GET['search']; ?>"<br/>
	
	&nbsp;
	<table>
	<tr>
		<th>ID</th><th>Τίτλος</th><th>Συγγραφέας/Εκδόσεις</th>
	</tr>
	<?php
		$i = $page * $items + 1;
		foreach($books as $row){
			echo "<tr><td>".
					$i++ 
					."</td><td>".
					$row['1']
					."</td><td>".
					$row['2'];
		}
		$db->__destruct();
	?>
	</table>
	<?php if($page >= 1) { ?>
	<span id="prev"><a href="index.php?show=results&search=<?php echo $_GET['search']; echo isset($_GET['title']) ? "&title=on" : ""; echo isset($_GET['writer_or']) ? "&writer_or=on" : ""; ?>&page=<?php echo $page - 1; ?>">< Πίσω</a></span>
	<?php } if($i > $page * $items + $items ) { ?>
	<span id="next"><a href="index.php?show=results&search=<?php echo $_GET['search']; echo isset($_GET['title']) ? "&title=on" : ""; echo isset($_GET['writer_or']) ? "&writer_or=on" : "";?>&page=<?php echo $page + 1; ?>">Μπροστά ></a></span>
	<?php } 
} ?>
</div>