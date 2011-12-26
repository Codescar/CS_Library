<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	if(!$user->is_logged_in()){
	?>
		<p>Πρέπει να συνδεθείτε πρώτα.</p>	
	<?php 
	}else{
?>
<div class="content">
	<div class="menu">
		<ul>
			<li><a href="?show=cp&more=info">Στοιχεία</a></li>
			<li><a href="?show=cp&more=history">Ιστορικό</a></li>
		</ul>
	</div><br />
	<?php 
	global $db;
	$db->connect();
	if(!isset($_GET['more']) || $_GET['more'] == "info"){
		$user->show_info();
	}
	elseif($_GET['more'] == "history"){
		$user->show_history();
	}elseif($_GET['more'] == "remove_request" && isset($_GET['id'])){
		$user->cansel_request(mysql_real_escape_string($_GET['id']));
	}
	$db->close();
	?>
</div>
<?php } ?>