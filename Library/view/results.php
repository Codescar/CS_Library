<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);

if(!isset($_GET['search']) || $_GET['search'] == "" || (!isset($_GET['title']) && !isset($_GET['writer_or'])))
{
	echo "Λάθος αναζήτηση";
}
else {
	$link = connect();
	$s = mysql_real_escape_string(trim(mysql_real_escape_string($_GET['search'])));
	$query = "SELECT * FROM `booklist` WHERE ";
	if(isset($_GET['title']))
		$query .= " booklist.title LIKE \"%$s%\" OR ";
	if(isset($_GET['writer_or']))
		$query .= " booklist.writer_or LIKE \"%$s%\" ";
	else
		$query .= " 1 = 2 ";
	$query .= "ORDER BY booklist.id ASC LIMIT ".$page*$items.",". $items ." ;";
	$results = mysql_query($query, $link) or die(mysql_error());
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
		while($row = mysql_fetch_row($results)){
			echo "<tr><td>".
					$i++ 
					."</td><td>".
					$row['1']
					."</td><td>".
					$row['2'];
		}
		mysql_close($link);
	?>
	</table>
	<?php if($page >= 1) { ?>
	<span id="prev"><a href="index.php?show=results&search=<?php echo $_GET['search']; echo isset($_GET['title']) ? "&title=on" : ""; echo isset($_GET['writer_or']) ? "&writer_or=on" : ""; ?>&page=<?php echo $page - 1; ?>">< Πίσω</a></span>
	<?php } if($i > $page * $items + $items ) { ?>
	<span id="next"><a href="index.php?show=results&search=<?php echo $_GET['search']; echo isset($_GET['title']) ? "&title=on" : ""; echo isset($_GET['writer_or']) ? "&writer_or=on" : "";?>&page=<?php echo $page + 1; ?>">Μπροστά ></a></span>
	<?php } 
} ?>
</div>