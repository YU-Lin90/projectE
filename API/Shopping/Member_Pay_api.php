<?php


//結帳API



require '../Connect_DataBase.php';

if (!isset($_SESSION)) {
    session_start();
}

$output = [
    'success' => false,
    'error' => '',
    'code' => 0
];

//寫入訂單概要，取得訂單SID
$totalPrice = $_POST['price'];
$cuttedPrice = $_POST['cuttedprice'];
$Msid =  $_SESSION['user']['sid'];
$shopSid = $_SESSION['cartShop'];
$coupon_sid = $_POST['coupon_sid'];
$memos = $_POST['memos'];

$sql = "INSERT INTO `orders`(
    `member_sid`,
    `shop_sid`, 
    `order_time`,
    `order_total`,
    `memo`,
    `coupon_sid`,
    `sale`

    ) VALUES (
    ?,
    ?,
    NOW(),
    ?,
    ?,
    ?,
    ?
    )";
    
$stmt = $pdo->prepare($sql);

$stmt->execute([
    $Msid,
    $shopSid,    
    $totalPrice,
    $memos,
    $coupon_sid,
    $cuttedPrice
]);

$getted_order_sid = $pdo->lastInsertId();


//寫入訂單明細


$cartlist = $_SESSION['cart'][$shopSid]['list'];

foreach ($cartlist as $i => $j) {

    $getPrice = "SELECT `SID`,`price` FROM `products` WHERE SID = $i";

    $gettedprice = $pdo->query($getPrice)->fetch();


    $sqlDetail =  "INSERT INTO `order_detail`(
    `order_sid`,
    `product_sid`,
    `product_price`,
    `amount`
)
VALUES(
    ?,
    ?,
    ?,
    ?
)";

    $stmt = $pdo->prepare($sqlDetail);

    $stmt->execute([$getted_order_sid, $i, $gettedprice['price'], $j]);
}


//寫入優惠券使用

if ($coupon_sid != 0) {

    $osid = $getted_order_sid;
    $sql_couponW = "UPDATE
`coupon`
SET
`order_sid` = $osid,
`is_used` = 1,
`used_time` = NOW()
WHERE
`sid` = $coupon_sid";

    $pdo->query($sql_couponW);
}

unset($_SESSION['cart'][$shopSid]);
unset($_SESSION['cartShop"']);

$OP = 0;

foreach ($_SESSION['cart'] as $i) {
    $OP = $OP + $i['shopTotal'];
}

$_SESSION['cartTotal'] = $OP;

if (!empty($stmt->rowCount())) {
    echo $stmt->rowCount();
}

