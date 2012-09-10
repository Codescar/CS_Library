<?php
/*  Admin class 
 */

//TODO use access lever and privilages for any action to a admin-user or even a user

class Admin{
	
	function __constructor($user){
		$this->user = $user;
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
		
		$r1 = $db->db_num_rows($db->query($q1));
		$r2 = $db->db_num_rows($db->query($q2));
		$r3 = $db->db_num_rows($db->query($q3));
		$r4 = $db->db_num_rows($db->query($q4));
		?>
		Library Statistics: <br />
		All users Count:			<?php echo $r1; ?><br />
		All Books Count:			<?php echo $r2; ?><br />
		All Books Now lended:		<?php echo $r4; ?><br />
		All lends done until now:	<?php echo $r3; ?><br />
		<?php 
	}

	function show_options(){
		global $db;
		$option = new option();
		$edit = false;
		if(isset($_GET['name']) && isset($_GET['value']) && isset($_GET['description']))
			$edit = true;
		if(!isset($_GET['cat_id']) || $_GET['cat_id'] == 3)
			$category = 3;
		elseif($_GET['cat_id'] == 2)
			$category = 2;
		elseif($_GET['cat_id'] == 1)
			$category = 1;
		?>
		<div class="block opt-category <?php echo ($category == 3) ? "opt-category-active" : ""; ?>"><a href="index.php?show=admin&more=options&cat_id=3" >Ρυθμίσεις Δανεισμού</a></div>
		<div class="block opt-category <?php echo ($category == 2) ? "opt-category-active" : ""; ?>"><a href="index.php?show=admin&more=options&cat_id=2" >Ρυθμίσεις Διαχειριστή</a></div>
		<div class="block opt-category <?php echo ($category == 1) ? "opt-category-active" : ""; ?>"><a href="index.php?show=admin&more=options&cat_id=1" >Ρυθμίσεις για Developers</a></div>
        <form style="margin: 20px 0 0 0;" action="index.php?show=admin&more=options&cat_id=<?php echo $category; ?>" method="post">
            <div class="block new-opt-name-value-div center">
            	<label class="bold" for="name">Όνομα: </label><br />
            	<input type="text" id="name" name="name" required="required" value="<?php echo ($edit) ? $_GET['name'] : "" ; ?>" />
            	<br />
            	<label class="bold" for="value">Τιμή: </label><br />
            	<input type="text" id="value" name="value" value="<?php echo ($edit) ? $_GET['value'] : "" ; ?>" />
            </div>
            <div class="block new-opt-description-div center">
				<label class="bold" for="description">Περιγραφή: </label><br />
            	<textarea id="description" name="description"><?php echo ($edit) ? $_GET['description'] : "" ; ?></textarea>
            </div>
            <div class="block new-opt-save">
				<input class="cp-button bold center link box" type="submit" value="<?php echo ($edit) ? "Αποθήκευσε" : "Πρόσθεσε"; ?>" />
			</div>
			<input type="hidden" name="id" value="<?php echo ($edit) ? $_GET['id'] : "" ; ?>" />
			<input type="hidden" name="id" value="<?php echo (isset($_GET['cat_id'])) ? $_GET['cat_id'] : "3" ; ?>" />
            <input type="hidden" name="hidden" value="codescar" />
        </form>
        <?php
		if(isset($_GET['delete']) && $_GET['delete'] == 'true')
			option::delete($_GET['id']);
        if(isset($_POST['hidden']) && $_POST['hidden'] == 'codescar')
            option::save($_POST['name'], $_POST['value'], $_POST['description'], $_POST['id'], $_GET['cat_id']);
        $res = option::list_all($category);
		?> <?php
		while($option = $db->db_fetch_object($res, 'option')){
			$edit_link = "index.php?show=admin&more=options&cat_id=".$category."&id=".$option->id."&name=".$option->name."&description=".$option->description."&value=".$option->value;
			$delete_link = "index.php?show=admin&more=options&cat_id=".$category."&delete=true&id=".$option->id; ?>
			<div class="option">
				<div class="block bold opt-name<?php echo ($category == 1) ? "2" : ""; ?>"><?php echo $option->name; ?></div>
				<div class="block opt-description<?php echo ($category == 1) ? "2" : ""; ?>"><?php echo $option->description; ?></div>
				<div class="block opt-value<?php echo ($category == 1) ? "2" : ""; ?>"><?php echo $option->value; ?></div>
				<div class="block opt-action"><a href="<?php echo $edit_link; ?>" >Edit</a></div>
				<div class="block opt-action"><a class="delete-option" href="<?php echo $delete_link; ?>">Delete</a></div>
			</div><?php
		}
	}
	
