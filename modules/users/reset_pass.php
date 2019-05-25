<?php
if (isset($_GET['emailUser']) && isset($_GET['code_change_pass'])) {
    $email = $_GET['emailUser'];
    $code_change_pass = $_GET['code_change_pass'];
}
if (!check_reset_pass($email, $code_change_pass)) {
    die("thất bại");
} else {
    $error = array();
    if (isset($_POST['sm_reset_pass'])) {
        //check password old
//        if (empty($_POST['user_pass_old'])) {
//            $error['user_pass_old'] = "không được để trống";
//        } else {
//            if (!is_password($_POST['user_pass_old'])) {
//                $error['user_pass_old'] = "mật khẩu không đúng định dạng";
//            } else {
//                if (!check_pass_old($_POST['user_pass_old'],$email)) {
//                    $error['user_pass_old'] = "mật khẩu không đúng";
//                } else {
//                    $password_old = $_POST['user_pass_old'];
//                }
//            }
//        }
        //check password new
        if (empty($_POST['user_pass'])) {
            $error['user_pass'] = "không được để trống";
        } else {
            if (!is_password($_POST['user_pass'])) {
                $error['user_pass'] = "mật khẩu không đúng định dạng";
            }
        }
        //check re_pass
        if (empty($_POST['user_re_pass'])) {
            $error['user_re_pass'] = "không được để trống";
        } else {
            if (check_password($_POST['user_pass'], $_POST['user_re_pass'])) {
                $error['user_re_pass'] = "mật khẩu không trùng khớp";
            } else {
                $passWord = $_POST['user_pass'];
            }
        }
//        if (check_password($password_old, $passWord)) {
//            $error['user_pass']="mật khẩu đã được sử dụng, vui lòng đổi mật khẩu khác!";
//        }
        //insert db
        if (empty($error)) {
            $data = array(
                'passWord' => md5($passWord),
            );
            db_update('tbl_user', $data, "`emailUser`='{$email}'");
            $notice = "thay đổi thành công. Quay về trag <a href='?mod=users&act=login'>đăng nhập";
        }
    }
}
?>
<?php get_header(); ?>
<div id="main-content-wp" class="reset-pass-page">
    <div class="wp-inner">
        <h3 id="title-page">Thay đổi mật khẩu</h3>
        <div class="detail-page">
            <form method="POST" action="" id="change-pass-wp">
                <!--              
                    <label for="user_pass_old">Mật khẩu cũ</label>
                   <input type="password" name="user_pass_old" id="user_pass"><br><br>-->


                <label for="user_pass">Mật khẩu mới</label>
                <input type="password" name="user_pass" id="user_pass"><br><br>
                <?php
                if (isset($error['user_pass'])) {
                    ?>
                    <span style="color: red"> <?php echo $error['user_pass']; ?></span>
                <?php } ?>
                <label for="user_re_pass">Xác nhận mật khẩu</label>
                <input type="password" name="user_re_pass" id="user_re_pass"><br/><br>
                <?php
                if (isset($error['user_re_pass'])) {
                    ?>
                    <span style="color: red"> <?php echo $error['user_re_pass']; ?></span>
                <?php } ?><br><br>
                <input type="submit" name="sm_reset_pass" value="Gửi yêu cầu"><br>
                <?php if (isset($notice)) {
                    ?>
                    <span style="color: red"> <?php echo $notice; ?></span>
                <?php } ?> 
            </form>
        </div>
    </div>
</div>
<?php get_footer(); ?>