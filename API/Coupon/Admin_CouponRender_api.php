<?php

//獲取全部優惠券資訊
require  '../Connect_DataBase.php';

if (!isset($_SESSION)) {
    session_start();
}


$ssid = $_SESSION['store']['sid'];
if ($ssid == 101)

{
$sql = "SELECT
cc.*,
s.name shop_name
FROM
`coupon_content` cc
LEFT JOIN
`shop` s
ON
s.`sid` = cc.`shop_sid`
WHERE
1";

$state = $pdo->query($sql);

echo json_encode($state->fetchAll(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}
else{
    exit;
}