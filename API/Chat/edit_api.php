<?php 
// require __DIR__ . '/parts/admin-required.php';
session_start();
require '../Connect_DataBase.php';

header('Content-Type: application/json');

$output = [
    'success' => false,
    'error' => '',
    'code' => 0,
    'postData' => $_POST, // 除錯用的
];

if(empty($_POST['chat'])){
    $output['error'] = '參數不足';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE); 
    exit;
}

// TODO: 檢查欄位資料

$sql = "UPDATE `chat` SET 
`title`=?,
`content`=?,
`chang_time`=NOW()
WHERE `chat`=?";

$stmt = $pdo->prepare($sql);

// $chang_time = null;
// if(strtotime($_POST['chang_time'])!==false){
//     $chang_time  = $_POST['chang_time'];
// }


try {
    $stmt->execute([
        $_POST['title'],
        $_POST['content'],
        $_POST['chat']
    ]);
} catch(PDOException $ex) {
    $output['error'] = $ex->getMessage();
}


if($stmt->rowCount()){
    $output['success'] = true;
} else {
    if(empty($output['error']))
        $output['error'] = '資料沒有修改';
}
echo json_encode($output, JSON_UNESCAPED_UNICODE); 