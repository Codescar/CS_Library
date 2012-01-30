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
	<div id="container">
	<?php if(isset($_GET['show']) && $_GET['show'] == "help"); else{ ?>
		<div id="header">
		<div class="right-nav"></div>
			<div class="logo">
				<h2><a href="<?php echo $url; ?>"><?php echo $title; ?></a></h2>
			</div>
			<div class="customermenu"><?php echo $user->show_login_status(); ?></div>
		</div><?php } ?>