<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	
	if(!isset($_GET['id']))
		die("Λάθος αίτημα");

	$lended  = FALSE;
	$have = FALSE;
	$requested = FALSE;
	$book_id = mysql_real_escape_string($_GET['id']);
	$results = $db->query("SELECT *, COUNT(category_id) AS numCategories 
							FROM {$db->table['booklist']} 
							CROSS JOIN  {$db->table['book_has_category']} 
							ON id = book_id 
							WHERE `id` = '$book_id';");
	if(mysql_num_rows($results) == 0)
		die("Λάθος αίτημα");
	$book = mysql_fetch_object($results);
	if($logged = $user->is_logged_in()){
		$have = have_book($book_id, $user->id);
		$requested = have_book_rq($book_id, $user->id);
		$query = "SELECT * FROM `{$db->table['lend']}` WHERE `user_id` = '{$user->id}';";
		$res = $db->query($query);
		for($i = 0; $tmp = mysql_fetch_array($res); $i++){
		    $lend[$i][0] = $tmp['book_id'];
		    $lend[$i][1] = $tmp['taken'];
		}
	}
	if(isset($_GET['lend']) && $logged && !$requested && !$have)
		$requested = lend_request($book_id);
	elseif(isset($_GET['lend']) && !$logged)
		$msg = "Θα πρέπει πρώτα να συνδεθείτε με το λογαριασμό σας!";
?>
<div id="direction">
	<a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;<a href="index.php?show=list">Κατάλογος βιβλίων</a>&nbsp;&gt;&gt;&nbsp;<?php echo $book->title; ?>
</div>
<?php 
	echo "<div class=\"content book-prev\">";
	render_template("singleBook.php"); ?>