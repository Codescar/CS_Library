<?php	
	class customMail{
		var $mailTemplate = array();
		var $m;
	
		public function  __contruct($type){
			global $CONFIG;
			
			$m = new MAIL;
			
			$mailTemplate['registerUser']['title'] = "Εγγραφή νέου μέλους - {$CONFIG['title']}";
			$mailTemplate['registerUser']['body'] = "
				Ευχατιστούμε πολύ για την εγγραφή σας στην πύλη της δανειστικής μας βιβλιοθήκης. 
				Θα χαρούμε να τη χρεισημοποιήσετε και να σας φανεί χρήσιμη\n{$CONFIG['url']}\n\nΗ Ομάδα Διαχείρησης";
			
			$m->Subject($mailTemplate[$type]['title']);
			$m->Text($mailTemplate[$type]['body']);
		}
		
		public function sentMail(){
			global $CONFIG;
			
			//$m = new MAIL;
			$m->From($CONFIG['admin_email']);
			//$m->AddTo($to);
			//$m->Subject($subject);
			//$m->Text($text);
			
			if($CONFIG['MAIL']['USE_SMTP'])
				$c = $m->Connect($CONFIG['MAIL']['SMTP']['HOSTNAME'], $CONFIG['MAIL']['SMTP']['PORT'], $CONFIG['MAIL']['SMTP']['USERNAME'], $CONFIG['MAIL']['SMTP']['PASSWORD']) or die(print_r($m->Result));
			
			if($CONFIG['MAIL']['USE_SMTP'])
				$res = $m->Send($c);
			else
				$res = $m->Send();
				
			echo $res ? '<p class=\"succes\">Mail sent !</p>' : '<p class=\"error\">Error !</p>';
			
			if($CONFIG['MAIL']['USE_SMTP'])
				$m->Disconnect();
		}
		
		public function AddTo($TO){
			$m->AddTo($TO);
		}
		
	};

?>