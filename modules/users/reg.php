<?php
$error = array();
if (isset($_POST['register'])) {
    /* --------------------------------checl fullname------------------------------------- */
    //kien tra tai khoan, trong 24h khong kich hoat thi se xoa tai khoan
    check_account();
    if (empty($_POST['fullName'])) {
        $error['fullName'] = 'không được để trống';
    } else {
        $fullName = $_POST['fullName'];
    }
    /* -------------------------------check user----------------------------------------- */
    if (empty($_POST['userName'])) {
        $error['userName'] = 'không được để trống';
    } else {
        if (!is_username($_POST['userName'])) {
            $error['userName'] = "tài khoản không hợp lệ";
        } else {
            if (check_user($_POST['userName'])) {
                $error['userName'] = 'tài khoản đã tồn tại';
            } else {
                $userName = $_POST['userName'];
            }
        }
    }
    /* --------------------------check password------------------------------------------- */
    if (empty($_POST['passWord'])) {
        $error['passWord'] = 'không được để trống';
    } else {
        if (!is_password($_POST['passWord'])) {
            $error['passWord'] = 'mật khẩu không hợp lệ';
        } else {
            if (empty($_POST['re_passWord'])) {
                $error['re_passWord'] = 'không được để trống';
            } else {
                if (check_password($_POST['passWord'], $_POST['re_passWord'])) {
                    $error['re_password'] = 'mật khẩu không trùng khớp';
                } else {
                    $passWord = $_POST['passWord'];
                }
            }
        }
    }
    /* --------------------------------check email-------------------------------------------- */
    if (empty($_POST['emailUser'])) {
        $error['emailUser'] = 'không được để trống';
    } else {
        if (!is_email($_POST['emailUser'])) {
            $error['emaiUser'] = 'email không đúng định dạng';
        } else {
            if (check_email($_POST['emailUser'])) {
                $error['emailUser'] = 'email đã tồn tại';
            } else {
                $emailUser = $_POST['emailUser'];
            }
        }
    }
    /* --------------------------------insert database---------------------------------------- */
    if (empty($error)) {
        $created_at = time();
        $code_active = md5(rand(1000, 1000000));
        $link = "http://localhost:8080/traiweb8/user/?mod=users&act=confirm_reg&emailUser={$emailUser}&code_active={$code_active}";
        $content = "Chào {$fullName} chúng tôi vừa nhận được yêu cầu đăng kí tài khoản của bạn. Vui lòng ấn vào link <a href='{$link}' >{$link}</a> để xác nhận đăng kí tài khoản. Nếu trong vòng 24h bạn không xác nhận hệ thống sẽ tự động hủy !";
        $subject = 'Moon Shop';
        sendmail($emailUser, $fullName, $subject, $content);
        $data = array(
            'fullName' => $fullName,
            'userName' => $userName,
            'passWord' => md5($passWord),
            'emailUser' => $emailUser,
            'code_active' => $code_active,
            'created_at' => $created_at
        );
        db_insert('tbl_user', $data);
        redirect("?mod=users&act=pending");
    }
}
?>


<?php get_header(); ?>
<div id="main-content-wp" class="reg-page">
    <div class="wp-inner">
        <h3 class="title-page">Đăng ký thành viên</h3>
        <div class="detail-page">
            <form method="POST" action="" id="reg-wp">
                <label for="fullName">Họ và tên</label>
                <input type="text" name="fullName" id="fullName" value="<?php
                if (isset($data['fullName'])) {
                    echo $data['fullName'];
                }
                ?>">
                       <?php
                       if (isset($error['fullName'])) {
                           echo $error['fullName'];
                       }
                       ?>

                <label for="userName">Tên đăng nhập</label>
                <input type="text" name="userName" id="userName"">
                <?php
                if (isset($error['userName'])) {
                    echo $error['userName'];
                }
                ?>
                <label for="passWord">Mật khẩu</label>
                <input type="password" name="passWord" id="passWord">
                <?php
                if (isset($error['passWord'])) {
                    echo $error['passWord'];
                }
                ?>
                <label for="re-password">Xác nhận mật khẩu</label>
                <input type="password" name="re_passWord" id="re-passWord">
                <?php
                if (isset($error['re_passWord'])) {
                    echo $error['re_passWord'];
                }
                ?>
                <label for="email">Email</label>
                <input type="email" name="emailUser" id="emailUser" ><br/>
                <?php
                if (isset($error['emailUser'])) {
                    echo $error['emailUser'];
                }
                ?><br>
                <input type="submit" value="Đăng ký" name="register">

            </form>
        </div>
    </div>
</div>

<?php get_footer(); ?>