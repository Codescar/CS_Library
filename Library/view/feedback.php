<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
	require_once('model/ckeditor/ckeditor.php');
	global $CONFIG;
?>
<script src="<?php echo $CONFIG['url']; ?>model/ckeditor/ckeditor.js" type="text/javascript"></script>
<div id="direction"><a href="index.php">Αρχική</a>&nbsp;&gt;&gt;&nbsp;Επικοινωνία</div>
<div class="content">
	<?php 
	if(isset($_POST['hidden']) && $_POST['hidden'] == "codescar"){
	    echo "<div class=\"success\">Ευχαριστούμε για το μύνημά σας!</div>";
	    $message = "Ο/Η ".$_POST['name']." μας αποστέλει τα εξής:<br />".$_POST['text']
	    			."<br />Email: <a href=\"mailto:".$_POST['email']."\" >".$_POST['email']."</a>"
	    			."<br /><br />Sent from Codescar Library Feedback\n";
    	$message = wordwrap($message, 200);
    	$headers  = 'MIME-Version: 1.0' . "\r\n";
    	$headers .= 'Content-type: text/html; charset='. $CONFIG['charset'] . "\r\n";
    	$headers .= 'From: info@codescar.eu' . "\r\n";
    	$headers .=	'X-Mailer: PHP/' . phpversion();
    	$admin_email = $CONFIG['admin_email'];
    	mail($admin_email, "Codescar Library ".$_POST['type'], $message, $headers);
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
        	<input type="hidden" name="hidden" value="codescar" />
        	<label for="name">Το όνομα σας: </label>
        	<input type="text" name="name" id="name" required="required" />
        	<label for="email" style="margin: 0 0 0 50px;">Το E-mail σας: </label>
        	<input type="email" name="email" id="email" required="required" />
        	<input class="form-button bold center link box" type="submit" value="Αποστολή" />
    	</div>
	</form>
</div>