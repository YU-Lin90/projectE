<?php

session_start();

require '../Connect_DataBase.php';


if($_POST['state']==0){
$output = [];
$_SESSION['cartTotal'];//total
$_SESSION['cart'];//foreach
//$_SESSION['cartShop'];//set

$output['cartTotal'] = $_SESSION['cartTotal'];


$k=0;
foreach($_SESSION['cart'] as $i=>$j){

    $sql="SELECT `name`
    FROM
    `shop`
    WHERE
    `sid`=$i
    ";
    $output['shopList'][$k]['shop_name'] = ($pdo->query($sql)->fetch())['name'];
    $output['shopList'][$k]['shopTotal'] = $_SESSION['cart'][$i]['shopTotal'];
    $output['shopList'][$k]['shop_sid'] = $i;
    $k++;


}

echo json_encode($output,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
exit;}

else if ($_POST['state']==1){
$_SESSION['cartShop'] = $_POST['choosed_sid'];
echo 1;
exit;
}