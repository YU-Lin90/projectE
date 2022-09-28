<?php
require '../Connect_DataBase.php';


// $_SESSION['store']['sid'];
//FD.append("confirm", 1);   0取消  1接單 2完成  $postData['confirm']
//FD.append("whoCanceled", 0);  0會員  1店家     $postData['whoCanceled']

$postData = $_POST;
//取消
if ($postData['confirm'] == 0) {
    $sql = "UPDATE `orders` SET 
    `shop_order_status`= 0,
    `order_finish`= 1,
    `complete_time` =NOW(),
    `who_canceled` =?,
    `canceled_reason` = ?
    WHERE `sid` = ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([        
        $postData['whoCanceled'],
        $postData['canceledReason'],
        $postData['order_sid']
    ]);
    if($postData['whoCanceled']==0){
        $postData['coupon_sid'] = 0;
    }
    if($postData['whoCanceled']==1&&$postData['coupon_sid']!=0){
        $csid = intval($postData['coupon_sid']);
        $couponsql = "UPDATE
        `coupon`
        SET
        `order_sid` = ?,
        `is_used` = 0,
        `used_time` = ?
        WHERE
        `sid`= ?";
        $stmt2 = $pdo->prepare($couponsql);
        $stmt2->execute([        
            null,
            null,
            $csid
        ]);       
    }
    echo $stmt->rowCount();
    exit;
}
//接單 
else if ($postData['confirm'] == 1) {
    $sql = "UPDATE `orders` SET 
    `shop_order_status`= 1,
    `recept_time` =NOW()
    WHERE `orders`.`sid` = ?";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $postData['order_sid'],
    ]);

    echo $stmt->rowCount();
    exit;
}
//完成
else if ($postData['confirm'] == 2) {
    $sql = "UPDATE `orders` SET 
    `shop_order_status`= 1,
    `order_finish`= 1,
    `complete_time` =NOW()
    WHERE `orders`.`sid`=?";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $postData['order_sid'],
    ]);

    echo $stmt->rowCount();
    exit;
}
