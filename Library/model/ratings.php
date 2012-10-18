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
    
    return;
}

class ratings {
    
    private $widget_id;
    private $data = array();
	
	public function update_data(){
		global $db;
		
		$query = "	SELECT COUNT(user_id) as number_votes, SUM(rating) as total_points, AVG(rating) as dec_avg FROM `{$db->table['ratings']}`
							WHERE `widget_id` = '{$this->widget_id}' 
							GROUP BY `widget_id`;";
		
		$res = $db->query($query);

		$data = $db->db_fetch_array($res);
		
		$this->data['widget_id'] 	= $this->widget_id;
		$this->data['number_votes'] = $data['number_votes'];
		$this->data['total_points'] = $data['total_points'];
		$this->data['dec_avg'] 		= round($data['dec_avg'], 1);
		$this->data['whole_avg'] 	= round($this->data['dec_avg']);
		
		return;
	}
	
	function __construct($wid) {
		global $db;
		
		$this->widget_id = $wid;
		
		$this->update_data();
	}
	
	public function get_ratings() {	echo json_encode($this->data); }

	public function vote() {
		global $db, $user;
		
		if(!isset($_POST['clicked_on']))
			return;
			
		# Get the value of the vote
		preg_match('/star_([1-5]{1})/', $_POST['clicked_on'], $match);
		$vote = $match[1];
	
		$query = "	INSERT INTO `{$db->table['ratings']}` 
						(`user_id`, `widget_id`, `rating`)
					VALUE ('{$user->id}', '{$this->widget_id}', '$vote')
					ON DUPLICATE KEY UPDATE `rating` = '$vote';";

		$db->query($query);
			
		$this->update_data();
		
		$this->get_ratings();
		
		return;
	}
};

?>