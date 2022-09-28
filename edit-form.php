
<?php require __DIR__ . './API/Connect_DataBase.php';

//管理者修改會員資料頁面

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {
    header('Location: list.php');
    exit;
}

$sql = "SELECT * FROM member WHERE sid=$sid";
$r = $pdo->query($sql)->fetch();
if (empty($r)) {
    header('Location: list.php');
    exit;
}
?>
<?php require __DIR__ . './HTMLSetting.php'; ?>
<?php require __DIR__ . './StyleSetting/CssSettingBootstrap.php'; ?>
<?php require __DIR__ . '/Admin_Nav.php'; ?>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <div class="card-body">
                    <h5 class="card-title">修改資料</h5>
                    <form name="form1" onsubmit="checkForm(); return false;" novalidate>
                        <input type="hidden" name="sid" value="<?= $r['sid'] ?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">name</label>
                            <input type="text" class="form-control" id="name" name="name" required value="<?= htmlentities($r['name']) ?>">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">password</label>
                            <input type="text" class="form-control" id="password" name="password" value="<?= $r['password'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">email</label>
                            <input type="text" class="form-control" id="email" name="email" value="<?= $r['email'] ?>" pattern="09\d{2}-?\d{3}-?\d{3}">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?= $r['phone'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="point" class="form-label">紅利</label>
                            <input type="text" class="form-control" id="point" name="point" value="<?= $r['point'] ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    function checkForm() {
        // document.form1.email.value

        const fd = new FormData(document.form1);

        for (let k of fd.keys()) {
            console.log(`${k}: ${fd.get(k)}`);
        }
        // TODO: 檢查欄位資料

        fetch('./API/Admin/edit-api.php', {
            method: 'POST',
            body: fd
        }).then(r => r.json()).then(obj => {
            console.log(obj);
            if (!obj.success) {
                alert(obj.error);
            } else {
                alert('修改成功')
                location.href = 'list.php';
            }
        })
    }
</script>
<?php require __DIR__. './Footer_CDN.php' ?>