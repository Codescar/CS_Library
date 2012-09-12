<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	
	$id = 0;
    $cat = array(false, false, false, false);
    if(isset($_GET['category'])){
    	foreach ($_GET['category'] as $var ){
    		if($var == "available")
    			$cat['0'] = true;
    		if($var == "read" && $user->is_logged_in())
    			$cat['1'] = true;
    		if($var == "popular")
    			$cat['2'] = true;
    		if($var == "new")
    			$cat['3'] = true;
    	}
    }
    if(isset($_GET['id']))
    	$id = $_GET['id'];
    $flag1 = false;
    $flag2 = false;
	$q = "FROM `{$db->table['booklist']}` ";
	if($cat['1'])
		$q .= " CROSS JOIN `{$db->table['log_lend']}` ON `{$db->table['booklist']}`.id = `{$db->table['log_lend']}`.book_id ";
	if(isset($_GET['more']) && $_GET['more'] == "category" && isset($_GET['id']) && $_GET['id'] != "false"){
		$q .= " LEFT JOIN `{$db->table['book_has_category']}` ON `{$db->table['booklist']}`.id = `{$db->table['book_has_category']}`.book_id " 
		   .  "WHERE `{$db->table['book_has_category']}`.category_id = ".$db->db_escape_string($_GET['id'])." ";
		$flag1 = true;
	}
	if($cat['0']){
		$q .= $flag1 ? "AND " : "WHERE ";
		$q .= "`{$db->table['booklist']}`.availability = 1 ";
		$flag1 = true;
	}
	if($cat['1']){
		$q .= $flag1 ? "AND " : "WHERE ";
		$q .= "`{$db->table['log_lend']}`.user_id = ".$user->id." GROUP BY `{$db->table['booklist']}`.id ";
	}
	//if($cat['3'])
		//$q .= "AND `{$db->table['booklist']}`.added_on > NOW - 15 days ";
	if($cat['2']){
		$q .= " ORDER BY `{$db->table['booklist']}`.read_times DESC ";
		$flag2 = true;
	}
	if($cat['3']){
		$q .= $flag2 ? " ," : "ORDER BY ";
		$q .= " `{$db->table['booklist']}`.added_on DESC ";
		$flag2 = true;
	}
	$q .= $flag2 ? " ," : "ORDER BY ";
	$q .= " `{$db->table['booklist']}`.id ASC ";

	$q2 = "SELECT COUNT(*) FROM (SELECT `booklist`.id " . $q. ") as bla;";
	
	$q = "SELECT * " . $q . "LIMIT ".$page*$CONFIG['items_per_page'].", ".$CONFIG['items_per_page'];
	$books = $db->get_books($q, $q2);
	$query = "	SELECT `category_name` AS name,  `{$db->table['categories']}`.id
				FROM `{$db->table['book_has_category']}`
					CROSS JOIN `{$db->table['categories']}` 
						ON `{$db->table['book_has_category']}`.category_id = `{$db->table['categories']}`.id
				WHERE `{$db->table['book_has_category']}`.book_id is not NULL
				GROUP BY `{$db->table['book_has_category']}`.category_id
				ORDER BY `{$db->table['categories']}`.category_name ASC;";
	$result = $db->query($query);
?>
<div id="direction"><a href="index.php">Αρχική</a> &nbsp;&gt;&gt;&nbsp; Κατάλογος βιβλίων</div>
<div class="content">
	<div id=categories>
    <form action="" method="get" class="block" id="form1">
    <?php 
    	if(isset($_GET['show']) && $_GET['show'] == "list")
    		echo "<input type=\"hidden\" name=\"show\" value=\"list\"> ";
    ?>
    <div><div class="block" style="vertical-align: middle;">Κατηγορίες:</div>
    <select class="block category-select" name="id">
		<option value="false" <?php echo ($id == 0) ? "selected=\"selected\" form=\"form2\"" : ""; ?>>Κατηγορία</option>
	<?php
    while($category = $db->db_fetch_object($result)){
		echo "<option value=\"$category->id\" ";
		echo ($id == $category->id) ? "selected=\"selected\"" : "";
		echo ">".$category->name."</option>";
	}
    ?></select></div>
    <input id="category-more" type="hidden" name="more" value="<?php echo isset($_GET['more']) ? "category" : ""; ?>" />
	<div id="sp-categories">
		<input type="checkbox" name="category[]" value="available" <?php echo ($cat['0']) ? "checked=\"checked\"" : ""; ?> />
			<label class="categories-label">Available</label>
		<?php if($user->is_logged_in()) { ?>
		<input type="checkbox" name="category[]" value="read" <?php echo ($cat['1']) ? "checked=\"checked\"" : ""; ?> />
			<label class="categories-label">I have Read</label>
		<?php } ?>
		<input type="checkbox" name="category[]" value="popular" <?php echo ($cat['2']) ? "checked=\"checked\"" : ""; ?> />
			<label class="categories-label">Popular</label>
		<input type="checkbox" name="category[]" value="new" <?php echo ($cat['3']) ? "checked=\"checked\"" : ""; ?> />
			<label class="categories-label">New</label>
		<input type="submit" value="Φιλτράρισμα" />
	</div>
	</form><?php
    if(isset($_GET['more']) && isset($_GET['id']) && ( !($_GET['id'] == "false" && $_GET['more'] == "category") || isset($_GET['category']['0'])))
        echo "<a href=\"index.php?show=list\"><img id=\"remove-ico\" src=\"view/images/cross.png\" alt=\"Αφαίρεση φίλτρου\" title=\"Αφαίρεση φίλτρου\" /></a>";
	?></div><?php
	list_books($books);
?>
</div>