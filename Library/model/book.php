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
									<div class="info-button box" style="margin-top: 0px;"><img src="view/images/information.png" />Το Έχεις!</div>
									<div class="box list-button" style="margin-top: 0px;"><a onclick="return alert('Μπορείτε να κρατήσετε το βιβλίο για άλλες 15 μέρες');" href="#">Ανανέωση</a></div>
								<?php } else {?>
									<img class="list-avail-img" src="view/images/cross.png" title="Μη Διαθέσιμο" alt="Μη Διαθέσιμο" />
									<div style="font-size: 9px;">Μη διαθέσιμο</div>
							<?php } } else { ?>
									<img class="list-avail-img" src="view/images/tick.png" title="Διαθέσιμο" alt="Διαθέσιμο" />
							<?php } ?>
					</div>
					<div class="box list-button list-add-to-wish">
    					<?php if(!$logged){ ?>
    	    				<a onclick="return alert('Πρέπει να συνδεθείτε πρώτα');" href="?show=login">+ Aγαπημένα</a>
    	    			<?php }else{ ?>
    	    				<a onclick="return confirm('Είσαι σίγουρος ότι θέλεις να το προσθέσεις στα αγαπημένα σου;');" href="#">+ Aγαπημένα</a>
    	    			<?php }?>
					</div>
					<?php if($row['availability'] != 0) { ?>
					<div class="box list-button list-lend-book">
						<?php if(!$logged){ ?>
    	    				<a onclick="return alert('Πρέπει να συνδεθείτε πρώτα');" href="?show=login">Δανείσου το</a>
    	    			<?php }else{ ?>
    	    				<a onclick="return confirm('Είσαι σίγουρος ότι θέλεις να το δανειστείς;');" href="?show=book&amp;id=<?php echo $row['id']; ?>&amp;lend=1">Δανείσου το</a>
    	    			<?php }?>
					</div>
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
					<div class="list-description">
						<?php if($logged && (($taken = in_there_pos($lend, $row['id'])) != -1)) { ?>
							Έχεις πάρει αυτό το βιβλίο την <?php echo date('d-m-Y στις H:i', strtotime($taken)); ?> και θα πρέπει να το επιστρέψεις μέχρι την 
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
		if(isset($_GET['search-type']))
			$ext .= "&amp;search-type={$_GET['search-type']}";
		if(isset($_GET['title']))
			$ext .= "&amp;title={$_GET['title']}";
		if(isset($_GET['writer']))
			$ext .= "&amp;writer={$_GET['writer']}";
		if(isset($_GET['isbn']))
			$ext .= "&amp;isbn={$_GET['isbn']}";
		if(isset($_GET['available']))
			$ext .= "&amp;available=1";
		
	}
	if(isset($_GET['more']) && $_GET['more'] == "category" && isset($_GET['id']))
		$ext .= "&amp;more=category&amp;id={$_GET['id']}";	
	
	if(!(isset($_GET['show']) && isset($_GET['more']) && $_GET['show'] == "cp" && $_GET['more'] == lended))
	{		
	?>
	<div class="list-nav-bar">
		<?php if($page >= 1) { ?>
		<div id="prev"><a href="index.php?show=<?php echo $_GET['show'].$ext; ?>&amp;page=<?php echo $page - 1; ?>"><img src="view/images/arrow.png" alt="Πίσω" title="Πίσω" class="list-nav-icons" /></a></div>
		<?php } ?>
		<div class="list-cur-page" >Σελίδα <?php echo $page + 1; ?></div> 
		<?php if(count($books) > $CONFIG['items_per_page'] ) { ?>
		<div id="next"><a href="index.php?show=<?php echo $_GET['show'].$ext; ?>&amp;page=<?php echo $page + 1; ?>"><img src="view/images/arrow.png" alt="Μπροστά" title="Μπροστά" class="list-nav-icons flip" /></a></div>
		<?php } ?>
	</div>
	<?php } ?>
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
// 	$query = "	INSERT INTO `{$db->table["requests"]}` (
// 					`book_id`, 
// 					`user_id`, 
// 					`date`)
// 			 		VALUES ('$id', '".$user->id."', NOW());";
// 	$db->query($query);
	$lend =	"	INSERT INTO `{$db->table['lend']}`
    				(`book_id`, `user_id`, `taken`) VALUES 
    				('$id', '".$user->id."', NOW());";
	$db->query($lend);
	$query = "	UPDATE `{$db->table['booklist']}`
				SET `availability` = 0
				WHERE `id` = '$id';";
	$db->query($query); 
	return;
}

function book_avail($book_id){
	global $db;
	$query = "	SELECT `availability` from `{$db->table["booklist"]}` 
				WHERE `id` = '$book_id'";
	$res = $db->query($query);
	return mysql_fetch_object($res)->availability;
}

function in_there_pos($where, $what){
	
	for($i = 0;$i < count($where);$i++)
		if($where[$i][0] == $what)
			return $where[$i][1];
	return -1;
	
	foreach($where as $check){
		
		if($check[0] == $what);
			return $check[1];
	}
	return -1;
}

function get_category_name($id){
	global $db;
	$query = "SELECT category_name FROM {$db->table['categories']} 
				CROSS JOIN {$db->table['book_has_category']} 
				ON {$db->table['categories']}.id = {$db->table['book_has_category']}.category_id
				WHERE {$db->table['book_has_category']}.book_id = '".mysql_real_escape_string($id)."' 
				ORDER BY category_name ASC;";
	$res = $db->query($query);
	$flag = 0;
	while($row = mysql_fetch_array($res))
	{
	    if($flag)
	        $ret .= ", ". $row['category_name'];
	    else   
	       $ret =  $row['category_name'];
	    $flag = 1;
	}
	return $ret;
	
}
?>