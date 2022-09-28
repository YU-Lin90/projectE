<?php 
require '../Connect_DataBase.php'; 

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

$sql = "DELETE FROM shop WHERE sid={$sid}";

$pdo->query($sql);

header("Location: ../../Store_list.php");