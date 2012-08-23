<?php 
function redirect($url, $time = 2000){
	echo "Αν δεν γίνεται ανακατεύθυνση, πιέστε <a href=\"".$url."\">εδώ</a>.</div>"
			."<script type=\"text/javascript\">var t=setTimeout(\"window.location = '".$url."'\",".$time.")</script>";
}

function date_gr($timestamp, $mode) {

	$result = "";
	$dval = date("N",$timestamp);
	$nval = (int) date("d",$timestamp);
	$mval = date("n",$timestamp);
	$myer = date("Y",$timestamp);

	// Feel free to personalize arrays for your mothertongue :-)
	// ---------------------------------------------------------
	$day = array("","Δευτέρα","Τρίτη","Τετάρτη","Πέμπτη","Παρασκευή","Σαββάτο","Κυριακή");

	$sday = array("","Δευ","Τρι","Τετ","Πεμ","Παρ","Σαβ","Κυρ");

	$month = array("","Ιανουαρίου","Φεβρουαρίου","Μαρτίου",
			"Απριλίου","Μαΐου","Ιουνίου","Ιουλίου",
			"Αυγούστου","Σεπτεμβρίου","Οκτωβρίου",
			"Νοεμβρίου","Δεκεμβρίου");

	$smonth = array("","Ιαν","Φεβ","Μαρ","Απρ","Μαι","Ιουν",
			"Ιουλ","Αύγ","Σεπτ","Οκτ","Νοέμ","Δεκ");

	// outputs the date with caps or not, long or short
	// ------------------------------------------------
	switch ($mode) {
		case "Long":
			$result = ucfirst($day[$dval])." $nval ".ucfirst($month[$mval]);
			break;		// Mardi 30 Juin
		case "long":
			$result = "$day[$dval] $nval $month[$mval]";
			break;		// mardi 30 juin
		case "mine":
			$result = $day[$dval]." $nval ".$month[$mval-1]." $myer";
			break;
		case "mine2":
			$result = $day[$dval];
			break;
		case "Short":
			$result = ucfirst($sday[$dval])." $nval ".ucfirst($smonth[$mval]);
			break;		// Mar 30 Juin
		default:
			$result = $day[$dval]." $nval-$mval";
	}
	return $result;
}

function upload_file() {
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

function get_avatar() {
	global $db, $user;

	$user_id = $user->id;

	$query = "SELECT * FROM `{$db->table['avatars']}` WHERE `user_id` = '$user_id' LIMIT 1;";
	$result = $db->query($query);
	$res = mysql_fetch_array($result);

	if(mysql_num_rows($result) != 0 )
		return $res;


	return 0;
}

function update_avatar_in_db($avatar = null, $is_file = 0) {
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

function isImage($url) {
	$params = array('http' => array(
			'method' => 'HEAD'
	));
	$ctx = stream_context_create($params);
	$fp = @fopen($url, 'rb', false, $ctx);
	if (!$fp)
		return false;  // Problem with url

	$meta = stream_get_meta_data($fp);
	if ($meta === false)
	{
		fclose($fp);
		return false;  // Problem reading data from url
	}

	$wrapper_data = $meta["wrapper_data"];
	if(is_array($wrapper_data)){
		foreach(array_keys($wrapper_data) as $hh){
			if (substr($wrapper_data[$hh], 0, 19) == "Content-Type: image") // strlen("Content-Type: image") == 19
			{
				fclose($fp);
				return true;
			}
		}
	}

	fclose($fp);
	return false;
}

?>