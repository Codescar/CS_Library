<?php 
	if(!defined('VIEW_SHOW'))
		die("Invalid request!");
	define('VIEW_FOOTER', true);
	global $db, $CONFIG;
	$db->close();
?>
</div>
<hr/>
<footer>
	<a href="http://codescar.eu">CodeScar</a> Library Project<br />
	<a href="?show=about">About</a>
	<?php 
		if($CONFIG['debug']){
			global $php_started;
			echo "<br/>Page Created on ". ((float)(microtime(true) - $php_started)) ." Seconds<br/>";
			echo "{$db->get_queries_num()} queries executed!<br/>";
			echo "In {$db->query_time} Seconds<br/>";
			echo "\n<!-- CONFIG VARIABLES: ";  print_r($CONFIG); echo " -->\n";
		}
	?>
</footer>
</body>
</html>