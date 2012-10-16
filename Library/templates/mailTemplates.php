<?php	
	class customMail{
		var $m;
	
		public function  __contruct($type){
			global $CONFIG;
			
			$this->m = new MAIL;
			
			$mailTemplate['registerUser']['title'] = "Εγγραφή νέου μέλους - {$CONFIG['title']}";
			$mailTemplate['registerUser']['body'] = "
				Ευχατιστούμε πολύ για την εγγραφή σας στην πύλη της δανειστικής μας βιβλιοθήκης. 
				Θα χαρούμε να τη χρεισημοποιήσετε και να σας φανεί χρήσιμη\n{$CONFIG['url']}\n\nΗ Ομάδα Διαχείρησης";
			
			$this->m->Subject($mailTemplate[$type]['title']);
			$this->m->Text($mailTemplate[$type]['body']);
		}
		
		public function sentMail(){
			global $CONFIG;
			
			//$m = new MAIL;
			$this->m->From($CONFIG['admin_email']);
			//$m->AddTo($to);
			//$m->Subject($subject);
			//$m->Text($text);
			
			if($CONFIG['MAIL']['USE_SMTP'])
				$c = $this->m->Connect($CONFIG['MAIL']['SMTP']['HOSTNAME'], $CONFIG['MAIL']['SMTP']['PORT'], $CONFIG['MAIL']['SMTP']['USERNAME'], $CONFIG['MAIL']['SMTP']['PASSWORD']) or die(print_r($m->Result));
			
			if($CONFIG['MAIL']['USE_SMTP'])
				$res = $this->m->Send($c);
			else
				$res = $this->m->Send();
				
			echo $res ? '<p class=\"succes\">Mail sent !</p>' : '<p class=\"error\">Error !</p>';
			
			if($CONFIG['MAIL']['USE_SMTP'])
				$this->m->Disconnect();
		}
		
		public function AddTo($TO, $NAME = null, $CHARSET = null, $ENCODING = null){
			$this->m->addto($TO, $NAME, $CHARSET, $ENCODING);
		}
		
	};

?>