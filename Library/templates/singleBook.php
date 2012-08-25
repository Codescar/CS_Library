<?php
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	global $book, $lended, $logged, $requested, $have, $taken, $lend, $msg, $CONFIG;
?>
<div class="book-info">
	<div class="book-left-info">
		<div class="book-image" id="book-image"><a href="<?php echo ($book->image_url == NULL) ? "view/images/noimage.jpg": $book->image_url; ?>"><img src="<?php echo ($book->image_url == NULL) ? "view/images/noimage.jpg": $book->image_url; ?>" alt="<?php echo str_replace('"', "'", $book->title); ?>" title="<?php echo str_replace('"', "'", $book->title); ?>" /></a></div>
		<div class="book-isbn">ISBN: <?php echo $book->isbn; ?></div>
		<div class="book-writer">
			<span class="book-colored">Συγγραφέας:</span><br />
			<span class="book-prop"><?php echo strlen($book->writer)>=2 ? $book->writer : "Άγνωστος"; ?></span>
		</div>
		<div class="book-publisher">
			<span class="book-colored">Εκδότης:</span><br />
			<span class="book-prop"><?php echo strlen($book->publisher)>=2 ? $book->publisher : "Άγνωστος"; ?></span>
		</div>
		<div class="book-category">
			<span class="book-colored">Κατηγορία:</span><br />
			<span class="book-prop"><?php echo ($book->numCategories == 0) ? "Χωρίς Κατηγορία" : get_category_name($book->id); ?></span>
		</div>
	</div>
	<div class="book-right-info">
		<div class="book-title"><?php echo $book->title; ?></div>
		<div class="book-avail block">
			<span class="book-colored">Διαθεσιμότητα:</span>
			<?php if($logged && $have){
					echo "<span class=\"avail\">Το έχεις εσύ</span>";
				}else{
					echo (!$have && !$requested && $book->availability == 1) ? "<span class=\"avail\">Διαθέσιμο</span>" : "<span class=\"avail_no\">Μη Διαθέσιμο</span>"; 
				} ?>
		</div>
		<div id="buttons" class="block">
			<div class="box book-button book-add-to-wish">
				<?php favorites::show_favorites_button($book->id); ?>  
    		</div>
    		<?php if(!$have && !$requested && $book->availability == 1){ ?>
    		<div class="box book-button book-lend-book" id="lend">
    			<?php if(!$logged){ ?>
    				<a class="must-login" href="?show=login">Δανείσου το</a>
    			<?php }else{ ?>
    				<a class="request-book" href="?show=book&amp;id=<?php echo $_GET['id']; ?>&amp;lend=1">Δανείσου το</a>
    			<?php }?>
    		</div>
    		<?php } elseif($logged && $have) { ?>
    			<div class="book-button box"><a class="renewal" href="#">Ανανέωση</a></div>
    		<?php } ?>
		</div><!--  #buttons end -->
		<?php if($logged && $requested && !$have && !isset($_GET['lend'])){
			?> <div class="error">Έχετε κάνει ήδη μια αίτησή για αυτό το βιβλίο, θα το πάρετε όταν είναι διαθέσιμο.</div><?php ;
		}
		if($requested && isset($_GET['lend'])){
			?> <div class="success">Το αίτημά σας κατοχυρώθηκε και θα εξεταστεί από το διαχειριστή.</div><?php ;
		}elseif(!$requested && isset($_GET['lend'])){
			?> <div class="error">Έχετε ξεπεράσει το όριο δανεισμών/αιτημάτων.<br />
				Να υπενθυμίσουμε ότι ισχύει: <br />
				1) Όρίο δανεισμών: <?php echo $CONFIG['lendings']; ?><br />
				2) Όριο αιτημάτων: <?php echo $CONFIG['requests']; ?><br />
				3) Πρέπει όμως το όριο αιτημάτων και δανεισμένων σας βιβλίων να μην ξεπερνά το όριο δανεισμών
			</div><?php ;
    	}elseif($logged && $have){
				?><div class="success" >
					Έχεις πάρει αυτό το βιβλίο την <?php echo date('d-m-Y στις H:i', strtotime($have->taken)); ?> και <br />θα πρέπει να το επιστρέψεις μέχρι την 
					<?php echo date('d-m-Y', mktime(0, 0, 0, date("m", strtotime($have->taken)), date("d", strtotime($have->taken))+$CONFIG['lend_days'], date("Y", strtotime($have->taken))));  ?>
				</div><?php
		}elseif(isset($msg)){ ?>
			<?php echo "<div class=\"error\" >".$msg."<br />";
			redirect("index.php?show=login", 3000);
		} ?>
		<div class="book-description">
			<span class="book-colored">Περιγραφή: </span><span style="font-size: 17px;">
				<?php if($book->description != NULL) {
					echo $book->description;
				} else {
					echo "Μη διαθέσιμη.";
				} ?>
			</span> 
		</div>
	</div>
</div><!-- .book-info end -->
<script type="text/javascript">
	$(function() {
		$('#book-image a').lightBox();
	});
</script>
</div>