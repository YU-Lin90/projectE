<?php

//購物車增減刪除(單項)API

session_start();
$ssid;
if (isset($_POST['shop_sid'])) {
    $ssid =  $_POST['shop_sid'];
};
//[$ssid]
//加
if ($_POST['state'] == 0) {

    $getData = $_POST;

    $idin =  $getData['sid'];

    if (!isset($_SESSION['cart'][$ssid]['list'][$idin]) || $_SESSION['cart'][$ssid]['list'][$idin] == "") {
        $_SESSION['cart'][$ssid]['list'][$idin] = 1;
        if (!isset($_SESSION['cart'][$ssid]['shopTotal'])) {
            $_SESSION['cart'][$ssid]['shopTotal'] = 1;
        } else {
            $_SESSION['cart'][$ssid]['shopTotal'] += 1;
        }
    } else {
        $_SESSION['cart'][$ssid]['list'][$idin] += 1;
        $_SESSION['cart'][$ssid]['shopTotal'] += 1;
    }

    $OP = 0;

    foreach ($_SESSION['cart'] as $i) {
        $OP = $OP + $i['shopTotal'];
    }

    $_SESSION['cartTotal'] = $OP;

    echo $OP;
    exit;
}

//減
if ($_POST['state'] == 1) {
    $getData = $_POST;

    $idin =  $getData['sid'];

    if (isset($_SESSION['cart'][$ssid]['list'][$idin]) && $_SESSION['cart'][$ssid]['list'][$idin] >= 1) {
        $_SESSION['cart'][$ssid]['list'][$idin] -= 1;
        $_SESSION['cart'][$ssid]['shopTotal'] -= 1;
    }

    if (isset($_SESSION['cart'][$ssid]['list'][$idin]) && $_SESSION['cart'][$ssid]['list'][$idin] == 0) {
        unset($_SESSION['cart'][$ssid]['list'][$idin]);
    }

    $OP = 0;

    foreach ($_SESSION['cart'] as $i) {
        $OP = $OP + $i['shopTotal'];
    }

    $_SESSION['cartTotal'] = $OP;

    if (empty($_SESSION['cart'][$ssid]['list'])) {
        unset($_SESSION['cart'][$ssid]);
    }
    if (empty($_SESSION['cart'])) {
        unset($_SESSION['cart']);
    }

    echo $OP;

    exit;
}

//清除單項
if ($_POST['state'] == 2) {
    $getData = $_POST;

    $idin =  $getData['sid'];

    unset($_SESSION['cart'][$ssid]['list'][$idin]);

    $ShopTotal=0;
    foreach ($_SESSION['cart'][$ssid]['list'] as $i) {
        $ShopTotal = $ShopTotal + $i;
    }

    $_SESSION['cart'][$ssid]['shopTotal']=$ShopTotal;
    
    $OP = 0;

    foreach ($_SESSION['cart'] as $i) {
        $OP = $OP + $i['shopTotal'];
    }

    $_SESSION['cartTotal'] = $OP;

    if (empty($_SESSION['cart'][$ssid]['list'])) {
        unset($_SESSION['cart'][$ssid]);
    }
    if (empty($_SESSION['cart'])) {
        unset($_SESSION['cart']);
    }

    echo $OP;

    exit;
}
