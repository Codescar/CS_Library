<?php

function list_books($books){
	global $CONFIG, $page, $user, $db;
	$logged = $user->is_logged_in();
	if($logged){
		$query = "SELECT * FROM `{$db->table['lend']}` WHERE `user_id` = '{$user->id}';";
		$res = $db->query($query);
		for($i = 0; $tmp = mysql_fetch_array($res); $i++){
			$lend[$i][0] = $tmp['book_id'];
			$lend[$i][1] = $tmp['taken'];
		}
	}
	?>
	<div class="list">
	<?php
		foreach($books as $row){
			$book_url = "index.php?show=book&amp;id=".$row['id'];
			if($row == $books['0']) continue;	
			?>
			<div class="list-item">
				<!-- Image -->
				<div class="list-image">
					<a href="<?php echo $book_url; ?>"><img src="<?php echo ($row['image_url'] == NULL) ? "view/images/noimage.jpg": $row['image_url']; ?>" alt="<?php echo str_replace('"', "'", $row['title']); ?>" title="<?php echo str_replace('"', "'", $row['title']); ?>"/></a>
				</div>
				<!-- Availability -->
				<div class="list-right">
					<div class="list-avail">
						<?php if($row['availability'] == 0) { 
								if($logged && in_there_pos($lend, $row['id']) != -1) { ?>
									<div class="info-button box"><img src="view/images/info.png" />Το Έχεις!</div>
								<?php } else {?>
								<img class="list-avail-img" src="view/images/cross.png" title="Μη Διαθέσιμο" alt="Μη Διαθέσιμο" />
							<?php } } else { ?>
								<img class="list-avail-img" src="view/images/tick.png" title="Διαθέσιμο" alt="Διαθέσιμο" />
							<?php } ?>
					</div>
					<div class="box list-button list-add-to-wish"><a onclick="return confirm('Είσαι σίγουρος ότι θέλεις να το προσθέσεις στα αγαπημένα σου;');" href="#">+ Aγαπημένα</a></div>
					<?php if($row['availability'] != 0) { ?>
					<div class="box list-button list-lend-book"><a onclick="return confirm('Είσαι σίγουρος ότι θέλεις να το δανειστείς;');" href="#">Δανείσου το</a></div>
					<?php } ?>
				</div>
				<div class="list-item-content">
					<!-- Title -->
					<div class="list-title">
						<a class="list-colored" href="<?php echo $book_url; ?>" ><?php echo $row['title']; ?></a>
					</div>
					<!-- Writer -->
					<div class="list-writer"><span class="list-colored">Συγγραφέας:</span> <?php echo strlen($row['writer'])>=2 ? $row['writer'] : "Άγνωστος"; ?></div>
					<div class="list-publisher"><span class="list-colored">Εκδότης:</span> <?php echo strlen($row['publisher'])>=2 ? $row['publisher'] : "Άγνωστος"; ?></div>
					<div class="list-description" >
						<?php if($logged && (($taken = in_there_pos($lend, $row['id'])) != -1)) { ?>
							Έχεις πάρει αυτό το βιβλίο την <?php date('d-m-Y στις H:i', strtotime($taken)); ?> και θα πρέπει να το επιστρέψει μέχρι την 
							<?php echo date('d-m-Y', mktime(0, 0, 0, date("m", strtotime($taken)), date("d", strtotime($taken))+$CONFIG['lend_default_days'], date("Y", strtotime($taken)))); ?> 
						<?php }else{ ?>
							<span class="list-colored">Περιγραφή:</span> <?php echo strlen($row['description'])>=2 ? $row['description'] : "Δεν υπάρχει." ?>
						<?php } ?>
					</div>
				</div>
				
			</div>
			<?php 
		}
	?>
	<?php 
	$ext = "";
	if(isset($_GET['search'])){
		$ext .= "&amp;do=search&amp;search={$_GET['search']}";
		if(isset($_GET['title']))
			$ext .= "&amp;title={$_GET['title']}";
		if(isset($_GET['writer']))
			$ext .= "&amp;writer={$_GET['writer']}";
	}
	?>
	<div class="list-nav-bar">
		<?php if($page >= 1) { ?>
		<div id="prev"><a href="index.php?show=<?php echo $_GET['show'].$ext; ?>&amp;page=<?php echo $page - 1; ?>"><img src="view/images/arrow.png" alt="Πίσω" title="Πίσω" class="list-nav-icons" /></a></div>
		<?php } ?>
		<div class="list-cur-page" >Σελίδα <?php echo $page + 1; ?></div> 
		<?php if(count($books) >= $CONFIG['items_per_page'] ) { ?>
		<div id="next"><a href="index.php?show=<?php echo $_GET['show'].$ext; ?>&amp;page=<?php echo $page + 1; ?>"><img src="view/images/arrow.png" alt="Μπροστά" title="Μπροστά" class="list-nav-icons flip" /></a></div>
		<?php } ?>
	</div>
	</div>
	<?php
}

function have_book_rq($book_id, $user_id){
	global $db;
	$query = "	SELECT * FROM `{$db->table["requests"]}`
				WHERE `user_id` = '".$user_id."'
				AND `book_id` = '$book_id'";
	$result = mysql_num_rows($db->query($query));
	return $result;
}

function have_book($book_id, $user_id){
	global $db;
	$query = "	SELECT * FROM `{$db->table["lend"]}` 
				WHERE `user_id` = '".$user_id."' 
				AND `book_id` = '$book_id'";
	$result = mysql_num_rows($db->query($query));
	return $result;
}

function lend_request($id){
	global $db, $user;
	$query = "	INSERT INTO `{$db->table["requests"]}` (
					`book_id`, 
					`user_id`, 
					`date`)
			 		VALUES ('$id', '".$user->id."', NOW());";
	$db->query($query);
	?><p>Το αίτημά σας κατοχυρώθηκε και θα εξεταστεί από το διαχειριστή.</p><?php 
}

function book_avail($book_id){
	global $db;
	$query = "	SELECT `availability` from `{$db->table["booklist"]}` 
				WHERE `id` = '$book_id'";
	$res = $db->query($query);
	return mysql_fetch_object($res)->availability;
}

function in_there_pos($where, $what){
	
	foreach($where as $check){
		
		if($check[0] == $what);
			return $check[1];
	}
	return -1;
}
?>