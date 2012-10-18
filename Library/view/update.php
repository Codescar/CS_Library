<?php 
	if(!defined('VIEW_NAV') || !defined('VIEW_SHOW') || !$user->is_admin())
		die("Invalid request!");

		global $CONFIG;
		
		require_once('model/xmlstr_to_array.php');
		/*
		 * GET PARAMETERS
		 * action:
		 * 			download
		 * 			download_all
		 * 			install
		 * 			install_all
		 * 			delete
		 * 			delete_all
		 * 			check (checks the POST parameters for actions)
		 * 
		 * after: 
		 * 			same as action but after the action is replacing it
		 */
		
		/*
		 * The controller of the actions...
		 */
		if(isset($_GET['action']) && $_GET['action'] == "download"){
			/*
			 *  Download a specific update-pakage from the update-site
			 */
			if(!isset($_GET['file']))
				echo "<p class=\"error\" >Invalid download request!</p>";
			else{
				$file = addslashes($_GET['file']);
				if(is_file($CONFIG['UPDATE']['dir'].$file))
					echo "<p class=\"error\" >File $file is already downloaded!</p>";
				else
					download_update_file($file);
			}
		}elseif(isset($_GET['action']) && $_GET['action'] == "download_all"){
			/*
			 *  Just Download all the availabe packages for update from the site
			 */
			$update_data = json_decode(file_get_contents($CONFIG['UPDATE']['URL'].'current-release-versions.php'));

			foreach($update_data as $update_row){
			
				//check only newer versions
				if(version_compare($update_row->version, $CONFIG['Version'], '<' ) || is_file($CONFIG['document-root']. $CONFIG['UPDATE']['dir'].$update_row->filename))
					continue;
					
				download_update_file($update_row->filename);
			}
			if(isset($_GET['after']))
				redirect("index.php?show=admin&more=update&action=".$_GET['after']);
				
		}elseif(isset($_GET['action']) && $_GET['action'] == "install"){
			/*
			 *  Installs an update package... it may be a disaster if the updates will install not in order...
			 */
			$error = false;
			if(!isset($_GET['file']) || !is_file($CONFIG['document-root']. $CONFIG['UPDATE']['dir'].$_GET['file'])){
				echo "<p class=\"error\" >Invalid installation request!</p>";
				$error = true;
			}
			else{
				$file = addslashes($_GET['file']);
				install_update_file($file);
				delete_update_file($file);
			}
		}elseif(isset($_GET['action']) && $_GET['action'] == "install_all"){
			/*
			 *  Installing all the updates 1 by 1 in the proper version order...
			 *  another think for that is to install the first version and then the $_GET['after'] gets the next etc...
			 */
			$files = list_all_updates();
			foreach($files as $file){
				install_update_file($file);
				delete_update_file($file);
			}			
			
		}elseif(isset($_GET['action']) && $_GET['action'] == "delete"){
			if(!isset($_GET['file']))
				echo "<p class=\"error\" >Invalid delete request!</p>";
			else{
				$file = addslashes($_GET['file']);
				delete_update_file($file);
			}
		}elseif(isset($_GET['action']) && $_GET['action'] == "delete_all"){
			
			$folder_handler = opendir($CONFIG['UPDATE']['dir']);
			
			while($file = readdir($folder_handler)){
				
				if($file == "." || $file == ".." )
					continue;
				if(pathinfo($file, PATHINFO_EXTENSION) != "zip")
					continue;
					
				delete_update_file($file);
				
			}
		}elseif(isset($_GET['action']) && $_GET['action'] == "check"){
			/*
			 *  This is a check of the forms and then choose what action to make...
			 */
			if(isset($_POST['hidden']) && $_POST['hidden'] == "form1"){
				
				if(isset($_POST['actions']) && $_POST['actions'] == "install"){
					
					foreach($_POST['files'] as $file)
						install_update_file($file);
					
				}elseif(isset($_POST['actions']) && $_POST['actions'] == "delete"){
					
					foreach($_POST['files'] as $file)
						delete_update_file($file);
					
				}
				
			}elseif(isset($_POST['hidden']) && $_POST['hidden'] == "form2"){
				
				if(isset($_POST['actions']) && $_POST['actions'] == "download"){
					foreach($_POST['files'] as $file)
						download_update_file($file);
					
				}
			}
		}
