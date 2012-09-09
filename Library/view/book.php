<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	?><div id="direction">
		<a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;<?php if(isset($_GET['edit'])) echo $_GET['edit'] == "edit" ? "Επεξεργασία Βιβλίου" : "Δημιουργία Βιβλίου"; ?>
	</div><?php
	global $db, $user;

	if(isset($_GET['id']))
		$book_id = $db->db_escape_string($_GET['id']);
	
	if(isset($_GET['id']) && isset($_GET['edit']) && $user->is_admin() && $_GET['edit'] == "edit"){
		$id = $db->db_escape_string($_GET['id']);
		
		$query = "SELECT title, isbn, availability, writer, publisher, description, pages, publish_year, image_url 
					FROM `{$db->table['booklist']}` 
					WHERE `id` = $id LIMIT 1;";
		
		$res = $db->query($query);
		
		$results = $db->db_fetch_array($res);
		
		render_template("singleBookEdit.php", $results);
		
	}elseif(isset($_GET['id']) && isset($_GET['edit']) && $user->is_admin() && $_GET['edit'] == "edit_done"){
		$id = $db->db_escape_string($_POST['id']);
		$title = $db->db_escape_string($_POST['title']);
		$isbn = $db->db_escape_string($_POST['isbn']);
		$availability = $db->db_escape_string($_POST['availability']);	
		$writer = $db->db_escape_string($_POST['writer']);
		$publisher = $db->db_escape_string($_POST['publisher']);
		$description = $db->db_escape_string($_POST['description']);
		$pages = $db->db_escape_string($_POST['pages']);
		$publish_year = $db->db_escape_string($_POST['publish_year']);
		$image_url = $db->db_escape_string($_POST['image_url']);
		
		$query = "	UPDATE `{$db->table['booklist']}` SET
					`title` = '$title', `isbn` = $isbn, `availability` = $availability, `writer` = '$writer', `publisher` = '$publisher', 
					 `description` = '$description', `pages` = $pages, `publish_year` = $publish_year, `image_url` = '$image_url'
					  WHERE `id` = $id LIMIT 1;";
		
		$db->query($query);
		
		if($db->db_affected_rows() == 1)
			status_page("Το βιβλίο ανανεώθηκε", "success", "?show=book&id=$id");
		else
			status_page("Το βιβλίο δεν ανανεώθηκε", "error", "?show=book&edit=edit&id=$id");
			
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
		
		if($db->db_affected_rows() == 1)
			status_page("Το βιβλίο προστέθηκε", "success", "?show=book&edit=add");
		else
			status_page("Το βιβλίο δεν προστέθηκε", "error", "?show=book&edit=add");
			
	}elseif(isset($_GET['id']) && isset($_GET['edit']) && $user->is_admin() && $_GET['edit'] == "delete"){
		
		$query = "DELETE FROM `{$db->table['booklist']}` WHERE id = $book_id LIMIT 1;";
		
		$db->query($query);
		
		if($db->db_affected_rows() == 1)
			status_page("Το βιβλίο διεγράφη!", "success", "?show=book&edit=add");
		else
			status_page("Το βιβλίο δεν διεγράφη!", "error", "?show=book&edit=add");
			
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
 
		echo "<div class=\"content book-prev\">";
		render_template("singleBook.php"); 
	} /* end else (don't edit, just view) */
	else
		include '404.php';
	?>