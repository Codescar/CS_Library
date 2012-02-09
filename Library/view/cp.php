<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	if(!$user->is_logged_in()){
	?>
		<div class="content"><p class="error">Πρέπει να συνδεθείτε πρώτα.</p></div>	
	<?php 
	} else {
	if($_GET['more'] == "lended"){ ?>
	<div id="direction"><a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;<a href="index.php?show=cp">Προφίλ χρήστη</a>&nbsp;&gt;&gt;&nbsp;Δανεισμένα Βιβλία</div>
	<?php }elseif($_GET['more'] == "history"){ ?>
	<div id="direction"><a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;<a href="index.php?show=cp">Προφίλ χρήστη</a>&nbsp;&gt;&gt;&nbsp;Ιστορικό δανεισμού</div>
	<?php }else{ ?>
	<div id="direction"><a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;Προφίλ χρήστη</div>
	<?php } ?>
<div class="content" style="position: relative; ">
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
		<div class="block" id="user-left">
        	<img src="view/images/user-icon.png" alt="User Images" />
        	<br /><a href="#">Αλλάξτε την φωτογραφία</a><br />
        	<br /><span class="bold">Όνομα Χρήστη:</span> <?php echo $row['username']; ?>
        	<br /><span class="bold">Τύπος Χρήστη:</span> <?php echo $row['usertype']; ?>
        	<br /><span class="bold">Δανεισμένα βιβλία:</span> <?php echo $row['books_lended']; ?>
        </div>
		<div class="block" id="user-info">
            <form action="" method="post" id="change-info">
            <label for="name">Όνομα: </label><input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" /><br />
            <label for="surname">Επίθετο: </label><input type="text" id="surname" name="surname" value="<?php echo $row['surname']; ?>" /><br />
            <label for="email">E-mail: </label><input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" /><br />
            <label for="born">Γεννήθηκε: </label><input type="date" id="born" name="born" value="<?php echo $row['born']; ?>" /><br />
            <label for="phone">Τηλέφωνο: </label><input type="tel" id="phone" name="phone" value="<?php echo $row['phone']; ?>" /><br />
            <label for="n_pass">Νέος κωδικός: </label><input type="password" id="n_pass" name="n_pass" /><br />
            <label for="r_n_pass">Ξανά νέος κωδικός: </label><input type="password" id="r_n_pass" name="r_n_pass" /><br />
            <label for="password">Τωρινός κωδικός: </label><input type="password" id="password" name="password" />
            <input type="submit" value="Ανανέωση" style="position: absolute; right: 108px; bottom: 10px;"/>
            <p>* Για να αλλάξετε κάποια από τα στοιχεία σας<br /> θα πρέπει να συμπληρώσετε απαραιτήτως<br/> και τον Τωρινό Κωδικό σας!</p>
    			<input type="hidden" name="hidden" value="1" />   
    			<?php //if($user_id == $this->id) { ; }?>
            </form>
        </div>
        <div class="block" id="user-right">
        	<div class="box link"><a href="index.php?show=cp&more=lended" style="color: black; text-decoration: none;">Δανεισμένα βιβλία</a></div>
        	<div class="box link"><a href="index.php?show=cp&more=history" style="color: black; text-decoration: none;">Ιστορικό δανεισμού</a></div>
        	<div class="box link">Λίστα αγαπημένων</div>
        	<div class="box link">Έκδοση κάρτας αναγνώστη</div>
        </div>
    <?php }
	elseif($_GET['more'] == "history"){
		$user->show_history();
	}elseif($_GET['more'] == "remove_request" && isset($_GET['id'])){
		$user->cansel_request(mysql_real_escape_string($_GET['id']));
	}elseif($_GET['more'] == "lended"){
		$user->show_lended();	
	}
	$db->close();
	?>
</div>
<?php } ?>