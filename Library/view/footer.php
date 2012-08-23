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
			echo "Page Created on {microtime(true) - $php_started} Seconds<br/>";
			echo "<br/>{$db->get_queries_num()} queries executed!<br/>";
			echo "In {$db->query_time} Seconds<br/>"
			echo "<!-- CONFIG VARIABLES: ";  printr($CONFIG); echo " -->";
		}
	?>
</footer>
</body>
</html>