<?php
function render_template($path, array $args = array())
{
	global $CONFIG;
    extract($args);
    ob_start();
    require $CONFIG['template_path'].$path;
    //TODO maybe make template output more abstract?
    //$html = '<div class="content">' . ob_get_clean() . '</div>';
	$html = ob_get_clean();
    echo $html;
}

function status_page($msg, $type = "success", $redirect = null, $content = ""){
	$arg = array();
	$arg['msg'] = $msg;
	$arg['type'] = $type;
	$arg['redirect'] = $redirect;
	$arg['content'] = $content;
	return render_template("statusPage.php", $arg);
}

function redirect($url, $time = 1000){
	echo "Αν δεν γίνεται ανακατεύθυνση, πιέστε <a href=\"".$url."\">εδώ</a>.</div>"
			."<script type=\"text/javascript\">var t=setTimeout(\"window.location = '".$url."'\",".$time.")</script>";
}
?>