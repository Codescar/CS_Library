<?php
	
	function create_mail($m, $type){
		$m->Subject($mailTemplate[$type]['title']);
		$m->Text($mailTemplate[$type]['body']);
	}
	$mailTemplate['registerUser']['title'] = "Εγγραφή νέου μέλους - {$CONFIG['title']}";
	$mailTemplate['registerUser']['body'] = "
	Ευχατιστούμε πολύ για την εγγραφή σας στην πύλη της δανειστικής μας βιβλιοθήκης. Θα χαρούμε να τη χρεισημοποιήσετε και να σας φανεί χρήσιμη\n{$CONFIG['url']}\n\nΗ Ομάδα Διαχείρησης";

?>