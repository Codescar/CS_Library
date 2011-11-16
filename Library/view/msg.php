<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	if(!$user->is_logged_in()){
	?>
		<p>Πρέπει να συνδεθείτε πρώτα.</p>	
	<?php 
	}else{
?>
<div class="content">
	<p>Υπο κατασκευή...</p>
</div>
<?php } ?>