<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	$db->connect();
	$books = $db->get_books("SELECT * FROM `{$db->table['booklist']}` ORDER BY id ASC LIMIT ".$page*$CONFIG['items_per_page'].", ".($page + 1) *$CONFIG['items_per_page']);
?>
<div id="direction"><a href="index.php">Αρχική</a> &nbsp;&gt;&gt;&nbsp; Κατάλογος βιβλίων</div>
<div class="content">
<?php list_books($books);
    $db->close();
?>
</div>