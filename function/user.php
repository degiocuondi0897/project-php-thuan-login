<?php

function check_pass_old($password, $email) {
    $result = db_fetch_array("SELECT `passWord`,`emailUser`from `tbl_user` where `emailUser`='{$email}'&&`passWord`='{$password}'");
    if (!empty($result)) {
        return TRUE;
    }
    return FALSE;
}

function check_reset_pass($email, $code_change_pass) {
    $result = db_fetch_array("SELECT `code_change_pass`,`emailUser` from `tbl_user` where `code_change_pass`='{$code_change_pass}'&&`emailUser`='$email'");
    if (!empty($result)) {
        return true;
    }
    return FALSE;
}

function check_account() {
    $result = db_fetch_array("SELECT `idUser`,`is_active`,`created_at` from `tbl_user`");
    foreach ($result as $value) {
        if ($value['is_active'] == 0 && time() - $value['created_at'] > 24 * 60 * 60) {
            $idUser = $value['idUser'];
            db_delete('tbl_user', "`idUser`='$idUser'");
        }
    }
}

/* ---------------------------------------------Đăng nhập------------------------------------------------------ */

function check_login($userName, $passWord) {
    $result = db_fetch_array("SELECT `userName`,`emailUser`,`passWord`,`is_active` from `tbl_user` ");
    foreach ($result as $value) {
        if (($userName == $value['userName'] || $userName == $value['emailUser']) && $passWord == $value['passWord'] &&$value['is_active']==1) {
            return 1;
        }else{
            return 2;
        }
    }
    return false;
}

function is_login() {
    if (isset($_SESSION['login'])) {

        return $_SESSION['login']['is_login'];
    }
    return false;
}

function user_login() {
    if (isset($_SESSION['login'])) {

        return $_SESSION['login']['user_login'];
    }
    return false;
}

/* ---------------------------------------------Đăng kí-------------------------------------------------------- */

//kiểm tra tồn tại của user
#return true: tài khoản đã tồn tại
#return false: tài khoản hợp lệ
function check_user($userName) {
    $result = db_fetch_row("SELECT COUNT('idUser') as total from `tbl_user` where `userName` = '{$userName}'");
    if ($result['total'] > 0)
        return true;
    return false;
}

//kiểm tra trùng pass
#return true: nếu như mật khâu  không trùng nhau
function check_password($password, $re_password) {
    if (strcmp($password, $re_password) != 0) {
        return true;
    }
    return false;
}

//kiểm tra tồn tại của email
#return true: email này đã tồn tại
#return false: email hợp lệ
function check_email($emailUser) {
    $result = db_fetch_row("SELECT COUNT('idUser') as total from `tbl_user` where `emailUser` = '{$emailUser}' ");
    if ($result['total'] > 0)
        return true;
    return false;
}

/* --------------------------------------xác nhận------------------------------------------------------------ */

//kiểm tra xem codeactive và email lấy từ trên url xuống có trùng với trong db hay k. nếu trùng thì update isActive = 1
function check_confirm($confirm_code, $confirm_email) {
    $result = db_fetch_array("SELECT `code_active`,`emailUser` from `tbl_user` where `code_active` = '$confirm_code' && `emailUser` = '{$confirm_email}' ");
    if (!empty($result)) {
        $data = array(
            'is_active' => 1
        );
        db_update('tbl_user', $data, "`emailUser` = '$confirm_email'");
        return true;
    }
    return false;
}

/* --------------------------------------------------reset-pass---------------------------------------------- */

function check_change_pass($emailUser, $code_chang_pass) {
    $result = db_fetch_row("SELECT `emailUser`,`code_change_pass` from `tbl_user` where `emailUser` = '{$emailUser}' && `code_change_pass` = '$code_chang_pass'");
    if (!empty($result)) {
        return TRUE;
    }
    return FALSE;
}

/* -------------------------------------------------VALIDATION--------------------------------------------- */
#username: trả về true nếu đúng định dạng

function is_username($username) {
    $parttern = "/^[A-Za-z0-9_\@.]{6,32}$/";
    if (preg_match($parttern, $username)) {
        return true;
    }
}

#password: nếu đúng định dạng trả về true. 
#password bao gồm 1 kí tự viết hoa, kí tự số.

function is_password($password) {
    $parttern = "/^([A-Z]){1}([\w_\.!@#$%^&*()]+){5,31}$/";
    if (preg_match($parttern, $password)) {
        return true;
    }
}

#email : nếu đúng định dạng trả về true

function is_email($emailUser) {
    $parternt = "/^[A-Za-z0-9_.]{6,32}@([a-zA-Z0-9]{2,12})(.[a-zA-Z]{2,12})+$/";
    if (preg_match($parternt, $emailUser)) {
        return true;
    }
}
//get list user
function get_list_user($start,$num_per_page)
{
    $result = db_fetch_array("SELECT *from `tbl_user` LIMIT $start,$num_per_page");
    $temp = 0;
    foreach ($result as &$value) {
        $temp++;
        $value['i'] = $temp;
        $value['edit_user'] = "?mod=users&act=edit_user&id={$value['idUser']}";
        $value['delete_user'] = "?mod=user&act=delete_user&id={$value['idUser']}";
    }
    return $result;
}
function get_total_user()
{
    $result = db_fetch_row("SELECT count(*)as `total` from `tbl_user`");
    return $result['total'];
}
//function get_paggin_html($num_rows,$num_per_page,$page,$paggin_url)
//{
//    //echo $page;
//    //$num_page = ceil($num_rows/$num_per_page);
//    $num_page = ceil($num_rows/$num_per_page);
//    $result= "<ul class=\"list-item\">";
//    for ($i = 1; $i <= $num_page; $i++) {
//        $class = "";
//        if ($i==$page) {
//            $class = "active";
//        }
//        $result.="<li class={$page}><a href='{$paggin_url}&page={$i}' title=''>{$i}</a> </li> ";
//    }
//    $result.="</ul>";
//    return $result;
//}
function create_pagging($num_page = 0, $base_url_pagging = "", $current_page) {
    $pagging = "<ul class=\"pagging\">";
    for ($i = 1; $i <= $num_page; $i++) {
        $class_active = "";
        if ($current_page == $i) {
            $class_active = "class = 'active'";
        }
        $pagging .= " <li {$class_active}><a href='{$base_url_pagging}&page={$i}'>{$i}</a></li>";
    }
    $pagging .= " </ul>";
    return $pagging;
}

?>

