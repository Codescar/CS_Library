<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	
	$q = "SELECT * FROM `{$db->table['booklist']}` ";
	
	if(isset($_GET['more']) && $_GET['more'] == "category" && isset($_GET['id']))
		$q .= " WHERE `category` = '".mysql_real_escape_string($_GET['id'])."' ";
	
	$q .= " ORDER BY id ASC LIMIT ".$page*$CONFIG['items_per_page'].", ".$CONFIG['items_per_page'];
	$books = $db->get_books($q);
	
	$query = "	SELECT category_name, {$db->table['categories']}.id 
				FROM `{$db->table['booklist']}` 
				CROSS JOIN `{$db->table['categories']}` 
				ON  {$db->table['booklist']}.category = {$db->table['categories']}.id;";
	
	$res = $db->query($query);
	
?>
<div id="direction"><a href="index.php">Αρχική</a> &nbsp;&gt;&gt;&nbsp; Κατάλογος βιβλίων</div>
<div class="content">
<?php 
	$flag = 0;
	$cats = array();
	while($row = mysql_fetch_array($res)){
		if($row['category_name'] == NULL || in_array($row['id'], $cats))
			continue;
		if($flag)
			echo ", ";
		else{
			$flag = 1;
			echo "\t\t\t\t<div id=\"categories\">\n<div id=\"head\">Διαλέξτε κάποια κατηγορία για φιλτράρισμα:</div><br /> \n";
		}
		
		array_push($cats, array($row['id'] => $row['category_name']));
	}
	sort($cats, SORT_STRING);
	foreach($cats as $cat)
	{
	    if(isset($_GET['id']) && $_GET['id'] == $cat[0])
	        echo "<div class=\"selected\">";
	    else
	        echo "<div class=\"non-selected\">";
	    if($flag)
	    {
	        echo "<a href=\"index.php?show=list&more=category&id={$cat[0]}\">{$cat[1]}</a>";
	        echo "</div>";
	    }
	}
	if(isset($_GET['more']) && $_GET['more'] == "category" && isset($_GET['id']))
		echo "<a href=\"index.php?show=list\"><img id=\"remove-ico\" src=\"view/images/cross.png\" alt=\"Αφαίρεση φίλτρου\" title=\"Αφαίρεση φίλτρου\" /></a>";
	if(!empty($cats))
		echo "\t\t\t\t</div>\n";
	list_books($books);
    $db->close();
?>
</div>