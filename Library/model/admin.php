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
			<a class="block panel-images" href="index.php?show=admin&more=announcements" >
				<img class="block panel-img" src="view/images/announcements.png" />
				<h3>Announcements</h3>
			</a>
			<a class="block panel-images" href="index.php?show=admin&more=history" >
				<img class="block panel-img" src="view/images/log.png" />
				<h3>History</h3>
			</a>
			<a class="block panel-images" href="index.php?show=admin&more=users" >
				<img class="block panel-img" src="view/images/users.png" />
				<h3>Users</h3>
			</a>
		</div>
		<div class="panel-blocks">
            <a class="block panel-images" href="index.php?show=admin&more=pendings" >
				<img class="block panel-img" src="view/images/attention.png" />
				<h3>Pendings</h3>
			</a>
			<a class="block panel-images" href="index.php?show=admin&more=pages" >
				<img class="block panel-img" src="view/images/pages.png" />
				<h3>Pages</h3>
			</a>
			<a class="block panel-images" href="index.php?show=admin&more=new_user" >
				<img class="block panel-img" src="view/images/user.png" />
				<h3>Create User</h3>
			</a>
        </div>
		<div class="panel-blocks">
            <a class="block panel-images" href="index.php?show=admin&more=statistics" >
				<img class="block panel-img" src="view/images/statistics.png" />
				<h3>Statistics</h3>
			</a>
            <a class="block panel-images" href="index.php?show=admin&more=options" >
				<img class="block panel-img" src="view/images/option.png" />
				<h3>Options</h3>
			</a>
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
		global $user;
		$user->show_history(1);
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
		
		$lend_query 	= "	SELECT * FROM `lend` 
							CROSS JOIN `users` 
							ON lend.user_id = users.id
							CROSS JOIN `booklist` 
							ON lend.book_id = booklist.id; ";
		
		$request_query 	= "	SELECT * FROM `requests` 
							CROSS JOIN `users` 
							ON requests.user_id = users.id 
							CROSS JOIN `booklist` 
							ON requests.book_id = booklist.id
							GROUP BY book_id
							ORDER BY date ASC; ";
		
		$lend_res 		= $db->query($lend_query);
		$requests_res 	= $db->query($request_query);
		?>
		<div id="lends">
            <span class="center"><h3>Lends</h3></span>
			<table>
			<tr>
				<th>Α/Α</th>
				<th>Title</th>
				<th>User</th>
				<th>Action</th>
				<th>Date</th>
				<th>Phone</th>
				<th>Email</th>
			</tr>
			<?php 
				$l = 1;
				while($len = mysql_fetch_object($requests_res)){
					?> <tr>
						<td><?php echo $l++; ?></td>
						<td><?php echo $len->title; ?></td>
						<td><?php echo $len->username; ?>(<?php echo $len->user_id; ?>)</td>
						<?php if(book_avail($len->book_id)){ ?>
							<td><a href="?show=admin&more=lend&lend=<?php echo $len->book_id; ?>&user=<?php echo $len->user_id; ?>" class="request-book">Request</a></td>
						<?php }else{ ?>
							<td>Request</td>
						<?php } ?>
						<td><?php echo $len->date; ?></td>
						<td><?php echo $len->phone; ?></td>
						<td><a href="mailto:<?php echo $ret->email; ?>"><?php echo $len->email; ?></a></td>
					</tr> <?php 
				}
			?> </table>
		</div>
		<div id="returns">
		<span class="center"><h3>Returns</h3></span>
			<table>
			<tr>
				<th>Α/Α</th>
				<th>Title</th>
				<th>User</th>
				<th>Action</th>
				<th>Date</th>
				<th>Phone</th>
				<th>Email</th>
			</tr>
			<?php 
				$r = 1;
				while($ret = mysql_fetch_object($lend_res)){
					?> <tr>
						<td><?php echo $r++; ?></td>
						<td><?php echo $ret->title; ?></td>
						<td><?php echo $ret->username; ?>(<?php echo $ret->user_id; ?>)</td>
						<td><a href="?show=admin&more=return&return=<?php echo $ret->book_id; ?>&user=<?php echo $ret->user_id; ?>" class="return-book">Have it now</a></td>
						<td><?php echo $ret->taken; ?></td>
						<td><?php echo $ret->phone; ?></td>
						<td><a href="mailto:<?php echo $ret->email; ?>"><?php echo $ret->email; ?></a></td>
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
				<td><?php echo $row->email; ?></td>
			</tr> <?php 
		} ?> </table> <?php
	}
	
	function show_user($id){
		global $user;
		?> <p class="error">WARNING! CHANGES WILL NOT TAKE AFFECT!</p><br />
		<p >Click <a href="?show=admin&more=user_history&id=<?php echo $id; ?>">here</a> to see the User's History</p>
		<?php $user->show_info(mysql_real_escape_string($id));	
	}
	
	function user_history($id){
		global $user;
		$user->show_history(0, mysql_real_escape_string($id));
	}
	
	function manage_announce(){
		if(!isset($_GET['id']) && !isset($_GET['add'])){
			$ret = announcements::list_all();
			?> <a href="<?php echo "?".http_build_query(array_merge($_GET, array("id" => 0))); ?>">Add New</a><br />
			<table>
			<tr>
				<th>ID</th>
				<th>Title</th>
				<th>Body</th>
				<th>Date</th>
				<th>Author</th>
				<th>Action</th>
			</tr> <?php 
			while($row = mysql_fetch_array($ret)){
				?> <tr>
					<td><?php echo $row['id']; 		?></td>
					<td><?php echo substr($row['title'], 0, 25); echo (strlen($row['title'])>25) ? "..." : ""; ?></td>
					<td><?php echo substr($row['body'], 0, 25);  echo (strlen($row['body'])>25)  ? "..." : ""; ?></td>
					<td><?php echo $row['date'];	?></td>
					<td><?php echo $row['author'];	?></td>
					<td><a href="<?php echo "?".http_build_query(array_merge($_GET, array("id" => $row[0]))); ?>">Edit</a> -- <a class="delete-announce" href="<?php echo "?".http_build_query(array_merge($_GET, array("id" => $row['id'], "delete" => "true"))); ?>">Delete</a></td>
				</tr> <?php 
			}
			?> </table>	<?php 
		}
		elseif(!isset($_GET['edit']) && !isset($_GET['delete']) && isset($_GET['id'])){
			$ret = announcements::get($_GET['id']);
			$row = mysql_fetch_array($ret);
			?> <form action="<?php echo "?".http_build_query(array_merge($_GET, array("edit" => "DONE")));?>" method="post">
				<label for="title">Title:</label> <input type="text" name="title" id="title" value="<?php echo $row['title']; ?>" /><br />
				<label for="body">Body:</label> <textarea class="ckeditor" name="body" id="body"><?php echo $row['body']; ?></textarea><br />
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
};
?>