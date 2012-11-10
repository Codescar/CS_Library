<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	if(!$user->is_logged_in() || !$user->is_admin()){
		echo "<div class=\"content\"><div class=\"error\">Δεν είστε διαχειριστής<br />";
		redirect("index.php?show=cp", 1500); 
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
		        }elseif($_GET['more'] == "del_user" && isset($_GET['id'])){
					$msg = "<a href=\"index.php?show=admin&more=users\">Χρήστες</a>&nbsp;&gt;&gt;&nbsp;";
					$msg .= "Διαγραφή Χρήστη</div>";
		        }elseif($_GET['more'] == "statistics"){
                    $msg = "Στατιστικά</div>";
    	        }elseif($_GET['more'] == "options"){
			        $msg = "Ρυθμίσεις</div>";
		        }elseif($_GET['more'] == "update"){
		        	$msg = "Update Codescar Library</div>";
	        	}elseif($_GET['more'] == "lend"){
	        		$msg = "Δανεισμός Βιβλίου</div>";
			    }elseif($_GET['more'] == "return"){
					$msg = "Επιστροφή Βιβλίου</div>";
				}elseif($_GET['more'] == "renewal"){
					$msg = "Ανανέωση Βιβλίου</div>";
				}elseif($_GET['more'] == "request_delete"){
					$msg = "Διαγραφή αιτήματος</div>";
			    }elseif($_GET['more'] == "backup"){
			    	$msg = "Αντίγραφα Ασφαλείας</div>";
			    }elseif($_GET['more'] == "mailtemplates"){
			    	$msg = "Πρότυπα Αυτόματων Μυνημάτων</div>";
			    }elseif($_GET['more'] == "user" && isset($_GET['id'])){
			        $msg = "<a href=\"index.php?show=admin&more=users\" >Χρήστες</a>&nbsp;&gt;&gt;&nbsp;".user::get_name($_GET['id'])."</div>";
			    }else{ ?>
					</div><?php 
                }
                if(isset($msg)) echo $msg; 
            } ?>
		<?php echo "<div class=\"content\">";
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
			$user->show_history();
		}elseif($_GET['more'] == "user_history" && isset($_GET['id'])){
			$user->show_history($db->db_escape_string($_GET['id']));
		}elseif($_GET['more'] == "users" && !isset($_GET['add'])){
			$user->admin->show_users();
		}elseif($_GET['more'] == "user" && isset($_GET['id'])){
			$user->admin->show_user($db->db_escape_string($_GET['id']));
		}elseif($_GET['more'] == "del_user" && isset($_GET['id'])){
			user::delete_user($_GET['id']);
		}elseif($_GET['more'] == "users" && 
				(isset($_GET['add']) &&  $_GET['add'] == "new_user")){
			$user->admin->create_user();
		}elseif($_GET['more'] == "options"){
			$user->admin->show_options();
		}elseif($_GET['more'] == "maintenance"){
			$user->admin->maintenance();
	  	}elseif($_GET['more'] == "update"){
	  		include('update.php');
	  	}elseif($_GET['more'] == "lend"){
	  		if(!isset($_GET['lend']) && !isset($_GET['user'])){
	  			echo "<div class=\"error\">Συνέβησε ένα σφάλμα, παρακαλώ δοκιμάστε ξανά<br />";
		        redirect("index.php?show=admin&more=pendings");
	  		}else{
				if($user->admin->lend_book($db->db_escape_string($_GET['lend']), $db->db_escape_string($_GET['user']))){
					echo "<div class=\"success\">Ο δανεισμός καταγράφηκε<br />";
					redirect("index.php?show=admin&more=pendings");
				} else {
					echo "<div class=\"error\">Ο χρήστης δεν επιτρέπεται να πάρει άλλα βιβλία, ας επιστρέψει πρώτα κάποιο<br />";
					redirect("index.php?show=admin&more=pendings", 2000);
				}
			}
	  	}elseif($_GET['more'] == "return"){
			if(!isset($_GET['return']) && !isset($_GET['user'])){
				echo "<div class=\"error\">Συνέβησε ένα σφάλμα, παρακαλώ δοκιμάστε ξανά<br />";
		        redirect("index.php?show=admin&more=pendings");
		    }else{
		    	$book = new book($db->db_escape_string($_GET['return']));
		    	$user->admin->return_book($db->db_escape_string($_GET['return']), $db->db_escape_string($_GET['user']));
		    	$u_name = user::get_name($db->db_escape_string($_GET['user']));
		    	$b_name = $book->get_book_name();
		    	echo "<div class=\"success\">Ο χρήστης ".$u_name." επέστρεψε το βιβλίο ".$b_name."<br />Η επιστροφή καταγράφηκε<br />";
		    	redirect("index.php?show=admin&more=pendings");
		    }
		}elseif($_GET['more'] == "renewal"){
			if(!isset($_GET['renewal']) && !isset($_GET['user'])){
				echo "<div class=\"error\">Συνέβησε ένα σφάλμα, παρακαλώ δοκιμάστε ξανά<br />";
		        redirect("index.php?show=admin&more=pendings");
		    }else{
		    	$book = new book($db->db_escape_string($_GET['renewal']));
		    	$res = $user->admin->renew_book($db->db_escape_string($_GET['renewal']), $db->db_escape_string($_GET['user']));
			    $u_name = user::get_name($db->db_escape_string($_GET['user']));
		    	if($res){
			    	$b_name = $book->get_book_name();
			    	echo "<div class=\"success\">Ο χρήστης ".$u_name." μπορεί να κρατήσει<br />το βιβλίο ".$b_name." για ακόμα μερικές μέρες<br />";
			    	redirect("index.php?show=admin&more=pendings", 1500);
			    }else{
					echo "<div class=\"error\">Ο χρήστης ".$u_name." πρέπει να επιστρέψει το βιβλίο<br />";
					redirect("index.php?show=admin&more=pendings");
				}
		    }
		}elseif($_GET['more'] == "request_delete"){
			if(!isset($_GET['book']) && !isset($_GET['user'])){
				echo "<div class=\"error\">Συνέβησε ένα σφάλμα, παρακαλώ δοκιμάστε ξανά<br />";
				redirect("index.php?show=admin&more=pendings");
			}else{
				$db->delete_request($db->db_escape_string($_GET['book']), $db->db_escape_string($_GET['user']));
				echo "<div class=\"success\">Το αίτημα διαγράφηκε<br />";
				redirect("index.php?show=admin&more=pendings", 1500);
			}
		}elseif($_GET['more'] == "backup"){
			include('backup.php');
		}elseif($_GET['more'] == "mailtemplates"){
			include('mailTemplates.php');
		}
	echo "</div>";
	} ?>