<?php
	if(!defined('VIEW_NAV') || !defined('VIEW_SHOW') || !$user->is_admin())
		die("Invalid request!");

	global $CONFIG, $db;
	
	$query = "SELECT * FROM `{$db->table['mailTemplates']}` ;";
		
	$res = $db->query($query);
	
/*	$(document).ready(function() {
        $('.test-mail .submit').click(function() {
        	$('#output').html("test");
            $.post('index.php?method=ajax&call=sent_test_mail',
                    { 
                		'test_mail_field' 	: $('.test-mail .test_mail_field').val(),
						'id'				: $('.test-mail .id').val()
        			 },
                    function (data){ $('#output').html(data); },
                    'json');
            
            return false;
        });
    });*/
	?>
	<div id="output"></div>
	<script type="text/javascript">

	$(document).ready(function() {
		$(".test-mail .submit").click(function(){
			var element = $(this);
			var Id = element.attr("id");

			$("#output").fadeIn(400).html('<img style="height: 20px;" src="view/images/ajax_loader.gif" align="absmiddle"> loading.....');
			$.post('index.php?method=ajax&call=sent_test_mail',
                   { 	'test_mail_field' 	: $('#test-mail-'+Id+' .test_mail_field').val(),
						'id'				: Id
    		 		},
               		function (data){ 
    		 			$('#output').fadeOut(400);
                   		$('#output').fadeIn(400).html(data); 
                   	}
			);
			
			return false;
		});
	
	});
	
	</script>
	<table>
	<tr>
		<th>Τύπος</th>
		<th>Τίτλος</th>
		<th>Επεξεργασία</th>
		<th>Δοκιμαστικό</th>
	</tr>
	<?php 	
	while($row = $db->db_fetch_array($res)){
	?>
	<tr>
		<td><?php echo $row['type']; ?></td>
		<td><?php echo $row['title']; ?></td>
		<td><a href="index.php?show=admin&more=mailtemplates&action=edit&id=<?php echo $row['id']; ?>">Επεξεργασία</a></td>
		<td>
			<form class="test-mail" id="test-mail-<?php echo $row['id']; ?>" action="" method="">
				<input type="text" name="test_mail_field" class="test_mail_field" value="<?php echo $CONFIG['admin_email']; ?>" />

				<input type="submit" class="submit" value="sent" id="<?php echo $row['id']; ?>"/>
			</form>
		</td>
	</tr>
	<?php	} ?>
	</table>
	<?php 
	if(isset($_GET['action']) && $_GET['action'] == "edit" && isset($_GET['id']) ){
		
		$id = $db->db_escape_string($_GET['id']);
		
		$query = "SELECT * FROM `{$db->table['mailTemplates']}` WHERE `id` = '$id';";
		
		$res = $db->query($query);
		
		while($row = $db->db_fetch_array($res)){
			?>
			<form action="index.php?show=admin&more=mailtemplates&action=save&id=<?php echo $id; ?>" method="post" >
				<label for="type">Κατηγορία / Χρήση:</label> <br/>
				<span id="type"><?php echo $row['type']; ?></span><br/>
				<label for="subj">Θέμα:</label> <br/>
				<input type="text" size="90" value="<?php echo addslashes($row['title']); ?>" name="subj" id="subj" /><br/>
				<label for="body">Κείμενο:</label> <br/>
				<textarea style="height: 250px; width: 570px;" name="body" id="body" ><?php echo $row['body']; ?></textarea><br/>
				<input type="submit" />
			</form>
			
			<div>
				<h2>Macros</h2>
				<?php 
				global $translate;
				foreach($translate as $key => $val){
					echo "$key => $val <br/>";
				} ?>
			</div>
			<?php 
		}
	
	}elseif(isset($_GET['action']) && $_GET['action'] == "save" && isset($_GET['id']) ){
		
		$id = $db->db_escape_string($_GET['id']);
		$title = $db->db_escape_string($_POST['subj']);
		$body = $db->db_escape_string($_POST['body']);
		
		$query = "UPDATE `{$db->table['mailTemplates']}` SET `title` = '$title', `body` = '$body' WHERE `id` = '$id';";
		
		$db->query($query);
	
	}
?>