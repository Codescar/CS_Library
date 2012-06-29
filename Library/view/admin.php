<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	if(!$user->is_logged_in() || !$user->is_admin()){
	?>
		<p class="error">Δεν είστε διαχειριστής.</p>	
	<?php 
	}else{
		if(!isset($_GET['more'])){ ?>
			<div id="direction"><a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;Διαχειριστικό Πάνελ</a></div>
        <?php }elseif($_GET['more'] == "history"){ ?>
			<div id="direction"><a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;<a href="index.php?show=admin">Διαχειριστικό Πάνελ</a>&nbsp;&gt;&gt;&nbsp;Ιστορικό</div>
		<?php }elseif($_GET['more'] == "pendings"){ ?>
			<div id="direction"><a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;<a href="index.php?show=admin">Διαχειριστικό Πάνελ</a>&nbsp;&gt;&gt;&nbsp;Σε αναμονή</div>
		<?php }elseif($_GET['more'] == "announcements"){ ?>
			<div id="direction"><a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;<a href="index.php?show=admin">Διαχειριστικό Πάνελ</a>&nbsp;&gt;&gt;&nbsp;Ανακοινώσεις</div>
		<?php }elseif($_GET['more'] == "users"){ ?>
			<div id="direction"><a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;<a href="index.php?show=admin">Διαχειριστικό Πάνελ</a>&nbsp;&gt;&gt;&nbsp;Χρήστες</div>
		<?php }elseif($_GET['more'] == "statistics"){ ?>
			<div id="direction"><a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;<a href="index.php?show=admin">Διαχειριστικό Πάνελ</a>&nbsp;&gt;&gt;&nbsp;Στατιστικά</div>
        <?php }elseif($_GET['more'] == "new_user"){ ?>
        	<div id="direction"><a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;<a href="index.php?show=admin">Διαχειριστικό Πάνελ</a>&nbsp;&gt;&gt;&nbsp;Δημιουργία Χρήστη</div>
    	<?php }elseif($_GET['more'] == "options"){ ?>
			<div id="direction"><a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;<a href="index.php?show=admin">Διαχειριστικό Πάνελ</a>&nbsp;&gt;&gt;&nbsp;Επιλογές</div>
        <?php }else{ ?>
			<div id="direction"><a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;Διαχειριστικό Πάνελ</div>
    <?php } ?>
<div class="content">
	<?php
	global $db;
	if(!isset($_GET['more'])){
		$user->admin->show_index();
	}elseif($_GET['more'] == "pendings"){
		$user->admin->show_pendings();
	}elseif($_GET['more'] == "announcements"){
		$user->admin->manage_announce();
	}elseif($_GET['more'] == "pages"){
		$user->admin->manage_pages();
	}elseif($_GET['more'] == "statistics"){
	    $user->admin->show_statistics();
	}elseif($_GET['more'] == "history"){
		$user->admin->show_history();
	}elseif($_GET['more'] == "new_user"){
		$user->admin->create_user();
	}elseif($_GET['more'] == "options"){
		$user->admin->show_options();
	}elseif($_GET['more'] == "users"){
		$user->admin->show_users();
	}elseif($_GET['more'] == "user" && isset($_GET['id'])){
		$user->admin->show_user($_GET['id']);
	}elseif($_GET['more'] == "user_history" && isset($_GET['id'])){
		$user->admin->user_history($_GET['id']);
	}elseif($_GET['more'] == "lend"){
		if(!isset($_GET['lend']) && !isset($_GET['user']))
			echo "<p class=\"error\">Error</p>";
		else{
		    echo "<p class=\"success\">Done, Lended book {$_GET['lend']} to user with id {$_GET['user']}.</p>";
		    $db->lend_book(mysql_real_escape_string($_GET['lend']), mysql_real_escape_string($_GET['user']), '0');
		}
	}
	elseif($_GET['more'] == "return"){
	    if(!isset($_GET['return']) && !isset($_GET['user']))
	        echo "<p class=\"error\">Error</p>";
	    else{
	        echo "<p class=\"success\">Done, book {$_GET['return']} returned from user with id {$_GET['user']}.</p>";
	        $db->return_book(mysql_real_escape_string($_GET['return']));
	    }
	}
	?>
	<br />
</div>
<?php } ?>