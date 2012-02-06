<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	$db->connect();
?>
<div id="direction"><a href="index.php">Αρχική</a></div>
<div class="content">
	<div class="book-title" style="color: white; font-size: 20px; line-height: 1.5em; border-radius: 4px;">
		Καλώς ορίσατε στην ηλεκτρονική πύλη της Εθνικής Βιβλιοθήκης Αθηνών.
	</div>
	<div id="announcements">
	<?php 
		announcements::show();
		$db->close();
	?>
	</div>
</div>