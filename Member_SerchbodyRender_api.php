<?php

//生成產品列表

require './API/Connect_DataBase.php';

$sql = "SELECT * FROM products";

//$sql = "SELECT * FROM product WHERE store_sid LIKE ?"; 限定店家
// $state= $pdo->prepare($sql);
$state= $pdo->query($sql);
// $state->execute([    
//     $_SESSION['user']['sid']
// ]);

// print_r($state->fetchAll());
// print_r($state->fetch());

echo json_encode($state->fetchAll(),JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);

?>
