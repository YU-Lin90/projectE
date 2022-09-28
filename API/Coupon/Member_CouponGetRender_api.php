<?php

require  '../Connect_DataBase.php';

if (!isset($_SESSION)) {
    session_start();
}

$msid = $_SESSION['user']['sid'];

$sql="SELECT
    cc.`sid`,
    cc.`coupon_name`,
    cc.`shop_sid`,
    cc.`sale_detail`,
    cc.`use_range`,
    cc.`need_point`,
    cc.`get_limit_time`,
    cc.`expire`,
    cc.`coupon_available`,
    cc.`coupon_complete`,
    s.name
FROM
    `coupon_content` cc
LEFT JOIN
    `shop` s
ON
	cc.`shop_sid` = s.`sid`
WHERE
    (cc.`get_limit_time` >= NOW()) AND (cc.`coupon_available` = 1)
";

$state = $pdo->query($sql);

$output['coupons'] = $state->fetchAll();
// echo json_encode($output, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
//檢查重複用

$checksql= "SELECT
`coupon_sid`
FROM
`coupon`
WHERE
`member_sid` = $msid";

$checkArr = $pdo->query($checksql)->fetchAll();

$output['check'] = $checkArr;

$pointsql = "SELECT
`point`
FROM
`member`
WHERE
`sid` = $msid";

$pointRes = $checkArr = $pdo->query($pointsql)->fetch();

$output['point'] = $pointRes['point'];


echo json_encode($output, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);