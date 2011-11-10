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
	if(!isset($_GET['more'])){
		$user->show_info();
	}
	elseif($_GET['more'] == "change"){
		
	}
	elseif($_GET['more'] == "history"){
		$user->show_history();
	}
	
	?>
</div>