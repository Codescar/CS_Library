<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
if(!isset($_GET['title'])){?>
    <div id="direction"><a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;Αναζήτηση</div>
<?php
}else{ ?>
    <div id="direction"><a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;<a href="index.php?show=search">Αναζήτηση</a>&nbsp;&gt;&gt;&nbsp;<?php if(isset($_GET['title'])) echo $_GET['search']; ?></div>
<?php } ?>
<div class="content">
	<form action="index.php" method="get" id="search">
		<div id="search-head">Αναζήτηση</div>
		<div id="search_main">
			<div class="subtitle">Εισάγετε λέξη-κλειδί για αναζήτηση</div>
			<input 	style="width: 220px; margin: 0 18px 0 0;" type="text" name="search" onclick="this.value='';"<?php /*this.select()" */ ?> onfocus="this.select()" 
					onblur="this.value=!this.value?'<?php echo (isset($_GET['search'])) ? $_GET['search'] : "Εισάγεται κείμενο εδώ..."; ?>':this.value;" 
					value="<?php echo (isset($_GET['search'])) ? $_GET['search'] : "Εισάγεται κείμενο εδώ..."; ?>" />
			
		</div>
		<input type="hidden" name="show" value="search" />
		<input type="hidden" name="do" value="search" />
		<div id="search-in">Αναζήτηση σε 
			<div class="search_rad" id="book-div">
				<input type="radio" name="search-type" id="books" value="books" <?php echo (isset($_GET['search-type']) && $_GET['search-type'] == "books") ? "checked=\"checked\"" : ((isset($_GET['do'])) ? "" : "checked=\"checked\""); ?>/><label for="books">Βιβλία</label>
			</div>
			<div class="search_rad">
				<input type="radio" name="search-type" id="newspapers" value="newspapers" <?php echo (isset($_GET['search-type']) && $_GET['search-type'] == "newspapers") ? "checked=\"checked\"" : ""; ?>/><label for="newspapers">Εφημερίδες</label>
			</div>
			<div class="search_rad">
				<input type="radio" name="search-type" id="manuscripts" value="manuscripts" <?php echo (isset($_GET['search-type']) && $_GET['search-type'] == "manuscripts") ? "checked=\"checked\"" : ""; ?>/><label for="manuscripts">Χειρόγραφα</label>
			</div>
			<div class="search_rad">
				<input type="radio" name="search-type" id="articles" value="articles" <?php echo (isset($_GET['search-type']) && $_GET['search-type'] == "articles") ? "checked=\"checked\"" : ""; ?>/><label for="articles">Άρθρα</label>
			</div>
		</div>
		
		<div id="search-book" style="display: none;">
		
			<div class="search_chk">
				<label for="writer">Συγγραφέας</label><input type="text" name="writer" id="writer" <?php echo (isset($_GET['writer'])) ? "checked=\"checked\"" : ""; ?>/>
			</div>
			<div class="search_chk">
				<label for="publisher">Εκδότης</label><input type="text" name="publisher" id="publisher" <?php echo (isset($_GET['publisher'])) ? "checked=\"checked\"" : ""; ?>/>
			</div>
			<div class="search_chk">
				<label for="isbn">ISBN</label><input type="text" name="isbn" id="isbn" <?php echo (isset($_GET['isbn'])) ? "checked=\"checked\"" : ""; ?>/>
			</div>
			<div class="search_chk">
				<label for="">Διαθέσιμο για δανεισμό</label><input type="checkbox" name="" id="" />
			</div>
		</div>
		<div id="search-newspapers" style="display: none;">
			<div class="search_chk">
				<label for="">Εκδόσεις</label><input type="text" name="" id="" />
			</div>
			<div class="search_chk">
				<label for="">Έτος</label><input type="text" name="" id="" />
			</div>
		</div>
		<div id="search-manuscripts" style="display: none;">
			<div class="search_chk">
				<label for="">Συγγραφέας</label><input type="text" name="" id="" />
			</div>
			<div class="search_chk">
				<label for="">Έτος</label><input type="text" name="" id="" />
			</div>
		</div>
		<div id="search-articles" style="display: none;">
			<div class="search_chk">
				<label for="">Συγγραφέας</label><input type="text" name="" id="" />
			</div>
			<div class="search_chk">
				<label for="">Έτος</label><input type="text" name="" id="" />
			</div>
			<div class="search_chk">
				<label for="">Εμφανίσεις</label><input type="text" name="" id="" />
			</div>
		</div>
		<input type="submit" value="Αναζήτηση" />
			<br />
	</form>
	<script type="text/javascript">
		
		function a(){
			$('.search_rad input').each(function (elem){
					if($(this).is(':checked')){
						$(this).parent().addClass('search-active-radio');
						
						if($(this).attr('id') == 'books')
							$('#search-book').show();
						else
							$('#search-book').hide();
						
						if($(this).attr('id') == 'newspapers')
							$('#search-newspapers').show();
						else
							$('#search-newspapers').hide();

						if($(this).attr('id') == 'manuscripts')
							$('#search-manuscripts').show();
						else
							$('#search-manuscripts').hide();

						if($(this).attr('id') == 'articles')
							$('#search-articles').show();
						else
							$('#search-articles').hide();
					}
					else{
						$(this).parent().removeClass('search-active-radio');
					}
			})};

		$('.search_rad input').click(function (){a();});

		a();
		
		</script>
	<hr style="margin-bottom: 0px;"/>
	<hr style="margin-top: 5px;"/>
<?php 
if(!isset($_GET['do']))
    echo "</div>";

elseif(!isset($_GET['search']) || $_GET['search'] == "" || 
	(!isset($_GET['title']) && !isset($_GET['writer'])
	&& !isset($_GET['publisher']) && !isset($_GET['isbn']) 
	)){
	?> <p class="error">Λάθος αναζήτηση</p></div> <?php
}
else {
	$db->connect();
	$s = mysql_real_escape_string(trim($_GET['search']));
	$query = "SELECT * FROM `{$db->table['booklist']}` WHERE ";
	if(isset($_GET['title']))
		$query .= "title LIKE \"%$s%\" OR ";
	if(isset($_GET['writer']))
		$query .= "writer LIKE \"%$s%\" OR ";
	if(isset($_GET['publisher']))
		$query .= "publisher LIKE \"%$s%\" OR ";
	if(isset($_GET['isbn']))
		$query .= "isbn LIKE \"%$s%\" OR ";
		
	$query .= "1=0 ORDER BY id ASC LIMIT ";
	$books = $db->get_books($page * $CONFIG['items_per_page'], $CONFIG['items_per_page'], $query);
	$db->close();
?>
	<div class="list">
	Αποτελέσματα αναζήτησης για "<?php echo $_GET['search']; ?>"<br />
	<?php if($books){
		list_books($books);
	}
	else{ ?>
	    <p class="error">Δεν βρέθηκαν αποτελέσματα</p>
	<?php } ?>
	</div>
</div>
<?php } ?>