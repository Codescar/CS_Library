<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);

?>
<div id="direction"><a href="index.php">Αρχική</a> &nbsp;&gt;&gt;&nbsp; Πληροφορίες</div>
<div class="content">
	<h2>Πληροφορίες για τη βιβλιοθήκη</h2>
	<p></p>
	<div class="info-accordion">
	    <div class="head">Πρόσβαση στην βιβλιοθήκη</div>
	    <div class="info">Η Εθνική Βιβλιοθήκη της Ελλάδος στεγάζεται σε Νεοκλασικό κτίριο στον αριθμό 32 της οδού Πανεπιστημίου στο κέντρο της Αθήνας. 
			Η ανέγερση του κτιρίου άρχισε το 1888 και ολοκληρώθηκε το 1903. Τα σχέδια έγιναν από τον Θεόφιλο Χάνσεν 
			ενώ η επίβλεψη της ανέγερσης από τον Ερνέστο Τσίλλερ.
			Τα έξοδα τις ανέγερσης του νέου κτιρίου ανέλαβαν οι αδελφοί Παναγής, Μαρίνος και Ανδρέας Βαλλιάνος.</div>
	    <div class="head">Έκδοση δελτίου αναγνώστη</div>
	    <div class="info">Για την έκδοση Δελτίου Αναγνώστη μπορείτε να υποβάλετε την αίτησή σας μέσω του Internet συμπληρώνοντας τα παρακάτω πεδία με 
	    κεφαλαίους ελληνικούς χαρακτήρες. Το Δελτίο Αναγνώστη παρέχεται δωρεάν από την Εθνική Βιβλιοθήκη. Η Εθνική Βιβλιοθήκη της Ελλάδος 
	    διατηρεί κάθε δικαίωμα για την αποδοχή η απόρριψη της αίτησής σας. Προσοχή, κατά την πρώτη σας επίσκεψη στην Εθνική Βιβλιοθήκη 
	    θα πρέπει να προσκομίσετε 2 φωτογραφίες ταυτότητας καθώς και την Αστυνομιή σας ταυτότητα προκειμένου να γίνουν οι απαραίτητες 
	    ενέργειες για την έκδοση του Δελτίου Αναγνώστη σε περίπτωση αποδοχής της αίτησής σας.
     <form action="aitiseisi.php" method="POST" name="aitisi" id="aitisi">
     	<div class="header">Φόρμα Έκδοσης Δελτίου Αναγνώστη</div>
		<label for="surname">Επώνυμο: </label><input type="text" id="surname" maxlength="25" /><br />
		<label for="name">Όνομα: </label><input type="text" id="name" maxlength="25" /><br />
		<label for="idiotita">Ιδιότητα: </label><input type="text" id="idiotita" maxlength="25" /><br />
		<label for="job">Επάγγελμα: </label><input type="text" id="job" maxlength="25" /><br />
		  
		<div class="sub">Στοιχεία Αστυνομικής ταυτότητας<br />
			<label for="id-num">Αρ.: </label><input type="text" id="id-num" maxlength="10" /><br />
			<label for="id-publ">Εκδ.  αρχή: </label><input type="text" id="id-publ" maxlength="25" /><br />
		</div>                                 
		<div class="sub">Διεύθυνση κατοικίας<br />
			<label for="house-addr">Οδός: </label><input type="text" id="house-addr" maxlength="25" /><br />
			<label for="house-num">Αρ.: </label><input type="text" id="house-num" maxlength="5" /><br />
			<label for="house-tk">Τ.Κ.: </label><input type="text" id="house-tk" maxlength="5" /><br />
			<label for="house-city">Πόλη: </label><input type="text" id="house-city" maxlength="25" /><br />
			<label for="house-phone">Τηλέφωνο: </label><input type="text" id="house-phone" maxlength="10" /><br />
		</div>
		<div class="sub">Διεύθυνση εργασίας<br />
			<label for="job-addr">Οδός: </label><input type="text" id="job-addr" maxlength="25" /><br />
			<label for="job-num">Αρ.: </label><input type="text" id="job-num" maxlength="5" /><br />
			<label for="job-tk">Τ.Κ.: </label><input type="text" id="job-tk" maxlength="5" /><br />
			<label for="job-city">Πόλη: </label><input type="text" id="job-city" maxlength="25" /><br />
			<label for="job-phone">Τηλέφωνο: </label><input type="text" id="job-phone" maxlength="10" /><br />
		 </div>
		 <input type="submit" value="Υποβολή" class="box form-button"/>
           </form>
	    </div>
	    <div class="head" onClick="window.open('http://www.nlg.gr/photogallery.htm','Ξενάγηση','width=600,height=600')">Περιήγηση στο κτίριο</div>
	    <div class="info">Αν ο περιγηητής σας το επιτρέπει θα ανοίξει ένα αναδυόμενο παράθυρο για την περιήγησή σας.</div>
	</div>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			$('.info-accordion .head').click(function() {
				$(this).next().toggle('fast');
				return false;
			}).next().hide();
		});
	</script>
</div>