<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	
	$logged = $user->is_logged_in();
?>
<div id="direction"><a href="index.php">Αρχική</a></div>
<div class="content">
	<div class="index-title">
		Καλώς ορίσατε στην ηλεκτρονική πύλη της Εθνικής Βιβλιοθήκης Αθηνών.
	</div>
	<?php if(announcements::num() > 0) {?>
		<div id="announcements">
			<div id="announcements-header">Ανακοινώσεις</div><br />
			<?php announcements::show(); ?>
		</div>
		<div class="block" id="quick-links">
			<div class="box index-box link">
		        <?php if($logged){?>
					<a href="index.php?show=cp&more=lended">Δανεισμένα</a>
			    <?php } else{?>
					Διασημότερα
			    <?php }?>
			</div>
			<div class="box index-box link">Νέες κυκλοφορίες</div>
			<div class="box index-box link">Προτάσεις</div>
			<div class="box index-box link">Ανακοινώσεις</div>
			<div class="box index-box link">Δελτία τύπου</div>
			<div class="box index-box link">Θέσεις εργασίας</div>
		</div>
	<?php } ?>
	<div id="index-content">
		<?php pages::get_body(1); ?>
	</div>
</div>
