<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);

?>
<div id="direction"><a href="index.php">Αρχική</a> &nbsp;&gt;&gt;&nbsp; Πληροφορίες για την Βιβλιοθήκη</div>
<div class="content">
    <?php pages::get_body(2); ?>
</div>