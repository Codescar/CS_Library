<?php
	if(isset($_GET['step']) && $_GET['step'] == 0)
	{
		// Submiting values!
		
		header('Location: ?step=' . $_POST['next']);
	}
	if(!isset($_GET['step']))
		//Generating database infos
		include('steps/step0.php');
	elseif($_GET['step'] == "1")
		//Generating basic config parametrs
		include('steps/step1.php');
		
?>

