<?php 
	if(!defined('VIEW_NAV') || !defined('VIEW_SHOW') || !$user->is_admin())
		die("Invalid request!");

		$CONFIG['UPDATE']['dir'] = 'UPDATE-PACKAGES/';
		$CONFIG['UPDATE']['URL'] = "http://projects.codescar.eu/Library/UPDATES/";
		
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
	<h3>Ready-to-install Updates</h3>
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
			$folder_handler = opendir($CONFIG['UPDATE']['dir']);
			while($file = readdir($folder_handler)){
				//list all updates located in update-folder
				//with their info which is in the info.xml file
				//NOTDONE yet, have to open the zip and read the xml
				if($file == "." || $file == ".." )
					continue;
				if(pathinfo($file, PATHINFO_EXTENSION) != "zip")
					continue;
								
				/*$zipHandle = zip_open($CONFIG['UPDATE']['dir'] . $file);
				if(is_int($zipHandle)){
					echo $CONFIG['UPDATE']['dir'] . $file . " file is invalid! error " . $zipHandle . "<br/>";
					continue;
				}
				$aF = zip_read($zipHandle);
				if($aF === false){
					echo "error while reading the zip<br/>";
					zip_close($zipHandle);
					continue;
				}
				
				while ($aF = zip_read($zipHandle)){
					echo "SKATA!";
					$thisFileName = zip_entry_name($aF);
					$thisFileDir = dirname($thisFileName);
					
					//Continue if its not a file
					if (substr($thisFileName,-1,1) == '/') 
						continue;
	
					//Make the directory if we need to...
					if (!is_dir ($CONFIG['document-root'].'/'.$thisFileDir ) ){
						 mkdir ($CONFIG['document-root'].'/'.$thisFileDir );
						 echo '<li>Created Directory '.$thisFileDir.'</li>';
					}
					
					//Overwrite the file
					if (!is_dir($CONFIG['document-root'].'/'.$thisFileName) ) {
						echo '<li>'.$thisFileName.'...........';
						$contents = zip_entry_read($aF, zip_entry_filesize($aF));
						$contents = str_replace("\r\n", "\n", $contents);
						$updateThis = '';
						
						//If we need to run commands, then do it.
						if ( $thisFileName == 'upgrade.php' ){
							$upgradeExec = fopen ('upgrade.php','w');
							fwrite($upgradeExec, $contents);
							fclose($upgradeExec);
							include ('upgrade.php');
							unlink('upgrade.php');
							echo' EXECUTED</li>';
						}
						else{
							$updateThis = fopen($CONFIG['document-root'].'/'.$thisFileName, 'w');
							fwrite($updateThis, $contents);
							fclose($updateThis);
							unset($contents);
						}
					}
				}
*/

		$za = new ZipArchive();
		$xml_info = new XMLReader();
		$za->open($CONFIG['UPDATE']['dir'] . $file);

		$array_info = xml2array($za->getFromName('info.xml'));
		$za->close();
		?>
		<tr>
			<td><input type="checkbox" name="<?php echo $file; ?>" /></td>
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
			<td>INSTALL - DELETE</td>
		</tr>
		<?php  } ?>
		</table>	
		<script type="text/javascript">
			$('.changes').dialog({ autoOpen: false });
			$('.view-changes').click(function (){ $(this).next().dialog(open); });
			
		</script>
		<div >Bulk actions <select name="actions"><option value="install">Install</option><option value="delete">Detele</option></select><input type="submit" value="Apply"/></div>
		</form>
</div>
<a class="link-button" href="index.php?show=admin&more=update&action=install_all">
	<button type="button" style="width: 140px;" class="index-button link box center bold">INSTALL ALL</button>
</a>
<a class="link-button" href="index.php?show=admin&more=update&action=delete_all">
	<button type="button" style="width: 140px;" class="index-button link box center bold">DELETE ALL</button>
</a>
<div id="available-updates">
	<h3>Available Updates</h3>
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
		$update_data = json_decode(file_get_contents($CONFIG['UPDATE']['URL'].'current-release-versions.php'));

		foreach($update_data as $update_row){
			//list all available updates from the server through json
			//have to check only newer versions
		?>
		<tr>
			<td><input type="checkbox" name="<?php echo $update_row->filename; ?>" /></td>
			<td><?php echo $update_row->name; ?></td>
			<td><?php echo $update_row->description; ?></td>
			<td><?php foreach($update_row->changes as $changelog) echo "$changelog "; ?></td>
			<td>DOWNLOAD</td>
		</tr>
		<?php } ?>
		</table>
		<div >Bulk actions <select name="actions"><option value="download">Download</option></select><input type="submit" value="Apply"/></div>
		</form>
