<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
?>
<div class="content">
	<form action="index.php?view=results" method="get">
		<input type="hidden" name="show" value="results" />
		<input type="text" name="search" /><input type="submit" value="Αναζήτηση" />
		<br/>
		&nbsp;
		
		Αναζήτηση σε: <input type="checkbox" name="title" checked="checked"/>Τίτλο
		<input type="checkbox" name="writer_or" checked="checked"/>Συγγραφέα/Εκδόσεις
	</form>
</div>