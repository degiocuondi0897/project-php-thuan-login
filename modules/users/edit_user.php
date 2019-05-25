<?php
$id = isset($_GET['id'])?$_GET['id']:"";
echo $id;
$userName = $_POST['fullName'];
$password = $_POST['password'];
$data = array(
'fullname' => $userName,
'password' => $password
)
db_update('user',$data,$id);


?>

<!-- <div id="main-content-wp" class="reg-page">
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
</div> -->