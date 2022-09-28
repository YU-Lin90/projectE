<?php
//登入API

require '../Connect_DataBase.php';

//檔頭，格式影響讀取結果
//header('Content-Type:application/json');

//-- 搜索 %為任意字
//SELECT *
//FROM `products`
//WHERE `author` LIKE '%陳%' OR `bookname` LIKE 'J';

//$state = $pdo->query("SELECT * FROM product");

// print_r($state->fetchAll());
// print_r($state->fetch());

//echo json_encode($state->fetchAll(),JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);

//SELECT * FROM `shop` WHERE `email` LIKE 'S1email'

$output = [
    'success' => false,
    'error' => '',
    'code' => 0
];

//輸入為空
if (empty($_POST['email']) || empty($_POST['password'])) {

    $output['error'] = '參數不足';

    echo json_encode($output, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}


$res = "SELECT `sid`, `name`, `email`, `password` FROM `member` WHERE `email` LIKE ? ";

$stmt = $pdo->prepare($res);

$stmt->execute([
    $_POST['email']
]);

// $check =  json_encode($stmt->fetch(),JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
$check = $stmt->fetch();
// echo json_encode($check, JSON_UNESCAPED_UNICODE);
//無法比對的結果
if (empty($check)){
    $output['error'] = '帳號或密碼錯誤'; //帳號錯誤
    $output['code'] = 401;
    echo json_encode($output, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

$checkPw = $check['password'];
$inPw = $_POST['password'];
//檢查密碼
//格式要正確  等號會不同
if($checkPw == $inPw){
    $output['success'] = true;
    $_SESSION['user'] = [
        'email' => $check['email'],
        'nickname' => $check['name'],
        'sid'=>$check['sid'],
    ];
    if(!isset($_SESSION['cartTotal'])){
        $_SESSION['cartTotal'] = 0;
    }

}
else {
    $output['error'] = '帳號或密碼錯誤';
    $output['code'] = 421;
}

echo json_encode($output, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
