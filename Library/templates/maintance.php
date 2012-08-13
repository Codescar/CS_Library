<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	//TODO have to make it more beatyfull :P
?>
<div class="content">
	Η υπηρεσία βρίσκετε σε κατάσταση συντήρησης. Παρακαλούμε περιμένετε
	να τελειώσει. Αν διατηρηθεί έτσι, παρακαλούμε επικοινωνήστε με τον 
	<a href="mailto:<?php echo $_CONFIG['admin_email']; ?>">Admin</a>.
	<a href="index.php?show=login"><button type="button" class="box link">Admin login</button></a>
</div>