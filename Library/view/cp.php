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
	
	if(isset($_POST['hidden']) && $_POST['hidden'] == "codescar")
		$user->update();
	elseif(isset($_POST['hidden']) && $_POST['hidden'] == "file_upload"){
		if(!isset($_POST['profilePicture'])){
			/* end with an error ! */
		}
		if($avatar = upload_file())
			update_avatar_in_db($avatar, 1);
		else
			echo "<div class=\"error\">Upload failed!</div>";
		
	}elseif(isset($_POST['hidden']) && $_POST['hidden'] == "use_url"){
		if(!isset($_POST['profilePicture'])){
			/* Check if is a valid url! */
			/* end with an error ! */
		}
		update_avatar_in_db(mysql_real_escape_string($_POST['profilePicture']), 0);
	}
	elseif(isset($_POST['hidden']) && $_POST['hidden'] == "no_image"){
		update_avatar_in_db(null, -1);
		
	}elseif(isset($_GET['more']) && $_GET['more'] == "history"){
		$user->show_history();
	}elseif(isset($_GET['more']) && $_GET['more'] == "remove_request" && isset($_GET['id'])){
		$user->cansel_request(mysql_real_escape_string($_GET['id']));
	}elseif(isset($_GET['more']) && $_GET['more'] == "lended"){
		$user->show_lended();
	}
	if(!isset($_GET['more']) || $_GET['more'] == "info"){
		$user->show_info();
	?>
</div>
<?php } } 
function upload_file(){
	global $user;
	
	$upload_dir = "avatars/";
	$allowedExts = array("jpg", "jpeg", "gif", "png");
	$expl = explode(".",$_FILES["profilePicture"]["name"]);
	
	if ( isset($_FILES) 
			&& (($_FILES["profilePicture"]["type"] == "image/gif")
			|| ($_FILES["profilePicture"]["type"] == "image/jpeg")
			|| ($_FILES["profilePicture"]["type"] == "image/png")
			|| ($_FILES["profilePicture"]["type"] == "image/pjpeg"))
			&& ($_FILES["profilePicture"]["size"] < 1000000)
			&& in_array(end($expl), $allowedExts))
 	{
	  	
	    $file_name = $upload_dir . $user->id . "." . end($expl);
	    
	    if (file_exists($file_name))
	      	unlink($file_name);
	      	
	    if (!file_exists($file_name))
	      {
	      	if(!move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $file_name))
	      		return 0;
	      	else
	      		return $file_name;
	      	
	      }
	   	else
	    	return 0;
	}
	else
		echo "<div class=\"error\">Invalid file!</div>";
	return 0;
}

function get_avatar()
{
	global $db, $user;
	
	$user_id = $user->id;
	
	$query = "SELECT * FROM `{$db->table['avatars']}` WHERE `user_id` = '$user_id' LIMIT 1;";
	$result = $db->query($query);
	$res = mysql_fetch_array($result);
	
	if(mysql_num_rows($result) != 0 )
		return $res;
	
	
	return 0;
}
function update_avatar_in_db($avatar = null, $is_file = 0)
{
	global $db, $user;
	
	$user_id = $user->id;

	$res = get_avatar();
	
	if($res != 0 && $res['is_file'] == 1)
	{
		$file = $res['avatar_path'];
		if (file_exists($file))
	      	unlink($file);
	}
	else
		$file = 0;
	
	if($res == 0 && $is_file != -1)
		$query = "INSERT INTO `{$db->table['avatars']}` (`user_id`, `is_file`, `avatar_path`) VALUES ('$user_id', '$is_file', '$avatar');";
	elseif($is_file == -1)
		$query = "DELETE FROM `{$db->table['avatars']}` WHERE `user_id` = '$user_id' LIMIT 1;";
	else
		$query = "UPDATE `{$db->table['avatars']}` SET `is_file` = '$is_file', `avatar_path` = '$avatar' WHERE `user_id` = '$user_id' LIMIT 1;";
	
	$db->query($query);
	
	echo "<div class=\"success\">Your image have been updated!</div>";
	
	return $file;
}
?>