<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	if(!$user->is_logged_in()){
		echo "<div class=\"content\"><div class=\"error\">Πρέπει να συνδεθείτε πρώτα.<br />";
		redirect("index.php?show=login");
	} else {
	if(isset($_GET['more']) && $_GET['more'] == "lended"){ ?>
	<div id="direction"><a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;<a href="index.php?show=cp">Προφίλ χρήστη</a>&nbsp;&gt;&gt;&nbsp;Βιβλία που έχω τώρα</div>
	<?php }elseif(isset($_GET['more']) && $_GET['more'] == "history"){ ?>
	<div id="direction"><a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;<a href="index.php?show=cp">Προφίλ χρήστη</a>&nbsp;&gt;&gt;&nbsp;Ιστορικό δανεισμού</div>
	<?php }else{ ?>
	<div id="direction"><a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;Προφίλ χρήστη</div>
	<?php } ?>
<div class="content" >
	<?php 
	global $db;
	
	if(!isset($_GET['more']) || $_GET['more'] == "info"){
		$user_info = user::show_info($user->id);
		render_template("userControlPanel.php");
	}
	elseif(isset($_POST['hidden']) && $_POST['hidden'] == "codescar"){
		$user->update();
	}elseif(isset($_POST['hidden']) && $_POST['hidden'] == "file_upload"){
		if(!isset($_POST['profilePicture'])){
			/* end with an error ! */
		}
		if($avatar = upload_file())
			update_avatar_in_db($avatar, 1);
		else
			echo "<div class=\"error\">Upload failed!</div>";	
	}elseif(isset($_POST['hidden']) && $_POST['hidden'] == "use_url"){
		if(isImage($_POST['profilePicture']))
			update_avatar_in_db(mysql_real_escape_string($_POST['profilePicture']), 0);
		else
			echo "<div class=\"error\">Invalid URL!</div>";
	}elseif(isset($_POST['hidden']) && ($_POST['hidden'] == "no_image")){
		update_avatar_in_db(null, -1);
	}elseif(isset($_GET['more']) && $_GET['more'] == "history"){
		$user->show_history();
	}elseif(isset($_GET['more']) && isset($_GET['id']) && ($_GET['more'] == "remove_request")){
		$user->cansel_request(mysql_real_escape_string($_GET['id']));
	}elseif(isset($_GET['more']) && $_GET['more'] == "lended"){
		$user->show_lended();
	}else{
		echo "<div class=\"error\">Λάθος αίτημα<br />";
		redirect("index.php?show=cp"); 
	} ?>
</div>
<?php }  ?>