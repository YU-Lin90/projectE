<?php

session_start();
$res;
if (!isset($_SESSION['cart'])||empty($_SESSION['cart'])) {
    $res = 0;
} 
else{
    $res = 1;    
}
echo $res ;
exit;