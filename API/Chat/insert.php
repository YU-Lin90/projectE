<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form name="formc" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">新增標題內文</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="author" value="<?= $_SESSION['user']['sid'] ?>">
                <input type="hidden" name="sid_title" value="1">

                <h5 class="card-title">標題文字</h5>
                <input type="text" name="title" class="form-control me-auto">
                <h5 class="card-title">標題內容</h5>
                <textarea name="content" class="form-control me-auto"></textarea>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" onclick="insertForm()">發表</button>
            </div>
        </form>
    </div>
</div>

<script>
    function insertForm() {
        // document.form1.email.value

        fetch("./API/Log/Member_islogin_api.php").then(r => r.json()).then(res => {
            if (res == 0) {
                alert("請先登入");
                location.href = "Member_login.php";
            } else {
                const fd = new FormData(document.formc);

                for (let k of fd.keys()) {
                    console.log(`${k}: ${fd.get(k)}`);
                }
                // TODO: 檢查欄位資料

                fetch('./API/Chat/insert_api.php', {
                    method: 'POST',
                    body: fd
                }).then(r => r.json()).then(obj => {
                    console.log(obj);
                    if (!obj.success) {
                        alert(obj.error);
                    } else {
                        alert('新增成功')
                        location.reload();
                        // location.href = 'list.php';
                    }
                })

            }
        })

    }
</script>