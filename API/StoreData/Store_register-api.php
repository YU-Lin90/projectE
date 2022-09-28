<?php
require  '../Connect_DataBase.php';

header('Content-Type: application/json');

$output = [
    'success' => false,
    'error' => '',
    'code' => 0,
    'postData' => $_POST, // 除錯用的
];

if (empty($_POST['name'])) {
    $output['error'] = '參數不足';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

if (empty($_POST['email'])) {
    $output['error'] = '參數不足';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

if (empty($_POST['phone'])) {
    $output['error'] = '參數不足';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

if (empty($_POST['password'])) {
    $output['error'] = '參數不足';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}


$email = test_input($_POST["email"]);
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $output['error'] = 'email格式錯誤';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

$phone = test_input($_POST["phone"]);

if (!preg_match("/\d{10}/", $phone)) {
    $output['error'] = '電話格式錯誤';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

$password = test_input($_POST["password"]);


if (!preg_match("/\d/", $password)) {
    $output['error'] = '密碼格式錯誤';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

if (!preg_match("/\S/", $password)) {
    $output['error'] = '密碼格式錯誤';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

if (preg_match("/\W/", $password)) {
    $output['error'] = '密碼格式錯誤';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

if (!preg_match("/[A-Z]/", $password)) {
    $output['error'] = '密碼格式錯誤';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

if (!preg_match("/[a-z]/", $password)) {
    $output['error'] = '密碼格式錯誤';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

if (strlen("$password") < 8) {
    $output['error'] = '密碼格式錯誤';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}



// TODO: 檢查欄位資料

//管理者或店家註冊差異
$rest_right;
$plat_right;
if (empty($_SESSION['admin'])) {
    $rest_right = 0;
    $plat_right = 1;
} else {
    $rest_right = $_POST['rest_right'];
    $plat_right = $_POST['plat_right'];
}

//帳號檢查用
// $email = $_POST['email'];
// $t_sql = "SELECT `email` FROM shop WHERE email = $email";
// $totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

// if($totalRows > 0){
//     $output['error'] = '帳號已重複';
//     $output['code'] = 400;
//     echo json_encode($output, JSON_UNESCAPED_UNICODE);
//     exit;
// }

$sql = "INSERT INTO `shop`(
    `name`,`email`,`password`,`address`,`phone`,`food_type_sid`,`bus_start`,`bus_End`,`bus_day`,`rest_right`,`plat_right`,`src`,`pay`,`side`
    )  VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

$stmt = $pdo->prepare($sql);

try {
    $stmt->execute([
        $_POST['name'],
        $_POST['email'],
        $_POST['password'],
        $_POST['address'],
        $_POST['phone'],
        $_POST['food_type_sid'],
        $_POST['bus_start'],
        $_POST['bus_end'],
        $_POST['bus_day'],
        $rest_right,
        $plat_right,
        $_POST['src'],
        $_POST['pay'],
        $_POST['side']
    ]);
} catch (PDOException $ex) {
    $output['error'] = $ex->getMessage();
};



if ($stmt->rowCount()) {
    $output['success'] = true;
} else {
    $output['error'] = '註冊失敗';
}




echo json_encode($output, JSON_UNESCAPED_UNICODE);
