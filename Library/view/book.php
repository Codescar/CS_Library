<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	
	if(!isset($_GET['id']))
		die("Λάθος αίτημα");
		
	$db->connect();
	$id = mysql_real_escape_string($_GET['id']);
	$results = $db->query("SELECT * FROM `booklist` WHERE `id` = '$id' LIMIT 1;");
	$logged = $user->is_logged_in();
	$have = have_book($id, $user->id);
	$requested = have_book_rq($id, $user->id);
	if(mysql_num_rows($results) == 0)
		die("Λάθος αίτημα");
		
	$results = mysql_fetch_array($results);
	
	if(isset($_GET['lend']) && $logged && !$requested && !$have)
		lend_request($id);
	elseif(isset($_GET['lend']) && !$logged)
		$msg = "Θα πρέπει πρώτα να συνδεθείτε με το λογαριασμό σας!";
?>
<div id="direction">
	<a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;<a href="index.php?show=list">Κατάλογος βιβλίων</a>&nbsp;&gt;&gt;&nbsp;<?php echo $results['title']; ?>
</div>
<div class="content book-prev">
	<div class="book-title" style="color: orange;"><?php echo $results['title']; ?></div>
	<div class="book-info">
		<div class="book-left-info">
			<div class="book-image" id="book-image"><a href="<?php echo ($results['image_url'] == NULL) ? "view/images/noimage.jpg": $results['image_url']; ?>"><img src="<?php echo ($results['image_url'] == NULL) ? "view/images/noimage.jpg": $results['image_url']; ?>" alt="<?php echo str_replace('"', "'", $results['title']); ?>" title="<?php echo str_replace('"', "'", $results['title']); ?>" /></a></div>
			<div class="book-isbn">ISBN: <?php echo $results['isbn']; ?></div>
			<div class="book-writer">
				<span class="book-colored">Συγγραφέας:</span><br />
				<span class="book-prop"><?php echo strlen($results['writer'])>=2 ? $results['writer'] : "Άγνωστος"; ?></span>
			</div>
			<div class="book-publisher">
				<span class="book-colored">Εκδότης:</span><br />
				<span class="book-prop"><?php echo strlen($results['publisher'])>=2 ? $results['publisher'] : "Άγνωστος"; ?></span>
			</div>
		</div>
		<div class="book-right-info">
			<div id="buttons">
				<div class="box book-button book-add-to-wish">
	    			<a onclick="return confirm('Είσαι σίγουρος ότι θέλεις να το προσθέσεις στα αγαπημένα σου;');" href="#">+ Aγαπημένα</a>
	    		</div>
	    		<?php if(!$have && !$requested && $results['availability']){ ?>
	    		<div class="box book-button book-lend-book" id="lend">
	    			<a onclick="return confirm('Είσαι σίγουρος ότι θέλεις να το δανειστείς;');" href="?show=book&amp;id=<?php echo $_GET['id']; ?>&amp;lend=1">Δανείσου το</a>
	    		</div>
	    		<?php }?>
			</div><!--  #buttons end -->
			<div class="book-avail">
				<span class="book-colored">Διαθεσιμότητα:</span>
				<?php echo ($results['availability'] == 1) ? "<span class=\"avail\">Διαθέσιμο</span>" : "<span class=\"avail_no\">Μη Διαθέσιμο</span>"; ?>
			</div>
			<div class="book-description">
			<?php if($results['description'] != NULL) { ?>
				<span class="book-colored">Περιγραφή:</span> <div style="font-size: 17px;"><?php echo $results['description']."</div>"; 
			} else { ?> 
				Χωρίς Περιγραφή.
			<?php } ?>
			</div>
    		<?php if($logged && $requested){ ?>
				<p class="error">Έχετε κάνει ήδη μια αίτησή για αυτό το βιβλίο, θα το πάρετε όταν είναι διαθέσιμο.</p>
			<?php }
			elseif($logged && $have){ ?>
				<p class="error">Εσείς έχετε ήδη δανειστεί αυτό το βιβλίο.</p>
			<?php }	else{ ?>
			<?php } ?>
		</div><!-- .book-right-info end -->
	</div><!--  -->
	<script type="text/javascript">
		$('#lend').submit(function (){
			return confirm('Είσαι σίγουρος ότι θέλεις το βιβλίο "<?php echo $results['title']; ?>";', 'Επιβεβαίωση');
			});
		$(function() {
			$('#book-image a').lightBox();
		});
	</script>
</div>
<?php $db->close(); ?>
