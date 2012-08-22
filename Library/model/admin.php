<?php
/*  Admin class 
 */

//TODO use access lever and privilages for any action to a admin-user or even a user

class Admin{
	
	function __constructor($user){
		$this->user = $user;
	}
	
	function lend(){
		
	}
	
	function restore(){
		//TODO add a confirmation link to a table
	
	}

	function show_statistics(){
		global $db;
		//Show the number of all the books, the current lended books
		//The total User Count, the total accepted lends
		$q1 = "SELECT * FROM `users`; ";
		$q2 = "SELECT * FROM `booklist`; ";
		$q3 = "SELECT * FROM `log_lend`; ";
		$q4 = "SELECT * FROM `lend`; ";
		
		$r1 = mysql_num_rows($db->query($q1));
		$r2 = mysql_num_rows($db->query($q2));
		$r3 = mysql_num_rows($db->query($q3));
		$r4 = mysql_num_rows($db->query($q4));
		?>
		Library Statistics: <br />
		All users Count:			<?php echo $r1; ?><br />
		All Books Count:			<?php echo $r2; ?><br />
		All Books Now lended:		<?php echo $r4; ?><br />
		All lends done until now:	<?php echo $r3; ?><br />
		<?php 
	}
	
	function show_history(){
		global $db;
		$query = "	SELECT title, username, taken, returned, book_id, user_id 
					FROM `{$db->table['log_lend']}`
    					CROSS JOIN `{$db->table['users']}`
    						ON `{$db->table['users']}`.id = `{$db->table['log_lend']}`.user_id
    					CROSS JOIN `{$db->table['booklist']}`
    						ON `{$db->table['booklist']}`.id = `{$db->table['log_lend']}`.book_id
    				ORDER BY `{$db->table['log_lend']}`.taken";
		$result = $db->query($query);
		echo "<table id=\"history\"><tr><th>Βιβλίο</th><th>Χρήστης</th><th>Το Πήρε</th><th>Το Έφερε</th></tr>";
		while($book = mysql_fetch_object($result)){
		    echo "<tr><td><a href=\"index.php?show=book&id={$book->book_id}\">{$book->title}</a></td>";
		    echo "<td><a href=\"?show=admin&more=user&id={$book->user_id}\">{$book->username}</a></td>";
		    echo "<td class=\"date\">".date('d-m-Y', strtotime($book->taken))."</td>";
		    echo "<td class=\"date\">".date('d-m-Y', strtotime($book->returned))."</td></tr>\n";
		}
        echo "</table>";
	}
	
	function show_options(){
		if(isset($_GET['delete']) && $_GET['delete'] == 'true')
			option::delete($_GET['id']);
        if(isset($_POST['hidden']) && $_POST['hidden'] == 'codescar')
            option::save($_POST['name'], $_POST['value'], $_POST['description'], $_POST['id']);
		$res = option::list_all();
		?> <?php
		while($option = mysql_fetch_object($res)){
			$edit_link = "index.php?show=admin&more=options&id=".$option->id."&name=".$option->name."&description=".$option->description."&value=".$option->value;
			$delete_link = "index.php?show=admin&more=options&delete=true&id=".$option->id; ?>
			<div class="option">
				<div class="block bold opt-name"><?php echo $option->name; ?></div>
				<div class="block opt-description"><?php echo $option->description; ?></div>
				<div class="block opt-value"><?php echo $option->value; ?></div>
				<div class="block opt-action"><a href="<?php echo $edit_link; ?>" >Edit</a></div>
				<div class="block opt-action"><a href="<?php echo $delete_link; ?>">Delete</a></div>
			</div><?php
		}
        $edit = false;
		if(isset($_GET['name']) && isset($_GET['value']) && isset($_GET['description']))
            $edit = true;
		?>
        <form action="index.php?show=admin&more=options" method="post">
            <h4>Πρόσθεσε νέα ρύθμιση</h4>
            <div class="block new-opt-name-value-div center">
            	<label class="bold" for="name">Όνομα: </label><br />
            	<input type="text" id="name" name="name" value="<?php echo ($edit) ? $_GET['name'] : "" ; ?>" />
            	<br />
            	<label class="bold" for="value">Τιμή: </label><br />
            	<input type="text" id="value" name="value"  value="<?php echo ($edit) ? $_GET['value'] : "" ; ?>" />
            </div>
            <div class="block new-opt-description-div center">
				<label class="bold" for="description">Περιγραφή: </label><br />
            	<textarea id="description" name="description"><?php echo ($edit) ? $_GET['description'] : "" ; ?></textarea>
            </div>
            <div class="block new-opt-save">
				<input class="cp-button bold center link box" type="submit" value="<?php echo ($edit) ? "Αποθήκευσε" : "Πρόσθεσε" ;?>" />
			</div>
			<input type="hidden" name="id" value="<?php echo ($edit) ? $_GET['id'] : "" ; ?>" />
            <input type="hidden" name="hidden" value="codescar" />
        </form>
        <?php
	}
	
