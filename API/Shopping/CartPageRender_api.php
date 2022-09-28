<?php

//生成購物車頁API

require '../Connect_DataBase.php';
$ssid = $_SESSION['cartShop'];
// $ssid = 89;
$amountTemp = [];
$b = 0;
foreach ($_SESSION['cart'][$ssid]['list'] as $a) {

    $amountTemp[$b] = $a;
    $b = $b + 1;
}

// var_dump($amountTemp)

$cartlist = $_SESSION['cart'][$ssid]['list'];

$output = [];
$k = 0;
foreach ($cartlist as $i => $j) {

    // $sql = "SELECT `SID`,`name`,`price`,`src`
    // FROM product  
    // WHERE `SID` = $i";

    $sql = "SELECT p.`sid`,p.`name` product_name,p.`price`,p.`src`,s.`name`,p.`shop_sid`,s.`wait_time`
    FROM products p
    LEFT JOIN `shop` s
    ON p.`shop_sid`= s.`sid`
    WHERE p.`sid` = $i";

    $state = $pdo->query($sql);

    $output[$k] = $state->fetch();

    $output[$k]['amount'] = $amountTemp[$k];

    $k = $k + 1;
}

$_SESSION['cartShop'] = $output[0]['shop_sid'];


//SELECT * FROM `product` 


// $sql = "SELECT * FROM product WHERE sid LIKE ?";

// $state= $pdo->prepare($sql);

// $state->execute([    
//     $_SESSION['user']['sid']
// ]);

// print_r($state->fetchAll());
// print_r($state->fetch());

echo json_encode($output, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
