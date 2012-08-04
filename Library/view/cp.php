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
	elseif(isset($_POST['hidden']) && $_POST['hidden'] == "file_upload"){
		if(!isset($_POST['profilePicture'])){
			/* end with an error ! */
		}
		upload_file();
	}elseif(isset($_POST['hidden']) && $_POST['hidden'] == "use_url"){
		if(!isset($_POST['profilePicture'])){
			/* Check if is a valid url! */
			/* end with an error ! */
		}
	}
	elseif(isset($_POST['hidden']) && $_POST['hidden'] == "no_image"){
		
	}elseif(isset($_GET['more']) && $_GET['more'] == "history"){
		$user->show_history();
	}elseif(isset($_GET['more']) && $_GET['more'] == "remove_request" && isset($_GET['id'])){
		$user->cansel_request(mysql_real_escape_string($_GET['id']));
	}elseif(isset($_GET['more']) && $_GET['more'] == "lended"){
		$user->show_lended();	
	}
	?>
</div>
<?php } } 
function upload_file(){
	/*$allowedExts = array("jpg", "jpeg", "gif", "png");
	$extension = end(explode(".", $_FILES["profilePicture"]["name"]));
	if ((($_FILES["profilePicture"]["type"] == "image/gif")
	|| ($_FILES["profilePicture"]["type"] == "image/jpeg")
	|| ($_FILES["profilePicture"]["type"] == "image/pjpeg"))
	//&& ($_FILES["profilePicture"]["size"] < 20000)
	//&& in_array($extension, $allowedExts)
	)
  {
  	if ($_FILES["file"]["error"] > 0){
    	echo "Return Code: " . $_FILES["profilePicture"]["error"] . "<br />";
    }
  	else
    {
	    echo "Upload: " . $_FILES["profilePicture"]["name"] . "<br />";
	    echo "Type: " . $_FILES["profilePicture"]["type"] . "<br />";
	    echo "Size: " . ($_FILES["profilePicture"]["size"] / 1024) . " Kb<br />";
	    echo "Temp file: " . $_FILES["profilePicture"]["tmp_name"] . "<br />";

    	if (file_exists("../avatars/" . $_FILES["profilePicture"]["name"]))
      	{
      		echo $_FILES["profilePicture"]["name"] . " already exists. ";
      	}
    	else
      	{
      		move_uploaded_file($_FILES["profilePicture"]["tmp_name"],
      		"../avatars/" . $_FILES["profilePicture"]["name"]);
      		echo "Stored in: " . "../avatars/" . $_FILES["profilePicture"]["name"];
      	}
    }
  }
else
  {
 	 echo "Invalid file";
  }
	  */
	  $target_path = "avatars/";

	$target_path = $target_path . basename( $_FILES['profilePicture']['name']); 
	
	if(move_uploaded_file($_FILES['profilePicture']['tmp_name'], $target_path)) {
	    echo "The file ".  basename( $_FILES['profilePicture']['name']). 
	    " has been uploaded";
	} else{
	    echo "There was an error uploading the file, please try again!";
	}
}?>