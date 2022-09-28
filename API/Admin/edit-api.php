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

$mobile = test_input($_POST["phone"]);

if (strlen("$mobile") > 10) {
    $output['error'] = '手機格式錯誤';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

if (!preg_match("/09\d{2}-?\d{3}-?\d{3}/", $mobile)) {
    $output['error'] = '手機格式錯誤';
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

$sql = "UPDATE `member` SET 
`name`=?,
`password`=?,
`email`=?,
`phone`=?,
`point`=?
WHERE sid=?";

$stmt = $pdo->prepare($sql);


try {
    $stmt->execute([
        $_POST['name'],
        $_POST['password'],
        $_POST['email'],
        $_POST['phone'],
        $_POST['point'],
        $_POST['sid']
    ]);
} catch (PDOException $ex) {
    $output['error'] = $ex->getMessage();
}


if ($stmt->rowCount()) {
    $output['success'] = true;
} else {
    if (empty($output['error']))
        $output['error'] = '資料沒有修改';
}
echo json_encode($output, JSON_UNESCAPED_UNICODE);
