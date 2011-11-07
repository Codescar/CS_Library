<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	session_unset(); 
	session_destroy();
?>
<p><h2>Σύνδεση χρήστη</h2><br/>

	<form action="" method="post" id="login-form">
	<label for="username">Όνομα Χρήστη: </label>
	<input type="text" name="username" id="username" /><br/>
	<label for="password">Κωδικός Πρόσβασης: </label>
	<input type="password" name="password" id="password" /><br/>
	<input type="submit" value="Υποβολή" class="submit"/>	
	</form>
</p>