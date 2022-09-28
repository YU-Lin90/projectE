<?php require __DIR__ . './API/Connect_DataBase.php'; ?>
<?php require __DIR__ . './HTMLSetting.php'; ?>
<?php require __DIR__ . './StyleSetting/CssSettingBootstrap.php';
//店家註冊(店家、管理者同一頁)
?>

<?php if (empty($_SESSION['admin'])) : ?>
    <?php require __DIR__ . './Store_Nav.php'; ?>
<?php else : ?>
    <?php require __DIR__ . '/Admin_Nav.php'; ?>
<?php endif; ?>




<div class="container">
    <div class="row"></div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">註冊新店家資料</h5>
                <form name="form1" onsubmit="checkForm(); return false;" novalidate>
                    <div class="mb-3">
                        <label for="name" class="form-label">店名</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">帳號(E-mail)</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">密碼</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <input type="checkbox" class="pw_btn">顯示密碼</input>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">地址</label>
                        <textarea class="form-control" name="address" id="address" cols="50" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">電話</label>
                        <input type="text" class="form-control" id="phone" name="phone" pattern="/\d{10}/">
                    </div>
                    <div class="mb-3">
                        <label for="food_type_sid" class="form-label">種類</label>
                        <input type="text" class="form-control" id="food_type_sid" name="food_type_sid">
                    </div>
                    <div class="mb-3">
                        <label for="bus_start" class="form-label">開始營業時間</label>
                        <input type="text" class="form-control" id="bus_start" name="bus_start">
                    </div>
                    <div class="mb-3">
                        <label for="bus_end" class="form-label">結束營業時間</label>
                        <input type="text" class="form-control" id="bus_end" name="bus_end">
                    </div>
                    <div class="mb-3">
                        <label for="bus_day" class="form-label">營業時間(週)</label>
                        <input type="text" class="form-control" id="bus_day" name="bus_day">
                        <!-- <input type="checkbox" class="form-control" id="bus_day" name="bus_day[]"><label>星期一</label>
                        <input type="checkbox" class="form-control" id="bus_day" name="bus_day[]"><label>星期二</label>
                        <input type="checkbox" class="form-control" id="bus_day" name="bus_day[]"><label>星期三</label>
                        <input type="checkbox" class="form-control" id="bus_day" name="bus_day[]"><label>星期四</label>
                        <input type="checkbox" class="form-control" id="bus_day" name="bus_day[]"><label>星期五</label>
                        <input type="checkbox" class="form-control" id="bus_day" name="bus_day[]"><label>星期六</label> -->
                    </div>

                    <?php if (!empty($_SESSION['admin'])) : ?>

                        <div class="mb-3">
                            <label for="rest_right" class="form-label">上架狀態(店家)</label>
                            <input type="text" class="form-control" id="rest_right" name="rest_right">
                        </div>
                        <div class="mb-3">
                            <label for="plat_right" class="form-label">上架狀態(平台)</label>
                            <input type="text" class="form-control" id="plat_right" name="plat_right">
                        </div>
                    <?php endif; ?>


                    <div class="mb-3">
                        <label for="src" class="form-label">圖檔路徑</label>
                        <input type="text" class="form-control" id="src" name="src">
                    </div>
                    <div class="mb-3">
                        <label for="pay" class="form-label">接受付款方式</label>
                        <input type="text" class="form-control" id="pay" name="pay">
                    </div>
                    <div class="mb-3">
                        <label for="side" class="form-label">外帶/外送/內用選擇</label>
                        <input type="text" class="form-control" id="side" name="side">
                    </div>
                    <button type="submit" class="btn btn-primary">送出</button>
                    <button type="reset" class="btn btn-primary">重填</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<script>


    //顯示密碼
    {
        let pw_stat = 0
        let pw_check = document.querySelector(".pw_btn")
        pw_check.addEventListener("click", () => {
            if (pw_stat === 0) {
                document.querySelector("#password").setAttribute("type", "Text")
                pw_stat = 1
            } else if (pw_stat === 1) {
                document.querySelector("#password").removeAttribute("type")
                pw_stat = 0
                document.querySelector("#password").setAttribute("type", "password")
            }
        })
    }

    function checkForm() {
        const fd = new FormData(document.form1);

        for (let k of fd.keys()) {
            console.log(`${k}:${fd.get(k)}`);
        }
        // TODO: 檢查欄位資料

        fetch('./API/StoreData/Store_register-api.php', {
            method: 'POST',
            body: fd
        }).then(r => r.json()).then(obj => {
            console.log(obj);
            if (!obj.success) {
                alert(obj.error);
            } else {
                alert('註冊成功')
                location.href = 'Store_login.php';
            }
        })

    }
</script>
<?php require __DIR__ . './Footer_CDN.php' ?>