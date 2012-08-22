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
			echo '<br/>' . $db->get_queries_num() . ' queries executed!<br/>';
			//printr($CONFIG);
		}
	?>
</footer>
</body>
</html>