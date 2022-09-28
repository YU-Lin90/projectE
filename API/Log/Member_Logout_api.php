<?php
//登出
session_start();
//取消設定
unset($_SESSION['user']);
//session_destroy();全部清除
//302 轉向
header('Location:../../Member_login.php');
?>