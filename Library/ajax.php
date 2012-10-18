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
	
	ratings_controller();

	$db->close();
?>