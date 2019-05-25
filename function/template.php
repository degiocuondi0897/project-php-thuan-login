<?php
function get_header($page = "") {
    $path = "";
    if (empty($page)) {
        $path = "inc/header.php";
    } else {
        $path = "inc/header_{$page}.php";
    }
    if (file_exists($path)) {
        require $path;
    } else {
        echo "Đường dẫn không tồn tại: {$path}";
    }
}

function get_footer()
{
    require 'inc/footer.php';
}