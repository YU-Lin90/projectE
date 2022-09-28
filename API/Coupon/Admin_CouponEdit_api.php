<?php


require  '../Connect_DataBase.php';

if (!isset($_SESSION)) {
    session_start();
}


$postdata = $_POST;

//寫入
if ($postdata['state'] == 0) {

    $ssid = $_SESSION['store']['sid'];


    $getLimit = $postdata['getLimit'] . ' 23:59:59';

    $uselimit = $postdata['useLimit'] . ' 23:59:59';

    if (empty($postdata['needPoint']) || ($postdata['needPoint'] < 0)) {
        $postdata['needPoint'] = 0;
    }
    if (empty($postdata['limitCost']) || ($postdata['limitCost'] < 0)) {
        $postdata['limitCost'] = 0;
    }
    if (empty($postdata['cutamount']) || ($postdata['cutamount'] < 10)) {
        $postdata['cutamount'] = 10;
    }
    $sql = "INSERT INTO `coupon_content`(
    `coupon_name`,
    `shop_sid`,
    `sale_detail`,
    `use_range`,
    `need_point`,
    `get_limit_time`,
    `expire`
    )
    VALUES(
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?
    )";

    $stmt = $pdo->prepare($sql);


    $stmt->execute([
        $postdata['coupon_name'],
        $postdata['newCouponShopSid'],
        $postdata['cutamount'],
        $postdata['limitCost'],
        $postdata['needPoint'],
        $getLimit,
        $uselimit
    ]);

    $res = $stmt->rowCount();
    if ($res == 1) {
        echo 1;
    } else {
        echo 0;
    }
    exit;
}
//修改 3
else if ($postdata['state'] == 3) {

    $getLimit = $postdata['getLimit'] . ' 23:59:59';

    $uselimit = $postdata['useLimit'] . ' 23:59:59';

    if (empty($postdata['needPoint']) || ($postdata['needPoint'] < 0)) {
        $postdata['needPoint'] = 0;
    }
    if (empty($postdata['limitCost']) || ($postdata['limitCost'] < 0)) {
        $postdata['limitCost'] = 0;
    }
    if (empty($postdata['cutamount']) || ($postdata['cutamount'] < 10)) {
        $postdata['cutamount'] = 10;
    }

    $avail = 0;
    $comp = 0;
    if (isset($postdata['couponAvail'])) {
        $avail = 1;
    }
    if (isset($postdata['couponComp'])) {
        $comp = 1;
    }
    //couponAvail 
    //couponComp

    $sql = "UPDATE
    `coupon_content`
    SET
    `coupon_name` = ?,
    `sale_detail` = ?,
    `use_range` = ?,
    `need_point` = ?,
    `get_limit_time` = ?,
    `expire` = ?,
    `coupon_available` = ?,
    `coupon_complete` = ?
    WHERE
    `sid` = ?";



    $stmt = $pdo->prepare($sql);


    $stmt->execute([
        $postdata['Cname'],
        $postdata['cutamount'],
        $postdata['limitCost'],
        $postdata['needPoint'],
        $getLimit,
        $uselimit,
        $avail,
        $comp,
        $postdata['sid']
    ]);

    echo 1;
    exit;
}
//刪除 4
else if ($postdata['state'] == 4) {
    $sid = $_POST['sid'];

    $sqlDelete = "DELETE
    FROM
        `coupon_content`
    WHERE
        `sid` = $sid ";

    $stmt = $pdo->query($sqlDelete);

    $res = $stmt->rowCount();
    if ($res == 1) {
        echo 1;
    } else {
        echo 0;
    }
    exit;
}
