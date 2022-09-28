<?php

//生成結帳頁API

require  '../Connect_DataBase.php';
$ssid = $_SESSION['cartShop'];
$amountTemp = [];
$b = 0;
foreach ($_SESSION['cart'][$ssid]['list'] as $a) {

    $amountTemp[$b] = $a;
    $b = $b + 1;
}

// var_dump($amountTemp)
//優惠券讀取
//SELECT * FROM `coupon` c LEFT JOIN `coupon_content` cc ON c.coupon_sid = cc.sid WHERE c.`member_sid` = 1;
//SELECT * FROM `coupon` c LEFT JOIN `coupon_content` cc ON (c.coupon_sid = cc.sid) AND (cc.shop_sid = 89 ) WHERE c.`member_sid` = 1
//SELECT c.*,cc.coupon_name,cc.sale_detail,cc.use_range FROM `coupon` c LEFT JOIN `coupon_content` cc ON (c.coupon_sid = cc.sid) && (cc.shop_sid = 89 or cc.shop_sid = 0) WHERE c.`member_sid` = 1;


$cartlist = $_SESSION['cart'][$ssid]['list'];

$output = [];
$k = 0;
foreach ($cartlist as $i => $j) {

    // $sql = "SELECT `SID`,`name`,`price`,`src`
    // FROM product  
    // WHERE `SID` = $i";

    $sql = "SELECT p.`sid`,p.`name` product_name,p.`price`,s.`name`,p.`shop_sid`,s.`wait_time`
    FROM products p
    LEFT JOIN `shop` s
    ON p.`shop_sid`= s.`sid`
    WHERE p.`sid` = $i";

    $state = $pdo->query($sql);

    $output['cart'][$k] = $state->fetch();

    $output['cart'][$k]['amount'] = $amountTemp[$k];

    $k = $k + 1;
}

// $_SESSION['cartShop'] = $output['cart'][0]['shop_sid'];


$msid = $_SESSION['user']['sid'];
$ssid = $_SESSION['cartShop'];

$sql_coupon = 
"SELECT c.*,
cc.coupon_name,
cc.sale_detail,
cc.use_range,
cc.shop_sid
FROM `coupon` c 
LEFT JOIN `coupon_content` cc 
ON (c.coupon_sid = cc.sid) 
WHERE (c.`member_sid` = $msid ) AND (cc.shop_sid = $ssid OR cc.shop_sid = 101) AND(c.is_used = 0)";
                                                    //      管理者SID


$state_coupon  = $pdo->query($sql_coupon);

$output['coupon'] =$state_coupon->fetchAll();





























//SELECT * FROM `product` 


// $sql = "SELECT * FROM product WHERE sid LIKE ?";

// $state= $pdo->prepare($sql);

// $state->execute([    
//     $_SESSION['user']['sid']
// ]);

// print_r($state->fetchAll());
// print_r($state->fetch());

echo json_encode($output, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
