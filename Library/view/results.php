<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);

if(!isset($_GET['search']) || $_GET['search'] == "" || (!isset($_GET['title']) && !isset($_GET['writer_or']))){
	echo "Λάθος αναζήτηση";
}
else {
	if(isset($_GET['title']))
		$mode = 1;
	else if(isset($_GET['writer_or']))
		$mode = 2;
	else if(isset($_GET['writer_or']) && isset($_GET['title']))
		$mode = 3;
	$db->connect();
	$books = $db->search($_GET['search'], $mode, $page*$CONFIG['items_per_page'], $CONFIG['items_per_page']);
	$db->close();
?>
<div class="content">
<div class="list">
	Αποτελέσματα αναζήτησης για "<?php echo $_GET['search']; ?>"<br />
	<?php if($books){ ?>
	&nbsp;
		<?php 
		list_books($books);
	}
	else{ ?>
	    <p>Δεν βρέθηκαν αποτελέσματα</p>
	<?php }
} ?>
</div>
</div>