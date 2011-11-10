<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	if(!isset($_GET['id']))
		die("Λάθος αίτημα");
	$db->connect();
	$id = mysql_real_escape_string($_GET['id']);
	$results = $db->query("SELECT * FROM `booklist` WHERE `id` = '$id' LIMIT 1;");
	if(mysql_num_rows($results) == 0)
		die("Λάθος αίτημα");
	$results = mysql_fetch_array($results);
?>
<div>
	<h2><?php echo $results[1]; ?></h2>
	<h3><?php echo $results[3]; ?></h3>
	<p>Διαθεσιμότητα: <?php echo ($results[2] == 1) ? "<span class=\available\">Διαθέσιμο</span>" : "<span class=\"no-available\">Μη Διαθέσιμο</span>"; ?><br/>
	<?php echo ($results[4] == null) ? "Περιγραφή: " . $results[4] : "Χωρίς Περιγραφή.";?></p>
</div>

<?php $db->close(); ?>