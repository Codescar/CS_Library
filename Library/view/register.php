<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
?>
<div><h2>Εγγραφή χρήστη</h2><br/>

	<form action="" method="post" id="register-form">
	<label for="username">Όνομα Χρήστη: </label>
	<input type="text" name="username" id="username" /><br/>
	<label for="password">Κωδικός Πρόσβασης: </label>
	<input type="password" name="password" id="password" /><br/>
	
	<label for="password2">Επιβεβαίωση Κωδικού: </label>
	<input type="password" name="password2" id="password2" /><br/>
	
	<label for="mail">E-mail επικοινωνίας: </label>
	<input type="email" name="mail" id="mail" /><br/>
	
	<input type="submit" value="Υποβολή" class="submit"/>	
	</form>
</div>