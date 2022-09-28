<?php


require  '../Connect_DataBase.php';

if (!isset($_SESSION)) {
    session_start();
}


$postdata = $_POST;

//寫入
if ($postdata['state'] == 0) {
    // $ssid;
    // if ($_SESSION['store']['sid'] != 101) {

        $ssid = $_SESSION['store']['sid'];
    // } else if ($_SESSION['store']['sid'] == 101) {
        // $ssid = 0;
    // }

    $getLimit = $postdata['getLimit'] . ' 23:59:59';

    $uselimit = $postdata['useLimit'] . ' 23:59:59';

    if(empty($postdata['needPoint'])||($postdata['needPoint']<0)){
        $postdata['needPoint'] = 0;
    }
    if(empty($postdata['limitCost'])||($postdata['limitCost']<0)){
        $postdata['limitCost'] = 0;
    }
    if(empty($postdata['cutamount'])||($postdata['cutamount']<10)){
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
        $ssid,
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



//上架
else if ($postdata['state'] == 1) {

    $ssid = $postdata['sid'];

    $sql = "UPDATE
    `coupon_content`
    SET    
    `coupon_available` = 1
    WHERE
    `sid` = $ssid";

    $stmt = $pdo->query($sql);

    $res = $stmt->rowCount();
    if ($res == 1) {
        echo 1;
    } else {
        echo 0;
    }
    exit;
}

//下架
else if ($postdata['state'] == 2) {

    $ssid = $postdata['sid'];

    $sql = "UPDATE
    `coupon_content`
    SET    
    `coupon_available` = 0
    WHERE
    `sid` = $ssid";

    $stmt = $pdo->query($sql);

    $res = $stmt->rowCount();
    if ($res == 1) {
        echo 1;
    } else {
        echo 0;
    }
    exit;
}
//修改
else if ($postdata['state'] == 3) {

    $getLimit = $postdata['getLimit'] . ' 23:59:59';

    $uselimit = $postdata['useLimit'] . ' 23:59:59';

    if(empty($postdata['needPoint'])||($postdata['needPoint']<0)){
        $postdata['needPoint'] = 0;
    }
    if(empty($postdata['limitCost'])||($postdata['limitCost']<0)){
        $postdata['limitCost'] = 0;
    }
    if(empty($postdata['cutamount'])||($postdata['cutamount']<10)){
        $postdata['cutamount'] = 10;
    }

    $sql = "UPDATE
    `coupon_content`
    SET
    `coupon_name` = ?,
    `sale_detail` = ?,
    `use_range` = ?,
    `need_point` = ?,
    `get_limit_time` = ?,
    `expire` = ?
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
    $postdata['sid_E']
]);


    $res = $stmt->rowCount();
    if ($res == 1) {
        echo 1;
    } else {
        echo 0;
    }
    exit;
}
