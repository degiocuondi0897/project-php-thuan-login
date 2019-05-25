<?php

if (is_login()) {
    unset($_SESSION['login']);
    setcookie('is_login', true, time() - 30 * 24 * 60 * 60);
    setcookie('user_login', $username, time() - 30 * 24 * 60 * 60);
    setcookie('user_id_login', $user_id_login, time() - 30 * 24 * 60 * 60);
    redirect("?mod=users&act=login");
}
?>