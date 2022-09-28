<?php require  './API/Connect_DataBase.php'; ?>
<?php require __DIR__ . './HTMLSetting.php'; ?>
<?php require __DIR__ . './StyleSetting/CssSetting_YU.php'; ?>
<?php require __DIR__ . './Store_Nav.php'; ?>


<form name="form01" onsubmit="checkForm();return false" enctype="multipart/form-data">
    <fieldset>

        <legend>店家登入</legend>

        <div class="st">
            <label for="" class="title">帳號</label>
            <input type="text" id="email" name="email" placeholder="請輸入帳號" >
        </div>

        <div class="st">
            <label for="" class="title">密碼</label>
            <input type="password" id="password" name="password" placeholder="請輸入密碼" >
        </div>
        <div class="st btn">
            <input type="submit" value="登入">
            <input type="reset" value="重填">
            <input class="quickA" type="button" value="管理者帳密">
            <input class="quickS" type="button" value="店家帳密">
        </div>


    </fieldset>
</form>

<script>
    async function checkForm() {
        const FD = new FormData(document.form01);
        // console.log(FD);
        //送給誰,物件

        //application/x-www-form-urlencoded
        const res = await fetch('./API/Log/Store_login_api.php', {
            method: 'POST',
            body: FD,
        })
        const obj = await res.json();
        if (obj.success&&!obj.adminCheck) {
            // location.href = location.href;
            location.href = "Store_index.php";
        }
        else if (obj.success&&obj.adminCheck){
            location.href = "Admin_Index.php";
        }
        else {
            alert(obj.error);
        }
    }


    //管理者帳密快速輸入
    document.querySelector('.quickA').addEventListener('click', () => {
        document.getElementById("email").value = "admin@test.com";
        document.getElementById("password").value = "test"
    });

    //使用者帳密快速輸入
    document.querySelector('.quickS').addEventListener('click', (event) => {

        <?php
        $acc = "SELECT `email`,`password` FROM `shop` WHERE `sid`!=101 ORDER BY RAND() LIMIT 1";
        $stmt = $pdo->prepare($acc);
        $stmt->execute();
        $check = $stmt->fetch();
        ?>

        let email = "<?php echo $check['email'] ?>";
        let password = "<?php echo $check['password'] ?>";

        document.getElementById("email").value = email;
        document.getElementById("password").value = password

        // $.ajax({
        //     type: 'POST',
        //     url: 'Store_login.php',
        //     data: {},
        //     success: function(data) {
        //         var a = data.split(' ');
        //         document.getElementById("email").value = JSON.parse(a[0]).email;
        //         document.getElementById("password").value = JSON.parse(a[0]).password;
        //     }
        // })
    })
</script>

</body>

</html>