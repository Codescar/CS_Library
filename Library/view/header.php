<?php 
	if(!defined('INDEX'))
		die("Invalid request!");
	define('VIEW_HEADER', true);
?><!DOCTYPE html> 
<html> 
<head> 
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<meta name="keywords" content="CS_Library" />
	<meta name="description" content="CS_Library" />
	<meta name="author" content="lion2486, sudavar" />
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" href="<?php echo $url; ?>view/css/style.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo $url; ?>view/css/menu.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo $url; ?>view/css/smoothness/jquery-ui-1.8.16.custom.css" type="text/css" />
	<script src="<?php echo $url; ?>view/js/jquery-1.6.2.min.js" type="text/javascript"></script>
	<script src="<?php echo $url; ?>view/js/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>
	<script src="<?php echo $url; ?>view/js/js.js" type="text/javascript"></script>
	<script src="<?php echo $url; ?>model/ckeditor/ckeditor.js" type="text/javascript"></script>
	<!--[if gte IE 9]>
		<style type="text/css">
			.gradient {	filter: none; }
		</style>
	<![endif]-->
</head>
<body>
<?php if(isset($_GET['show']) && $_GET['show'] == "help"); else{ ?>
	<div class="black-gradient" id="top-gradient"></div>
	<div id="head">
	<p id="user-settings"><?php echo $user->show_login_status(); ?></p>
		<p><h2><?php echo $title; ?></h2></p>
	</div><?php } ?>