</div>
<a class="link-button" href="index.php?show=admin&more=update&action=download_all">
	<button type="button" style="width: 140px;" class="index-button link box center bold">Download ALL</button>
</a>
<?php
	//Somewhere have to be the installation of the packages and controller for them

/*
ini_set('max_execution_time',60);
$updateURL = "http://projects.codescar.eu/Library/UPDATES/";
//Check For An Update
$getVersions = file_get_contents($updateURL.'current-release-versions.php') or die ('ERROR');
if ($getVersions != '')
{
	//TODO maybe add the changelog to the about page
	echo '<p>CURRENT VERSION: '.get_siteInfo('Version').'</p>';
	echo '<p>Reading Current Releases List</p>';
	$versionList = explode("\n", $getVersions);	
	foreach ($versionList as $aV)
	{
		if ( version_compare($aV, get_siteInfo('Version'), '>' )) {
			echo '<p>New Update Found: v'.$aV.'</p>';
			$found = true;
			
			//Download The File If We Do Not Have It
			if ( !is_file(  $CONFIG['document-root'].'/UPDATE-PACKAGES/'.$CONFIG['update-prefix'].$aV.'.zip' )) {
				echo '<p>Downloading New Update</p>';
				$newUpdate = file_get_contents($updateURL.$CONFIG['update-prefix'].$aV.'.zip');
				if ( !is_dir( $CONFIG['document-root'].'/UPDATE-PACKAGES/' ) ) mkdir ($CONFIG['document-root'].'/UPDATE-PACKAGES/' );
				$dlHandler = fopen($CONFIG['document-root'].'/UPDATE-PACKAGES/'.$CONFIG['update-prefix'].$aV.'.zip', 'w');
				if ( !fwrite($dlHandler, $newUpdate) ) { echo '<p>Could not save new update. Operation aborted.</p>'; exit(); }
				fclose($dlHandler);
				echo '<p>Update Downloaded And Saved</p>';
			} else echo '<p>Update already downloaded.</p>';	
			
			if (isset($_GET['doUpdate']) && $_GET['doUpdate'] == true) {
				//Open The File And Do Stuff
				$zipHandle = zip_open($CONFIG['document-root'].'/UPDATE-PACKAGES/' .$CONFIG['update-prefix'].$aV.'.zip');
				echo '<ul>';
				while ($aF = zip_read($zipHandle) ) 
				{
					$thisFileName = zip_entry_name($aF);
					$thisFileDir = dirname($thisFileName);
					
					//Continue if its not a file
					if ( substr($thisFileName,-1,1) == '/') continue;
					
	
					//Make the directory if we need to...
					if ( !is_dir ( $CONFIG['document-root'].'/'.$thisFileDir ) )
					{
						 mkdir ( $CONFIG['document-root'].'/'.$thisFileDir );
						 echo '<li>Created Directory '.$thisFileDir.'</li>';
					}
					
					//Overwrite the file
					if ( !is_dir($CONFIG['document-root'].'/'.$thisFileName) ) {
						echo '<li>'.$thisFileName.'...........';
						$contents = zip_entry_read($aF, zip_entry_filesize($aF));
						$contents = str_replace("\r\n", "\n", $contents);
						$updateThis = '';
						
						//If we need to run commands, then do it.
						if ( $thisFileName == 'upgrade.php' )
						{
							$upgradeExec = fopen ('upgrade.php','w');
							fwrite($upgradeExec, $contents);
							fclose($upgradeExec);
							include ('upgrade.php');
							unlink('upgrade.php');
							echo' EXECUTED</li>';
						}
						else
						{
							$updateThis = fopen($CONFIG['document-root'].'/'.$thisFileName, 'w');
							fwrite($updateThis, $contents);
							fclose($updateThis);
							unset($contents);
							echo' UPDATED</li>';
						}
					}
				}
				echo '</ul>';
				$updated = TRUE;
			}
			else echo '<p>Update ready. <a href="?show=update&doUpdate=true">&raquo; Install Now?</a></p>';
			break;
		}
	}
	
	if (isset($updated) && $updated == true)
	{
		set_setting('Version',$aV);
		echo '<div class="success">&raquo; CMS Updated to v'.$aV.'</div>';
	}
	else if (isset($found) && $found != true) echo '<p>&raquo; No update is available.</p>';

	
}
else echo '<p>Could not find latest realeases.</p>';

function get_siteInfo($type)
{
    global $CONFIG;
    if($type == "Version")
    return $CONFIG['Version'];
}

function set_setting($type, $val)
{
    global $db;
    if($type == "Version")
    {
        $query = "UPDATE `{$db -> table['options']}` SET `Value` = '".$db->db_escape_string($val)."' WHERE `Name` = 'Version';";
        $db -> query($query);
    }
}*/
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
?>
</div>