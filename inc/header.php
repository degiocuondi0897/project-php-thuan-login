<?php
session_start();
ob_start();
print_r($_SESSION['login']);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>User</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="public/reset.css" rel="stylesheet" type="text/css"/>
        <link href="public/style.css" rel="stylesheet" type="text/css"/>

        <script src="public/js/jquery-2.2.4.min.js" type="text/javascript"></script>
        <script src="public/js/main.js" type="text/javascript"></script>
    </head>
    <body>
        <div id="site">
            <div id="container">
                <div id="header-wp">
                    <div class="wp-inner clearfix">
                        <div id="main-menu" class="fl-left">
                            <ul class="list-item clearfix">
                                <li>
                                    <a href="?mod=home&act=main" title="">Trang chủ</a>
                                </li>
                                <li>
                                    <a href="?mod=users&act=member" title="">Thành viên</a>
                                </li>
                            </ul>
                        </div>
                        <div id="action-user" class="not-signed fl-right">
                             <?php if (is_login()) {
                                ?>
                                <span> xin chào <strong><?php echo user_login(); ?></strong></span>

                                <a href="?mod=users&act=logout" title="Đăng xuất" id="logout">logout</a>
                                <?php
                            } else {
                                ?>
                                <a href="?mod=users&act=login" title="Đăng nhập" id="login">Đăng nhập</a>
                                <a href="?mod=users&act=reg" title="Đăng ký" id="reg">Đăng ký</a>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
