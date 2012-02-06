<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	$db->connect();
?>
<div id="direction"><a href="index.php">Αρχική</a>&nbsp;---&nbsp;Καλώς ορίσατε στην ηλεκτρονική πύλη της Εθνικής Βιβλιοθήκης Αθηνών.</div>
<div class="content">
	<div id="announcements">
	<?php 
		announcements::show();
		$db->close();
	?>
	</div>
</div>