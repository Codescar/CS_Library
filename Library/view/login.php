<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);

	if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'])
		header('Location: index.php');
		
	$db->connect();
	
	if(isset($_GET['do']) && $_GET['do'] == "login"){		
		
		if(!isset($_POST['username']) || !isset($_POST['password']) || !$user->login($_POST['username'], $_POST['password'], $_SESSION))
			$error = "Invalid informations, try again... ";
		else{
			if($user->is_admin())
				$user->admin 	= new Admin($user);
			$_SESSION['user']   = serialize($user);
			?>
			<p>Επιτυχής σύνδεση...<br/>
			Αν δεν γίνεται ανακατεύθυνση, πιέστε <a href="<?php echo $url; ?>">εδώ</a>.</p>
			<script type="text/javascript">
				var t=setTimeout("window.location = '<?php echo $url; ?>'",2000);
			</script>
			<?php 
		}
	}elseif(isset($_GET['do']) && $_GET['do'] == "register"){
		if(!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['password2']) || !isset($_POST['mail']) || $_POST['password'] != $_POST['password2'])
			$error = "Invalid informations, try again... ";
		else{
			if(user::username_check($_POST['username']))
				$error = "Username already exists.";
			else{
				user::createUser($_POST['username'], $_POST['password'], $_POST['mail']);
				$success = "Your account have been created, please login.";
			}
		}
		
	}
if(isset($error) || !isset($_GET['do'])){
?>
<?php if(isset($error) && !empty($error)) echo "<p class=\"error\">".$error."</p><br/>";?>
<?php if(isset($success) && !empty($success)) echo "<p class=\"sucess\">".$success."</p><br/>";?>
<div class="content">
<fieldset>
	<legend style="font-size: 20px; font-weight: bold;">Σύνδεση χρήστη</legend>
	<form action="?show=login&do=login" method="post" id="login-form">
	<label for="username">Όνομα Χρήστη: </label>
	<input type="text" name="username" id="username" /><br/>
	<label for="password">Κωδικός Πρόσβασης: </label>
	<input type="password" name="password" id="password" /><br/>
	<input type="submit" value="Υποβολή" class="submit"/>	
	</form>
</fieldset>
<?php if($CONFIG['allow_register']) { ?>
<br /> ή <br />
<fieldset>
	<legend style="font-size: 20px; font-weight: bold;">Εγγραφή χρήστη</legend>
	<form action="?show=login&do=register" method="post" id="register-form">
	<label for="username">*Όνομα Χρήστη: </label>
	<input type="text" name="username" id="username" />
	<label for="name">Όνομα: </label>
	<input type="text" name="name" id="name" />
	<br />
	<label for="mail">*E-mail επικοινωνίας: </label>
	<input type="email" name="mail" id="mail" />
	<label for="surname">Επίθετο: </label>
	<input type="text" name="surname" id="surname" />
	<br />
	<label for="password">*Κωδικός Πρόσβασης: </label>
	<input type="password" name="password" id="password" />
	<label for="phone">Τηλέφωνο : </label>
	<input type="tel" name="phone" id="phone" />
	<br />
	<label for="password2">*Επιβεβαίωση Κωδικού: </label>
	<input type="password" name="password2" id="password2" />
	<label for="born">Ημερομηνία Γέννησης: </label>
	<input type="date" name="born" id="born" />
	<br />
	<label for="user_type">Τύπος Χρήστη: </label>
	<select id="user_type">
		<option value="reader">Αναγνώστης</option>
		<option value="writer">Συγγραφέας</option>
		<option value="publisher">Εκδότης</option>
		<option value="researcher">Ερευνητής</option>
	</select><br />
	<span>Τα στοιχεία με * είναι απαραίτητα </span>
	<input type="submit" value="Υποβολή" class="submit"/>	
	</form>
</fieldset>
<?php 
	} 
}?>
</div>
<?php $db->close();	?>