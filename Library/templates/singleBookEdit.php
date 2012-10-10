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
		<form action="index.php?show=book&edit=<?php echo $_GET['edit']."_done"; ?><?php if(isset($_GET['id'])) echo "&id=".$_GET['id'];?>" method="post">
			<label for="title-input">Τίτλος:</label>				<input type="text" name="title" id="title-input" <?php echo value("title", $args); ?>/><br/>
			<label for="isbn-input">ISBN:</label>					<input type="text" name="isbn" id="isbn-input" <?php echo value("isbn", $args); ?>/><br/>
			<label for="availability-input">Διαθεσιμότητα:</label>	<input type="radio" value="3" checked="checked" 
			name="availability" id="availability-input" />Όχι		<input type="radio" value="1" name="availability" id="availability-input" />Ναι<br/>
			<label for="writer-input">Συγγραφέας:</label>			<input type="text" name="writer" id="writer-input" <?php echo value("writer", $args); ?>/><br/>
			<label for="publisher-input">Εκδότης:</label>			<input type="text" name="publisher" id="publisher-input" <?php echo value("publisher", $args); ?>/><br/>
			<label for="pages-input">Σελίδες:</label>				<input type="text" name="pages" id="pages-input" <?php echo value("pages", $args); ?>/><br/>
			<label for="publish_year-input">Έτος Έκδοσης:</label>	<input type="text" name="publish_year" id="publish_year-input" <?php echo value("publish_year", $args); ?>/><br/>
			<label for="description-input">Περιγραφή:</label>		<textarea rows="8" cols="80" name="description" id="description-input" ><?php echo isset($args['description']) ? $args['description'] : ""; ?></textarea><br/>
			<label for="categories">Κατηγορίες: </label>			<input type="text" id="categories" name="categories" list="categories-list">
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
				echo get_category_name($_GET['id']);
			}
			?>
		
			</div>
			<style type="text/css">
				#categories_have{
					margin-top: 20px;
					margin-bottom: 20px;
					margin-left: 250px;
				}
				#categories_have span{
					padding: 2px;
					border-radius: 3px;
					max-width: 200px;
					border: 2px green solid;
					background-color: green;
					color: white;
					background-image: url('view/images/cross.png');
					background-attachment: inherit;
					background-size:10px 10px;
					background-repeat: no-repeat;
					background-position: right center;
					display: block;
				}
			</style>
			<script type="text/javascript">

			add_click_handler();
			
			$('#add-category').click(function (){ 
				
				$.post('index.php?method=ajax',
					{ 	"call" 		: "edit_book", 
					  	"action" 	: "add",
					  	"category_name" :  $('#categories').val(),
					  	"book_id"	: "<?php  echo isset($_GET['id']) ? $_GET['id'] : "0" ; ?>"
					 } , 
					function (data){
						 if(data.error == true)
							alert(data.desc);
						if(data.success == true){
							//this.remove();
						}
					},
					"json");

					$('#categories_have').hide().append($('<br/><span>'+$('#categories').val()+'</span>')).fadeIn(700);
					add_click_handler();
				});
			
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
			</script>

			<label for="image_url-input">Εικόνα:</label>			<input type="text" name="image_url" id="image_url-input" <?php echo value("image_url", $args); ?> /><br/>		
			<?php if(isset($_GET['id'])){ ?>
				<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
			<?php } ?>
			
			<input type="submit" value="Αποθήκευση" />
		</form>

	</div><!-- .book-info end -->

</div>