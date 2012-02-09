<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	session_unset(); 
	session_destroy();
?>
<div id="direction"><a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;Έξοδος</div>
<div class="content">
	<br />
	<div class="success">Επιτυχής αποσύνδεση...<br/>
	Αν δεν γίνεται ανακατεύθυνση, πιέστε <a href="<?php echo $url; ?>">εδώ</a>.</div>
	<script type="text/javascript">
		var t=setTimeout("window.location = '<?php echo $url; ?>'",2000);
	</script>
	<br />
</div>