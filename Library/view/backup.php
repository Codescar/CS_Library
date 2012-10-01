<?php
	if(!defined('VIEW_NAV') || !defined('VIEW_SHOW') || !$user->is_admin())
		die("Invalid request!");

	?>
	<div >
		<a class="link-button" href="index.php?show=admin&more=backup&action=backup">
			<button type="button" style="width: 140px;" class="index-button link box center bold">BACKUP</button>
		</a>
		<a class="link-button" href="index.php?show=admin&more=backup&action=restore">
			<button type="button" style="width: 140px;" class="index-button link box center bold">RESTORE</button>
		</a>
		<a class="link-button" href="index.php?show=admin&more=maintenance">
			<button type="button" style="width: 140px;" class="index-button link box center bold">MAINTENANCE</button>
		</a>
	</div>
	<?php
	if(isset($_GET['action']) && $_GET['action'] == "backup"){
		?>
		Backup Database (includes users, books, history, etc)
		<a class="link-button" href="index.php?show=admin&more=backup&action=backup&do=backup&type=database">
			<button type="button" style="width: 140px;" class="index-button link box center bold">HERE</button>
		</a><br/>
		Media Files (user images, book images, etc)
		<a class="link-button" href="index.php?show=admin&more=backup&action=backup&do=backup&type=media">
			<button type="button" style="width: 140px;" class="index-button link box center bold">HERE</button>
		</a><br/>
		<?php 
		include('model/backup.php');
		$back = new backup;
		$back->do_backup();
	}elseif(isset($_GET['action']) && $_GET['action'] == "restore"){
		
	}else{
		
	}
?>