<?php
session_start();
//取消設定
unset($_SESSION['admin']);
unset($_SESSION['store']);
unset($_SESSION['orderCount']);
//session_destroy();全部清除
//302 轉向
header('Location:../../Store_login.php');
?>