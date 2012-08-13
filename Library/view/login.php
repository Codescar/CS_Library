<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);

	if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'])
		header('Location: index.php');
		
	
	if(isset($_GET['do']) && $_GET['do'] == "login"){		
		
		if(!isset($_POST['username']) || !isset($_POST['password']) || !$user->login($_POST['username'], $_POST['password'], $_SESSION)){
			$error = "Λάθος στοιχεία, δοκιμάστε ξανά...";
		}
		elseif($CONFIG['maintance'] && $user->access_level < 100) {
			$error = "Μόνο admins μπορούν να εισέλθουν κατά την συντήρηση";
		}
		else {
			if($user->is_admin())
				$user->admin = new Admin($user);
			
			$user->favorites = new favorites;
			
			$_SESSION['user']   = serialize($user);
			?>
			<div id="direction"><a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;Είσοδος</div>
			<div class="content">
    			<div class="success">Επιτυχής σύνδεση...<br />
    		<?php redirect($CONFIG['url']);
		}
	}elseif(isset($_GET['do']) && $_GET['do'] == "register"){
		if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['password2']) || empty($_POST['mail']) || $_POST['password'] != $_POST['password2'])
			$error = "Λάθος πληροφορίες, δοκιμάστε ξανά...";
		else{
			if(user::username_check($_POST['username']))
				$error = "Το όνομα χρήστη χρησιμοποιείται ήδη...";
			else{
				user::createUser($_POST['username'], $_POST['password'], $_POST['mail']);
				$success = "Ο λογαριασμός σας δημιουργήθηκε, παρακαλούμε συνδεθείτε.";
			}
		}
	}
if(isset($error) || isset($success) ||!isset($_GET['do'])){
?>
<div id="direction"><a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;Είσοδος/Εγγραφή Χρήστη</div>
<div class="content">
<?php if(isset($error) && !empty($error)) echo "<div class=\"error\">".$error."</div><br/>";?>
<?php if(isset($success) && !empty($success)) echo "<div class=\"success\">".$success."</div><br/>";?>
<fieldset>
	<legend class="bold" style="font-size: 20px;">Σύνδεση χρήστη</legend>
	<form action="?show=login&do=login" method="post" id="login-form">
	<label for="username">Όνομα Χρήστη: </label>
	<input type="text" name="username" id="username" /><br/>
	<label for="password">Κωδικός Πρόσβασης: </label>
	<input type="password" name="password" id="password" /><br/>
	<input type="submit" value="Υποβολή" class="submit"/>	
	</form>
</fieldset>
<?php if($CONFIG['allow_register']) { ?>
<div class="bold" style="text-align: center; width: 100%; font-size: 20px;">ή</div>
<fieldset>
	<legend class="bold" style="font-size: 20px;">Εγγραφή χρήστη</legend>
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
	<select name="user_type">
		<option selected="selected" value="Αναγνώστης">Αναγνώστης</option>
		<option value="Συγγραφέας">Συγγραφέας</option>
		<option value="Εκδότης">Εκδότης</option>
		<option value="Ερευνητής">Ερευνητής</option>
	</select><br />
	<span>Τα στοιχεία με * είναι απαραίτητα </span>
	<input type="submit" value="Υποβολή" class="submit"/>	
	</form>
</fieldset>
<?php 
	} 
} ?>
<br />
</div>