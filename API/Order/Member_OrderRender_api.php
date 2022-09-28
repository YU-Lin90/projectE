<?php

//生成訂單頁API

require '../Connect_DataBase.php';

$output = [
    'success' => false,
    'error' => '',
    'code' => 0
];

//登入檢查
// code 0 OK 1 沒登入
if (!isset($_SESSION['user']['email'])) {

    $output['error'] = '請先登入';
    $output['code'] = 1;
    echo json_encode($output, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}


$Mid = $_SESSION['user']['sid'];

$sql = "SELECT
o.`SID`,
o.`member_sid`,
o.`shop_sid`,
o.`shop_order_status`,
o.`order_finish`,
o.`order_time`,
o.`recept_time`,
o.`complete_time`,
o.`order_total`,
o.`memo`,
o.`coupon_sid`,
o.`sale`,
o.`review`,
o.`chat_sid`,
o.`canceled_reason`,
o.`who_canceled`,
s.`name`,
cc.`coupon_name`
FROM
`orders` o
LEFT JOIN `shop` s
ON o.`shop_sid` = s.`sid`
LEFT JOIN `coupon` c
ON o.`coupon_sid`=c.`sid`
LEFT JOIN `coupon_content` cc
ON 
c.`coupon_sid` = cc.`sid`
WHERE
o.member_sid = $Mid";

$state = $pdo->query($sql);

$info = $state->fetchAll() ;

foreach($info as $k=>$i){
    $orderID = $i['SID'];
    $sqlDetail = "SELECT od.* ,p.name `product_name`,p.src
    FROM `order_detail` od
    LEFT JOIN `products` p
    ON od.`product_sid`= p.`SID`
    WHERE od.`order_sid` = $orderID";

    $detailState = $pdo->query($sqlDetail)->fetchAll();

    $info[$k]['cartList'] = $detailState;

}
echo json_encode($info,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
