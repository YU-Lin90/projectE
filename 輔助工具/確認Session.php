<?php
session_start();
//這個檔案只顯示現有SESSION
//檔頭，格式影響讀取結果
header('Content-Type:application/json');


echo json_encode($_SESSION,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);