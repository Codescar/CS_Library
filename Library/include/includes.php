<?php
	global $db;
	require_once('include/db.php');
	require_once('model/db.php');
	$db = new Lbdb();
	$db->connect();
	require_once('include/config.php');
	
	require_once('model/session.php');
	require_once('model/user.php');
	require_once('model/admin.php');
		
	function load_model(){/* Models */
		require_once('model/book.php');
		require_once('model/message.php');
		require_once('model/announcements.php');
		require_once('model/pages.php');
		require_once('model/ckeditor/ckeditor.php');	/* Web-Based Text Editor Library */
		require_once('model/XPM/MAIL.php');				/* Mail Library */
	}
?>