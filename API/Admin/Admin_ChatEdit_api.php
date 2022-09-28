<?php 

require '../Connect_DataBase.php'; 

$postData = $_POST;

$sql = "UPDATE
`chat`
SET
`chang_time` = NOW(),
`title` = ?,
`content` = ?
WHERE
`chat`=?";

$stmt = $pdo->prepare($sql);


$stmt->execute([
    $postData['title'],
    $postData['content'],
    $postData['sid']
]);



$res = $stmt->rowCount();
if ($res == 1) {
    echo 1;
} else {
    echo 0;
}
exit;