	function show_pendings(){
		global $user, $db;
		
		$lend_query 	= "	SELECT * FROM `{$db->table['lend']}`
							CROSS JOIN `{$db->table['users']}`
							ON `{$db->table['lend']}`.user_id = `{$db->table['users']}`.id
							CROSS JOIN `{$db->table['booklist']}`
							ON `{$db->table['lend']}`.book_id = `{$db->table['booklist']}`.id; ";
		
		$request_query 	= "	SELECT * FROM `{$db->table['requests']}` 
							CROSS JOIN `{$db->table['users']}`
							ON `{$db->table['requests']}`.user_id = `{$db->table['users']}`.id 
							CROSS JOIN `{$db->table['booklist']}` 
							ON `{$db->table['requests']}`.book_id = `{$db->table['booklist']}`.id
							GROUP BY `{$db->table['requests']}`.book_id
							ORDER BY date ASC; ";
		
		$lend_res 		= $db->query($lend_query);
		$requests_res 	= $db->query($request_query);
		?>
		<div id="lends">
            <h3 class="center">Αιτήματα Δανεισμού</h3>
			<table>
			<tr>
				<th>Α/Α</th>
				<th>Title</th>
				<th>User</th>
				<th>Action</th>
				<th>Date</th>
			</tr>
			<?php 
				$l = 1;
				while($len = mysql_fetch_object($requests_res)){
					?> <tr>
						<td><?php echo $l++; ?></td>
						<td><?php echo $len->title; ?></td>
						<td><a href="?show=admin&more=user&id=<?php echo $len->user_id; ?>" ><?php echo $len->username; ?></a></td>
						<?php if(book_avail($len->book_id)){ ?>
							<td><a href="?show=admin&more=lend&lend=<?php echo $len->book_id; ?>&user=<?php echo $len->user_id; ?>" class="request-book">Request</a></td>
						<?php }else{ ?>
							<td>Request</td>
						<?php } ?>
						<td><?php echo $len->date; ?></td>
					</tr> <?php 
				}
			?> </table>
		</div>
		<div id="returns">
		<h3 class="center">Δανεισμένα Βιβλία</h3>
			<table>
			<tr>
				<th>Α/Α</th>
				<th>Title</th>
				<th>User</th>
				<th>Action</th>
				<th>Date</th>
			</tr>
			<?php 
				$r = 1;
				while($ret = mysql_fetch_object($lend_res)){
					?> <tr>
						<td><?php echo $r++; ?></td>
						<td><?php echo $ret->title; ?></td>
						<td><a href="?show=admin&more=user&id=<?php echo $ret->user_id; ?>" ><?php echo $ret->username; ?></a></td>
						<td><a href="?show=admin&more=return&return=<?php echo $ret->book_id; ?>&user=<?php echo $ret->user_id; ?>" class="return-book">Have it now</a></td>
						<td><?php echo $ret->taken; ?></td>
					</tr> <?php 
				}
			?> </table>
		</div>
		<?php 
		
	}
	