?>
<h2>DYNAMIC UPDATE SYSTEM</h2>
<a class="link-button" href="index.php?show=admin&more=maintenance">
	<button type="button" style="width: 140px;" class="index-button link box center bold">Maintenance</button>
</a>
<a class="link-button" href="index.php?show=admin&more=update&action=download_all&after=install_all">
	<button type="button" style="width: 140px;" class="index-button link box center bold">DOWNLOAD & INSTALL ALL</button>
</a>
<!-- 
BACKUP TOOL IS NOW EXISTS YET!
<a class="link-button" href="index.php?show=admin&more=backup">
	<button type="button" style="width: 140px;" class="index-button link box center bold">BACKUP</button>
</a> -->
<div id="downloaded-updates">
	<?php $files = list_all_updates(); ?>
	<h3>Ready-to-install Updates(<?php echo count($files); ?>)</h3>
	<form action="index.php?show=admin&more=update&action=check" method="post">
		<table>
		<tr>
			<th> </th>
			<th>Name</th>
			<th>Description</th>
			<th>Changes</th>
			<th>Action</th>
		</tr>
		<?php 
			if($files !== false)
			foreach($files as $file){
				//list all updates located in update-folder
				//with their info which is in the info.xml file
				
				/* the list function is doing this job now
				  if($file == "." || $file == ".." || pathinfo($file, PATHINFO_EXTENSION) != "zip")
					continue;
*/
				$array_info = get_update_xml_data($CONFIG['UPDATE']['dir'] . $file);

		?>
				<tr>
					<td><input type="checkbox" name="files[]" value="<?php echo $file; ?>" /></td>
					<td><span title="<?php echo $file; ?>"><?php echo $array_info['update']['title']; ?></span></td>
					<td><?php echo $array_info['update']['description']; ?></td>
					<td>
						<a class="view-changes" >View Changes</a>
						<p style="display: none;" class="changes">
							<ul style="display: none;">
							<?php 
								$tmp = $array_info['update']['changes']['change'];
				
								foreach($tmp as $a)
									echo "<li>". $a . "</li>";
								?>
							</ul>
						</p>
					</td>
					<td><a href="index.php?show=admin&more=update&action=install&file=<?php echo $file; ?>">INSTALL</a> - <a href="index.php?show=admin&more=update&action=delete&file=<?php echo $file; ?>">DELETE</a></td>
				</tr>
		<?php  } ?>
		</table>	
		<script type="text/javascript">
			$('.changes').dialog({ autoOpen: false });
			$('.view-changes').click(function (){ $(this).next().dialog(open); });
			
		</script>
		<div>
			Bulk actions 
			<select name="actions">
				<option value="install">Install</option>
				<option value="delete">Detele</option>
			</select>
			<input type="hidden" name="hidden" value="form1" />
			<input type="submit" value="Apply"/>
		</div>
		</form>
</div>
<a class="link-button" href="index.php?show=admin&more=update&action=install_all">
	<button type="button" style="width: 140px;" class="index-button link box center bold">INSTALL ALL</button>
</a>
<a class="link-button" href="index.php?show=admin&more=update&action=delete_all">
	<button type="button" style="width: 140px;" class="index-button link box center bold">DELETE ALL</button>
