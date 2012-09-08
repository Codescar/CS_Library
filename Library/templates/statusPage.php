<?php
	if(!defined('VIEW_NAV'))
		die("Invalid request!");
	
?><div class="content">
	<div class="<?php echo ($args['type'] == "success") ? "success" : "error"; ?>"><?php echo $args['msg']; ?> <br/><?php if($args['redirect'] != null) redirect($args['redirect']);?></div>
	<br/>
	<p><?php if($args['content']) echo $args['content']; ?></p>
</div>