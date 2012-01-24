<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	
	$db->connect();
?>
<div class="content">
	<p >Καλώς ορίσατε στην ηλεκτρονική πύλη της δανειστική 
	βιβλιοθήκης του 15ου Συστήματος Προσκόπων Αθηνών.
	</p>
</div>
<?php 
	announcements::show();
	$db->close();
?>
