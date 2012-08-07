<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
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
	<h3 class="block panel-images"><a class="panel-links" href="index.php?show=admin&more=pages" >
		<img class="block panel-img" src="view/images/pages.png" /><br />
		Pages
	</a></h3>
	<h3 class="block panel-images"><a class="panel-links" href="index.php?show=admin&more=update" >
		<img class="block panel-img" src="view/images/update.png" /><br />
		Update
	</a></h3>
</div>
<div class="panel-blocks">
	<h3 class="block panel-images"><a class="panel-links" href="index.php?show=admin&more=statistics" >
		<img class="block panel-img" src="view/images/statistics.png" /><br />
		Statistics
	</a></h3>
	<h3 class="block panel-images"><a class="panel-links" href="index.php?show=admin&more=options" >
		<img class="block panel-img" src="view/images/option.png" /><br />
		Options
	</a></h3>
	<h3 class="block panel-images"><a id="maintance-button" class="panel-links" href="index.php?show=admin&more=maintance" >
		<img class="block panel-img" src="view/images/maintaince.jpg" /><br />
		Maintance
	</a></h3>
	<script type="text/javascript">
		$('#maintance-button').click(function(){return confirm("Are you sure you want to enter maintance mode? Until it ends site will be unavailable to the public.");});
	</script>
</div>