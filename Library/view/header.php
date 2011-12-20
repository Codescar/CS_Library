<?php 
	if(!defined('VIEW_INDEX'))
		die("Invalid request!");
	define('VIEW_HEADER', true);
?>
<!DOCTYPE html> 
<html lang="el"> 
<head> 
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<meta name="keywords" content="CS_Library" />
	<meta name="description" content="CS_Library" />
	<meta name="author" content="lion2486" />
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" href="<?php echo $url; ?>view/css/style.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo $url; ?>view/css/smoothness/jquery-ui-1.8.16.custom.css" type="text/css" />
	<script src="<?php echo $url; ?>view/js/jquery-1.6.2.min.js" type="text/javascript"></script>
	<script src="<?php echo $url; ?>view/js/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>
	<script src="<?php echo $url; ?>view/js/js.js" type="text/javascript"></script>
</head>
<body>
<?php if(isset($_GET['show']) && $_GET['show'] == "help"); else{ ?>
<p id="user-settings"><?php echo $user->show_login_status(); ?></p>
<h1><?php echo $title; ?></h1>
<br/>
<?php } ?>