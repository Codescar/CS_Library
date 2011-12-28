<?php 
	/*
	 * help may open without the rest template
	 * if(!defined('VIEW_NAV'))
		die("Invalid request!");*/
	define('VIEW_SHOW', true);
	
?>

<div class="content help">
<button type="button" onclick="window.close();">Κλείσιμο</button>
	<h2 id="start">Περιεχόμενο Βοήθειας</h2>
	<ul>
		<li><a href="#basic">Βασική λειτουργία</a></li>
		<li><a href="#infos">Επεξήγηση βασικού μενού</a>
		<ul>
			<li><a href="#index">Αρχική</a></li>
			<li><a href="#list">Λίστα Βιβλίων</a></li>
			<li><a href="#search">Αναζήτηση</a></li>
		</ul>
		</li>
		<li><a href="#sub-menu">Επεξήγηση δευτερεύοντος μενού</a>
		<ul>
			<li><a href="#login">Είσοδος</a></li>
			<li><a href="#username"><όνομα></a></li>
			<ul>
				<li><a href="#details">Στοιχεία</a></li>
				<li><a href="#history">Ιστορικό</a></li>
			</ul>
			<li><a href="#msg">Μηνύματα</a></li>
			<li><a href="#register">Εγγραφή</a></li>
			<li><a href="#feedback">Feedback</a></li>
			<li><a href="#help">Βοήθεια</a></li>
		</ul></li>
		<li><a href="#usage">Η Χρήση της εφαρμογής Βήμα-Βήμα</a>
		<ul>
			<li><a href="#usage-find">Αναζήτηση για πληροφορίες ενός βιβλίου</a></li>
			<li><a href="#usage-lend">Ζήτηση ενός βιβλίου και απόκτησή του</a></li>
		</ul>
		</li>
	</ul>
	<p id="basic">
	<h3>Βασική λειτουργία</h3>
	Η Βασική λειτουργία αυτής της σελίδας προορίζεται ώστε να βοηθάει τη λειτουργία μια δανειστικής βιβλιοθήκης. </p>
	<p><a href="#start">Επιστροφή στην κορυφή</a></p>
	
	<p id="infos">
	<h3>Επεξήγηση βασικού μενού</h3>
	Στα αριστερά της σελίδας, κάτω από τον τίτλο τη βρίσκεται το βασικό μενού περιήγησης στις υποσελίδες, εκεί υπάρχουν οι εξείς επιλογές:</p>
	<p><a href="#start">Επιστροφή στην κορυφή</a></p>
		<div class="sub-help">
			
			<p id="index">
			<h3>Αρχική</h3>
			Αυτή είναι η αρχική σελίδα της εφαρμογής, παρουσιάζονται αρχικές πληροφορίες για τη λειτουργία και πιθανές ενημερώσεις από τους διαχειριστές. Σιγουρευτείτε ότι 
			λαμβάνεται υπ' όψην τις τελευταίες αλλαγές σε αυτή την ενότητα προτού προβείτε σε άλλες ενέργειες.</p>
			<p><a href="#start">Επιστροφή στην κορυφή</a></p>
			
			<p id="list">
			<h3>Λίστα Βιβλίων</h3>
			Αυτή είναι η βασική υποσελίδα της εφαρμογής. Εδώ προβάλλονται όλοι οι τίτλοι των βιβλίων που υπάρχουν στη δανιστική βιβλιοθήκη. Επίσης προβάλλονται 
			βασικές πληροφορίες για κάθε τίτλο βιβλίου όπως ο εκδότης, ο συγγραφέας καθώς και η διαθεσιμότητα του βιβλίου στη βιβλιοθήκη. Η διαθεσιμότητα μπορεί να είναι είτε 
			"Διαθέσιμο" είτε "Μη Διαθέσιμο". Η λίστα των βιβλίων σελιδοποιείται για περιορισμό της εμφάνισης των βιβλίων, μπορείτε να περιηγηθείτε στις σελίδες της λίστας των βιβλίων. 
			Η πρώτη στήλη στη λίστα των βιβλίων δεν είναι ο αύξων αριθμός των βιβλίων, αλλά ο μοναδικός αριθμός του κάθε βιβλίου στη βιβλιοθήκη. Επιλέγοντας έναν τίτλο βιβλίου θα 
			μεταφερθείτε στη σελίδα με τις διαθέσιμες πληροφορίες του συγκεκριμένου βιβλίου. </p>
			<p><a href="#start">Επιστροφή στην κορυφή</a></p>
			
			<p id="search">
			<h3>Αναζήτηση</h3>
			Σε αυτή την υποσελίδα μπορείτε να αναζητήσετε κάποιο βιβλίο σύμφωνα είτε με τον τίτλο του είτε με τον εκδότη/συγγραφέα του, είτε και με τα 2. 
			Τα αποτελέσματα εμφανίζονται με τον ίδιο τρόπο όπως και στη λίστα, σελιδοποιημένα.</p>
			<p><a href="#start">Επιστροφή στην κορυφή</a></p>
		</div>
	
	<p id="sub-menu">
	<h3>Επεξήγηση δευτερεύοντος μενού</h3>
	
	</p>
	<p><a href="#start">Επιστροφή στην κορυφή</a></p>
	<div class="sub-help">
		
		<p id="login">
		<h3>Είσοδος</h3>
		Πιέζοντας εδώ θα χρησιμοποιήσετε τα στοιχεία εισόδου σας για να προβείτε σε ενέργειες που χρειάζονται λογαριασμό.
		</p>
		<p><a href="#start">Επιστροφή στην κορυφή</a></p>
		
		<p id="username">
		<h3><όνομα></h3>
		Αυτό το πεδίο εμφανίζεται το όνομα με το οποίο έχετε εισέλθει στο σύστημα. Αν το πατήσετε θα μεταβείτε στις πληροφορίες του λογαριασμού σας, καθώς και μπορείτε να αλλάξετε τα στοιχεία σας.
		</p>
		<p><a href="#start">Επιστροφή στην κορυφή</a></p>
		<div class="sub-help">
			
			<p id="details">
			<h3>Στοιχεία</h3>
			Στη καρτέλα "Στοιχεία" βλέβεται τα στοιχεία του λογαρισμού σας καθώς και μπορείτε να τα αλλάξετε. Για να κάνετε μια αλλαγή στα στοιχεία σας θα πρέπει να αλλάξετε αυτά που θέλετε να διορθώσετε 
			και να βάλετε το κωδικό σας. Για να αλλάξετε τον κωδικό σας πρέπει να τον εισάγετε 2 φορές και να βάλετε και τον ισχύων κωδικό. ΠΡΟΣΟΧΗ! Αν θέλετε να αλλάξετε κωδικό θα αλλάξουν και τα στοιχεία 
			που ίσως έχετε αλλάξει.
			</p>
			<p><a href="#start">Επιστροφή στην κορυφή</a></p>
			
			<p id="history">
			<h3>Ιστορικό</h3>
			Στη καρτέλα "Ιστορικό" βλέπετε το ιστορικό των ατομικών σας δραστηριοτήτων με το λογαριασμό σας. Αυτά μπορεί να είναι παλαιότερες εγγραφές για δανεισμούς βιβλίων, για αιτήματα που είναι σε αναμονή 
			για το χρήστη καθώς και τα βιβλία που έχει αυτή τη στιγμή ο χρήστης.
			</p>
			<p><a href="#start">Επιστροφή στην κορυφή</a></p>
		</div>
		
		<p id="msg">
		<h3>Μηνύματα</h3>
		Υπο κατασκευή...
		</p>
		<p><a href="#start">Επιστροφή στην κορυφή</a></p>
		
		<p id="register">
		<h3>Εγγραφή</h3>
		Η Εγγραφή νέων χρηστών είναι ανενεργή, ζητήστε ένα λογαριασμό από έναν διαχειριστή.
		</p>
		<p><a href="#start">Επιστροφή στην κορυφή</a></p>
		
		<p id="feedback">
		<h3>Feedback</h3>
		Ανατροφοδότηση, εδώ δίνεται η ευκαιρία σε κάθε χρήστη και επισκέπτη να αφήσει αξιολόγηση, σχόλιο, επισήμανση είτε κάποιο πρόβλημα που βρήκε ώστε να το ερευνήσουν οι διαχειριστές. 
		</p>
		<p><a href="#start">Επιστροφή στην κορυφή</a></p>
		
		<p id="help">
		<h3>Βοήθεια</h3>
		Σε αυτή τη καρτέλα βλέπεται το παρών κείμενο, την επεξήγηση της λειτουργίας της εφαρμογής.
		</p>
		<p><a href="#start">Επιστροφή στην κορυφή</a></p>
	</div>
	
	<p id="usage">
	<h3>Η Χρήση της εφαρμογής Βήμα-Βήμα</h3>
	Παρακάτω βρίσκονται κάποιες οδηγίες βήμα-βήμα για τη χρήση της εγαρμογής.
	</p>
	<p><a href="#start">Επιστροφή στην κορυφή</a></p>
	
	<div class="sub-help">
		<p id="usage-find">
		<h3>Αναζήτηση για πληροφορίες ενός βιβλίου</h3>
		Για να βρείτε ένα βιβλίο που σας ενδιαφέρει θα μεταβείτε είτε στη λίστα βιβλίων και μετά θα κάνεται πλοήγηση στις σελίδες με τα βιβλία ή θα μεταβείτε στην αναζήτηση και θα εισάγεται τα κριτίρια 
		για την αναγήτηση των βιβλίων. Με τον ίδιο τρόπο θα πλοηγηθείτε στα αποτελέσματα της αναζήτησης.
		</p>
		<p><a href="#start">Επιστροφή στην κορυφή</a></p>
		
		<p id="usage-lend">
		<h3>Ζήτηση ενός βιβλίου και απόκτησή του</h3>
		Για να ζητήσετε ένα βιβλίο για δανεισμό θα πρέπει πρώτα να βρείτε το βιβλίο που σας ενδιαφέρει. Επίσης θα πρέπει να έχετε κάνει είσοδο με το λογαριασμό σας. Θα πατήσετε πάνω στον τίτλο του βιβλίου 
		και θα σας εμφανίσει τις πληροφορίες του βιβλίου, τη διαθεσιμότητά του, και θα δείτε και ένα κουμπί με το οποίο μπορείτε να κάνετε ένα αίτημα για να αποκτήσετε το βιβλίο. Μπορείτε να κάνετε αίτημα 
		ακόμα και για μη διαθέσιμο βιβλίο, ο διαχειριστής θα επικοινωνήσει μαζί σας για τυχόν διευκρινήσεις καθώς και για το πότε είναι διαθέσιμο για να το αποκτήσετε, σύμφωνα με τη σειρά προτεραιότητας.
		</p>
		<p><a href="#start">Επιστροφή στην κορυφή</a></p>
	</div>
	
</div>