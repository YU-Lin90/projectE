<?php
    // SELECT `title`,`content`,`time`,`member`.`name` FROM `chat` JOIN member on `chat`.`author`=`member`.`sid` WHERE `sid_title`=1
    // SELECT * FROM `chat` WHERE `reply_sid` =3
    // SELECT `chat`,`content`,`member`.`name`,`time`,`reply_sid` FROM `chat` JOIN `member` on `chat`.`author`=`member`.`sid` WHERE `reply_sid` =1 ORDER BY `time` DESC;
    $ta_sql = "SELECT `chat`,`content`,`author`,`member`.`name`,`time`,`reply_sid` FROM `chat` JOIN `member` on `chat`.`author`=`member`.`sid` WHERE `reply_sid` ORDER BY `time` DESC";
    $rows2 = [];

    $rows2 = $pdo->query($ta_sql)->fetchAll();
    // echo json_encode($rows2, JSON_UNESCAPED_UNICODE);
    // $na_sql = "SELECT `member`.`name` FROM `chat` JOIN member on `chat`.`author`=`member`.`sid` WHERE `sid_title`=1";  //合併chat跟member表單取出name
    // $a_sql = "SELECT `member`.`name` FROM `chat` JOIN member on `chat`.`author`=`member`.`sid`"; //合併chat跟member表單 
    // $totalname = $pdo->query($a_sql)->fetchAll();

    // $author = json_encode($totalname, JSON_UNESCAPED_UNICODE);
    // $var = 1;
    
    $ta_sql = "SELECT `chat`,`content`,`member`.`name`,`time`,`reply_sid` FROM `chat` JOIN `member` on `chat`.`author`=`member`.`sid` WHERE `reply_sid` ORDER BY `time` DESC";
    $rows2 = [];

    $rows2 = $pdo->query($ta_sql)->fetchAll();

    // echo json_encode($rows2, JSON_UNESCAPED_UNICODE);

?>