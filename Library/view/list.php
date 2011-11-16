<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	$db->connect();
	$books = $db->get_books($page*$CONFIG['items_per_page'], $CONFIG['items_per_page']);
?>
<div class="content">
<?php list_books($books);
    $db->close(); 
?>
</div>