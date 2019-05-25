<?php
$error = array();
if (isset($_POST['sm_forgot_pass'])) {
    if (empty($_POST['user_email'])) {
        $error['user_email']="không được để trống";
    }else{
        if (!is_email($_POST['user_email'])) {
           $error['user_email']="email không đúng định dạng"; 
        }else{
            $emailUser = $_POST['user_email'];
        }
    }
    if (empty($error)) {
        if (!check_email($_POST['user_email'])) {
                $error['user_email'] = 'Email không tồn tại';
            } else {
                $code_change_pass = md5(rand(10000, 100000000));
                $emailUser = $_POST['user_email'];
                $subject = "Moon shop";
                $link = "http://localhost:8080/traiweb8/user/?mod=users&act=reset_pass&emailUser={$emailUser}&code_change_pass={$code_change_pass}";
                $content = "hệ thống của chúng tôi vừa nhận được yêu cầu đồi mật khẩu của bạn.<br/>Nếu như đây thực sự là yêu cầu của bạn thì vui lòng nhấn vào link dưới đây"
                        . "để tiếp tục, nếu không phải thì vui lòng bỏ qua email này <br/> <a href='{$link}'>{$link}</a>";
                sendmail($emailUser, "", $subject, $content);
                $data = array(
                    'code_change_pass' => $code_change_pass,
                );
                db_update('tbl_user', $data, "`emailUser` = '{$emailUser}'");
                redirect("?mod=users&act=pending");
            }
    }
}


?>

<?php get_header();?>
<div id="main-content-wp" class="forgot-pass-page">
    <div class="wp-inner">
        <h3 id="title-page">Lấy lại mật khẩu</h3>
        <div class="detail-page">
            <form method="POST" action="" id="forgot-pass-wp">
                <label for="user_email">Email</label>
                <input type="email" name="user_email" id="user_email"><br/>
                <input type="submit" name="sm_forgot_pass" value="Gửi yêu cầu">
            </form>
        </div>
    </div>
</div>
<?phpget_footer();?>