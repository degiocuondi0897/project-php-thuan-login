<?php

require 'config/db.php';
require 'function/database.php';
require 'function/user.php';
require 'function/template.php';
require 'function/url.php';
require 'function/sendmail.php';
require 'function/show_array.php';

db_connect($db);
$mod = isset($_GET['mod']) ? $_GET['mod'] : 'home';
$act = isset($_GET['act']) ? $_GET['act'] : 'main';
$path = "modules/{$mod}/{$act}.php";
if (file_exists($path)) {
    require $path;
} else {
    echo "không tìm thấy " . $path;
}

?>