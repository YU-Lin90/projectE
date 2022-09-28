<?php

session_start();
$OP =0;
if(isset($_SESSION['cartTotal'])){
$OP = $_SESSION['cartTotal'];}
echo $OP;
?>