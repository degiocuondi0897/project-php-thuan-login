<?php
get_header();
if (isset($_GET['code_active']) && isset($_GET['emailUser'])) {
    $confirm_code = $_GET['code_active'];
    $confirm_email = $_GET['emailUser'];
    if (check_confirm($confirm_code, $confirm_email)== true) {
        echo "<div id='main-content-wp' class='home-page'>
                <div class='wp-inner'>
                    <h3 class='title-page'>Xác nhận thành công về trang <a href='?mod=users&act=login'>đăng nhập</a></h3>
                </div>
            </div>";
    } else {
        echo "<div id='main-content-wp' class='home-page'>
                <div class='wp-inner'>
                    <h3 class='title-page'>Xác nhận thất bại</h3>
                </div>
            </div>";
    }
}
get_footer();