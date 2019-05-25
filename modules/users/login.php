<?php
$error = array();
if (isset($_COOKIE['userName'])) {
    $userName = $_COOKIE['userName'];
}
if (isset($_POST['user_login'])) {
    $data['userName'] = (isset($_POST['userName'])) ? $_POST['userName'] : '';
    $data['passWord'] = (isset($_POST['passWord'])) ? $_POST['passWord'] : '';
    /* -----------------------------------------kiểm tra tên đăng nhập------------------------------------ */
    if (empty($data['userName'])) {
        $error['userName'] = 'không được để trống';
    } else {
        if (!is_username($data['userName'])) {
            $error['userName'] = 'tài khoản không đúng định dạng';
        } else {
            $userName = $data['userName'];
        }
    }
    if (empty($data['passWord'])) {
        $error['passWord'] = 'không được để trống';
    } else {
        if (!is_password($data['passWord'])) {
            $error['passWord'] = 'mật khẩu không đúng định dạng';
        } else {
            $passWord = md5($data['passWord']);
        }
    }
    if (empty($error)) {
        $result = check_login($userName, $passWord);
        if ($result == 1) {
            $_SESSION['login'] = array(
                'is_login' => true,
                'user_login' => $userName,
            );
            if (isset($_POST['remember'])) {
                setcookie('is_login', true, time() + 30 * 24 * 60 * 60);
                setcookie('user_login', $username, time() + 30 * 24 * 60 * 60);
                setcookie('user_id_login', $user_id_login, time() + 30 * 24 * 60 * 60);
            }
            redirect("?mod=home&act=main");
        } elseif ($result == 2) {
            $error['user_login'] = 'tài khoản chưa được kích hoạt';
        } else {
            $error['user_login'] = 'tài khoản hoặc mật khẩu không tồn tại';
        }
    }
}
?>
<?php get_header();?>
<div id="main-content-wp" class="login-page">
    <div class="wp-inner">
        <h3 class="title-page">Đăng nhập</h3>
        <div class="detail-page">
            <form method="POST" action="" id="login-wp">
                <label>Tên đăng nhập</label>
                <input type="text" name="userName" id="username" value="<?php if (isset($_COOKIE['userName'])) {
    echo $_COOKIE['userName'];
} ?>" >
                <?php
                if (isset($error['userName'])) {
                    echo $error['userName'];
                }
                ?>
                <label>Mật khẩu</label>
                <input type="password" name="passWord" id="password" value="<?php if (isset($_COOKIE['password'])) echo $_COOKIE['password']; ?>">
                <?php
                if (isset($error['passWord'])) {
                    echo $error['passWord'];
                };
                ?>
                <div class="wrap-checkbox">
                    <input type="checkbox" name="remember" id="remember" <?php if (isset($_POST['remember'])) echo "checked = 'checked'"; ?> >
                    <label for="remember" id="title-remember">Ghi nhớ mật khẩu?</label><br/>
                </div>
                <input type="submit" name="user_login" value="Đăng nhập"><br/><br/>
                <?php
                if (isset($error['user_login'])) {
                    echo $error['user_login'];
                }
                ?>
            </form>
        </div>
        <a href="?mod=users&act=forgot_pass" title="Quên mật khẩu?" id="forgot-pass">Quên mật khẩu?</a>
    </div>
</div>
<?php get_footer();?>
