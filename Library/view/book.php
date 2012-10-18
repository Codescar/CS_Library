<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	global $db, $user, $book;

	if(isset($_GET['id'])){
		$book_id = $db->db_escape_string($_GET['id']);
		$book = new book($book_id);
		
	}
	
	if(isset($_GET['id']) && isset($_GET['edit']) && $user->is_admin() && $_GET['edit'] == "edit"){
		?><div id="direction">
			<a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;Επεξεργασία Βιβλίου
		</div><?php
		render_template("singleBookEdit.php", array($book));
		
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

		if(isset($_FILES['image-input']) && isset($_POST['image-input']))
			if(isset($book->image_url))
				unlink($book->image_url);
		
		if(isset($_FILES['image-input']) && !empty($_FILES['image-input']) && isset($_POST['image-input']) && $upload = upload_file($_FILES['image-input'], "book_images", "image", $id, true, true))
			if($upload === false)
				echo "<div class=\"error\">Η Εικόνα δεν μπόρεσε να αποθηκευτεί!</div>";
		
		
		$query = "	UPDATE `{$db->table['booklist']}` SET
					`title` = '$title', `isbn` = '$isbn', `availability` = '$availability', `writer` = '$writer', `publisher` = '$publisher', 
					 `description` = '$description', `pages` = '$pages', `publish_year` = '$publish_year' ";
		if(isset($upload) && $upload)
			$query .= "	, `image_url` = '$upload' ";
			
		$query .= " WHERE `id` = '$id' LIMIT 1;";
		
		$db->query($query);
		?><div id="direction">
			<a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;Επεξεργασία Βιβλίου
		</div><?php
		if($db->db_affected_rows() == 1 || (isset($upload) && $upload))
			status_page("Το βιβλίο ανανεώθηκε", "success", "?show=book&id=$id");
		else
			status_page("Το βιβλίο δεν ανανεώθηκε", "error", "?show=book&edit=edit&id=$id");
			
	}elseif(isset($_GET['edit']) && $user->is_admin() && $_GET['edit'] == "add"){
		?><div id="direction">
			<a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;Προσθήκη Βιβλίου
		</div><?php
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
		?><div id="direction">
			<a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;Προσθήκη Βιβλίου
		</div><?php
		if($db->db_affected_rows() == 1)
			status_page("Το βιβλίο προστέθηκε", "success", "?show=book&edit=add");
		else
			status_page("Το βιβλίο δεν προστέθηκε", "error", "?show=book&edit=add");
			
	}elseif(isset($_GET['id']) && isset($_GET['edit']) && $user->is_admin() && $_GET['edit'] == "delete"){
		
		$query = "DELETE FROM `{$db->table['booklist']}` WHERE id = $book_id LIMIT 1;";
		
		$db->query($query);
		?><div id="direction">
			<a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;Διαγραφή Βιβλίου
		</div><?php
		if($db->db_affected_rows() == 1)
			status_page("Το βιβλίο διεγράφη!", "success", "?show=book&edit=add");
		else
			status_page("Το βιβλίο δεν διεγράφη!", "error", "?show=book&edit=add");
			
	}elseif(isset($_GET['id'])){/* else (don't edit, just view) */
		
		$lended  = FALSE;
		$have = FALSE;
		$requested = FALSE;
		/*$results = $db->query("SELECT *, COUNT(category_id) AS numCategories 
								FROM {$db->table['booklist']} 
									CROSS JOIN  {$db->table['book_has_category']} 
										ON id = book_id 
								WHERE `id` = '$book_id';");
		if($db->db_num_rows($results) == 0)
			die("Λάθος αίτημα");
		$book = $db->db_fetch_object($results);*/
		if($logged = $user->is_logged_in()){
			$have = $book->have_book($user->id);
			$requested = $book->have_book_rq($user->id);
			if(isset($_GET['lend']) && !$requested && !$have)
				$requested = lend_request($book_id, $user->id);
		}
		elseif(isset($_GET['lend']))
			$msg = "Θα πρέπει πρώτα να συνδεθείτε με το λογαριασμό σας!";
		?><div id="direction">
			<a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;<?php echo $book->title; ?>
		</div><?php
		echo "<div class=\"content book-prev\">";
		render_template("singleBook.php"); 
	} /* end else (don't edit, just view) */
	else
		include '404.php';
	?>