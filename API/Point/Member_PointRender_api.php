<?php
require  '../Connect_DataBase.php';



$msid = $_SESSION['user']['sid'];

$sql = "SELECT p.*,cc.`coupon_name`
FROM `point_detail` p
LEFT JOIN `coupon_content` cc
ON p.`coupon_sid` = cc.`sid`
WHERE 
`member_sid`=$msid";

$output = $pdo->query($sql)->fetchAll();

echo json_encode($output, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
exit;