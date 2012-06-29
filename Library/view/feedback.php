<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	
?>
<div class="content">
	<?php 
	if(isset($_POST['hidden']) && $_POST['hidden'] == "1"){
	    echo "<span class=\"success\">Ευχαριστούμε για το μύνημά σας!</span>";
	    $message = "Sent from Feedback\nSub: ".$_POST['type']."\n".$_POST['text']."\nEmail: ".$_POST['email']."\n";
    	$message = wordwrap($message, 170);
    	mail('kostislion@gmail.com', 'Feedback', $message);
	}
	?>
	<form action="" method="post" id="feedback-form">
	    <div class="block" id="feedback-form-header">
    		Φόρμα Ανατροφοδότησης
    	</div>
    	<div class="block" id="feedback-form-header2">
        	<label for="type" style="width: 150px;">Τύπος μυνήματος:</label>
        	<select name="type" id="type">
        		<option value="Bug">Πρόβλημα</option>
        		<option value="New Idea">Νέα ιδέα</option>
        		<option value="Other">Άλλο</option>
        	</select>
    	</div>
        <textarea class="ckeditor" id="text" name="text"/></textarea>
    	<div id="feedback-form-footer">
        	<input type="hidden" name="hidden" value="1" />
        	<label for="name">Το όνομα σας: </label>
        	<input type="text" name="name" id="name" />
        	<label for="email" style="margin: 0 0 0 50px;">Το E-mail σας: </label>
        	<input type="email" name="email" id="email" />
        	<input type="submit" value="Αποστολή" style="margin: 0 0 0 150px;"/>
    	</div>
	</form>
</div>