<?php
require '../Connect_DataBase.php';

$postData = $_POST;

$ssid = $_SESSION['store']['sid'];

//讀取時紀錄
if ($postData['state'] == 0) {
    $sql = "SELECT COUNT(1) AS `total`
    FROM `orders`
    WHERE `shop_sid`=$ssid";
    $output = $pdo->query($sql)->fetch();
    $count = $output['total'];
    $_SESSION['orderCount'] = $count;

    echo json_encode($count, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    exit;
} else if ($postData['state'] == 1) {
    $sql = "SELECT COUNT(1) AS `newTotal`
    FROM `orders`
    WHERE `shop_sid`=$ssid";

    $output = $pdo->query($sql)->fetch();
    $count = $output['newTotal'];
    // $_SESSION['orderCount'] = $count;
    if($count!=$_SESSION['orderCount']){
        $_SESSION['orderCount']=$count;
        echo json_encode(1, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
    else{
        echo json_encode(0, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    exit;
}






//echo json_encode($output, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