	function show_pendings(){
		global $user, $db, $lend_res, $request_res;
		
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
		$request_res 	= $db->query($request_query);
		render_template("adminPanelPendings.php");
	}
	
	function create_user(){
		global $db, $user;
		if(isset($_POST['hidden']) && $_POST['hidden'] == "codescar"){
			if(	!isset($_POST['username']) 		|| !isset($_POST['password']) || 
				!isset($_POST['email']) 		||  empty($_POST['username']) || 
				 empty($_POST['password']) 		||  empty($_POST['email']) ){
				echo "<div class=\"error\">Ο χρήστης δεν δημιουργήθηκε, δεν δώσατε τις απαραίτητες πληροφορίες.<br />";
				redirect("index.php?show=admin&more=users", 2000);
				echo "<br />";
			}
			else{
                $user->createUser(	$db->db_escape_string($_POST['username']), 
                                    $db->db_escape_string($_POST['password']), 
                                    $db->db_escape_string($_POST['email'])); 
                echo "<div class=\"success\">Ο χρήστης δημιουργήθηκε και θα λάβει σχετικό email.<br />";
				redirect("index.php?show=admin&more=users");
				echo "<br />";
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
		global $db, $CONFIG, $page;
		$query = "SELECT * FROM `users` ORDER BY `id` LIMIT ".$page*$CONFIG['users_per_page'].", ".$CONFIG['users_per_page'].";";
		$res = $db->query($query);
		?> <table class="add-new-under">
		<tr>
			<th>ID</th>
			<th>Όνομα Χρήστη</th>
			<th>Τηλέφωνο</th>
			<th>Email</th>
		</tr> <?php 
		while($row = $db->db_fetch_object($res)){
			?><tr>
				<td><?php echo $row->id; ?> -- <a class="delete-user" href="?show=admin&more=del_user&id=<?php echo $row->id; ?>">Διαγραφή</a></td>
				<td><a href="?show=admin&more=user&id=<?php echo $row->id; ?>"><?php echo $row->username; ?></a></td>
				<td><?php echo $row->phone; ?></td>
				<td><a href="mailto:<?php echo $row->email; ?>"><?php echo $row->email; ?></a></td>
			</tr> <?php 
		} ?> </table> 
		<a class="add-new link-button" href="?show=admin&amp;more=users&amp;add=new_user">
			<button type="button" class="box link cp-button bold center">Δημιουργία Χρήστη</button>
		</a>
		<?php
		$result = $db->query("SELECT * FROM `{$db->table['users']}`");
		$num = $db->db_num_rows($result);
		paggination($num, -1, -1, $CONFIG['users_per_page']);
	}
	
	function show_user($id){
		global $user, $user_info, $db;
		
		if(isset($_POST['hidden_update']) && $_POST['hidden_update'] == "codescar"){
			$name = $db->db_escape_string($_POST['name']);
			$surname = $db->db_escape_string($_POST['surname']);
			$email = $db->db_escape_string($_POST['email']);
			$born = $db->db_escape_string($_POST['born']);
			$phone = $db->db_escape_string($_POST['phone']);
			$new_pass = $db->db_escape_string($_POST['n_pass']);
			$r_new_pass = $db->db_escape_string($_POST['r_n_pass']);
			$user_id = $db->db_escape_string($_POST['hidden_treasure']);
			$user->update($user_id, $name, $surname, $born, $phone, $email, $new_pass, $r_new_pass);
		}
		if(isset($_GET['ban']) && $_GET['ban'] != ""){
			$db->user_change_attr($_GET['id'], "banned", " + 1 ");
			echo "<div class=\"error\">Ο χρήστης τέθηκε ύπο περιοσμό</div>";
		}
		elseif(isset($_GET['unban']) && $_GET['unban'] != ""){
			$db->user_change_attr($_GET['id'], "banned", " - 1 ");
			echo "<div class=\"success\">Άρθηκε ο περιοσμός του χρήστη</div>";
		}
		$user_info = $user->show_info($id);
		render_template("userControlPanel.php"); ?>
		<div class="center" style="margin: -40px auto 0 auto;">
			<span class="bold">Επιλογές Admin</span>
			<?php if($user_info->banned == 0){ ?>
			<a class="ban-user link-button" href="index.php?show=admin&more=user&id=<?php echo $user_info->id; ?>&ban=1" style="margin: 0 20px 0 10px;">
				<button type="button" class="cp-button link box center bold" style="width: 170px;">Περιορισμός Χρήστη</button>
			</a>
			<?php }else{ ?>
			<a class="unban-user link-button" href="index.php?show=admin&more=user&id=<?php echo $user_info->id; ?>&unban=1" style="margin: 0 20px 0 10px;">
				<button type="button" class="cp-button link box center bold" style="width: 170px;">Αφαίρεση Περιορισμού</button>
			</a>
			<?php } ?>
			<a class="delete-user link-button" href="index.php?show=admin&more=del_user&id=<?php echo $user_info->id; ?>" style="margin: 0 20px;">
				<button type="button" class="cp-button link box center bold" style="width: 100px;">Διαγραφή</button>
			</a>
		</div><?php //TODO select user role
	}

	function lend_book($book_id, $user_id){
		global $db, $CONFIG;
		$user = user::show_info($user_id);
		if($user->books_lended + 1 > $CONFIG['lendings'])
			return false;
		$db->lend_book($book_id, $user_id);
		$db->delete_request($book_id, $user_id);
		$db->change_avail($book_id, 0);
		$db->user_change_attr($user_id, "books_lended", "+ 1");
		return true;
	}

	function return_book($book_id, $user_id){
		global $db;
        $db->return_book($book_id);
        $db->log_the_lend($book_id);
        $db->change_avail($book_id, 1);
        $db->user_change_attr($user_id, "books_lended", "- 1");
        $db->user_change_attr($user_id, "read_books", "+ 1");
        $query = "UPDATE `{$db->table['booklist']}`
	        SET `read_times` = `read_times` + 1
	        WHERE `id` = '$book_id' LIMIT 1";
        $db->query($query);
	}

	function renew_book($book_id, $user_id){
		global $db, $CONFIG;
		$query = "SELECT * FROM `{$db->table['lend']}`
					WHERE `book_id` = '$book_id' AND `user_id` = '$user_id' ";
		$result = $db->query($query);
		$lend = $db->db_fetch_object($result);
		if($lend->renewals < $CONFIG['renewals']){
			$query = "UPDATE `{$db->table['lend']}`
						SET `renewals` = `renewals` + 1 , `must_return` = ADDDATE('$lend->must_return', {$CONFIG['extra_days_lend']})
						WHERE `book_id` = '$book_id' AND `user_id` = '$user_id'";
			$db->query($query);
			return TRUE;
		}
		return FALSE;
	}

	function manage_announce(){
		global $CONFIG, $db;
		$announcement = new announcements();
		if(!isset($_GET['id']) && !isset($_GET['add'])){
            $ret = announcements::list_all(); ?>
            <a class="add-new link-button" href="<?php echo "?".http_build_query(array_merge($_GET, array("id" => 0))); ?>">
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
            while($announcement = $db->db_fetch_object($ret, 'announcements')){
                ?> <tr>
                    <td><?php echo substr($announcement->title, 0, 40); echo (strlen($announcement->title) > 40) ? "..." : ""; ?></td>
                    <td><?php echo substr($announcement->body, 0, 40);  echo (strlen($announcement->body) > 40)  ? "..." : ""; ?></td>
                    <td><?php echo $announcement->username; ?></td>
                    <td><?php echo $announcement->date; ?></td>
                    <td><a href="<?php echo "?".http_build_query(array_merge($_GET, array("id" => $announcement->id))); ?>">Επεξεργασία</a>
                    -- <a class="delete-announce" href="<?php echo "?".http_build_query(array_merge($_GET, array("id" => $announcement->id, "delete" => "true"))); ?>">Διαγραφή</a>
                    </td>
                </tr> <?php
            }
            ?> </table> <?php
        }
        elseif(!isset($_GET['edit']) && !isset($_GET['delete']) && isset($_GET['id'])){
			require_once('model/ckeditor/ckeditor.php');
			?> <script src="<?php echo $CONFIG['url']; ?>model/ckeditor/ckeditor.js" type="text/javascript"></script> <?php
			$new = true;
            if($_GET['id'] != 0){
            	$announcement = announcements::get($db->db_escape_string($_GET['id'])); 
            	$new = false;
            } ?>
            <form action="<?php echo "?".http_build_query(array_merge($_GET, array("edit" => "DONE"))); ?>" method="post">
                <textarea class="ckeditor" name="body" id="body"><?php echo ($new) ? "" : $announcement->body; ?></textarea><br />
                <label for="title" class="bold">Τίτλος:</label>
                    <input type="text" name="title" id="title" value="<?php echo ($new) ? "" : $announcement->title; ?>" />
                <input type="submit" value="Αποθήκευσε" />
            </form> <?php
        }
        elseif(isset($_GET['edit']) && $_GET['edit'] == "DONE" && isset($_GET['id'])){
            if($_GET['id'] != 0)
                announcements::update($_GET['id'], $_POST['title'], $_POST['body'])    ;
            else
                announcements::add($_POST['title'], $_POST['body']);
            echo "<div class=\"success\">Η ανακοίνωση δημιουργήθηκε/ανανεώθηκε.<br />";
            redirect("index.php?show=admin&more=announcements");
        }
        if(isset($_GET['delete']) && $_GET['delete'] == "true" && isset($_GET['id'])){
			announcements::delete($_GET['id']);
            echo "<div class=\"success\">Η ανακοίνωση διαγράφηκε.<br />";
            redirect("index.php?show=admin&more=announcements");
        }
	}

	function manage_pages(){
		global $db, $CONFIG;
		require_once('model/ckeditor/ckeditor.php');
		?><script src="<?php echo $CONFIG['url']; ?>model/ckeditor/ckeditor.js" type="text/javascript"></script><?php
		if(isset($_GET['edit']) && $_GET['edit'] == "DONE" && isset($_GET['id'])){
				pages::update($_GET['id'], $_POST['body']);
			echo "<div class=\"success\">Το κείμενο ανανεώθηκε<br />";
            redirect("index.php?show=admin&more=pages");
		}
	    if(!isset($_GET['id']) && !isset($_GET['add'])){
	        $ret = pages::list_all();
			while($page = $db->db_fetch_object($ret)){
				 echo $page->desc;
				 ?> -- <a href="<?php echo "?".http_build_query(array_merge($_GET, array("id" => $page->id))); ?>">Edit</a><br /> <?php 
			}
	    }
		elseif(!isset($_GET['edit']) && !isset($_GET['delete']) && isset($_GET['id'])){		
			$ret = pages::get($_GET['id']);
			$page = $db->db_fetch_object($ret); ?>
			<form action="<?php echo "?".http_build_query(array_merge($_GET, array("edit" => "DONE"))); ?>" method="post">
				<textarea class="ckeditor" name="body" id="body"><?php echo $page->body; ?></textarea><br />
				<input type="submit" value="Save" />
			</form>	<?php 	
		}
	}
	
	function maintenance(){
		//TODO maybe optimise the database tables
		global $CONFIG, $user;
		
		if($CONFIG['maintenance'])
			$CONFIG['maintenance'] = false;
		else
			$CONFIG['maintenance'] = true;
		
		option::save('maintenance', $CONFIG['maintenance'], "", -1, -1);
		/* Remove invalid favorites (missing user or book) */
		$user->favorites->cleanup_favorites();
		
		if($CONFIG['maintenance']) {
			echo "<div class=\"success\">Η Υπηρεσία μπήκε σε κατάσταση συντήρησης<br />";
		}else{
			echo "<div class=\"success\">Η Υπηρεσία μπήκε σε κανονική κατάσταση λειτουργίας<br />";
		}
			redirect("index.php?show=admin", 1500);
	}
};
?>