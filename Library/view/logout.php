<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	session_unset(); 
	session_destroy();
?>
<div class="content">
	<p>Επιτυχής αποσύνδεση...<br/>
	Αν δεν γίνεται ανακατεύθυνση, πιέστε <a href="<?php echo $url; ?>">εδώ</a>.</p>
	<script type="text/javascript">
		var t=setTimeout("window.location = '<?php echo $url; ?>'",3000);
	</script>
</div>