	function create_user(){
		global $db, $user;
		if(isset($_POST['hidden']) && $_POST['hidden'] == "codescar"){
			if(	!isset($_POST['username']) 		|| !isset($_POST['password']) || 
				!isset($_POST['email']) 		||  empty($_POST['username']) || 
				 empty($_POST['password']) 		||  empty($_POST['email']) ){
				?> <div class="error">Ο χρήστης δεν δημιουργήθηκε, δεν δώσατε τις απαραίτητες πληροφορίες.<br /><?php
				redirect("index.php?show=admin&more=users");
			}
			else{
                $user->createUser(	mysql_real_escape_string($_POST['username']), 
                                    mysql_real_escape_string($_POST['password']), 
                                    mysql_real_escape_string($_POST['email']));
                ?> <div class="success">Ο χρήστης δημιουργήθηκε και θα λάβει σχετικό email.<br /><?php
				redirect("index.php?show=admin&more=users", 4000);
                //TODO send an email to the user 
            }
		} ?>
		<form action="" method="post" id="new-user-form">
		<label for="username">*Όνομα Χρήστη: </label><input type="text" id="username" name="username" required="required" />
		<label for="password">*Κωδικός: </label><input type="password" id="password" name="password" required="required" /><br />
		<label for="email">*E-mail: </label><input type="email" id="email" name="email" required="required" />
		<label for="name">Τηλέφωνο: </label><input type="text" id="phone" name="phone" /><br />
		<input type="hidden" name="hidden" value="codescar" />
		<input type="submit" value="Create" />
		</form> <?php 
	}
	
	function show_users(){
		global $db;
		//TODO may use pages for the results
		$query = "SELECT * FROM `users` ORDER BY `id`;";
		$res = $db->query($query);
		?> <table class="add-new-under">
		<tr>
			<th>ID</th>
			<th>Όνομα Χρήστη</th>
			<th>Τηλέφωνο</th>
			<th>Email</th>
		</tr> <?php 
		while($row = mysql_fetch_object($res)){
			?><tr>
				<td><?php echo $row->id; ?> -- <a href="?show=admin&more=del_user&id=<?php echo $row->id; ?>">Delete</a></td>
				<td><a href="?show=admin&more=user&id=<?php echo $row->id; ?>"><?php echo $row->username; ?></a></td>
				<td><?php echo $row->phone; ?></td>
				<td><a href="mailto:<?php echo $row->email; ?>"><?php echo $row->email; ?></a></td>
			</tr> <?php 
		} ?> </table> 
		<a class="add-new" href="?show=admin&amp;more=users&amp;add=new_user">
			<button type="button" class="box link cp-button bold center">Δημιουργία Χρήστη</button>
		</a>
		<?php
	}
	
	function show_user($id){
		global $user;
		//TODO add a back link
		?> <div class="error">WARNING! CHANGES WILL NOT TAKE AFFECT!</div> <?php
		$user->show_info(mysql_real_escape_string($id));
		render_template("userControlPanel.php");
		//TODO add some options like ban / delete / and so on
	}
	
	function user_history($id){
		global $user;
		$user->show_history(mysql_real_escape_string($id));
	}
	
	function return_book(){
	    global $db, $CONFIG;
	    if(!isset($_GET['return']) && !isset($_GET['user'])){
	        ?><div class="error">Συνέβησε ένα σφάλμα, παρακαλώ δοκιμάστε ξανά <br /><?php
	        redirect("index.php?show=admin&more=pendings");
	        return;
	    }else{
	        $u_name = user::get_name($_GET['user']);
	        $b_name = get_book_name($_GET['return']);
	        $db->return_book(mysql_real_escape_string($_GET['return']));
	        ?><div class="success center">Ο χρήστης<?php echo $u_name; ?> επέστρεψε το βιβλίο <?php echo $b_name."<br />";
	        redirect("index.php?show=admin&more=pendings", 4000);
	    }
	}
	
