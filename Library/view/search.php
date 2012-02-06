<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
if(!isset($_GET['title'])){?>
    <div id="direction"><a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;<a href="index.php?show=search">Αναζήτηση</a></div>
<?php
}else{ ?>
    <div id="direction"><a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;<a href="index.php?show=search">Αναζήτηση</a>&nbsp;&gt;&gt;&nbsp;<?php if(isset($_GET['title'])) echo $_GET['search']; ?></div>
<?php } ?>
<div class="content">
	<form action="index.php" method="get" id="search">
		<input type="hidden" name="show" value="search" />
		<input type="hidden" name="do" value="search" />
		<input style="width: 180px; margin: 0 18px 0 0;" type="text" name="search" onclick="this.select()"<?php /*this.value='';" */?> onfocus="this.select()" onblur="this.value=!this.value?'<?php echo (isset($_GET['search'])) ? $_GET['search'] : "Search..."; ?>':this.value;" value="<?php echo (isset($_GET['search'])) ? $_GET['search'] : "Search..."; ?>"/>
		
		<div class="search_chk">
		<input type="checkbox" name="title" id="title" <?php echo (isset($_GET['title'])) ? "checked=\"checked\"" : ( (isset($_GET['do'])) ? "" : "checked=\"checked\"" ); ?>/>
		<label for="title">Τίτλος</label>
		</div>
		<div class="search_chk">
		<input type="checkbox" name="newspapers" id="newspapers" <?php echo (isset($_GET['newspapers'])) ? "checked=\"checked\"" : ""; ?>/><label for="newspapers">Εφημερίδες</label>
		</div>
		<div class="search_chk">
		<input type="checkbox" name="manuscripts" id="manuscripts" <?php echo (isset($_GET['manuscripts'])) ? "checked=\"checked\"" : ""; ?>/><label for="manuscripts">Χειρόγραφα</label>
		</div>
		<input type="submit" value="Αναζήτηση" />
		<br />
		<div class="search_chk">
		<input type="checkbox" name="writer" id="writer" <?php echo (isset($_GET['writer'])) ? "checked=\"checked\"" : ""; ?>/><label for="writer">Συγγραφέας</label>
		</div>
		<div class="search_chk">
		<input type="checkbox" name="publisher" id="publisher" <?php echo (isset($_GET['publisher'])) ? "checked=\"checked\"" : ""; ?>/><label for="publisher">Εκδότης</label>
		</div>
		<div class="search_chk">
		<input type="checkbox" name="isbn" id="isbn" <?php echo (isset($_GET['isbn'])) ? "checked=\"checked\"" : ""; ?>/><label for="isbn">ISBN</label>
		</div>
		<div class="search_chk">
		<input type="checkbox" name="articles" id="articles" <?php echo (isset($_GET['articles'])) ? "checked=\"checked\"" : ""; ?>/><label for="articles">Άρθρα</label>
		</div>
		<div class="search_chk">
		<input type="checkbox" name="books" id="books" <?php echo (isset($_GET['books'])) ? "checked=\"checked\"" : ""; ?>/><label for="books">Βιβλία</label>
		</div>
	</form>
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