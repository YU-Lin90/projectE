<?php 
    // SELECT `title`,`content`,`time`,`member`.`name` FROM `chat` JOIN member on `chat`.`author`=`member`.`sid` WHERE `sid_title`=1
    // SELECT * FROM `chat` WHERE `reply_sid` =3
    // SELECT `chat`,`content`,`member`.`name`,`time`,`reply_sid` FROM `chat` JOIN `member` on `chat`.`author`=`member`.`sid` WHERE `reply_sid` =1 ORDER BY `time` DESC;
    $ta_sql = "SELECT `chat`,`content`,`member`.`name`,`time`,`reply_sid` FROM `chat` JOIN `member` on `chat`.`author`=`member`.`sid` WHERE `reply_sid` ORDER BY `time` DESC";
    $rows2 = [];

    $rows2 = $pdo->query($ta_sql)->fetchAll();
    // echo json_encode($rows2, JSON_UNESCAPED_UNICODE);
?>
<div class="row">
    <div class="col">
    <?php foreach ($rows as $r) : ?>
        <div class="accordion" id="accordionExample">
            
            <div class="accordion-item">                     
                <h2 class="accordion-header" id="heading<?=$r['chat']?>"> 
                    <!-- 原本的?page=1怎麼被取代 -->               
                    <button class="accordion-button" type="button" data-bs-toggle='collapse' data-bs-target="#collapse<?=$r['chat']?>" aria-expanded="true" aria-controls="collapse<?=$r['chat']?>">
                        <?= htmlentities($r['title']) ?>
                    </button>               
                </h2>               
                <div id="collapse<?=$r['chat']?>" class="accordion-collapse collapse" aria-labelledby="heading<?=$r['chat']?>" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <?= htmlentities($r['content']) ?>
                        <br>
                        <?= $r['name'] ?><?= $r['time'] ?>
                        <br>
                        <a href="javascript: alogin()" class="btn btn-primary">留言</a>
                        <?php foreach ($rows2 as $ch) : 
                            if($r['chat']==$ch['reply_sid']):
                        ?>
                            <div class="alert alert-info" role="alert">
                                <?= htmlentities($ch['content']) ?>
                                <?= $ch['name'] ?>
                                <?= $ch['time'] ?>
                            </div>
                        <?php endif;
                            endforeach; 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
</div>
<script>
    function alogin(){
        if(confirm('要登入才能留言，請問要登入嗎？')){
            location.href = 'Member_login.php';
        }
    }
</script>