	function manage_announce(){
	 if(!isset($_GET['id']) && !isset($_GET['add'])){
            $ret = announcements::list_all(); ?>
            <a class="add-new" href="<?php echo "?".http_build_query(array_merge($_GET, array("id" => 0))); ?>">
                <button type="button" class="box link cp-button bold center">Νέα Ανακοίνωση</button>
            </a>
            <table class="add-new-under">
            <tr>
                <th>Τίτλος</th>
                <th>Σώμα</th>
                <th>Συγγραφέας</th>
                <th>Ημερομηνία</th>
                <th>Επιλογές</th>
            </tr> <?php
            while($announcement = mysql_fetch_object($ret)){
                ?> <tr>
                    <td><?php echo substr($announcement->title, 0, 40); echo (strlen($announcement->title) > 40) ? "..." : ""; ?></td>
                    <td><?php echo substr($announcement->body, 0, 40);  echo (strlen($announcement->body) > 40)  ? "..." : ""; ?></td>
                    <td><?php echo $announcement->username; ?></td>
                    <td><?php echo $announcement->date; ?></td>
                    <td><a href="<?php echo "?".http_build_query(array_merge($_GET, array("id" => $announcement->id))); ?>">Επεξεργασία</a> -- <a class="delete-announce" href="<?php echo "?".http_build_query(array_merge($_GET, array("id" => $announcement->id, "delete" => "true"))); ?>">Διαγραφή</a></td>
                </tr> <?php
            }
            ?> </table> <?php
        }
        elseif(!isset($_GET['edit']) && !isset($_GET['delete']) && isset($_GET['id'])){
            $ret = announcements::get($_GET['id']);
            $announcement = mysql_fetch_object($ret); ?>
            <form action="<?php echo "?".http_build_query(array_merge($_GET, array("edit" => "DONE")));?>" method="post">
                <textarea class="ckeditor" name="body" id="body"><?php echo $announcement->body; ?></textarea><br />
                <label for="title" class="bold">Title:</label>
                    <input type="text" name="title" id="title" value="<?php echo $announcement->title; ?>" />
                <input type="submit" value="Save" />
            </form> <?php
        }
        elseif(isset($_GET['edit']) && $_GET['edit'] == "DONE" && isset($_GET['id'])){
            if($_GET['id'] != 0)
                announcements::update($_GET['id'], $_POST['title'], $_POST['body'])    ;
            else
                announcements::add($_POST['title'], $_POST['body']);
            ?> <div class="success">Η ανακοίνωση δημιουργήθηε/ανανεώθηκε.<br /><?php 
            redirect("index.php?show=admin&more=announcements");
        }
        if(isset($_GET['delete']) && $_GET['delete'] == "true" && isset($_GET['id'])){
                announcements::delete($_GET['id']);
                ?> <div class="success">Η ανακοίνωση διαγράφηκε.<br /><?php 
            redirect("index.php?show=admin&more=announcements");
        }
	}

	function manage_pages(){
		if(isset($_GET['edit']) && $_GET['edit'] == "DONE" && isset($_GET['id'])){
				pages::update($_GET['id'], $_POST['body']);
			?> <div class="success">Το κείμενο ανανεώθηκε<br /><?php 
            redirect("index.php?show=admin&more=pages");
		}
	    if(!isset($_GET['id']) && !isset($_GET['add'])){
	        $ret = pages::list_all();
			while($page = mysql_fetch_object($ret)){
				 echo $page->desc;
				 ?> -- <a href="<?php echo "?".http_build_query(array_merge($_GET, array("id" => $page->id))); ?>">Edit</a><br /> <?php 
			}
	    }
		elseif(!isset($_GET['edit']) && !isset($_GET['delete']) && isset($_GET['id'])){		
			$ret = pages::get($_GET['id']);
			$page = mysql_fetch_object($ret);
			?> <form action="<?php echo "?".http_build_query(array_merge($_GET, array("edit" => "DONE")));?>" method="post">
				<label for="body">Body:</label> <textarea class="ckeditor" name="body" id="body"><?php echo $page->body; ?></textarea><br />
				<input type="submit" value="Save" />
			</form>	<?php 	
		}
	}
	
	function maintance(){
		//TODO maybe optimise the mysql tables
		//TODO disable the public access until it's done
		global $CONFIG, $user;
		
		if($CONFIG['maintance'])
			$CONFIG['maintance'] = false;
		else
			$CONFIG['maintance'] = true;
		
		option::save('maintance', $CONFIG['maintance'], "", -1);
		/* Remove invalid favorites (missing user or book) */
		$user->favorites->cleanup_favorites();
		
		if($CONFIG['maintance']) {
			?> <div class="success">Η Υπηρεσία μπήκε σε κατάσταση συντήρησης<br /> <?php
		}else{
			?> <div class="success">Η Υπηρεσία μπήκε σε κανονική κατάσταση λειτουργίας<br /> <?php
		}
			redirect("index.php");
		
		//WTF does the following code do?
// 		if($CONFIG['maintance']){
// 			$CONFIG['maintance'] = true;
// 			$flag = true;
// 		}
// 		else
// 			$flag = false;
		
// 		/* Remove invalid favorites (missing user or book) */
// 		$user->favorites->cleanup_favorites();

// 		if($flag)
// 			$CONFIG['maintance'] = false;
	}

};
?>