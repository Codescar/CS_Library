<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	if(!$user->is_logged_in()){
		?><div class="content"><p class="error">Πρέπει να συνδεθείτε πρώτα.<br /><?php
		redirect("index.php?show=login"); 
	}else{
?>
<div class="content">
	<p ><a href="?show=msg&resieve">Ληφθέντα</a> | <a href="?show=msg&msg=sent">Σταλμένα</a> | <a href="?show=msg&msg=all">Όλα</a> | <a href="?show=msg&msg=new">Δημιουργία</a></p>
	<p>Έχεις <?php echo $user->message->have_new(); ?> νέα μυνήματα...</p>
	<p >Υπο κατασκευή...</p>
	<?php 
	if(!isset($_GET['msg']) || $_GET['msg'] == "resieve"){
	
	}elseif($_GET['msg'] == "sent"){
		
	}elseif($_GET['msg'] == "all"){
		
	}elseif($_GET['msg'] == "new"){
		
	}
	?>
</div>
<?php } ?>