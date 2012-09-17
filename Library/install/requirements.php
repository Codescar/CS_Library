<p>Welcome to CodeScar (CS) Library Installation</p>
<?php

	//Checking the php version
	echo "Checking your php version, you need php 5.2.0 or grater.... ";
	if (version_compare(phpversion(), "5.2.0", ">=")) {
		// you're on 5.2.0 or later
		echo "success, you have php ".phpversion();
	} else {
		// you're not
		echo "error, you have php ".phpversion();
	}
	
	echo "<br/>";
	
	check_module('mysql');
	check_module('mysqli');
	check_module('session');
	check_module('json');
	check_module('zip');
	
	function check_module($module){
		$load_ext = get_loaded_extensions();
		echo "<br/>Cheching if your php server have $module module..... ";
		if (in_array($module, $load_ext))
			echo "success<br/>";
		else
			echo "error, you need php ". phpverion($module). "<br/>";
		return;
	}
	?>