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
	global $db, $user;
	if(isset($_POST['hidden_update']) && $_POST['hidden_update'] == "codescar"){
		$name = $db->db_escape_string($_POST['name']);
		$surname = $db->db_escape_string($_POST['surname']);
		$email = $db->db_escape_string($_POST['email']);
		$born = $db->db_escape_string($_POST['born']);
		$phone = $db->db_escape_string($_POST['phone']);
		$new_pass = $db->db_escape_string($_POST['n_pass']);
		$r_new_pass = $db->db_escape_string($_POST['r_n_pass']);
		$user_id = $user->id;
		if($user->is_admin())
			$user_id = $db->db_escape_string($_POST['hidden_treasure']);
		$user->update($user_id, $name, $surname, $born, $phone, $email, $new_pass, $r_new_pass);
	}elseif(isset($_POST['hidden']) && $_POST['hidden'] == "file_upload"){
		if(!isset($_FILES['profilePicture'])){
			echo "<div class=\"error\">Σφάλμα μεταφόρτωσης, παρακαλώ προσπαθήστε ξανά!</div>";
			redirect("index.php?show=cp", 1500);
		}
		elseif($avatar = upload_file($_FILES["profilePicture"], "avatars", "image", $user->id, true, true)){
			if($avatar === false)
				echo "<div class=\"error\">Η Εικόνα δεν μπόρεσε να αποθηκευτεί! $avatar</div>";
			if(update_avatar_in_db($avatar, 1) != 0)
				echo "<div class=\"success\">Η εικόνα προφίλ σας ανανεώθηκε!</div>";
		}
	}elseif(isset($_POST['hidden']) && $_POST['hidden'] == "use_url"){
		if(isImage($_POST['profilePicture']))
			update_avatar_in_db($db->db_escape_string($_POST['profilePicture']), 0);
		else
			echo "<div class=\"error\">Λάθος URL!</div>";
	}elseif(isset($_POST['hidden']) && ($_POST['hidden'] == "no_image")){
		update_avatar_in_db(null, -1);
	}

	if(!isset($_GET['more']) || $_GET['more'] == "info"){
		$user_info = user::show_info($user->id);
		render_template("userControlPanel.php");
	}elseif($_GET['more'] == "history"){
		if($user->is_admin() && !empty($_GET['id']))
			$user->show_history($db->db_escape_string($_GET['id']));
		else
			$user->show_history();
	}elseif($_GET['more'] == "lended"){
		if($user->is_admin() && !empty($_GET['id']))
			$user->show_lended($db->db_escape_string($_GET['id']));
		else
			$user->show_lended();
	}elseif(isset($_GET['id']) && ($_GET['more'] == "remove_request")){
		$user->cansel_request($db->db_escape_string($_GET['id']));
	}else{
		echo "<div class=\"error\">Λάθος αίτημα<br />";
		redirect("index.php?show=cp"); 
	} ?>
</div>
<?php }  ?>