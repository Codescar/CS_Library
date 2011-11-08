<!DOCTYPE html> 
<html>
<head>
<title>CodeScar - Library Installation - Step 2</title>
</head>
<body>
<div>
	<p>Setting up basic parametrs</p><br/>
	<form action="?step=0" id="" method="post">
	<label for="title">Title: </label>
	<input type="text" name="title" id="title" /><br/>
	<label for="url">URL: </label>
	<input type="text" name="url" id="url" /><br/>
	<label for="items">Items per page: </label>
	<input type="text" name="items" id="items" value="20"/><br/>
	<label for="register">Allow Register?: </label>
	<select id="register" name="register">
		<option value="true" selected="selected">True</option>
		<option value="false">False</option>
	</select><br/>
	<input type="hidden" name="next" value="2" />
	<input type="submit" value="Next" />
	</form> 
</div>
</body>
</html>