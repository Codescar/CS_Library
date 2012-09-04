<?php

function list_books($books){
	global $CONFIG, $page, $user, $db;
	$logged = $user->is_logged_in();
	if($logged){
		$query = "SELECT `book_id`, `taken`, `must_return` FROM `{$db->table['lend']}` WHERE `user_id` = '{$user->id}';";
		$res = $db->query($query);
		$user_books = array();
		$taken = array();
		while ($user_books[] = mysql_fetch_array($res)) {};
	}
	?>
	<div class="list">
	<?php
	if(empty($books))
		echo '<div class="error">Η λίστα που ζητήσατε δεν περιέχει βιβλία.</div>';
	else
		foreach($books as $row){
			$book_url = "index.php?show=book&amp;id=".$row['id'];
			if($row == $books['0']) continue;
			if($logged)
				list($taken['has_taken'], $taken['taken'], $taken['must_return']) = in_there_pos($user_books, $row['id']);
			?>
			<div class="list-item">
				<div>
					<!-- Image -->
					<div class="list-image">
						<img src="<?php echo ($row['image_url'] == NULL) ? "view/images/noimage.jpg": $row['image_url']; ?>" alt="<?php echo str_replace('"', "'", $row['title']); ?>" title="<?php echo str_replace('"', "'", $row['title']); ?>" />
					</div>
					<!-- Availability -->
					<div class="list-right">
						<div class="list-avail">
							<?php if($row['availability'] != 1) { 
										if($logged && $user_books && $taken['has_taken']) { ?>
											<div class="info-button box center bold" style="margin-bottom: 10px;"><img src="view/images/information.png" />Το Έχεις!</div>
											<div class="box list-button center bold" style="margin-top: 0px;"><a class="renewal" href="#">Ανανέωση</a></div>
									<?php } else { ?>
											<img class="list-avail-img" src="view/images/cross.png" title="Μη Διαθέσιμο" alt="Μη Διαθέσιμο" />
											<div style="font-size: 9px;">Μη διαθέσιμο</div>
									<?php }
							 		} else { ?>
										<img class="list-avail-img" src="view/images/tick.png" title="Διαθέσιμο" alt="Διαθέσιμο" />
								<?php } ?>
						</div>
						<div class="box list-button list-add-to-wish center bold">
							<?php favorites::show_favorites_button($row['id']);	?>
						</div>
						<?php if($row['availability'] == 1) { ?>
						<div class="box list-button list-lend-book center bold">
							<?php if(!$logged){ ?>
								<a class="must-login" href="?show=login">Δανείσου το</a>
							<?php }else{ ?>
								<a class="request-book" href="?show=book&amp;id=<?php echo $row['id']; ?>&amp;lend=1">Δανείσου το</a>
							<?php } ?>
						</div>
						<?php } ?>
					</div>
					<div class="list-item-content">
						<!-- Title -->
						<div class="list-title list-colored">
							<?php echo $row['title']; ?>
						</div>
						<!-- Writer -->
						<div class="list-writer"><span class="list-colored">Συγγραφέας:</span> <?php echo strlen($row['writer'])>=2 ? $row['writer'] : "Άγνωστος"; ?></div>
						<div class="list-publisher"><span class="list-colored">Εκδότης:</span> <?php echo strlen($row['publisher'])>=2 ? $row['publisher'] : "Άγνωστος"; ?></div>
						<div class="list-description">
							<?php if($logged && $taken['has_taken']) { ?>
								<div class="success" style="width: 400px; margin: 0 auto; padding: 5px 10px 5px 20px">
								Έχεις πάρει αυτό το βιβλίο την <span class="bold"><?php echo date('d-m-Y στις H:i', strtotime($taken['taken'])); ?></span><br />
								και θα πρέπει να το επιστρέψεις μέχρι την <span class="bold"><?php echo date('d-m-Y', strtotime($taken['must_return'])); ?></span></div>
								<?php //echo date('d-m-Y', mktime(0, 0, 0, date("m", strtotime($taken)), date("d", strtotime($taken))+$CONFIG['lend_default_days'], date("Y", strtotime($taken)))); ?> 
							<?php }else{ ?>
								<span class="list-colored">Περιγραφή:</span> <?php echo strlen($row['description'])>=2 ? $row['description'] : "Δεν υπάρχει." ?>
							<?php } ?>
						</div>
					</div>
				</div>
				<a class="list-item-link" href ='<?php echo $book_url; ?>'></a>
			</div>
			<?php 
		}
	?>
	<?php 
	/*$ext = "";
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
	*/
	if(!(isset($_GET['show']) && isset($_GET['more']) && $_GET['show'] == "cp" && $_GET['more'] == "lended"))
	{
		  paggination($books['0']);	
		  /*	
	?>
	<div class="list-nav-bar">
		<?php if($page >= 1) { ?>
		<div class="fl-left"><a href="index.php?show=<?php echo $_GET['show'].$ext; ?>&amp;page=<?php echo $page - 1; ?>"><img src="view/images/arrow.png" alt="Πίσω" title="Πίσω" class="list-nav-icons" /></a></div>
		<?php } ?>
		<div class="list-cur-page" >Σελίδα <?php echo $page + 1; ?></div> 
		<?php if($books['0'] > ($page + 1) * $CONFIG['items_per_page'] ) { ?>
		<div class="fl-right"><a href="index.php?show=<?php echo $_GET['show'].$ext; ?>&amp;page=<?php echo $page + 1; ?>"><img src="view/images/arrow.png" alt="Μπροστά" title="Μπροστά" class="list-nav-icons flip" /></a></div>
		<?php } ?>
	</div>
	<?php */ } ?>
	</div>
	<?php 
}

