<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	if(!$user->is_logged_in()){
	?>
		<p>Πρέπει να συνδεθείτε πρώτα.</p>	
	<?php 
	}else{
?>
<div class="content">
	<div id="direction"><a href="index.php">Αρχική</a> &nbsp;&gt;&gt;&nbsp; Προφίλ χρήστη</div>
	<!-- <div class="menu">
		<ul>
			<li><a href="?show=cp&more=info">Στοιχεία</a></li>
			<li><a href="?show=cp&more=history">Ιστορικό</a></li>
		</ul>
	</div> -->
	<?php 
	global $db;
	$db->connect();
	if(!isset($_GET['more']) || $_GET['more'] == "info"){
		$row = $user->show_info();?>
		<div style="display: inline-block; vertical-align: top; margin: 0 80px 0 0;">Γεια σου <?php echo $row['username']; ?><br />
        	<img src="http://projects.codescar.eu/Library/demo/view/images/user-icon.png" alt="User Images" />
        	<br />Όνομα Χρήστη: <?php echo $row['username']; ?>
        	<br />Τύπος Χρήστη: <?php echo $row['usertype']; ?>
        	<br />Δανεισμένα βιλία: <?php echo $row['books_lended']; ?>
        </div>
		<div style="display: inline-block; margin: 0 40px 0 0;">
            <form action="" method="post" id="change-info">
            <label for="name">Name: </label><input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" /><br />
            <label for="surname">Surname: </label><input type="text" id="surname" name="surname" value="<?php echo $row['surname']; ?>" /><br />
            <label for="email">E-mail: </label><input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" /><br />
            <label for="born">Born: </label><input type="date" id="born" name="born" value="<?php echo $row['born']; ?>" /><br />
            <label for="phone">Phone: </label><input type="tel" id="phone" name="phone" value="<?php echo $row['phone']; ?>" /><br />
            <label for="n_pass">New Password: </label><input type="password" id="n_pass" name="n_pass" /><br />
            <label for="r_n_pass">Repeat New Password: </label><input type="password" id="r_n_pass" name="r_n_pass" /><br />
            <label for="password">Your Password: </label><input type="password" id="password" name="password" /><br />
    			<input type="hidden" name="hidden" value="1" />   
            	<input type="submit" value="Update" />
    			<?php //if($user_id == $this->id) { ; }?>
            </form>
        </div>
        <div style="display: inline-block; vertical-align: top;">
        	<div>Έκδοση κάρτας αναγνώστη</div>
        	<div>Wishlist</div>
        	<div>Ιστορικό δανεισμού</div>
        	<div>Δανεισμένα βιβλία</div>
        </div>
    <?php }
	elseif($_GET['more'] == "history"){
		$user->show_history();
	}elseif($_GET['more'] == "remove_request" && isset($_GET['id'])){
		$user->cansel_request(mysql_real_escape_string($_GET['id']));
	}
	$db->close();
	?>
</div>
<?php } 
include 'right_sidebar.php';
?>