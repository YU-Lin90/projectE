<?php

require '../Connect_DataBase.php';

$postData = $_POST;
$ssid = $_SESSION['store']['sid'];

if ($postData['state'] == 0) {

    $sql = "SELECT s.`wait_time`
    FROM `shop` s
    WHERE `sid` = $ssid";

    $state = $pdo->query($sql)->fetch();

    echo json_encode($state, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
} else if ($postData['state'] == 1) {

    $WTime = $postData['time'];
    $sql = "UPDATE
    `shop`
    SET
    `wait_time` = $WTime
    WHERE
    `sid` = $ssid";

    $state = $pdo->query($sql);

    exit;
}
