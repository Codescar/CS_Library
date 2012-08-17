	<p>Setting up additional parametrs</p><br/>
	<form action="?step=3" id="" method="post">
	<label for="admin_user">Admin Username: </label>
		<input type="text" name="admin_user" id="admin_user" value="Admin" required placeholder="The username of the administrator account"/><br/>
	<label for="admin_pass">Admin Password: </label>
		<input type="password" name="admin_pass" id="admin_pass" required placeholder="The password of the administrator account"/><br/>
	<label for="admin_pass2">Repeat Password: </label>
		<input type="password" name="admin_pass2" id="admin_pass2" required placeholder="Repeat the administrator password"/><br/>
	
	<label for="admin_email">Admin Email: </label>
		<input type="email" name="admin_email" id="admin_email" value="admin@example.com" required placeholder="The e-mail address of the administrator"/><br/>
	<label for="allow_admin">Allow Administration?: </label>
	<select id="allow_admin" name="allow_admin">
		<option value="true" selected="selected">True</option>
		<option value="false">False</option>
	</select><br/>
	<input type="hidden" name="next" value="3" />
	<button onclick="window.history.back()"><< Back</button>
	<input type="submit" value="Next >>" />
	</form> 