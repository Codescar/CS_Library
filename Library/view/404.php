<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
?>
<div class="content">
	<?php echo "<div class=\"error\">Λάθος αίτημα...<br />";
	redirect("index.php", 3000) ?>
</div>