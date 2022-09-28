<?php require __DIR__ . './API/Connect_DataBase.php'; ?>
<?php require __DIR__ . './HTMLSetting.php'; ?>
<?php require __DIR__ . './StyleSetting/CssSettingBootstrap.php'; ?>
<?php require __DIR__ . './Member_Nav.php'; ?>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <div class="card-body">
                    <h5 class="card-title">註冊資料</h5>
                    <form name="form1" onsubmit="checkForm(); return false;" novalidate>
                        <div class="mb-3">
                            <label for="name" class="form-label">name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">password</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <input type="checkbox" class="ck">顯示密碼
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">mobile</label>
                            <input type="text" class="form-control" id="phone" name="phone" pattern="09\d{2}-?\d{3}-?\d{3}">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    let check_password = document.querySelector(".ck");
    let password = document.querySelector("#password"); {
        let pa_stat = 0
        check_password.addEventListener("click", () => {
            if (pa_stat === 0) {
                password.setAttribute("type", "text");
                pa_stat = 1;
            } else if (pa_stat === 1) {
                password.removeAttribute("type", "text");
                pa_stat = 0;
                password.setAttribute("type", "password");
            }
        })
    }




    function checkForm() {
        // document.form1.email.value

        const fd = new FormData(document.form1);

        for (let k of fd.keys()) {
            console.log(`${k}: ${fd.get(k)}`);
        }
        // TODO: 檢查欄位資料

        fetch('./API/MemberData/register-api.php', {
            method: 'POST',
            body: fd
        }).then(r => r.json()).then(obj => {
            console.log(obj);
            if (!obj.success) {
                alert(obj.error);
            } else {
                alert('註冊成功')
                location.href = 'Member_login.php';
            }
        })


    }
</script>
<?php require __DIR__ . './Footer_CDN.php' ?>