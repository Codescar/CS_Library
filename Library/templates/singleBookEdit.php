<?php
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
		
	function value($var, $arg){
		if(isset($arg[$var]))
			return " value=\"$arg[$var]\" ";
		else
			return " ";
	}
	
	$book = $args[0];

?>
<div class="content ">
	<div class="book-edit">
		<form action="index.php?show=book&edit=<?php echo $_GET['edit']."_done"; ?><?php if(isset($_GET['id'])) echo "&id=".$_GET['id'];?>" method="post" enctype="multipart/form-data">
			<label for="title-input">Τίτλος:</label>				<input type="text" name="title" id="title-input" value="<?php echo $book->title; ?>"/><br/>
			<label for="isbn-input">ISBN:</label>					<input type="text" name="isbn" id="isbn-input" value="<?php echo $book->isbn; ?>"/><br/>
			<label for="availability-input">Διαθεσιμότητα:</label>	<input type="radio" value="3" checked="checked" 
			name="availability" id="availability-input" />Όχι		<input type="radio" value="1" name="availability" id="availability-input" />Ναι<br/>
			<label for="writer-input">Συγγραφέας:</label>			<input type="text" name="writer" id="writer-input" value="<?php echo $book->writer; ?>"/><br/>
			<label for="publisher-input">Εκδότης:</label>			<input type="text" name="publisher" id="publisher-input" value="<?php echo $book->publisher; ?>"/><br/>
			<label for="pages-input">Σελίδες:</label>				<input type="text" name="pages" id="pages-input" value="<?php echo $book->pages; ?>"/><br/>
			<label for="publish_year-input">Έτος Έκδοσης:</label>	<input type="text" name="publish_year" id="publish_year-input" value="<?php echo $book->publish_year; ?>"/><br/>
			<label for="description-input">Περιγραφή:</label>		<textarea rows="8" cols="80" name="description" id="description-input" ><?php echo isset($book->description) ? $book->description : ""; ?></textarea><br/>
			<label for="categories">Κατηγορίες: </label>			<input type="text" id="categories-add" name="categories" list="categories-list">
																		<datalist id="categories-list">
																		<label>
																			<select name="categories">
																			<?php 
																			global $db;
																			$query = "SELECT `category_name` AS name,  `{$db->table['categories']}`.id
																						FROM `{$db->table['book_has_category']}`
																							CROSS JOIN `{$db->table['categories']}` 
																								ON `{$db->table['book_has_category']}`.category_id = `{$db->table['categories']}`.id
																						WHERE `{$db->table['book_has_category']}`.book_id is not NULL
																						GROUP BY `{$db->table['book_has_category']}`.category_id
																						ORDER BY `{$db->table['categories']}`.category_name ASC;";
																			$result = $db->query($query);
																			while($category = $db->db_fetch_object($result))
																				echo "<option name=\"$category->id\" >$category->name";
																			?>
																			</select>
																		</label>
																		</datalist>
																		<input type="button" id="add-category" value="Προσθήκη"/>
																		<br/>
																		
			<div id="categories_have">
			<?php 
			if(isset($_GET['id'])){
				echo get_category_name($_GET['id'], "<br/>");
			}
			?>
		
			</div>
			
			<label for="image-input">Εικόνα:</label>			<input type="file" id="image-input" name="image-input" /><br/>
			<p class="error">Η εικόνα που θα βάλετε θα αντικαταστήσει την προηγούμενη αν υπήρχε!</p>
			<?php if(isset($_GET['id'])){ ?>
				<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
			<?php } ?>
			
			<input type="submit" value="Αποθήκευση" />
		</form>
	</div><!-- .book-info end -->
</div>
			<script type="text/javascript" src="<?php echo $CONFIG['url']; ?>view/js/events.js"></script>
			<script type="text/javascript" src="<?php echo $CONFIG['url']; ?>view/js/jquery.form.js"></script>
			<script type="text/javascript">
			function add_click_handler(){
				$('#categories_have span').click(function (){ 
							if(confirm("Do you want to remove this category: " + $(this).text())){
								
								$.post('index.php?method=ajax',
										{ 	"call" 		: "edit_book", 
									  		"action" 	: "remove",
									  		"category_name" :  $(this).text(),
									  		"book_id"	: "<?php  echo isset($_GET['id']) ? $_GET['id'] : "0" ; ?>"
										 }, 
									function (data){
										
										if(data.error == true)
											alert(data.desc);
										if(data.success == true){
											//this.remove();
										}
									},
									"json");
							
								$(this).delay(500).fadeOut('slow');
							}
						});
				
			}
			
			$('#categories-add').keypress(function (event){ 
				
				if ( event.which == 13 ) {
					event.preventDefault(); 
					$('#add-category').click();
					return false;
				}
			});
		
			$('#add-category').click(function (){ 
				
				$.post('index.php?method=ajax',
					{ 	"call" 		: "edit_book", 
					  	"action" 	: "add",
					  	"category_name" :  $('#categories-add').val(),
					  	"book_id"	: "<?php  echo isset($_GET['id']) ? $_GET['id'] : "0" ; ?>"
					 } , 
					function (data){
						 if(data.error == true){
							 alert(data.desc);
							 $('#categories_have span:last').prev().remove();
							 $('#categories_have span:last').fadeOut(700);	
							 add_click_handler();
						 }
						 
						if(data.success == true){
							//this.remove();
						}
					},
					"json");

					var tmp = $('<br/><span>'+$('#categories-add').val()+'</span>').appendTo($('#categories_have')).fadeIn(700);
					$('#categories-add').val(''); //empty the input box
					
					add_click_handler();
				});
			
			add_click_handler();
			
			</script>