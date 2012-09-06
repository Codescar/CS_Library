<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	global $CONFIG;
?>
<div id="direction"><a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;Κατάσταση Συντήρησης</div>
<div class="content maintenance">
	<img class="block maintenance-img" src="view/images/maintaince.jpg">
	<div class="maintenance-msg">Η υπηρεσία βρίσκετε σε κατάσταση συντήρησης. Παρακαλούμε περιμένετε
	να τελειώσει. Αν διατηρηθεί έτσι για ώρες, παρακαλούμε επικοινωνήστε με τον 
	<a href="mailto:<?php echo $CONFIG['admin_email']; ?>">Admin</a>.</div>
	<a class="add-new link-button" href="index.php?show=login"><button type="button" class="box link">Admin login</button></a>
</div>