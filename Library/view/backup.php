<?php
	if(!defined('VIEW_NAV') || !defined('VIEW_SHOW') || !$user->is_admin())
		die("Invalid request!");
	
	include('model/backup.php');
	?>
	<div >
		<a class="link-button" href="index.php?show=admin&more=backup">
			<button type="button" style="width: 140px;" class="index-button link box center bold">LIST</button>
		</a>
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
	if(isset($_GET['action']) && $_GET['action'] == "backup" && isset($_GET['do']) && $_GET['do'] == "backup"){
		if(isset($_GET['type']) ){
			$back = new backup;
			$back->do_backup($_GET['type']);
		}
	}elseif(!isset($_GET['action'])){
		?>
		<h3>Here are all your backups:</h3>
		<table>
		<tr>
			<th>Name</th><th>Size</th><th>Download</th><th>Restore</th><th>Delete</th>
		</tr>
		<?php 
			$back = new backup;
			$list = $back->backups_array();
			foreach($list as $file => $path){
			?>
			<tr>
				<td><?php echo $file; ?></td>
				<td><?php echo round(filesize($path)/(1024*1024), 3); ?> MB</td>
				<td><a href="<?php echo $CONFIG['url'] . $path; ?>" >Download</a></td>
				<td><a href="">Restore</a></td>
				<td>Delete</td>
			</tr>
			<?php 
			}
			?>
		</table>
		<?php 
	}elseif(isset($_GET['action']) && $_GET['action'] == "backup"){
		?>
		<h3>What do you want to backup?</h3>
		<a class="link-button" href="index.php?show=admin&more=backup&action=backup&do=backup&type=database">
			<button type="button" style="width: 140px;" class="index-button link box center bold">Database</button>
		</a>
		Backup Database (includes users, books, history, etc)
		<br/>
		<a class="link-button" href="index.php?show=admin&more=backup&action=backup&do=backup&type=files">
			<button type="button" style="width: 140px;" class="index-button link box center bold">Files</button>
		</a>
		Media Files (user images, book images, etc)
		<br/>
		<a class="link-button" href="index.php?show=admin&more=backup&action=backup&do=backup&type=all">
			<button type="button" style="width: 140px;" class="index-button link box center bold">All</button>
		</a>
		All Data (Database & Files)
		<?php 
		
	}elseif(isset($_GET['action']) && $_GET['action'] == "restore"){
		?>
		<h3>What do you want to restore?</h3>
		
		<?php 
	}else{
		
	}
?>