</a>
<div id="available-updates">
	<?php 
	$update_data = json_decode(file_get_contents($CONFIG['UPDATE']['URL'].'current-release-versions.php?version='.$CONFIG['Version']));
	$avail_updates_num = 0;

	foreach($update_data as $update_row)
		if(version_compare($update_row->version, $CONFIG['Version'], '<=') || is_file($CONFIG['document-root']. $CONFIG['UPDATE']['dir'].$update_row->filename))
			continue;
		else
			$avail_updates_num ++;
		
	
	?>
	<h3>Available Updates (<?php echo "$avail_updates_num/".count($update_data);?>)</h3>
	<form action="index.php?show=admin&more=update&action=check" method="post">
		<table>
		<tr>
			<th> </th>
			<th>Name</th>
			<th>Description</th>
			<th>Changes</th>
			<th>Action</th>
		</tr>
		<?php 
		
		foreach($update_data as $update_row){
			//check only newer versions && un-downloaded files
			
			if(version_compare($update_row->version, $CONFIG['Version'], '<=') || is_file($CONFIG['document-root']. $CONFIG['UPDATE']['dir'].$update_row->filename))
				continue;
		?>
		<tr>
			<td><input type="checkbox" name="files[]" value="<?php echo $update_row->filename; ?>" /></td>
			<td title="<?php echo $update_row->filename; ?>"><?php echo $update_row->title; ?></td>
			<td><?php echo $update_row->description; ?></td>
			<td><?php  foreach($update_row->changes as $changelog) echo "$changelog "; ?></td>
			<td><a href="index.php?show=admin&more=update&action=download&file=<?php echo $update_row->filename; ?>">DOWNLOAD</a></td>
		</tr>
		<?php } ?>
		</table>
		<div>
		Bulk actions 
			<select name="actions">
				<option value="download">Download</option>
			</select>
			<input type="hidden" name="hidden" value="form2" />
			<input type="submit" value="Apply"/>
		</div>
		</form>
</div>
<a class="link-button" href="index.php?show=admin&more=update&action=download_all">
	<button type="button" style="width: 140px;" class="index-button link box center bold">Download ALL</button>
</a>
<?php

function set_setting($type, $val)
{
    global $db;
    if($type == "Version")
    {
        $query = "UPDATE `{$db -> table['options']}` SET `Value` = '".$db->db_escape_string($val)."' WHERE `Name` = 'Version';";
        $db -> query($query);
    }
}

function get_siteInfo($type)
{
    global $CONFIG;
    if($type == "Version")
    return $CONFIG['Version'];
}

function unzip($file){ 
    $zip = zip_open($file); 
    if(is_resource($zip)){ 
        $tree = ""; 
        while(($zip_entry = zip_read($zip)) !== false){ 
            echo "Unpacking ".zip_entry_name($zip_entry)."\n"; 
            if(strpos(zip_entry_name($zip_entry), DIRECTORY_SEPARATOR) !== false){ 
                $last = strrpos(zip_entry_name($zip_entry), DIRECTORY_SEPARATOR); 
                $dir = substr(zip_entry_name($zip_entry), 0, $last); 
                $file = substr(zip_entry_name($zip_entry), strrpos(zip_entry_name($zip_entry), DIRECTORY_SEPARATOR)+1); 
                if(!is_dir($dir)){ 
                    mkdir($dir, 0755, true) or die("Unable to create $dir\n"); 
                } 
                if(strlen(trim($file)) > 0){ 
                    $return = file_put_contents($dir."/".$file, zip_entry_read($zip_entry, zip_entry_filesize($zip_entry))); 
                    if($return === false){ 
                        die("Unable to write file $dir/$file\n"); 
                    } 
                } 
            }else{ 
                file_put_contents($file, zip_entry_read($zip_entry, zip_entry_filesize($zip_entry))); 
            } 
        } 
    }else{ 
        echo "Unable to open zip file\n"; 
    } 
} 

function download_update_file($filename){
	global $CONFIG;
	
	echo "<p class=\"success\">Downloading update: $filename ...</p>";

	$newUpdate = file_get_contents($CONFIG['UPDATE']['URL'].$filename);
	
	if(!is_dir( $CONFIG['document-root'].$CONFIG['UPDATE']['dir']))
		mkdir($CONFIG['document-root'].$CONFIG['UPDATE']['dir']);
		
	$dlHandler = fopen($CONFIG['document-root'].$CONFIG['UPDATE']['dir'].$filename, 'w');
	
	if(!fwrite($dlHandler, $newUpdate))
		echo "<p class=\"error\">Could not save new update. Operation aborted.</p>"; 
	else
		echo "<p class=\"success\">Update $filename Downloaded And Saved</p>";
		
	fclose($dlHandler);
	return;
}

