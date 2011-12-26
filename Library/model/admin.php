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
		
	}
	
	function show_history(){
		global $user;
		$user->show_history(1);
		//TODO Have to group them by book and disable lending for already dended books
	}
	
	function show_options(){
		
	}
	
	function show_info(){
		
	}
	
	function create_user(){
		global $db, $user;
		if(isset($_POST['hidden']) && $_POST['hidden'] == 1)
		{
			if(	!isset($_POST['username']) 		|| !isset($_POST['password']) || 
				!isset($_POST['email']) 		|| !isset($_POST['department']) ||
				empty($_POST['username']) 		|| empty($_POST['password']) || 
				empty($_POST['email']) 			|| empty($_POST['department']))
			{
				?>
				<p class="error">Cannot Create the User!</p>
				<?php 
			}
			else{
			//do the new user creation
			$user->createUser(	mysql_real_escape_string($_POST['username']), 
								mysql_real_escape_string($_POST['password']), 
								mysql_real_escape_string($_POST['email']), 
								mysql_real_escape_string($_POST['department']));
			?>
			<p class="success">The User have been created!</p>
			<?php 
			}
		}
		?>
		<form action="" method="post" id="new-user-form">
		<label for="username">Username: </label><input type="text" id="username" name="username" /><br />
		<label for="password">Password: </label><input type="text" id="password" name="password" /><br />
		<label for="email">E-mail: </label><input type="email" id="email" name="email" /><br />
		<label for="department">Department: </label>
			<select id="department" name="department">
				<?php 
					$query = "SELECT * FROM `{$db->table["departments"]}` ;";
					$results = $db->query($query);
					while($row = mysql_fetch_object($results)){
						echo "<option value=\"{$row->{$db->columns["departments"]["id"]}}\">{$row->{$db->columns["departments"]["name"]}}</option>";
					}
				?>
			</select><br />
		<input type="hidden" name="hidden" value="1" />
		<input type="submit" value="Create" />
		</form>
		<?php 
	}
	
	function create_department(){
		global $db;
		//TODO end the process and the edit
	?>
		<h2>Edit a department</h2>
		<form action="" method="post" id="edit-department-form" >
			<label for="dep">Old name: </label>
			<select name="names">
				<?php 
					$query = "SELECT * FROM `{$db->table["departments"]}` ;";
					$results = $db->query($query);
					while($row = mysql_fetch_object($results)){
						echo "<option value=\"{$row->{$db->columns["departments"]["id"]}}\">{$row->{$db->columns["departments"]["name"]}}</option>";
					}
				?>
			</select>
			<label for="dep_name">New Department Name: </label><input type="text" name="dep_name" id="dep_name" /><br />
			<label for="">In Charge: </label><input type="text" name="" id="" />
			<input type="hidden" name="hidden" value="1" />
			<input type="submit" value="Edit" />
		
		</form>
		<h2>Create a new department</h2>
		<form action="" method="post" id="new-department-form" >
			<label for="dep_name">Department Name:</label><input type="text" name="dep_name" id="dep_name" /><br />
			<input type="hidden" name="hidden" value="1" />
			<input type="submit" value="Create" />
		</form>
	<?php 	
	}
	
	function show_users(){
		global $db;
		//TODO may use pages for the results
		$query = "SELECT * FROM `users` ;";
		$res = $db->query($query);
		?>
		<table >
		<tr>
			<th>ID</th>
			<th>Username</th>
			<th>Department</th>
			<th>Phone</th>
			<th>email</th>
		</tr>
		<?php 
		while($row = mysql_fetch_object($res)){
			?>
			<tr>
				<td><?php echo $row->id; ?></td>
				<td><a href="?show=admin&more=user&id=<?php echo $row->id; ?>"><?php echo $row->username; ?></a></td>
				<td><?php echo $row->dep_id; ?></td>
				<td><?php echo $row->phone; ?></td>
				<td><?php echo $row->email; ?></td>
			</tr>
			<?php 
		}
		?>
		</table>
		<?php 
		
	}
	
	function show_user($id){
	global $user;
	?>
	<p >WARNING! CHANGES WILL NOT TAKE AFFECT!</p>
	<?php 
	$user->show_info($id);	
	}
}
?>