<?php 
	if(!defined('VIEW_NAV') || !defined('VIEW_SHOW') || !$user->is_admin())
		die("Invalid request!");

?>
<h2>DYNAMIC UPDATE SYSTEM</h2>
<?php
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
		if ( $aV > get_siteInfo('Version')) {
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
        $query = "UPDATE `{$db -> table['options']}` SET `Value` = '".mysql_real_escape_string($val)."' WHERE `Name` = 'Version';";
        $db -> query($query);
    }
}
?>
</div>