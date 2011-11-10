<?php 
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	define('VIEW_SHOW', true);
?>
<div class="content">
	<div class="menu">
		<ul>
			<li><a href="?show=cp&more=info">Info</a></li>
			<li><a href="?show=cp&more=change">Change Info</a></li>
			<li><a href="?show=cp&more=history">History</a></li>
		</ul>
	</div><br />
	<?php 
	if(!isset($_GET['more'])){
		
	}
	elseif($_GET['more'] == "change"){
		
	}
	elseif($_GET['more'] == "history"){
		show_history();
	}
	
	?>
</div>
<?php 
	function show_history(){
		global $db;
		$db->connect();
		$query = "	SELECT * FROM 
					`requests` CROSS JOIN `booklist` 
					ON requests.book_id = booklist.id
					WHERE requests.user_id = ".$_SESSION['user_id'];
		$result = $db->query($query);
		echo "<table><tr><th>Book</th><th>Action</th><th>Date</th></tr>";
		while($row = mysql_fetch_array($result)){
			echo "<tr><td>".$row['title']
			."</td><td>Request</td><td>".$row['date']."</td><tr>";
		}
		echo "</table>";
		$db->close();
	}


?>