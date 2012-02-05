<?php
class book{
	private $id, $title, $author, $available, $description, $added;
	
	function __construct($id, $title, $author = "", $available = 1, $description = ""){
		
	}
}

function list_books($books){
	global $CONFIG, $page, $user;
	?>
	<div class="list">
	<?php
		foreach($books as $row){
			$book_url = "index.php?show=book&amp;id=".$row['id'];
			if($row == $books['0']) continue;	
			?>
			<div class="list-item">
				<!-- Image -->
				<div class="list-image">
					<a href="<?php echo $book_url; ?>"><img src="<?php echo ($row['image_url'] == NULL) ? "view/images/noimage.jpg": $row['image_url']; ?>" alt="<?php echo str_replace('"', "'", $row['title']); ?>" title="<?php echo str_replace('"', "'", $row['title']); ?>"/></a>
				</div>
				<!-- Availability -->
				<div class="list-right">
					<div class="list-avail">
						<?php if($row['availability'] == 0) { ?>
							<img class="list-avail-img" src="view/images/cross.png" title="Μη Διαθέσιμο" alt="Μη Διαθέσιμο" />
						<?php } else { ?>
							<img class="list-avail-img" src="view/images/tick.png" title="Διαθέσιμο" alt="Διαθέσιμο" />
						<?php } ?>
					</div>
					<div class="list-button list-add-to-wish"><a onclick="return confirm('Είσαι σίγουρος ότι θέλεις να το προσθέσεις στα αγαπημένα σου;');" href="#">+ Aγαπημένα</a></div>
					<?php if($row['availability'] != 0) { ?>
					<div class="list-button list-lend-book"><a onclick="return confirm('Είσαι σίγουρος ότι θέλεις να το δανειστείς;');" href="#">Δανείσου το</a></div>
					<?php } ?>
					
				</div>
				<div class="list-item-content">
					<!-- Title -->
					<div class="list-title">
						<a class="list-colored" href="<?php echo $book_url; ?>" ><?php echo $row['title']; ?></a>
					</div>
					<!-- Writer -->
					<div class="list-writer"><span class="list-colored">Συγγραφέας:</span> <span class="list-non-colored"><?php echo strlen($row['writer'])>=2 ? $row['writer'] : "Άγνωστος"; ?></span></div>
					<div class="list-publisher"><span class="list-colored">Εκδότης:</span> <span class="list-non-colored"><?php echo strlen($row['publisher'])>=2 ? $row['publisher'] : "Άγνωστος"; ?></span></div>
					<div class="list-description"><span class="list-colored">Περιγραφή:</span> <span class="list-non-colored"><?php echo strlen($row['description'])>=2 ? $row['description'] : "Δεν υπάρχει." ?></span></div>
				</div>
				
			</div>
			<?php 
		}
	?>
	<?php 
	$ext = "";
	if(isset($_GET['search'])){
		$ext .= "&amp;search={$_GET['search']}";
		if(isset($_GET['title']))
			$ext .= "&amp;title={$_GET['title']}";
		if(isset($_GET['writer']))
			$ext .= "&amp;writer={$_GET['writer']}";
	}
	?>
	<?php if($page >= 1) { ?>
	<span id="prev"><a href="index.php?show=<?php echo $_GET['show'].$ext; ?>&amp;page=<?php echo $page - 1; ?>">&lt; Πίσω</a></span>
	<?php } if(count($books) >= $CONFIG['items_per_page'] ) { ?>
	<span id="next"><a href="index.php?show=<?php echo $_GET['show'].$ext; ?>&amp;page=<?php echo $page + 1; ?>">Μπροστά &gt;</a></span>
	<?php } ?>
	</div>
	<?php
}

function have_book_rq($book_id, $user_id){
	global $db;
	$query = "	SELECT * FROM `{$db->table["requests"]}`
				WHERE `user_id` = '".$user_id."'
				AND `book_id` = '$book_id'";
	$result = mysql_num_rows($db->query($query));
	return $result;
}

function have_book($book_id, $user_id){
	global $db;
	$query = "	SELECT * FROM `{$db->table["lend"]}` 
				WHERE `user_id` = '".$user_id."' 
				AND `book_id` = '$book_id'";
	$result = mysql_num_rows($db->query($query));
	return $result;
}

function lend_request($id){
	global $db, $user;
	$query = "	INSERT INTO `{$db->table["requests"]}` (
					`book_id`, 
					`user_id`, 
					`date`)
			 		VALUES ('$id', '".$user->id."', NOW());";
	$db->query($query);
	?><p>Το αίτημά σας κατοχυρώθηκε και θα εξεταστεί από το διαχειριστή.</p><?php 
}

function book_avail($book_id){
	global $db;
	$query = "	SELECT `availability` from `{$db->table["booklist"]}` 
				WHERE `id` = '$book_id'";
	$res = $db->query($query);
	return mysql_fetch_object($res)->availability;
	
}
?>