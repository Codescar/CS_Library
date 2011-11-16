<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
?>
<div class="content">
	<div class="menu">
		<ul>
			<li><a href="?show=cp&more=info">Info</a></li>
			<li><a href="?show=cp&more=change">Change Info</a></li>
			<li><a href="?show=cp&more=history">History</a></li>
		</ul>
	</div><br />
	<?php 
	global $db;
	$db->connect();
	if(!isset($_GET['more']) || $_GET['more'] == "info"){
		$user->show_info();
	}
	elseif($_GET['more'] == "change"){
	    $user->change_info();
	}
	elseif($_GET['more'] == "history"){
		$user->show_history();
	}
	$db->close();
	?>
</div>