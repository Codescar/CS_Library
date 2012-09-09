	<?php 
	//let's check if the database is accessable
	require_once('../model/db.php');
	switch($_POST['db_driver']){
		case 'MySQL':	require_once('../model/dbDrivers/MySQLDriver.php');
						break;
		case 'MySQLi':	require_once('../model/dbDrivers/MySQLiDriver.php');
						break;
	}
	
	$db = new Lbdb();

	print_r($db->connect());

	
	$db->close();
	?>
	<p>Setting up basic parametrs</p><br/>
	<form action="?step=2" id="" method="post">
	<label for="title">Title: </label>
		<input type="text" name="title" id="title" required 
		placeholder="Enter the title of your library"/><br/>
	<label for="url">URL: </label>
		<input type="url" name="url" id="url" 
		value="<?php echo substr("http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'], 0, 
		strlen("http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']) - strlen("install/index.php")); ?>" required 
		placeholder="Enter the url of the installation"/><br/>
	<label for="path">Path: </label>
		<input type="text" name="path" id="path" required 
		value="<?php echo substr($_SERVER["SCRIPT_FILENAME"], 0, 
		strlen($_SERVER["SCRIPT_FILENAME"]) - strlen("install/index.php"));; ?>"
		placeholder="Enter the path of the installation folder on the server"/><br/>
	<label for="items">Items per page: </label>
		<input type="text" name="items" id="items" value="5" required 
		placeholder="The number of the items that will be displayed in the pages"/><br/>
	<label for="register">Allow Register?: </label>
	<select id="register" name="register">
		<option value="true" selected="selected">True</option>
		<option value="false">False</option>
	</select><br/>
	<input type="hidden" name="next" value="2" />
	<button onclick="window.history.back()"><< Back</button>
	<input type="submit" value="Next >>" />
	</form> 