function paggination($all_items, $nums_to_display = -1, $cur_page = -1, $items_per_page = -1){
	global $CONFIG;
	
	//Initializing the arguements if ignored
	if($items_per_page == -1)
		$items_per_page = $CONFIG['items_per_page'];
	if($cur_page == -1 && isset($_GET['page']))
		$cur_page = $_GET['page'];
	elseif($cur_page == -1 && !isset($_GET['page']))
		$cur_page = 0;
	if($nums_to_display == -1)
		$nums_to_display = $CONFIG['num_of_pages_to_navigate'];
			
	//Calculating the total pages	
	$pages = (double)$all_items / (double)$items_per_page;	
	if($pages - round($pages, 0) != 0)
		$pages = (int) $pages + 1;
	
	if($pages <= 1)
		return;	
	
	$diff = (int)$nums_to_display / (int)2;
	if($cur_page <= $diff){
		$page = 1;
		$end = $nums_to_display;
	}
	else{
		$page = $cur_page - $diff;
		$end = $cur_page + $diff;
	}
	
	if($end+1 >= $pages){
		$end = $pages - 1;
		$page = $pages - $nums_to_display - 1;
	}
	
	//Building the old url
	$newurl = "";
	foreach($_GET as $variable => $value)
		if($variable != "page")
			$newurl .= $variable.'='.$value.'&amp;';

	$newurl = rtrim($newurl,'&');
	
	echo '<div class="list-nav-bar">';
	
	//Display left arrow if needing
	if($cur_page >= 1) 
		echo '<div class="fl-left"><a href="index.php?' . $newurl .'page=' . ($cur_page-1) .'"><img src="view/images/arrow.png" alt="Προηγούμενη Σελίδα" title="Προηγούμενη Σελίδα" class="list-nav-icons" /></a></div>';
	
	echo '<div class="list-cur-page" >Σελίδα ' . ($cur_page+1) . '</div>';
	
	//Display right arrow if needing
	if($cur_page < $pages-1) 
		echo '<div class="fl-right"><a href="index.php?' . $newurl . 'page=' . ($cur_page + 1) . '"><img src="view/images/arrow.png" alt="Επόμενη Σελίδα" title="Επόμενη Σελίδα" class="list-nav-icons flip" /></a></div>';

	 
	//Display First Page...
	echo '<br/><a style="margin-left: 8px; margin-right:8px;" href="index.php?'.$newurl.'page=0">Πρώτη</a>';
	if($page != 1)
		echo '<span> ... </span>';
	
	//Display the numbers of the pages
	while($page <= $end + 1){
		echo '<a style="margin-left: 8px; margin-right:8px;" href="index.php?'.$newurl.'page='. (round($page, 0) - 1) .'">'. round($page, 0) .'</a>';
		$page++;
	}

	//Display Last Page...
	if($page < $pages)
		echo '<span> ... </span>';
	echo '<a style="margin-left: 8px; margin-right:8px;" href="index.php?'.$newurl.'page='. ($pages-1) .'">Τελευταία</a>';
	
	echo '</div>';
	return;
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
	$query = "	SELECT `taken` FROM `{$db->table["lend"]}` 
				WHERE `user_id` = '".$user_id."' 
				AND `book_id` = '$book_id'";
	$result = mysql_fetch_object(($db->query($query)));
	return $result;
}

function lend_request($book_id, $user_id){
	global $db, $CONFIG;
	$user = user::show_info($user_id);
	if($user->books_lended + $user->books_requested + 1 > $CONFIG['lendings'])
		return false;
	if($user->books_requested + 1 > $CONFIG['requests'])
		return false;
	$request = "INSERT INTO `{$db->table["requests"]}` (
					`book_id`, `user_id`, `date`)
			 		VALUES ('$book_id', '".$user->id."', NOW());";
	$db->query($request);
	$db->change_avail($book_id, 2);
	$db->user_change_attr($user->id, "books_requested", "+ 1");
	return true;
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
		if($check[0] == $what){
			return array(true, $check[1], $check[2]);
		}
	}
	return -1;
}

function get_category_name($id){
	global $db;
	$query = "SELECT {$db->table['categories']}.category_name FROM {$db->table['categories']} 
				CROSS JOIN {$db->table['book_has_category']} 
				ON {$db->table['categories']}.id = {$db->table['book_has_category']}.category_id
				WHERE {$db->table['book_has_category']}.book_id = '".mysql_real_escape_string($id)."' 
				ORDER BY category_name ASC;";
	$res = $db->query($query);
	$flag = 0;
	while($row = mysql_fetch_array($res)){
	    if($flag)
	        $ret .= ", ". $row['category_name'];
	    else   
	       $ret =  $row['category_name'];
	    $flag = 1;
	}
	return $ret;
	
}

function get_book_name($id){
    global $db;
    $query = "SELECT {$db->table['booklist']}.title FROM {$db->table['booklist']}
    			WHERE `id` = '".mysql_real_escape_string($id)."'";
    $res = $db->query($query);
    $book = mysql_fetch_object($res);
    return $book->title;
}
?>