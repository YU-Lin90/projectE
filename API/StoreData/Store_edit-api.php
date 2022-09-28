<?php require '../Connect_DataBase.php'; ?>

<?php

// header('Content-Type: application/json');

$output = [
    'success' => false,
    'error' => '',
    'code' => 0,
    'postData' => $_POST, //除錯用的
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


if (!preg_match("/\d/", $password))
{
    $output['error'] = '密碼格式錯誤';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

if (!preg_match("/\S/", $password))
{
    $output['error'] = '密碼格式錯誤';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

if (preg_match("/\W/", $password))
{
    $output['error'] = '密碼格式錯誤';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

if (!preg_match("/[A-Z]/", $password))
{
    $output['error'] = '密碼格式錯誤';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

if (!preg_match("/[a-z]/", $password))
{
    $output['error'] = '密碼格式錯誤';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

if (strlen("$password")<8)
{
    $output['error'] = '密碼格式錯誤';
    $output['code'] = 400;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}




// TODO: 檢查欄位資料

$sql = "UPDATE `shop` SET 
`name`=?,
`email`=?,
`password`=?,
`address`=?,
`phone`=?,
`food_type_sid`=?,
`bus_start`=?,
`bus_end`=?,
`bus_day`=?,
`rest_right`=?,
`plat_right`=?,
`src`=?,
`pay`=?,
`side`=?,
`wait_time`=? 
WHERE sid=?";
// WHERE前面不能加東西!

$stmt = $pdo->prepare($sql);

// $birthday = null;
// if (strtotime($_POST['birthday']) !== false) {
//     $birthday = $_POST['birthday'];
// }

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
        $_POST['rest_right'],
        $_POST['plat_right'],
        $_POST['src'],
        $_POST['pay'],
        $_POST['side'],
        $_POST['wait_time'],
        $_POST['sid']
    ]);
} catch (PDOException $ex) {
    $output['error'] = $ex->getMessage();
}


if ($stmt->rowCount()) {
    $output['success'] = true;
} else {
    $output['error'] = '資料沒有修改';
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);
