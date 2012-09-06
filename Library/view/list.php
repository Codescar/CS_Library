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
	
	$query = "	SELECT `category_name`,  {$db->table['categories']}.id
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
    $flag = 0;
    while($row = $db->db_fetch_array($res)){

        if($flag)
        echo ", ";
        else{
            $flag = 1;
            echo "\t\t\t\t<div id=\"categories\">\n<div id=\"head\">Διαλέξτε κάποια κατηγορία για φιλτράρισμα:</div><br /> \n";
        }
        if(isset($_GET['id']) && $_GET['id'] == $row['id'])
            echo "<div class=\"selected\">";
        else
            echo "<div class=\"non-selected\">";

        if($flag)
        {
            echo "<a href=\"index.php?show=list&more=category&id={$row['id']}\">{$row['category_name']}</a>";
            echo "</div>";
        }
    }
    if(isset($_GET['more']) && $_GET['more'] == "category" && isset($_GET['id']))
        echo "<a href=\"index.php?show=list\"><img id=\"remove-ico\" src=\"view/images/cross.png\" alt=\"Αφαίρεση φίλτρου\" title=\"Αφαίρεση φίλτρου\" /></a>";
    if($flag)
        echo "\t\t\t\t</div>\n";
	list_books($books);
?>
</div>