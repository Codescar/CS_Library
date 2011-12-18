<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	
?>
<div class="content">
	<h2>Feedback Form</h2><br />
	
	<form action="" method="form" id="" >
	<label for="">Type: </label>
	<select name="" id="">
		<option value="Bug">Bug</option>
		<option value="Other">Other</option>
	</select><br />
	<label for="">Your E-mail: </label><input type="email" name="" id="" /><br />
	<label for="">Text: </label>
	<textarea id="" name="" rows="10" /></textarea><br />
	<input type="submit" value="Submit" />
	</form>
</div>