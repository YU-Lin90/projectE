<?php
require '../Connect_DataBase.php';
header('Content-Type:application/json');

$output = [
    'success' => false,
    'error' => '',
    'code' => 0,
];

if (empty($_POST['email']) or empty($_POST['password'])) {
    $output['error'] = '參數不足';
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit; // 結束程式
}

//用帳號找資料
$res = "SELECT * FROM shop WHERE email=?";

$stmt = $pdo->prepare($res);

$stmt->execute(
    [$_POST['email']
]);

$check = $stmt->fetch();

if (empty($check)) {
    $output['error'] = '帳號或密碼錯誤'; // 帳號錯誤
    $output['code'] = 401;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit; // 結束程式
}
$checkAC = $check['email'];
$inAC = $_POST['email'];
$checkPW = $check['password'];
$inPW = $_POST['password'];
// 驗證密碼
// if (password_verify($_POST['password'], $row['password'])) {
//         $output['success'] = true;
//         $_SESSION['admin'] = [
//             'sid' => $row['sid'],
//             'email' => $row['email'],
//         ];
//     } else {
//     $output['error'] = '帳號或密碼錯誤'; // 帳號錯誤
//     $output['code'] = 421;
// }

if($checkPW == $inPW){
    $output['success'] = true;
    if($inAC =='admin@test.com'){
        $_SESSION['admin'] = [
            'email' => $check['email'],
            'nickname' => $check['name'],
            'sid'=>$check['sid'],
        ];
        $_SESSION['store'] = [
            'email' => $check['email'],
            'nickname' => $check['name'],
            'sid'=>$check['sid'],
        ];
        $output['adminCheck'] = true;
    }else{
        $_SESSION['store'] = [
            'email' => $check['email'],
            'nickname' => $check['name'],
            'sid'=>$check['sid'],
        ];
    }
    if(!isset($_SESSION['cartTotal'])){
        $_SESSION['cartTotal'] = 0;
    }
}
else {
    $output['error'] = '帳號或密碼錯誤';
    $output['code'] = 421;
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
