<?php 
// require './admin-required.php';  //之後再處理
require '../Connect_DataBase.php'; 

$author = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

$sql = "DELETE FROM chat WHERE chat=$author";

$pdo->query($sql);

header("Location:../../list-forum.php");
