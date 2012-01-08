<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	
?>
<div class="content">
	<?php 
	if(isset($_POST['hidden']) && $_POST['hidden'] == "1"){
	    echo "<span class=\"success\">Ευχαριστούμε για την ανατροφοδότηση!</span>";
	    $message = "Sent from Feedback\nSub: ".$_POST['type']."\n".$_POST['text']."\nEmail: ".$_POST['email']."\n";
    	$message = wordwrap($message, 170);
    	mail('kostislion@gmail.com', 'Feedback', $message);
	}
	?>
	<h2>Feedback Form</h2><br />
	
	<form action="" method="post" id="feedback-form" >
	<label for="type">Type: </label><select name="type" id="type">
		<option value="Bug">Bug</option>
		<option value="New Idea">New Idea</option>
		<option value="Other">Other</option>
	</select><br />
	<label for="email">Your E-mail: </label><input type="email" name="email" id="email" /><br />
	<label for="text">Text: </label><textarea class="ckeditor" id="text" name="text" rows="10" /></textarea><br />
	<input type="hidden" name="hidden" value="1" />
	<input type="submit" value="Submit" />
	</form>
</div>