<?php	
	global $translate, $CONFIG, $user;
	
	$translate = array(	'%url'		=> $CONFIG['url'],
						'%title'	=> $CONFIG['title'],
						'%user'		=> $user->username,
						'%date'		=> date('D-M-Y'),
						'%time'		=> date('H:m')
						
			);
			
	class customMail{
		var $m;
		var $enabled;
	
		public function  __construct($type, $id = 0){
			global $CONFIG, $db, $user, $mailTranslate;
			
			$this->m = new MAIL;
			
			$query = "SELECT `title`, `body`, `enabled` FROM `{$db->table['mailTemplates']}` WHERE LOWER(type) = LOWER('{$db->db_escape_string($type)}') ";
			if($type == "id")
				$query .= " AND `id` = '$id' ";
			$res = $db->query($query);
			
			if($db->db_num_rows($res) == 0){
				$this->m = null;
				return ;
			}
				
			$mail = $db->db_fetch_array($res);

			$this->enabled = $mail['enabled'];
			
			$this->m->Subject(strtr($mail['title'], $this->translate), $CONFIG['charset']);
			$this->m->Text(strtr($mail['body'], $this->translate), $CONFIG['charset']);

		}
		
		public function sentMail($force = false){
			global $CONFIG;
			
			if($this->m == null)
				return;
				
			if(!$this->enabled && !$force)
				return;
			
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
			
			if($CONFIG['MAIL']['USE_SMTP'])
				$this->m->Disconnect();
				
			return $res;
		}
		
		public function AddTo($TO, $NAME = null, $CHARSET = null){
			global $CONFIG;
			
			if($this->m == null)
				return;
				
			if($CHARSET == null)
				$CHARSET = $CONFIG['charset'];
				
			$this->m->addto($TO, $NAME, $CHARSET);
		}
		
	};

?>