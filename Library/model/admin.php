<?php
/*  Admin class 
 */
class Admin{
	
	function __constructor($user){
		$this->user = $user;
	}
	
	function lend(){
		
	}
	
	function restore(){
		
	}
	
	function show_statistics(){
		
	}
	
	function show_history(){
		
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
		
	?>
		<form action="" method="post" id="new-department-form" >
		
		
		</form>
	<?php 	
	}
}
?>