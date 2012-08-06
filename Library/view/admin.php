<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	if(!$user->is_logged_in() || !$user->is_admin()){ ?>
		<p class="error">Δεν είστε διαχειριστής.</p>	
	<?php 
	}else{
		if(!isset($_GET['more'])){ ?>
			<div id="direction"><a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;Διαχειριστικό Πάνελ</div>
        <?php }else{ ?>
			<div id="direction"><a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;<a href="index.php?show=admin">Διαχειριστικό Πάνελ</a>&nbsp;&gt;&gt;&nbsp;<?php 
			    if($_GET['more'] == "history"){
				    $msg = "Ιστορικό</div>";
		        }elseif($_GET['more'] == "pendings"){
				    $msg = "Σε αναμονή</div>"; 
                }elseif($_GET['more'] == "pages"){
        	        $msg = "Σελίδες</div>";
		        }elseif($_GET['more'] == "announcements"){
			        $msg = "Ανακοινώσεις</div>";
					if(isset($_GET['id'])){
						$msg = "<a href=\"index.php?show=admin&more=announcements\">Ανακοινώσεις</a>&nbsp;&gt;&gt;&nbsp;";
						if($_GET['id'] == 0)
							$msg .= "Νέα Ανακοίνωση</div>";
						else
							$msg .= "Επεξεργασία Ανακοίνωσης</div>";
					}
		        }elseif($_GET['more'] == "users"){
			        $msg = "Χρήστες</div>";
			        if(isset($_GET['add']) && $_GET['add'] == "new_user"){
			        	$msg = "<a href=\"index.php?show=admin&more=users\">Χρήστες</a>&nbsp;&gt;&gt;&nbsp;";
        	        	$msg .= "Δημιουργία Χρήστη</div>";
			        }
		        }elseif($_GET['more'] == "statistics"){
                    $msg = "Στατιστικά</div>";
    	        }elseif($_GET['more'] == "options"){
			        $msg = "Επιλογές</div>";
			    }elseif($_GET['more'] == "return"){
					$msg = "Επιστροφή Βιβλίου</div>";
			    }elseif($_GET['more'] == "user" && isset($_GET['id'])){
			        $msg = "<a href=\"index.php?show=admin&more=users\" >Χρήστες</a>&nbsp;&gt;&gt;&nbsp;".user::get_name($_GET['id'])."</div>";
			    }else{ ?>
					</div><?php 
                }
                if(isset($msg)) echo $msg; 
            } ?>
<div class="content">
	<?php
	global $db;
	if(!isset($_GET['more'])){
		render_template('adminPanel.php');
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
	}elseif($_GET['more'] == "users" && $_GET['add'] == "new_user"){
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
	}elseif($_GET['more'] == "maintance"){
		$user->admin->maintance();
  	}elseif($_GET['more'] == "update"){
  		include('update.php');
  	}elseif($_GET['more'] == "return"){
	    $user->admin->return_book();
	}
	?>
	<br />
</div>
<?php } ?>