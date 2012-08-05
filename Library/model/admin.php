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
	
	function show_index(){
	?>
		<div class="panel-blocks">
			<h3 class="block panel-images"><a class="panel-links" href="index.php?show=admin&more=announcements" >
				<img class="block panel-img" src="view/images/announcements.png" /><br />
				Announcements
			</a></h3>
			<h3 class="block panel-images"><a class="panel-links" href="index.php?show=admin&more=history" >
				<img class="block panel-img" src="view/images/log.png" /><br />
				History
			</a></h3>
			<h3 class="block panel-images"><a class="panel-links" href="index.php?show=admin&more=users" >
				<img class="block panel-img" src="view/images/users.png" /><br />
				Users
			</a></h3>
		</div>
		<div class="panel-blocks">
            <h3 class="block panel-images"><a class="panel-links" href="index.php?show=admin&more=pendings" >
				<img class="block panel-img" src="view/images/attention.png" /><br />
				Pendings
			</a></h3>
			<h3 class="block panel-images"><a class="panel-links" href="index.php?show=admin&more=pages" >
				<img class="block panel-img" src="view/images/pages.png" /><br />
				Pages
			</a></h3>
			<h3 class="block panel-images"><a class="panel-links" href="index.php?show=admin&more=new_user" >
				<img class="block panel-img" src="view/images/user.png" /><br />
				Create User
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
			<h3 class="block panel-images"><a class="panel-links" href="index.php?show=admin&more=maintance" >
				<img class="block panel-img" src="view/images/maintaince.jpg" /><br />
				Maintance
			</a></h3>
        </div>
        <div class="panel-blocks">
            <h3 class="block panel-images"><a class="panel-links" href="index.php?show=admin&more=update" >
				<img class="block panel-img" src="view/images/update.png" /><br />
				Update
			</a></h3>
          
        </div>
	<?php
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
		$flag = 0;
		while($row = mysql_fetch_array($result)){
		    echo "<tr><td><a href=\"index.php?show=book&id={$row['book_id']}\">{$row['title']}</a></td>";
		    echo "<td><a href=\"?show=admin&more=user&id={$row['user_id']}\">{$row['username']}</a></td>";
		    echo "<td class=\"date\">".date('d-m-Y', strtotime($row['taken']))."</td>";
		    echo "<td class=\"date\">".date('d-m-Y', strtotime($row['returned']))."</td></tr>\n";
		}
        echo "</table>"; 
        return;
		//TODO Have to group them by book and disable lending for already dended books
	}
	
	function show_options(){
		if(isset($_GET['delete']) && $_GET['delete'] == 'true')
			option::delete($_GET['name']);
        if(isset($_POST['hidden']) && $_POST['hidden'] == 'codescar')
            option::save($_POST['name'], $_POST['value']);
		$res = option::list_all();
		?><h3>Options Page</h3>
		<div class="block opt-block">Name</div>
		<div class="block opt-block">Value</div>
		<br />
		<?php
		while($option = mysql_fetch_array($res)){
			$edit_link = "index.php?show=admin&more=options&name=".$option['Name']."&value=".$option['Value'];
			$delete_link = "index.php?show=admin&more=options&delete=true&name=".$option['Name']; ?>
			<div class="block opt-block"><?php echo $option['Name']; ?></div>
			<div class="block opt-block"><?php echo $option['Value']; ?></div>
			<div class="block opt-block fl-right"><a href="<?php echo $delete_link; ?>">Delete</a></div>
			<div class="block opt-block fl-right"><a href="<?php echo $edit_link; ?>" >Edit</a></div>
			<br /> <?php
		}
        $edit = false;
		if(isset($_GET['name']) && isset($_GET['value']))
            $edit = true;
		?>
        <form action="" method="post">
            <h4>Πρόσθεσε νέο option</h4>
            <div class="block opt-block"><label for="name">Name: </label>
            	<input type="text" id="name" name="name" value="<?php echo ($edit) ? $_GET['name'] : "" ; ?>" />
            </div>
            <div class="block opt-block"></div>
            <div class="block opt-block"><label for="value">Value: </label>
            	<input type="text" id="value" name="value"  value="<?php echo ($edit) ? $_GET['value'] : "" ; ?>" />
            </div>
            <div class="block opt-block"></div>
            <div class="block opt-block"><input type="submit" value="<?php echo ($edit) ? "Save" : "Add" ;?>" /></div>
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
            <h3 class="center">Lends</h3>
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
		<h3 class="center">Returns</h3>
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
		if(isset($_POST['hidden']) && $_POST['hidden'] == 1){
			if(	!isset($_POST['username']) 		|| !isset($_POST['password']) || 
				!isset($_POST['email']) 		|| !isset($_POST['department']) ||
				empty($_POST['username']) 		|| empty($_POST['password']) || 
				empty($_POST['email']) 	){
				?> <p class="error">Cannot Create the User!</p>	<?php 
			}
			else{
                //do the new user creation
                $user->createUser(	mysql_real_escape_string($_POST['username']), 
                                    mysql_real_escape_string($_POST['password']), 
                                    mysql_real_escape_string($_POST['email']));
                ?> <p class="success">The User have been created!</p> <?php 
            }
		} ?>
		<form action="" method="post" id="new-user-form">
		<label for="username">Username: </label><input type="text" id="username" name="username" /><br />
		<label for="password">Password: </label><input type="text" id="password" name="password" /><br />
		<label for="email">E-mail: </label><input type="email" id="email" name="email" /><br />
		<input type="hidden" name="hidden" value="1" />
		<input type="submit" value="Create" />
		</form> <?php 
	}
	
	function show_users(){
		global $db;
		//TODO may use pages for the results
		$query = "SELECT * FROM `users` ;";
		$res = $db->query($query);
		?> <table>
		<tr>
			<th>ID</th>
			<th>Username</th>
			<th>Phone</th>
			<th>email</th>
		</tr> <?php 
		while($row = mysql_fetch_object($res)){
			?><tr>
				<td><?php echo $row->id; ?></td>
				<td><a href="?show=admin&more=user&id=<?php echo $row->id; ?>"><?php echo $row->username; ?></a></td>
				<td><?php echo $row->phone; ?></td>
				<td><a href="mailto:<?php echo $row->email; ?>"><?php echo $row->email; ?></a></td>
			</tr> <?php 
		} ?> </table> <?php
	}
	
	function show_user($id){
		global $user;
		//TODO add a back link
		?> <p class="error">WARNING! CHANGES WILL NOT TAKE AFFECT!</p> <?php
		$user->show_info(mysql_real_escape_string($id));
		//TODO add some options like ban / delete / and so on
	}
	
	function user_history($id){
		global $user;
		$user->show_history(0, mysql_real_escape_string($id));
	}
	
	function return_book(){
	    global $db;
	    if(!isset($_GET['return']) && !isset($_GET['user'])){
	        ?> <p class="error">Error</p> <?php
	        return;
	    }else{
	        $u_name = user::get_name($_GET['user']);
	        $b_name = get_book_name($_GET['return']);
	        ?><p class="success center">Ο χρήστης<?php echo $u_name; ?> επέστρεψε το βιβλίο <?php echo $b_name; ?></p><?php
	        $db->return_book(mysql_real_escape_string($_GET['return']));
	    }
	}
	
	function manage_announce(){
		if(!isset($_GET['id']) && !isset($_GET['add'])){
			$ret = announcements::list_all(); ?> 
			<a class="add-new" href="<?php echo "?".http_build_query(array_merge($_GET, array("id" => 0))); ?>">
				<button type="button" class="box link">Νέα Ανακοίνωση</button>
			</a>
			<table>
			<tr>
				<th>Title</th>
				<th>Body</th>
				<th>Author</th>
				<th>Date</th>
				<th>Action</th>
			</tr> <?php 
			while($row = mysql_fetch_array($ret)){
				?> <tr>
					<td><?php echo substr($row['title'], 0, 40); echo (strlen($row['title']) > 40) ? "..." : ""; ?></td>
					<td><?php echo substr($row['body'], 0, 40);  echo (strlen($row['body']) > 40)  ? "..." : ""; ?></td>
					<td><?php echo User::get_name($row['author']);	?></td>
					<td><?php echo $row['date'];	?></td>
					<td><a href="<?php echo "?".http_build_query(array_merge($_GET, array("id" => $row[0]))); ?>">Edit</a> -- <a class="delete-announce" href="<?php echo "?".http_build_query(array_merge($_GET, array("id" => $row['id'], "delete" => "true"))); ?>">Delete</a></td>
				</tr> <?php 
			}
			?> </table>	<?php 
		}
		elseif(!isset($_GET['edit']) && !isset($_GET['delete']) && isset($_GET['id'])){
			$ret = announcements::get($_GET['id']);
			$row = mysql_fetch_array($ret); ?>
			<form action="<?php echo "?".http_build_query(array_merge($_GET, array("edit" => "DONE")));?>" method="post">
				<textarea class="ckeditor" name="body" id="body"><?php echo $row['body']; ?></textarea><br />
				<label for="title" class="bold">Title:</label> 
					<input type="text" name="title" id="title" value="<?php echo $row['title']; ?>" />
				<input type="submit" value="Save" />
			</form> <?php 	
		}
		elseif(isset($_GET['edit']) && $_GET['edit'] == "DONE" && isset($_GET['id'])){
			if($_GET['id'] != 0)
				announcements::update($_GET['id'], $_POST['title'], $_POST['body'])	;
			else
				announcements::add($_POST['title'], $_POST['body']);
			?> <p class="success">Announcement Added/Updated</p> <?php 
		}
		if(isset($_GET['delete']) && $_GET['delete'] == "true" && isset($_GET['id'])){
				announcements::delete($_GET['id']);
				?> <p class="success">The announcement has been removed.</p> <?php 
		}				
	}

	function manage_pages(){
	    if(!isset($_GET['id']) && !isset($_GET['add'])){
	        $ret = pages::list_all();
			while($row = mysql_fetch_array($ret)){
				 echo $row['desc'];
				 ?> -- <a href="<?php echo "?".http_build_query(array_merge($_GET, array("id" => $row[0]))); ?>">Edit</a><br /> <?php 
			}
	    }
		elseif(!isset($_GET['edit']) && !isset($_GET['delete']) && isset($_GET['id'])){		
			$ret = pages::get($_GET['id']);
			$row = mysql_fetch_array($ret);
			?> <form action="<?php echo "?".http_build_query(array_merge($_GET, array("edit" => "DONE")));?>" method="post">
				<label for="body">Body:</label> <textarea class="ckeditor" name="body" id="body"><?php echo $row['body']; ?></textarea><br />
				<input type="submit" value="Save" />
			</form>	<?php 	
		}
		elseif(isset($_GET['edit']) && $_GET['edit'] == "DONE" && isset($_GET['id'])){
				pages::update($_GET['id'], $_POST['body']);
			?> <p class="success">Page Updated</p> <?php 
		}
	}
	
	function maintance(){
		//TODO maybe optimise the mysql tables
		//TODO disable the public access until it's done
		
		global $CONFIG;
		
		if($CONFIG['maintance']){
			$CONFIG['maintance'] = true;
			$flag = true;
		}
		else
			$flag = false;
		
		/* Remove invalid favorites (missing user or book) */
		favorites::cleanup_favorites();

		if($flag)
			$CONFIG['maintance'] = false;
	}

};
?>