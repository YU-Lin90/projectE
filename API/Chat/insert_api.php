<?php 
// require __DIR__ . '/parts/admin-required.php';  //之後再確認
session_start();
require '../Connect_DataBase.php';

header('Content-Type: application/json');

$output = [
    'success' => false,
    'error' => '',
    'code' => 0,
    'postData' => $_POST, // 除錯用的
];

if(empty($_POST['content'])){
    $output['error'] = '參數不足';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE); 
    exit;
}

// TODO: 檢查欄位資料

$sql = "INSERT INTO `chat`(
    `author`, `time`, `content`, `title`, `sid_title`
    ) VALUES (?, NOW(), ?, ?, ?)";

$stmt = $pdo->prepare($sql);

// $time = null;
// if(strtotime($_POST['birthday'])!==false){
//     $birthday = $_POST['birthday'];
// }


try {
    $stmt->execute([
        $_POST['author'],
        $_POST['content'],
        $_POST['title'],
        $_POST['sid_title'],
    ]);
} catch(PDOException $ex) {
    $output['error'] = $ex->getMessage();
}


if($stmt->rowCount()){
    $output['success'] = true;
} else {
    if(empty($output['error']))
        $output['error'] = '資料沒有新增';

}




echo json_encode($output, JSON_UNESCAPED_UNICODE); 