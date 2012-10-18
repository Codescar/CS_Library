<?php 
	if(!defined('INDEX'))
		die("Invalid request!");
	define('VIEW_HEADER', true);
?><!DOCTYPE html> 
<html> 
<head> 
	<meta content="text/html; charset=<?php echo $CONFIG['charset']; ?>" http-equiv="Content-Type" />
	<meta name="keywords" content="CS_Library" />
	<meta name="description" content="CS_Library" />
	<meta name="author" content="lion2486, sudavar" />
	<title><?php echo $CONFIG['title']; ?></title>
	<link rel="stylesheet" href="<?php echo $CONFIG['url']; ?>view/css/style.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo $CONFIG['url']; ?>view/css/list.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo $CONFIG['url']; ?>model/jquery.lightbox/css/jquery.lightbox-0.5.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo $CONFIG['url']; ?>view/css/smoothness/jquery-ui-1.8.16.custom.css" type="text/css" />
	<link rel="icon" type="image/png" href="<?php echo $CONFIG['url']; ?>view/images/favicon.ico">
	<script src="<?php echo $CONFIG['url']; ?>view/js/jquery-1.6.2.min.js" type="text/javascript"></script>
	<script src="<?php echo $CONFIG['url']; ?>view/js/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>
	<script src="<?php echo $CONFIG['url']; ?>view/js/js.js" type="text/javascript"></script>
	<script src="<?php echo $CONFIG['url']; ?>model/jquery.lightbox/js/jquery.lightbox-0.5.js" type="text/javascript"></script>
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
			<div id="header-top">
				<div class="block" id="header-date">
				    <?php echo date_gr(time(), "Long") ?>
				</div>
				<?php if($CONFIG['maintenance'] && $user->is_admin()) 
					echo "<div class=\"block\" id=\"error-maintenance\">Η υπηρεσία είναι σε κατάσταση συντήρησης</div>";
				?>
				<div class="block" id="header-timeline">
					<?php pages::get_body(3); ?>
				</div>
			</div>
			<div class="logo">
				<a href="<?php echo $CONFIG['url']; ?>"><?php echo $CONFIG['title']; ?></a>
			</div>
			<div class="customermenu"><?php echo $user->show_login_status(); ?></div>
		</div><?php } ?>