	<p>Welcome to CodeScar (CS) Library Installation<br/>
	Setting up Database Informations...</p><br/>
	<form action="?step=1" id="" method="post">
		<label for="db_host">Database Hostname/IP: </label>
			<input type="text" name="db_host" id="db_host" value="localhost" required placeholder="The domain of your MySQL Server"/><br/>
		<label for="db_user">Database User: </label>
			<input type="text" name="db_user" id="db_user" value="root" required placeholder="The username of the MySQL user"/><br/>
		<label for="db_pass">Database Password: </label>
			<input type="password" name="db_pass" id="db_pass" required placeholder="The password of the MySQL user"/><br/>
		<label for="db_name">Database Name: </label>
			<input type="text" name="db_name" id="db_name" value="cs_library" required placeholder="The name of the MySQL Database"/><br/>
		<label for="db_pref">Database Name: </label>
			<input type="text" name="db_pref" id="db_pref" value=""/><br/>
		
		<input type="hidden" name="next" value="1" />
			<input type="submit" value="Next >>" />
	</form> 