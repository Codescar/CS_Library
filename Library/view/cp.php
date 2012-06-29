<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	if(!$user->is_logged_in()){
	?>
		<div class="content"><p class="error">Πρέπει να συνδεθείτε πρώτα.</p></div>	
	<?php 
	} else {
	if(isset($_GET['more']) && $_GET['more'] == "lended"){ ?>
	<div id="direction"><a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;<a href="index.php?show=cp">Προφίλ χρήστη</a>&nbsp;&gt;&gt;&nbsp;Βιβλία που έχω τώρα</div>
	<?php }elseif(isset($_GET['more']) && $_GET['more'] == "history"){ ?>
	<div id="direction"><a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;<a href="index.php?show=cp">Προφίλ χρήστη</a>&nbsp;&gt;&gt;&nbsp;Ιστορικό δανεισμού</div>
	<?php }else{ ?>
	<div id="direction"><a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;Προφίλ χρήστη</div>
	<?php } ?>
<div class="content" >
	<!-- <div class="menu">
		<ul>
			<li><a href="?show=cp&more=info">Στοιχεία</a></li>
			<li><a href="?show=cp&more=history">Ιστορικό</a></li>
		</ul>
	</div> -->
	<?php 
	global $db;
	if(!isset($_GET['more']) || $_GET['more'] == "info"){
		$user->show_info();
	if(isset($_POST['hidden']) && $_POST['hidden'] == "codescar")
		$user->update();
	}elseif($_GET['more'] == "history"){
		$user->show_history();
	}elseif($_GET['more'] == "remove_request" && isset($_GET['id'])){
		$user->cansel_request(mysql_real_escape_string($_GET['id']));
	}elseif($_GET['more'] == "lended"){
		$user->show_lended();	
	}
	?>
</div>
<?php } ?>