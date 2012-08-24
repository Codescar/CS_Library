<?php
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	global $request_res, $lend_res;
?>
<div id="lends">
	<table>
	<caption>Αιτήματα Δανεισμού</caption>
	<tr>
		<th>Α/Α</th>
		<th>Τίτλος βιβλίου</th>
		<th>Όνομα Χρήστη</th>
		<th>Το ζήτησε</th>
		<th>Ενέργεια</th>
	</tr>
	<?php 
	$num = 1;
	while($request = mysql_fetch_object($request_res)){ 
	?><tr>
		<td><?php echo $num++; ?></td>
		<td><?php echo $request->title; ?></td>
		<td><a href="?show=admin&more=user&id=<?php echo $request->user_id; ?>" ><?php echo $request->username; ?></a></td>
		<td><?php echo date('d-m-Y στις H:i', strtotime($request->date)); ?></td>
		<?php if(book_avail($request->book_id)){ ?>
			<td><a href="?show=admin&more=lend&lend=<?php echo $request->book_id; ?>&user=<?php echo $request->user_id; ?>" class="lend-book">Δανεισμός</a>
			<?php //TODO fix this link to delete the currrent request ?>
			-- <a href="?show=admin&more=request_delete&book=<?php echo $request->book_id; ?>&user=<?php echo $request->user_id; ?>" class="delete-request">Διαγραφή</a>
			</td>
		<?php }else{
			?><td>Μη διαθέσιμο</td><?php 
			} ?>
	</tr> <?php } ?>
	</table>
	<br />
	<table>
	<caption>Δανεισμένα Βιβλία</caption>
	<tr>
		<th>Α/Α</th>
		<th>Τίτλος βιβλίου</th>
		<th>Όνομα Χρήστη</th>
		<th>Το πήρε</th>
		<th>Να το φέρει</th>
		<th>Ενέργεια</th>
	</tr>
	<?php 
	$num = 1;
	while($return = mysql_fetch_object($lend_res)){
	?> <tr>
		<td><?php echo $num++; ?></td>
		<td><?php echo $return->title; ?></td>
		<td><a href="?show=admin&more=user&id=<?php echo $return->user_id; ?>" ><?php echo $return->username; ?></a></td>
		<td><?php echo date('d-m-Y', strtotime($return->taken)); ?></td>
		<td><?php echo date('d-m-Y', strtotime($return->must_return)); ?></td>
		<td><a href="?show=admin&more=return&return=<?php echo $return->book_id; ?>&user=<?php echo $return->user_id; ?>" class="return-book">Επιστροφή</a></td>
	</tr> 
	<?php } ?> </table>
</div>