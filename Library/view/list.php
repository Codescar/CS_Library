<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	
	$q = "FROM `{$db->table['booklist']}`";
	
	if(isset($_GET['more']) && $_GET['more'] == "category" && isset($_GET['id']))
		$q .= " LEFT JOIN `{$db->table['book_has_category']}` ON {$db->table['booklist']}.id = {$db->table['book_has_category']}.book_id " 
		   .  "WHERE {$db->table['book_has_category']}.category_id = ".$db->db_escape_string($_GET['id'])." ";
	
	$q .= " ORDER BY id ASC ";
	
	$q2 = "SELECT COUNT(*) " . $q;
	
	$q = "SELECT * " . $q . "LIMIT ".$page*$CONFIG['items_per_page'].", ".$CONFIG['items_per_page'];
	
	$books = $db->get_books($q, $q2);
	
	$query = "	SELECT `category_name` AS name,  {$db->table['categories']}.id
					FROM {$db->table['book_has_category']}
					CROSS JOIN `{$db->table['categories']}` 
					ON {$db->table['book_has_category']}.category_id = {$db->table['categories']}.id
					WHERE {$db->table['book_has_category']}.book_id is not NULL
					GROUP BY {$db->table['book_has_category']}.category_id
					ORDER BY {$db->table['categories']}.category_name ASC;";
	$res = $db->query($query);
?>
<div id="direction"><a href="index.php">Αρχική</a> &nbsp;&gt;&gt;&nbsp; Κατάλογος βιβλίων</div>
<div class="content">
<?php
    ?><div id=categories>
    <form action="" method="get" class="block" >
    <?php if(isset($_GET)){
		foreach ($_GET as $key => $value)
			echo "<input type=\"hidden\" name=\"$key\" value=\"$value\"> ";
		if(isset($_GET['sp-category']))
			switch ($_GET['sp-category']){
				case "available" : 
					$cat = 1;
					break;
				case "read" :
					$cat = 2;
					break;
				case "popular" :
					$cat = 3;
					break;
				case "mread" :
					$cat = 4;
					break;
		}
	} ?>
    <div><div class="block" style="vertical-align: middle;">Κατηγορίες:</div><select class="block category-select" name="id"><?php
    while($category = $db->db_fetch_object($res)){
		echo "<option value=\"$category->id\" ";
		echo ($_GET['id'] == $category->id) ? "selected=\"selected\"" : "";
		echo ">".$category->name."</option>";
	}
    ?></select></div>
	<div id="sp-categories">
		<input type="radio" name="sp-category" value="available" <?php echo ($cat == 1) ? "checked" : ""; ?> />
			<label class="categories-label">Available</label>
		<input type="radio" name="sp-category" value="read" <?php echo ($cat == 2) ? "checked" : ""; ?> />
			<label class="categories-label">Read</label>
		<input type="radio" name="sp-category" value="popular" <?php echo ($cat == 3) ? "checked" : ""; ?> />
			<label class="categories-label">Popular</label>
		<input type="radio" name="sp-category" value="mread" <?php echo ($cat == 4) ? "checked" : ""; ?> />
			<label class="categories-label">Most Read</label>
		<input type="submit" value="Φιλτράρισμα" />
		<input id="category-more" type="hidden" name="more" />
	</div>
	</form><?php
    if(isset($_GET['more']) && $_GET['more'] == "category" && isset($_GET['id']))
        echo "<a href=\"index.php?show=list\"><img id=\"remove-ico\" src=\"view/images/cross.png\" alt=\"Αφαίρεση φίλτρου\" title=\"Αφαίρεση φίλτρου\" /></a>";
	?></div><?php
	list_books($books);
?>
</div>