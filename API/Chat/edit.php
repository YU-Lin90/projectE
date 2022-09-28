<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form name="form1" id="form1<?=$r['chat']?>" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">修改標題內文</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="chat" value="<?= $r['chat'] ?>">
                <h5 class="card-title">標題文字</h5>
                    <input type="text" name="title" class="form-control me-auto" value="<?= $r['title'] ?>">
                <h5 class="card-title">標題內容</h5>
                    <textarea name="content" class="form-control me-auto"><?=$r['content']?></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                <button type="button" onclick="editForm(<?=$r['chat']?>)" class="btn btn-primary">確認</button>
            </div>
        </form>
    </div>
</div>





<script>
    function editForm(sid){
        // document.form1.email.value

        let FM = document.querySelector(`#form1${sid}`);
        console.log(FM);
        const fd = new FormData(FM);
        // for(let k of fd.keys()){
        //     console.log(`${k}: ${fd.get(k)}`);
        // }
        // TODO: 檢查欄位資料

        fetch('./API/Chat/edit_api.php', {
            method: 'POST',
            body: fd
        }).then(r=>r.json())
        .then(obj=>{
            console.log(obj);
            if(! obj.success){
                alert(obj.error);
            } else {
                alert('修改成功')
                location.href = 'Chat_index.php';
            }
        })


    }
</script>