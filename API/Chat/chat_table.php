<?php require './API/Chat/Buy-api.php' ?>

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
                        <button type="button" class="btn btn-primary <?= $_SESSION['user']['nickname']==$r['name']?'':'disabled'  ?>" data-bs-toggle="modal" data-bs-target="#exampleModal1">
                        編輯
                        </button>
                        
                        <a href="javascript: delete_it(<?= $r['chat'] ?>,1)" class="btn btn-primary <?= $_SESSION['user']['nickname']==$r['name']?'':'disabled'  ?> ">刪除</a>
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <form name="form1" class="row g-3" id="form<?=$r['chat']?>">
                                        <div class="hstack gap-3">
                                            <textarea name="content" class="form-control me-auto" placeholder="留言" rows="1"></textarea>
                                            <button type="button" onclick="checkForm(<?=$r['chat']?>); return false;" class="btn btn-secondary">Enter</button>
                                            <div class="vr"></div>
                                            <button type="reset" class="btn btn-outline-danger">Reset</button>
                                            
                                            <input type="hidden" name="reply_sid" id="reply_sid" value="<?=$r['chat']?>" checked/>
                                            <input type="hidden" name="author" id="author" value="<?= $_SESSION['user']['sid'] ?>" checked/>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php foreach ($rows2 as $ch) : 
                            if($r['chat']==$ch['reply_sid']):
                        ?>
                            <div class="container">
                                <div class="row alert alert-info" role="alert">
                                    <div class="col-7">
                                        <?= htmlentities($ch['content']) ?>
                                    </div>
                                    <div class="col">
                                        <?= $ch['name'] ?>
                                    </div>
                                    <div class="col">
                                        <?= $ch['time'] ?> 
                                    </div>
                                    <div class="col">
                                        <a href="javascript: delete_it(<?= $ch['chat'] ?>,0)" class="btn btn-primary <?= $_SESSION['user']['nickname']==$ch['name']?'':'disabled'  ?> ">刪除</a>
                                    </div>
                                </div>
                            </div>
                            
                        <?php endif;
                            endforeach; 
                        ?>
                    </div>
                </div>
            </div>
        </div>
        
        <?php require './API/Chat/edit.php' ?>
        <script>
            function checkForm(sid){
                // document.form1.email.value
                let FM = document.querySelector(`#form${sid}`);
                const fd = new FormData(FM);

                // for(let k of fd.keys()){
                //     console.log(`${k}: ${fd.get(k)}`);
                // }
                // TODO: 檢查欄位資料

                fetch('./API/Chat/reply-api.php', {
                    method: 'POST',
                    body: fd
                })
                .then(r=>r.json())
                .then(obj=>{
                    console.log(obj);
                    if(! obj.success){
                        alert(obj.error);
                    } else {
                        alert('謝謝留言')
                        // location.href = 'list.php';
                        location.reload();
                    }
                })
            }

            function delete_it(name,torc){
                const test = !torc?'留言':'標題'
                if(confirm(`確定要刪除${test}嗎?`)){
                    location.href = `./API/Chat/chat_delete_api.php?author=${name}`;
                }
            }
        </script>

    <?php endforeach; ?>
    </div>
</div>
