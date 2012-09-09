<?php
	if(isset($_GET['step']) && $_GET['step'] == 0)
	{
		// Submiting values!
		
		header('Location: ?step=' . $_POST['next']);
	}
	?><!DOCTYPE html> 
<html>
<head>
<title>CodeScar - Library Installation - Step <?php echo $_GET['step'] ? $_GET['step'] + 1 : 1; ?></title>
<style type="text/css">
label {
    display: block;
    float: left;
    width: 150px;
}
input{
	width: 270px;
}
</style>
</head>
<body>
<div>
	<?php
	if(!isset($_GET['step'])){
		include('requirements.php');
		//Generating database infos
		include('steps/step0.php');
	}elseif($_GET['step'] == "1")
		//Generating basic config parametrs
		include('steps/step1.php');
	elseif($_GET['step'] == "2")
		//Generating admin login
		include('steps/step2.php');
	elseif($_GET['step'] == "3")
		//the review of the installation
		include('steps/step3.php');
?>
</div>
</body>
</html>

