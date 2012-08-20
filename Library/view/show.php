<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);

	$logged = $user->is_logged_in();
?>
<div id="direction"><a href="index.php">Αρχική</a></div>
<div class="content">
	<div class="block" id="show-index">
		<?php render_template("indexPanel.php"); ?>
	</div>
	<div class="block" id="announcements">
		<div id="announcements-header">Ανακοινώσεις</div>
		<?php announcements::show(); ?>
		<div class="center">
			<?php if($user->is_admin()) { ?>
				<a href="index.php?show=admin&more=announcements&id=0">
					<button type="button" class="index-button link box center bold">Νέα</button>
				</a>
			<?php } ?>
			<a href="#"><button type="button" class="index-button link box center bold">Παλιότερες</button></a>
		</div>
	</div>
</div>
