<?php
function render_template($path, array $args = array())
{
    extract($args);
    ob_start();
    require TEMPLATE_PATH . $path;
    $html = ob_get_clean();

    echo $html;
}
?>