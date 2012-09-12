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
		<?php
		$all = announcements::list_all(1);
		$num = round($all/$CONFIG['announ_num']);
		for($i = 0; $i < $num; $i++){
			echo "<div class=\" ";
			echo ($i == 0) ? "announ-shown" : "announ-div";
			echo ($i == $num - 1) ? " announ-last" : "";
			echo " \">";
			announcements::show($i);
			echo "</div>";
		}
		?>
		<div class="center">
			<?php if($user->is_admin()) { ?>
				<a class="link-button" href="index.php?show=admin&more=announcements&id=0">
					<button type="button" class="index-button link box center bold">Νέα</button>
				</a>
			<?php } ?>
			<a class="link-button" id="old-ann" href="#"><button type="button" class="index-button link box center bold">Παλιότερες</button></a>
		</div>
	</div>
</div>
