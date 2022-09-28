<?php

//檢查是否登入，回傳0/1

if(!isset($_SESSION)){
    session_start();
}

if (empty($_SESSION['user'])){
    echo 0;
    exit;
}
else {
    echo 1;
    exit;
}
?>