<!DOCTYPE html> 
<html>
<head>
<title>CodeScar - Library Installation - Step 1</title>
</head>
<body>
<div>
	<p>Welcome to CodeScar (CS) Library Installation<br/>
	Setting up Database Informations...</p><br/>
	<form action="?step=0" id="" method="post">
	<label for="db_host">Database Hostname/IP: </label>
	<input type="text" name="db_host" id="db_host" /><br/>
	<label for="db_user">Database User: </label>
	<input type="text" name="db_user" id="db_user" /><br/>
	<label for="db_pass">Database Password: </label>
	<input type="text" name="db_pass" id="db_pass" /><br/>
	<label for="db_name">Database Name: </label>
	<input type="text" name="db_name" id="db_name" /><br/>
	<input type="hidden" name="next" value="1" />
	<input type="submit" value="Next" />
	</form> 
</div>
</body>
</html>