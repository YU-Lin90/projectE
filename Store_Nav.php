<div class="nav nav2">
    <button class="navButton"><a href="Store_index.php">店家首頁</a></button>

    <button id="" class="navButton"><a href="simple-product-admin.php">商品管理</a></button>

    <!-- 用if判斷式改變列表連結 -->
    <?php if (empty($_SESSION['admin']) and empty($_SESSION['store'])) : ?>
        <!-- 沒有admin和store 不顯示 -->
    <?php elseif (empty($_SESSION['admin'])) : ?>
        <!-- 有store但沒有admin -->
        <button class="navButton">
            <a href="store_list.php">店家資料</a>
        </button>
        <!-- 有admin -->
    <?php endif; ?>

    <!-- ---------------我是分隔線---------------- -->



    <!-- ---------------我是分隔線---------------- -->

    <!-- <button ><a href="writetest.php">上傳頁</a></button>

    <button><a href="update.php">修改頁</a></button>

    <button><a href="delete.php">刪除頁</a></button>-->

    <button id="goOrder" class="navButton"><a href="Store_Order.php">訂單</a></button>

    <?php if (empty($_SESSION['admin'])) : ?>
        <button id="coupon" class="navButton"><a href="Store_Coupon.php">優惠券</a></button>
    <?php endif; ?>


    <?php if (empty($_SESSION['store']) and empty($_SESSION['admin'])) : ?>

        <div class="navDiv"><a href="Store_login.php">登入</a></div>


        <div class="navDiv"><a class="nav-link" href="Store_register-form.php">註冊</a></div>

    <?php else : ?>

        <div class="navDiv">
            <a>
                <?php
                if (empty($_SESSION['admin'])) {
                    echo $_SESSION['store']['nickname'];
                } else {
                    echo $_SESSION['admin']['nickname'];
                }
                ?>
            </a>
        </div>


        <div class="navDiv"><a href="./API/Log/Store_logout_api.php">登出</a></div>

    <?php endif; ?>

    <button id="" class="navButton"><a href="index.php">會員頁面</a></button>

    <?php if (empty($_SESSION['admin'])) : ?>
    <?php else : ?>
        <button id="" class="navButton"><a href="Admin_Index.php">管理者頁面</a></button>
    <?php endif; ?>

</div>
<style>
    .navDiv {
        margin: 0;
        padding: 0 2%;
        /* border: 1px red solid; */
        line-height: 20px;
        font-size: 16px;
    }

    .nav {
        display: flex;
        height: 50px;
        width: 100%;
        background-color: #cfc;
        justify-content: end;
        align-items: center;
        padding: 0 5%;
        position: sticky;
        top: 0;
        z-index: 10000000;
        margin-bottom: 30px;
    }

    .navButton {
        letter-spacing: normal;
        word-spacing: normal;
        line-height: 20px;
        text-align: center;
        color: #0d6efd;
        border-width: 2px;
        font-size: 16px;
        padding: 1px 6px;
    }

    .nav2 {
        background-color: #ccf;
    }

    a:visited {
        color: #0d6efd;
    }
</style>