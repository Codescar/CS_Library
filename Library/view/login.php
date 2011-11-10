<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);

	if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'])
		header('Location: index.php');
		
	if(isset($_GET['do']) && $_GET['do'] == "login"){
		
		if(!isset($_POST['username']) || !isset($_POST['password']) || !$user->login($_POST['username'], $_POST['password'], $_SESSION))
			$error = "Invalid informations, try again... ";
		else
		{
			?>
			<p>Επιτυχής σύνδεση...<br/>
			Αν δεν γίνεται ανακατεύθυνση, πιέστε <a href="<?php echo $url; ?>">εδώ</a>.</p>
			<script type="text/javascript">
				var t=setTimeout("window.location = '<?php echo $url; ?>'",3000);
			</script>
			<?php 
		}
	}
if(isset($error) || !isset($_GET['do'])){
?>
<div class="content">
	<h2>Σύνδεση χρήστη</h2><br/>
	<?php if(isset($error)) echo "<p class=\"error\">".$error."</p><br/>";?>
	<form action="?show=login&do=login" method="post" id="login-form">
	<label for="username">Όνομα Χρήστη: </label>
	<input type="text" name="username" id="username" /><br/>
	<label for="password">Κωδικός Πρόσβασης: </label>
	<input type="password" name="password" id="password" /><br/>
	<input type="submit" value="Υποβολή" class="submit"/>	
	</form>
</div>
<?php }?>