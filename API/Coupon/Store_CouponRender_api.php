<?php

//獲取店家優惠券資訊
require  '../Connect_DataBase.php';

if (!isset($_SESSION)) {
    session_start();
}


// $ssid;
// if($_SESSION['store']['sid']!=101){

    $ssid = $_SESSION['store']['sid'];
// }
// else if($_SESSION['store']['sid']==101){
//     $ssid = 0;
// }

$sql = "SELECT
`sid`,
`coupon_name`,
`shop_sid`,
`sale_detail`,
`use_range`,
`need_point`,
`get_limit_time`,
`expire`,
`coupon_available`,
`coupon_complete`
FROM
`coupon_content`
WHERE
shop_sid = $ssid";

$state = $pdo->query($sql);

echo json_encode($state->fetchAll(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
