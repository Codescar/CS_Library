<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	$db->connect();
	$books = $db->get_books($page*$CONFIG['items_per_page'], $CONFIG['items_per_page'], "SELECT * FROM `{$db->table['booklist']}` ORDER BY id ASC LIMIT ");
?>
<div class="content">
    <div id="direction"><a href="index.php">Αρχική</a> &nbsp;&gt;&gt;&nbsp; Κατάλογος βιβλίων</div>
<?php list_books($books);
    $db->close(); 
?>
</div>