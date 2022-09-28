<?php
require  '../Connect_DataBase.php';

if (!isset($_SESSION)) {
    session_start();
}

$msid = $_SESSION['user']['sid'];

$postData = $_POST;
$usepoint = $postData['use_point'];

$getsql="INSERT INTO `coupon`(
    `coupon_sid`,
    `member_sid`,
    `expire`,
    `get_time`
)
VALUES(
    ?,?,?,NOW()
)";

$stmt = $pdo->prepare($getsql);

$stmt->execute([
    $postData['coupon_sid'],
    $msid,
    $postData['expire']    
]);

// $getted_order_sid = $pdo->lastInsertId();

if($usepoint!=0){
    $pointsql = "UPDATE
    `member`
    SET
    `point` = `point` - $usepoint
    WHERE
    `sid`   =  $msid";

    $stmt2 = $pdo->query($pointsql);
    // echo $stmt->rowCount();

    $pointdetailsql = "INSERT INTO `point_detail`(
        `member_sid`,
        `point_amount`,
        `point_change_time`,
        `point_change_method`,
        `coupon_sid`
    )
    VALUES(
        ?,
        ?,
        NOW(),
        0,
        ?
    )";
    $stmt3 = $pdo->prepare($pointdetailsql);

    $usepoint = $usepoint * -1 ;

    $stmt3->execute([
        $msid,
        $usepoint,
        $postData['coupon_sid']
    ]);
}
$res = $stmt->rowCount();
echo $res;

