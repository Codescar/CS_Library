<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
?>
<div class="content">
	<div >Λάθος αίτημα...<br />
	<?php redirect("index.php", 3000) ?>
</div>