function delete_update_file($file){
	global $CONFIG;
	
	if(!@is_file($CONFIG['UPDATE']['dir'].$file))
		echo "<p class=\"error\" >File $file does not exists!</p>";
	else{
		if(@unlink($CONFIG['UPDATE']['dir'].$file))
			echo "<p class=\"success\" >File $file deleted!</p>";
		else	
			echo "<p class=\"error\" >Could not delete the file!</p>";
	}
	return;
}

function install_update_file($file){
	global $CONFIG, $error, $db;
	
	$zipHandle = zip_open($CONFIG['UPDATE']['dir'].$file);
	if(is_int($zipHandle)){
		echo "<p class=\"error\"> $file file is invalid! error " . $zipHandle . "</p><br/>";
		$error = true;
	}

	$aF = zip_read($zipHandle);
	if($aF === false){
		echo "<p class=\"error\">Error while reading the update zip</p><br/>";
		zip_close($zipHandle);
		$error = true;
	}
	
	echo "<p class=\"success\">Installing update...<br/><ul>";
	
	while ($aF = zip_read($zipHandle)){

		$thisFileName = zip_entry_name($aF);
		$thisFileDir = dirname($thisFileName);
		
		//Continue if its not a file
		if (substr($thisFileName,-1,1) == '/') 
			continue;
		
		//Make the directory if we need to...
		if (!is_dir ($CONFIG['document-root'].$thisFileDir ) ){
			 mkdir ($CONFIG['document-root'].$thisFileDir );
			 echo "<li>Created Directory $thisFileDir</li>";
		}
		
		//write the file
		if (!is_dir($CONFIG['document-root'].$thisFileName)) {
			echo "<li>$thisFileName copying...</li>";
			$contents = zip_entry_read($aF, zip_entry_filesize($aF));
			$contents = str_replace("\r\n", "\n", $contents);
			$updateThis = '';
			
			//If we need to run commands, then do it.
			if ($thisFileName == 'upgrade.php'){
				$upgradeExec = fopen ('upgrade.php','w');
				fwrite($upgradeExec, $contents);
				fclose($upgradeExec);
				include ('upgrade.php');
				unlink('upgrade.php');
				echo "<li>Upgrade file executed!</li>";
			}
			else{
				$updateThis = fopen($CONFIG['document-root'].'/'.$thisFileName, 'w');
				fwrite($updateThis, $contents);
				fclose($updateThis);
				unset($contents);
			}
		}
	}
	if($zipHandle)
		zip_close($zipHandle);

	echo "</ul></p>";
		
	if(!$error){
	
		$za = new ZipArchive();
		$za->open($CONFIG['document-root'].$CONFIG['UPDATE']['dir'].$file);
		$array_info = xml2array($za->getFromName('info.xml'));
		$za->unchangeAll();
		$za->close();
		
		option::save("Version", $array_info['update']['version']);
		
		unset($za);
		
		delete_update_file($file);
		
		if(!$error)	
			echo "<p class=\"success\">Library Updated to version {$array_info['update']['version']} successfully!</p>";
		else
			echo "<p class=\"error\">Library Updated to version {$array_info['update']['version']} failed!</p>";
			
	}
}

function get_update_xml_data($file){
	
	$za = new ZipArchive();
	
	//$xml_info = new XMLReader();
	
	$za->open($file);

	$array_info = xml2array($za->getFromName('info.xml'));
	
	$za->close();
	
	return $array_info;
}

function list_all_updates($flag = 1){
	global $CONFIG;
	
	$folder_handler = opendir($CONFIG['UPDATE']['dir']);
	$files = array();
	
	while ($file = readdir($folder_handler)){
		if($file == "." || $file == ".." )
			continue;
		if(pathinfo($file, PATHINFO_EXTENSION) != "zip")
			continue;
		if($flag){
			$array_info = get_update_xml_data($CONFIG['UPDATE']['dir'] . $file);
			$files[0][] = $array_info['update']['version'];
		}
		$files[1][] = $file;
	}
	function compare_them($a, $b){
		return version_compare($a[0], $b[0], ">");
	}
	if($flag && !empty($files))
		//usort($files, "compare_them");
		array_multisort($files[0], $files[1]);
	
	closedir($folder_handler);
	if(!empty($files))
		return $files[1];
	else 	
		return false;
}
?>
</div>