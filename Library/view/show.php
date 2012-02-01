<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	$db->connect();
?>
<div class="content">
	<div id="direction"><a href="/index.php">Αρχική</a></div>
	<div>Καλώς ορίσατε στην ηλεκτρονική πύλη της δανειστική 
	βιβλιοθήκης του 15ου Συστήματος Προσκόπων Αθηνών.
	</div>
	<div id="announcements">
	<?php 
		announcements::show();
		$db->close();
	?>
	</div>
</div>
