<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
?>
<div class="content">
	<form action="index.php?view=results" method="get">
		<input type="hidden" name="show" value="results" />
		<input style="width: 304px;" type="text" name="search" value="Search"/>
		
		<div class="search_chk">
		<input type="checkbox" name="title" id="title" checked="checked"/><label for="title">Τίτλος</label>
		</div>
		<div class="search_chk">
		<input type="checkbox" name="books" id="books" checked="checked"/><label for="books">Βιβλία</label>
		</div>
		<div class="search_chk">
		<input type="checkbox" name="newspapers" id="newspapers" /><label for="newspapers">Εφημερίδες</label>
		</div>
		<input type="submit" value="Αναζήτηση" />
		<br />
		<div class="search_chk">
		<input type="checkbox" name="writer_or" id="writer_or"/><label for="writer_or">Συγγραφέας</label>
		</div>
		<div class="search_chk">
		<input type="checkbox" name="publisher" id="publisher"/><label for="publisher">Εκδότης</label>
		</div>
		<div class="search_chk">
		<input type="checkbox" name="isbn" id="isbn"/><label for="isbn">ISBN</label>
		</div>
		<div class="search_chk">
		<input type="checkbox" name="manuscripts" id="manuscripts"/><label for="manuscripts">Χειρόγραφα</label>
		</div>
		<div class="search_chk">
		<input type="checkbox" name="articles" id="articles"/><label for="articles">Άρθρα</label>
		</div>
	</form>
</div>