<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	if(!$user->is_logged_in() || !$user->is_admin()){
	?>
		<p>Δεν είστε διαχειριστής.</p>	
	<?php 
	}else{
?>
<div class="content">
	<div class="menu">
		<ul>
			<li><a href="?show=admin&more=info">Info</a></li>
			<li><a href="?show=admin&more=statistics">Statistics</a></li>
			<li><a href="?show=admin&more=history">History</a></li>
			<li><a href="?show=admin&more=new_user">Create User</a></li>
			<li><a href="?show=admin&more=options">Options</a></li>
		</ul>
	</div><br />
	<?php 
	global $db;
	$db->connect();
	if(!isset($_GET['more']) || $_GET['more'] == "info"){
		
	}elseif($_GET['more'] == "statistics"){
	    
	}elseif($_GET['more'] == "history"){
		
	}elseif($_GET['more'] == "new_user"){
		
	}elseif($_GET['more'] == "options"){
		
	}
	$db->close();
	?>
</div>
<?php } ?>