<?php	

/* Editing categories controller */
	if(isset($_POST['call']) && $_POST['call'] == "edit_book")
	{
		if(isset($_POST['action']) && $_POST['action'] == "add"){
			$return = array();
			$return['desc'] = "Category added";
			$return['success'] = add_category_by_name($_POST['book_id'], $_POST['category_name']);
			$return['error'] = !$return['success'];
			if($return['success'])
				$return['desc'] = "Category added!";
			else 
				$return['desc'] = "Category already exists!";
			echo json_encode($return);
		}
		elseif(isset($_POST['action']) && $_POST['action'] == "remove"){
			$return = array();
			$return['success'] = remove_category_by_name($_POST['book_id'], $_POST['category_name']);
			$return['error'] = !$return['success'];
			if($return['success'])
				$return['desc'] = "Category revoved!";
			else 
				$return['desc'] = "Category not exists!";
			echo json_encode($return);
		}
			
	}
	
	if(isset($_GET['call']) && $_GET['call'] == "sent_test_mail")
	{
		global $db;
		
		$email = $_POST['test_mail_field'];
		
		$m = new customMail("id", $db->db_escape_string($_POST['id']));
		$m->AddTo($email);
		$r = $m->sentMail();

		echo $r ? "<p class=\"success\">Ελέγξτε τα μηνύματά σας!</p>" : "<p class=\"error\">Υπήρξε ένα πρόβλημα στην αποστολή του email!</p>";
		
	}
	
	ratings_controller();

	$db->close();
?>