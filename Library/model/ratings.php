<?php
/*
 * This is a ready rating system from 
 * http://net.tutsplus.com/tutorials/html-css-techniques/building-a-5-star-rating-system-with-jquery-ajax-and-php/
 */
function ratings_controller(){
	global $db, $user;
	
	if(!isset($_POST['widget_id']) || empty($_POST['widget_id']))
		return;
		
	$rating = new ratings($db->db_escape_string($_POST['widget_id']));

    isset($_POST['fetch']) ? $rating->get_ratings() :  $user->is_logged_in() ? $rating->vote() : die();
}

class ratings {
    
    private $widget_id;
    private $data = array();
 
	function __construct($wid) {
		global $db;
		
		$this->widget_id = $wid;
		
		$query = "SELECT * FROM `{$db->table['ratings']}` WHERE `widget_id` = '$this->widget_id' LIMIT 1;";
		
		$res = $db->query($query);

		if($db->db_affected_rows() == 1) 
			$data = $db->db_fetch_array($res);
		else {
			$data['widget_id'] = $this->widget_id;
			$data['number_votes'] = 0;
			$data['total_points'] = 0;
			$data['dec_avg'] = 0;
			$data['whole_avg'] = 0;
			$query = "INSERT INTO `{$db->table['ratings']}`
						(`widget_id`, `number_votes`, `total_points`, `dec_avg`, `whole_avg`) 
						VALUES ($this->widget_id, 0, 0, 0, 0);"; 
			
			$db->query($query);
		} 
		
		$this->data['widget_id'] = $data['widget_id'];
		$this->data['number_votes'] = $data['number_votes'];
		$this->data['total_points'] = $data['total_points'];
		$this->data['dec_avg'] = $data['dec_avg'];
		$this->data['whole_avg'] = $data['whole_avg'];
	}
	public function get_ratings() {
		echo json_encode($this->data);
	}

	public function vote() {
		global $db;
		
		# Get the value of the vote
		preg_match('/star_([1-5]{1})/', $_POST['clicked_on'], $match);
		$vote = $match[1];
		
		# Update the record if it exists
		if($this->data) {
			$this->data['number_votes'] += 1;
			$this->data['total_points'] += $vote;
		}
		# Create a new one if it doesn't
		else {
			$this->data['number_votes'] = 1;
			$this->data['total_points'] = $vote;
		}
		
		$this->data['dec_avg'] = round( $this->data['total_points'] / $this->data['number_votes'], 1 );
		$this->data['whole_avg'] = round( $this->data['dec_avg'] );

		$query = "UPDATE `{$db->table['ratings']}` SET 
					`number_votes` = ".$this->data['number_votes'].", 
					`total_points` = ".$this->data['total_points'].",
					`dec_avg`	   = ".$this->data['dec_avg'].",
					`whole_avg`    = ".$this->data['whole_avg']."
					WHERE `widget_id` = {$this->widget_id} LIMIT 1;";
	
		$db->query($query);
			
		$this->get_ratings();
	}
};

?>