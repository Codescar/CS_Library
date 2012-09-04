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
?>