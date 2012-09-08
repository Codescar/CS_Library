<?php
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
		
	function value($var, $arg){
		if(isset($arg[$var]))
			return " value=\"$arg[$var]\" ";
		else
			return " ";
	}

?>
<div class="content ">
	<div class="book-edit">

		<form action="index.php?show=book&edit=<?php echo $_GET['edit']."_done";?><?php if(isset($_GET['id'])) echo "&id=".$_GET['id'];?>" method="post">
			<label for="title-input">Τίτλος:</label>				<input type="text" name="title" id="title-input" <?php echo value("title", $args); ?>/><br/>
			<label for="isbn-input">ISBN:</label>					<input type="text" name="isbn" id="isbn-input" <?php echo value("isbn", $args); ?>/><br/>
			<label for="availability-input">Διαθεσιμότητα:</label>	<input type="radio" value="0" checked="checked" 
			name="availability" id="availability-input" />Όχι	<input type="radio" value="1" name="availability" id="availability-input" />Ναι<br/>
			<label for="writer-input">Συγγραφέας:</label>			<input type="text" name="writer" id="writer-input" <?php echo value("writer", $args); ?>/><br/>
			<label for="publisher-input">Εκδότης:</label>			<input type="text" name="publisher" id="publisher-input" <?php echo value("publisher", $args); ?>/><br/>
			<label for="pages-input">Σελίδες:</label>				<input type="text" name="pages" id="pages-input" <?php echo value("pages", $args); ?>/><br/>
			<label for="publish_year-input">Έτος Έκδοσης:</label>	<input type="text" name="publish_year" id="publish_year-input" <?php echo value("publish_year", $args); ?>/><br/>
			<label for="description-input">Περιγραφή:</label>		<textarea rows="8" cols="80" name="description" id="description-input" ><?php echo isset($args['description']) ? $args['description'] : ""; ?></textarea><br/>
			<label for="image_url-input">Εικόνα:</label>							<input type="text" name="image_url" id="image_url-input" <?php echo value("image_url", $args); ?> /><br/>		
			<?php if(isset($_GET['id'])){ ?>
				<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
			<?php } ?>
			<input type="submit" value="Αποθήκευση" />
		
		</form>

	</div><!-- .book-info end -->

</div>