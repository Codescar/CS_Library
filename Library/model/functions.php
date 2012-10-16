<?php 

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

function upload_file($file, $upload_dir = "avatars", $file_type = "image", $filename = null, $check_type = true, $overwrite = true, $max_size = 1000000) {

	if($filename == null)
		$filename = $file["name"];
		
	$upload_dir .= "/";
	
	switch($file_type){
		case "ebook":	
						$allowedExts 	= array("pdf");
						$allowedTypes 	= array("document/pdf"); 
						break;
		case "image":
		default:
						$allowedExts 	= array("jpg", "jpeg", "gif", "png");
						$allowedTypes 	= array("image/gif", "image/jpeg", "image/png", "image/pjpeg"); 
						break;
	
	}
	$expl = explode(".",$file["name"]);

	if (isset($file)
			&& in_array($file["type"], $allowedTypes)
			&& $file["size"] < $max_size
			&& in_array(end($expl), $allowedExts))
	{

		$file_name = $upload_dir .$filename . "." . end($expl);
	  
		if (file_exists($file_name))
			if($overwrite)
				unlink($file_name);
			else
				echo "<div class=\"error\">File already exists!</div>";

		elseif(!file_exists($file_name))
		{
			if(!move_uploaded_file($file["tmp_name"], $file_name))
				return false;
			else
				return $file_name;
		}
		else
			return false;
	}
	else
		echo "<div class=\"error\">Invalid file!</div>";
	return false;
}

function get_avatar($user_id) {
	global $db, $user;

	$query = "SELECT * FROM `{$db->table['avatars']}` WHERE `user_id` = '$user_id' LIMIT 1;";
	$result = $db->query($query);
	$res = $db->db_fetch_array($result);
	if($db->db_num_rows($result) != 0 )
		return $res;

	return 0;
}

function update_avatar_in_db($avatar = null, $is_file = 0) {
	global $db, $user;

	$user_id = $user->id;

	$res = get_avatar($user_id);

	if($res != 0 && $res['is_file'] == 1){
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

function arrayToObject($array) {
    if(!is_array($array)) {
        return $array;
    }
    
    $object = new stdClass();
    if (is_array($array) && count($array) > 0) {
      foreach ($array as $name=>$value) {
         $name = strtolower(trim($name));
         if (!empty($name)) {
            $object->$name = arrayToObject($value);
         }
      }
      return $object; 
    }
    else {
      return FALSE;
    }
}

function logg($file, $string){
		$fh = fopen($file, 'a');
		fwrite($fh, $string);
		fclose($fh);
}
?>