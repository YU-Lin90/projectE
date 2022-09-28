<?php

//獲取店家優惠券資訊
require  '../Connect_DataBase.php';

if (!isset($_SESSION)) {
    session_start();
}


$msid = $_SESSION['user']['sid'];

$sql = "SELECT
c.*,
cc.`coupon_name`,
cc.`use_range`,
cc.`sale_detail`,
cc.`shop_sid`,
s.name
FROM
`coupon` c
LEFT JOIN 
`coupon_content` cc
ON 
c.`coupon_sid` = cc.`sid`
LEFT JOIN
`shop` s
ON
s.`sid` = cc.`shop_sid`
WHERE
c.`member_sid` = $msid";

$state = $pdo->query($sql);

echo json_encode($state->fetchAll(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
