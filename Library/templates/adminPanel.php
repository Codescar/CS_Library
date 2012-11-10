<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	global $CONFIG;
?>
<div class="panel-blocks">
	<h3 class="block panel-images"><a class="panel-links" href="index.php?show=admin&more=announcements" >
		<img class="block panel-img" src="view/images/announcements.png" /><br />
		Announcements
	</a></h3>
	<h3 class="block panel-images"><a class="panel-links" href="index.php?show=admin&more=pendings" >
		<img class="block panel-img" src="view/images/attention.png" /><br />
		Pendings
	</a></h3>
	<h3 class="block panel-images"><a class="panel-links" href="index.php?show=admin&more=users" >
		<img class="block panel-img" src="view/images/users.png" /><br />
		Users
	</a></h3>
</div>
<div class="panel-blocks">
	<h3 class="block panel-images"><a class="panel-links" href="index.php?show=admin&more=history" >
		<img class="block panel-img" src="view/images/log.png" /><br />
		History
	</a></h3>
	<h3 class="block panel-images"><a class="panel-links" href="index.php?show=book&edit=add" >
		<img class="block panel-img" src="view/images/book.png" /><br />
		Add Book
	</a></h3>
	<h3 class="block panel-images"><a class="panel-links" href="index.php?show=admin&more=statistics" >
		<img class="block panel-img" src="view/images/statistics.png" /><br />
		Statistics
	</a></h3>
</div>
<div class="panel-blocks">
	<h3 class="block panel-images"><a class="panel-links" href="index.php?show=admin&more=update" >
		<img class="block panel-img" src="view/images/update.png" /><br />
		Update
	</a></h3>
	<h3 class="block panel-images"><a class="panel-links" href="index.php?show=admin&more=options" >
		<img class="block panel-img" src="view/images/option.png" /><br />
		Options
	</a></h3>
	<h3 class="block panel-images"><a class="panel-links <?php echo ($CONFIG['maintenance']) ? "disable-maintenance" : "enable-maintenance"; ?>" href="index.php?show=admin&more=maintenance" >
		<img class="block panel-img" src="view/images/maintaince.jpg" /><br />
		Maintenance
	</a></h3>
</div>
<div class="panel-blocks">
	<h3 class="block panel-images"><a class="panel-links" href="index.php?show=admin&more=pages" >
		<img class="block panel-img" src="view/images/pages.png" /><br />
		Pages
	</a></h3>
	<h3 class="block panel-images"><a class="panel-links" href="index.php?show=admin&more=backup" >
		<img class="block panel-img" src="view/images/backup.png" /><br />
		Αντίγραφα Ασφαλείας
	</a></h3>
	<h3 class="block panel-images"><a class="panel-links" href="index.php?show=admin&more=mailtemplates" >
		<img class="block panel-img" src="view/images/mail.png" /><br />
		Πρότυπα Αυτόματων Μυνημάτων
	</a></h3>
</div>