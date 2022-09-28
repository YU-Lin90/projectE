<?php require __DIR__ . '/API/Connect_DataBase.php'; ?>
<?php require __DIR__ . '/HTMLSetting.php'; ?>
<?php require __DIR__ . '/StyleSetting/CssSetting_YU.php'; ?>
<?php require __DIR__ . '/Admin_Nav.php'; ?>


<h2 class="fs36 txtACenter mb20">管理者頁面</h2>
<p class="mb20"><a href="list.php">會員管理</a></p>
<p class="mb20"><a href="list-forum.php">論壇管理</a></p>
<p class="mb20"><a href="store_list.php">店家管理</a></p>
<p class="mb20"><a href="Admin_Coupon.php">優惠券管理</a></p>
<script>
    fetch("./API/Log/Admin_islogin_api.php").then(r => r.json()).then(res => {
        if (res == 0) {
            alert("請先登入");
            location.href = "./API/Log/Store_logout_api.php";
        }
    })
</script>

<?php require __DIR__ . './Footer.php' ?>