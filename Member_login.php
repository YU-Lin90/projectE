<?php require __DIR__ . './API/Connect_DataBase.php'; ?>
<?php require __DIR__ . './HTMLSetting.php'; ?>
<?php require __DIR__ . './StyleSetting/CssSetting_YU.php'; ?>
<?php require __DIR__ . './Member_Nav.php'; ?>


<form name="form01" onsubmit="checkForm();return false" enctype="multipart/form-data">
    <fieldset>

        <legend>會員登入</legend>

        <div class="st">
            <label for="" class="title">帳號</label>
            <input class="email" type="text" name="email" placeholder="請輸入帳號">
        </div>

        <div class="st">
            <label for="" class="title">密碼</label>
            <input class="password" type="password" name="password" placeholder="請輸入密碼">
        </div>
        <div class="st btn">
            <input type="submit" value="送出">
            <input type="reset" value="重置">
            <button class="btn1">快速登入</button>

        </div>


    </fieldset>
</form>


<script>
    document.querySelector(".btn1").addEventListener("click", () => {
        email = document.querySelector(".email");
        password = document.querySelector(".password");
        <?php
        $acc = "SELECT `email`,`password` FROM member ORDER BY RAND() LIMIT 1";
        $stmt = $pdo->prepare($acc);
        $stmt->execute();
        $check = $stmt->fetch();
        ?>
        var emailValue = "<?php echo $check['email'] ?>";
        var passwordValue = "<?php echo $check['password'] ?>";

        email.value = emailValue;
        password.value = passwordValue;
    })

    async function checkForm() {
        const FD = new FormData(document.form01);
        // console.log(FD);
        //送給誰,物件

        //application/x-www-form-urlencoded
        const res = await fetch('./API/Log/Member_login_api.php', {
            method: 'POST',
            body: FD,
        })
        const obj = await res.json();
        if (obj.success) {
            // location.href = location.href;
            location.href = "index.php";
        } else {
            alert(obj.error);
        }
    }
</script>

<?php require __DIR__. './Footer.php' ?>