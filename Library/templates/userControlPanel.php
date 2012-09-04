<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	global $user_info, $user;
?>
	<div id="PictureUtil" style="display: none;">
		<h3>Ενημέρωση εικόνας προφίλ</h3>
		<input type="radio" name="profile_image_or_no" checked="checked" id="with-image"/><label for="with-image"> Χρήση προκαθορισμένης εικόνας</label><br/>
		<ul>
			<li>
				Ανέβασμα αρχείου εικόνας<br />
				<div class="subtitle">Η εικόνα πρέπει να είναι μέχρι 150x150 εικονοστροιχεία και μέγεθος μικρότερο του 1MB.</div>
				<form action="" id="uploadForm" method="post" enctype="multipart/form-data" >
					<input type="file" onclick="check_with_image();" name="profilePicture" id="profilePicture" />
					<input type="hidden" name="hidden" value="file_upload" /><br/>
					<input type="submit" onclick="check_with_image();" value="Ανέβασμα" />
				</form>
			</li>
			<li>
				Χρήση εικόνας από URL<br/>
				<div class="subtitle">Σιγουρευτείτε ότι η εικόνα είναι διαθέσιμη και δεν θα διαγραφεί.</div>
				<form action="" id="uploadForm" method="post" >
					<input type="text" onclick="check_with_image();" name="profilePicture" id="profilePicture" value="http://example.com/image.jpg" size="60"/>
					<input type="hidden" name="hidden" value="use_url" /><br/>
					<input type="submit" onclick="check_with_image();" value="Χρήση" />
				</form>
			</li>
		</ul><br/>
		<input type="radio" name="profile_image_or_no" id="no-image"/> <label for="no-image">Χωρίς εικόνα προφίλ</label>
		<form action="" id="uploadForm" method="post" >
			<input type="hidden" name="hidden" value="no_image" /><br/>
			<input type="submit" onclick="check_no_image();" value="Συνέχεια" />
		</form>
	</div>
	<div class="block" id="user-left">
		<?php $image_url = "view/images/user-icon.png";
        	if($ret = get_avatar())
        		$image_url = $ret['avatar_path']; ?>
		<img src="<?php echo $image_url; ?>" style="width: 150px; height: 150px;" alt="User Image" /><br />
		
		<a href="#" onclick="showPictureUtil();">Αλλάξτε την φωτογραφία</a><br />
		<br /><span class="bold">Όνομα Χρήστη: </span> <?php echo $user_info->username; ?>
		<br /><span class="bold">Τύπος Χρήστη: </span> <?php echo $user_info->usertype; ?>
		<br /><span class="bold">Δανεισμένα βιβλία: </span> <?php echo $user_info->books_lended; ?>
		<br /><span class="bold">Αιτήματα δανεισμού: </span> <?php echo $user_info->books_requested; ?>
	</div>
	<div class="block" id="user-info">
		<form action="" method="post" id="change-info">
			<label for="name">Όνομα: </label><input type="text" id="name" name="name" value="<?php echo $user_info->name; ?>" /><br />
			<label for="surname">Επίθετο: </label><input type="text" id="surname" name="surname" value="<?php echo $user_info->surname; ?>" /><br />
			<label for="email">E-mail: </label><input type="email" id="email" name="email" value="<?php echo $user_info->email; ?>" /><br />
			<label for="born">Γεννήθηκε: </label><input type="date" id="born" name="born" value="<?php echo $user_info->born; ?>" /><br />
			<label for="phone">Τηλέφωνο: </label><input type="tel" id="phone" name="phone" value="<?php echo $user_info->phone; ?>" /><br />
			<label for="n_pass">Νέος κωδικός: </label><input type="password" id="n_pass" name="n_pass" /><br />
			<label for="r_n_pass">Ξανά νέος κωδικός: </label><input type="password" id="r_n_pass" name="r_n_pass" /><br />
			<input type="submit" value="Αποθήκευση" class="cp-button link center bold" style="position: absolute; right: 57px; bottom: 40px;" />
			<input type="hidden" name="hidden_update" value="codescar" />
			<?php if($user->is_admin()) { echo "<input type=\"hidden\" name=\"hidden_treasure\" value=\"$user_info->id\" />"; } ?>
		</form>
	</div>
	<div class="block" id="user-right">
		<a href="index.php?show=cp&more=lended"><button type="button" class="cp-button link box center bold">Δανεισμένα βιβλία</button></a><br /><br />
		<a href="index.php?show=cp&more=history"><button type="button" class="cp-button link box center bold">Ιστορικό δανεισμού</button></a><br /><br />
		<a href="index.php?show=favorites"><button type="button" class="cp-button link box center bold">Λίστα αγαπημένων</button></a><br /><br />
	</div>