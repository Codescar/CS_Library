﻿<?php 
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
			&& is_logged_in() && !have_book_rq($id) && !have_book($id))
	{
		$query = "	INSERT INTO `requests` (`book_id`, `user_id`, `date`)
			 		VALUES ('$id', '".$_SESSION['user_id']."', NOW());";
		$db->query($query);
		?>
		<p>Το αίτημά σας κατοχυρώθηκε και θα εξεταστεί από το διαχειριστή.</p>
		<?php 
	}
	$db->close();
?>
<div class="content">
	<h2><?php echo $results['title']; ?></h2>
	<h3><?php echo $results['writer_or']; ?></h3>
	<p>Διαθεσιμότητα: <?php echo ($results['availability'] == 1) ? "<span class=\available\">Διαθέσιμο</span>" : "<span class=\"no-available\">Μη Διαθέσιμο</span>"; ?>
	<?php if(is_logged_in() && !($have_book_rq = have_book_rq($id))){ ?>
	<form action="?show=book&id=<?php echo $_GET['id']; ?>&lend" id="lend" method="post">
		<input type="hidden" value="1" name="hidden" />
		<input type="submit" value="Ζήτησέ το" /> 
	</form>
	<?php 
	}
	elseif(is_logged_in() && $have_book_rq){ ?>
		<p>Υπάρχει ήδη μια αίτησή σου για αυτό το βιβλίο.</p>
	<?php }
	elseif(is_logged_in() && have_book($id)){ ?>
		<p>Έχεις ήδη δανειστέι αυτό το βιβλίο.</p>
	<?php }
	?>
	<?php echo ($results['description'] == null) ? "Περιγραφή: " . $results['description'] : "Χωρίς Περιγραφή.";?></p>
	<script type="text/javascript">
		$('#lend').submit(function (){
			return confirm("Είσαι σίγουρος ότι θέλεις το βιβλίο \"<?php echo $results['title']; ?>\";", "Επιβεβαίωση");
			});
	</script>
</div>