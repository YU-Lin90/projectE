<?php 
require  '../Connect_DataBase.php'; 

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

$sql = "DELETE FROM member WHERE sid={$sid}";

$pdo->query($sql);

$come_from = 'list.php';

if(! empty($_SERVER['HTTP_REFERER'])){
    $come_from = $_SERVER['HTTP_REFERER'];
}
header("Location: {$come_from}");