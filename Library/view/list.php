<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	$db->connect();
	$books = $db->get_books($page*$CONFIG['items_per_page'], $CONFIG['items_per_page'], "SELECT * FROM `{$db->table['booklist']}` ORDER BY id ASC LIMIT ");
?>
<div id="direction"><a href="index.php">Αρχική</a> &nbsp;&gt;&gt;&nbsp; Κατάλογος βιβλίων</div>
<div class="content">
<?php list_books($books);
    $db->close();
?>
</div>
<?php include 'right_sidebar.php'; ?>