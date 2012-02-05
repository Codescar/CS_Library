<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	
	if(!isset($_GET['id']))
		die("Λάθος αίτημα");
		
	$db->connect();
	$id = mysql_real_escape_string($_GET['id']);
	$results = $db->query("SELECT * FROM `booklist` WHERE `id` = '$id' LIMIT 1;");
	
	if(mysql_num_rows($results) == 0)
		die("Λάθος αίτημα");
		
	$results = mysql_fetch_array($results);
	
	if(isset($_GET['lend']) && isset($_POST['hidden']) 
			&& $user->is_logged_in() && !have_book_rq($id, $user->id) && !have_book($id, $user->id))
		lend_request($id);
?>
<div class="content book-prev">
	<div class="book-title"><?php echo $results['title']; ?></div>
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
			
			<div class="book-avail">
				<span class="book-colored">Διαθεσιμότητα:</span>
				<?php echo ($results['availability'] == 1) ? "<span class=\"avail\">Διαθέσιμο</span>" : "<span class=\"avail_no\">Μη Διαθέσιμο</span>"; ?>
			</div>
			<div class="book-description">
			<?php if($results['description'] != NULL) { ?>
				<span class="book-colored">Περιγραφή:</span> <?php echo $results['description']; 
			} else { ?> 
				Χωρίς Περιγραφή.
			<?php } ?>
			</div>
			<div id="buttons">
    			<div class="book-button book-add-to-wish">
    				<a onclick="return confirm('Είσαι σίγουρος ότι θέλεις να το προσθέσεις στα αγαπημένα σου;');" href="#">+ Aγαπημένα</a>
    			</div>
    		<?php if($user->is_logged_in() && $have_book_rq){ ?>
				<p>Υπάρχει ήδη μια αίτησή σου για αυτό το βιβλίο.</p>
			<?php }
			elseif($user->is_logged_in() && have_book($id, $user->id)){ ?>
				<p>Έχεις ήδη δανειστεί αυτό το βιβλίο.</p>
			<?php }else{ ?>
	    		<div class="book-button book-lend-book">
	    			<form action="?show=book&amp;id=<?php echo $_GET['id']; ?>&amp;lend" id="lend" method="post">
	    				<input type="hidden" value="1" name="hidden" />
	    				<a onclick="return confirm('Είσαι σίγουρος ότι θέλεις να το δανειστείς;');" href="#">Δανείσου το</a>
	    			</form>
	    		</div>
			<?php 
			}?>
			</div><!--  #buttons end -->
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