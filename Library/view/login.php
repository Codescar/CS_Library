<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);

	if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'])
		header('Location: index.php');

	if(isset($_GET['do']) && $_GET['do'] == "login"){		
		
		if(!isset($_POST['username']) || !isset($_POST['password']) || !$user->login($_POST['username'], $_POST['password'], $_SESSION)){
			$error = "Λάθος στοιχεία, δοκιμάστε ξανά...";
			session_unset();
			session_destroy();
		}
		elseif($CONFIG['maintenance'] && $user->access_level < 100) {
			$error = "Δεν είστε διαχειριστής";
			session_unset();
			session_destroy();
		}
		elseif($CONFIG['register_activation'])
			if($user->access_level == UNACTIVATED_ACCESS_LVL){
				$error = "Ο λογαριασμός δεν είναι ενεργοποιημένος, ενεργοποιήστε τον από το email σας.";
				session_unset();
				session_destroy();
			}
		elseif($user->banned){
			$error = "Σας έχει επιβληθεί περιορισμός και ο λογαριασμός σας είναι απενεργοποιημένος<br />
					 Αν δεν γνωρίζετε τους λόγους που σας επιβλήθηκε περιορισμός, παρακαλώ επικοινωνήστε με τους διαχειρηστές";
			session_unset();
			session_destroy();
		}
		else {
			if($user->is_admin())
				$user->admin = new Admin($user);
			
			$user->favorites = new favorites;
			
			$_SESSION['user']   = serialize($user);
			?>
			<div id="direction"><a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;Είσοδος</div>
			<?php echo "<div class=\"content\">";
    			echo "<div class=\"success\">Επιτυχής σύνδεση...<br />";
    		redirect($CONFIG['url']);
		}
	}elseif(isset($_GET['do']) && $_GET['do'] == "register"){
		if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['password2']) || empty($_POST['mail']) || $_POST['password'] != $_POST['password2'])
			$error = "Λάθος πληροφορίες, δοκιμάστε ξανά...";
		else{
			if(user::username_check($_POST['username']))
				$error = "Το όνομα χρήστη χρησιμοποιείται ήδη...";
			else{
				user::createUser($_POST['username'], $_POST['password'], $_POST['mail']);
				if($CONFIG['register_activation'])
					$success = "Ο λογαριασμός σας δημιουργήθηκε, πριν συνθεθείτε θα πρέπει να τον ενεργοποιήσετε από το email σας.";
				else
					$success = "Ο λογαριασμός σας δημιουργήθηκε, παρακαλούμε συνδεθείτε.";
			}
		}
	}
if(isset($error) || isset($success) ||!isset($_GET['do'])){
?>
<div id="direction"><a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;Είσοδος/Εγγραφή Χρήστη</div>
<div class="content">
	<?php if(isset($error) && !empty($error)) echo "<div class=\"error\">".$error."</div><br/>"; ?>
	<?php if(isset($success) && !empty($success)) echo "<div class=\"success\">".$success."</div><br/>"; ?>
	<?php if($CONFIG['maintenance']) echo "<div class=\"error\">Κατάσταση συντήρησης, μόνο Admins μπορούν να εισέλθουν</div><br/>"; ?>
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
	<?php if($CONFIG['allow_register'] && !$CONFIG['maintenance']) { ?>
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
		<?php if($CONFIG['allow-user-class']) { ?>
		<label for="user_type">Τύπος Χρήστη: </label>
		<select name="user_type">
			<option selected="selected" value="Αναγνώστης">Αναγνώστης</option>
			<option value="Συγγραφέας">Συγγραφέας</option>
			<option value="Εκδότης">Εκδότης</option>
			<option value="Ερευνητής">Ερευνητής</option>
		</select><br />
		<?php } ?>
		<span>Τα στοιχεία με * είναι απαραίτητα </span>
		<input type="submit" value="Υποβολή" class="submit"/>	
		</form>
	</fieldset>
	<?php 
		} 
	} ?>
</div>