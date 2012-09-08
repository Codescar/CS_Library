<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	
	global $db, $user;

	if(isset($_GET['id']))
		$book_id = $db->db_escape_string($_GET['id']);
	
	if(isset($_GET['id']) && isset($_GET['edit']) && $user->is_admin() && $_GET['edit'] == "edit"){
		
	}elseif(isset($_GET['id']) && isset($_GET['edit']) && $user->is_admin() && $_GET['edit'] == "edit_done"){
		
	}elseif(isset($_GET['edit']) && $user->is_admin() && $_GET['edit'] == "add"){
		render_template('singleBookEdit.php');
	}elseif(isset($_GET['edit']) && $user->is_admin() && $_GET['edit'] == "add_done"){
		$title = $db->db_escape_string($_POST['title']);
		$isbn = $db->db_escape_string($_POST['isbn']);
		$availability = $db->db_escape_string($_POST['availability']);	
		$writer = $db->db_escape_string($_POST['writer']);
		$publisher = $db->db_escape_string($_POST['publisher']);
		$description = $db->db_escape_string($_POST['description']);
		$pages = $db->db_escape_string($_POST['pages']);
		$publish_year = $db->db_escape_string($_POST['publish_year']);
		$image_url = $db->db_escape_string($_POST['image_url']);
		
		$query = "	INSERT INTO `{$db->table['booklist']}` 
					(`title`, `isbn`, `availability`, `writer`, `publisher`, 
					 `description`, `pages`, `publish_year`, `image_url`, `added_on`) 
					VALUES ('$title', $isbn, $availability, '$writer', '$publisher',
				 	 '$description', $pages, $publish_year, '$image_url', NOW());";
		$db->query($query);
		
	}elseif(isset($_GET['id']) && isset($_GET['edit']) && $user->is_admin() && $_GET['edit'] == "delete"){
		$query = "DELETE FROM `{$db->table['booklist']}` WHERE id = $book_id;";
		$db->query($query);
		
	}elseif(isset($_GET['id'])){/* else (don't edit, just view) */
		
		$lended  = FALSE;
		$have = FALSE;
		$requested = FALSE;
		$results = $db->query("SELECT *, COUNT(category_id) AS numCategories 
								FROM {$db->table['booklist']} 
									CROSS JOIN  {$db->table['book_has_category']} 
										ON id = book_id 
								WHERE `id` = '$book_id';");
		if($db->db_num_rows($results) == 0)
			die("Λάθος αίτημα");
		$book = $db->db_fetch_object($results);
		if($logged = $user->is_logged_in()){
			$have = have_book($book_id, $user->id);
			$requested = have_book_rq($book_id, $user->id);
			if(isset($_GET['lend']) && !$requested && !$have)
				$requested = lend_request($book_id, $user->id);
		}
		elseif(isset($_GET['lend']))
			$msg = "Θα πρέπει πρώτα να συνδεθείτε με το λογαριασμό σας!";
	?>
	<div id="direction">
		<a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;<a href="index.php?show=list">Κατάλογος βιβλίων</a>&nbsp;&gt;&gt;&nbsp;<?php echo $book->title; ?>
	</div>
	<?php 
		echo "<div class=\"content book-prev\">";
		render_template("singleBook.php"); 
	} /* end else (don't edit, just view) */
	else
		include '404.php';
	?>