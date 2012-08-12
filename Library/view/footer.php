<?php 
	if(!defined('VIEW_SHOW'))
		die("Invalid request!");
	define('VIEW_FOOTER', true);
	$db->close();
?>
</div>
<hr/>
<footer>
	<a href="http://codescar.eu">CodeScar</a> Library Project<br />
	<a href="?show=about">About</a>
	<?php 
		global $db;
		if($CONFIG['debug'])
			echo '<br/>' . $db->get_queries_num() . ' queries executed!<br/>';
	?>
</footer>
</body>
</html>