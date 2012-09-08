<?php
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	global $book, $lended, $logged, $requested, $have, $taken, $lend, $msg, $CONFIG;
?>
<div class="content ">
	<div class="book-edit">

		<form action="&show=book&edit=add_done">
			<label for="title-input">Τίτλος:</label>				<input type="text" name="title" id="title-input" /><br/>
			<label for="isbn-input">ISBN:</label>					<input type="text" name="isbn" id="isbn-input" /><br/>
			<label for="availability-input">Διαθεσιμότητα:</label>	<input type="radio" value="0" checked="checked" 
			name="availability" id="availability-input" />Όχι	<input type="radio" value="1" name="availability" id="availability-input" />Ναι<br/>
			<label for="writer-input">Συγγραφέας:</label>			<input type="text" name="writer" id="writer-input" /><br/>
			<label for="publisher-input">Εκδότης:</label>			<input type="text" name="publisher" id="publisher-input" /><br/>
			<label for="pages-input">Σελίδες:</label>				<input type="text" name="pages" id="pages-input" /><br/>
			<label for="publish_year-input">Έτος Έκδοσης:</label>	<input type="text" name="publish_year" id="publish_year-input" /><br/>
			<label for="description-input">Περιγραφή:</label>		<textarea rows="8" name="description" id="description-input" ></textarea><br/>
			<label for="">Εικόνα:</label>							<br/>		
			<input type="submit" value="Αποθήκευση" />
		
		</form>

	</div><!-- .book-info end -->

</div>