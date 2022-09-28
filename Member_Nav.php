<div class="nav">

    <div id="cartcount" class="navDiv cartAmount">
        <?php
        if (!isset($_SESSION)) {
            session_start();
        }
        $OP = 0;
        if (isset($_SESSION['cartTotal'])) {
            $OP = $_SESSION['cartTotal'];
        }
        echo $OP;
        ?>
    </div>

    <button class="navButton"><a href="index.php">首頁</a></button>


    <button id="" class="navButton"><a href="Chat_index.php">論壇</a></button>

    <button id="goCart" class="navButton"><a href="">購物車</a></button>

    <button id="goOrder" class="navButton"><a href="Member_Order.php">訂單</a></button>

    <button id="goCoupon" class="navButton"><a href="Member_CouponShow.php">確認優惠券</a></button>

    <button id="goCouponGet" class="navButton"><a href="Member_CouponGet.php">獲得優惠券</a></button>

    <button class="navButton"><a href="Member_PointRecord.php">紅利點數確認</a></button>

    <button class="navButton"><a href="list-user.php">會員修改</a></button>


    <?php if (empty($_SESSION['user'])) : ?>

        <div class="navDiv"><a href="Member_login.php">登入</a></div>


        <div class="navDiv"><a href="register.php">註冊</a></div>

    <?php else : ?>

        <div class="navDiv"><?= $_SESSION['user']['nickname'] ?></a></div>


        <div class="navDiv"><a href="./API/Log/Member_Logout_api.php">登出</a></div>

    <?php endif; ?>


    <button id="" class="navButton"><a href="Store_index.php">店家頁面</a></button>

    <?php if (!empty($_SESSION['admin'])) : ?>
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

    .cartAmount::before {
        content: "購物車：";
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

    a:visited {
        color: #0d6efd;
    }
</style>


<script>
    let cartLink = document.querySelector("#goCart");

    cartLink.addEventListener("click", (evt) => {
        evt.preventDefault();
        fetch("./API/Shopping/Checkcart_api.php").then(r => r.json()).then(res => {
            if (res == 0) {
                alert("購物車為空!!");
                evt.preventDefault();
            } else if (res == 1) {
                location.href = "CartChooseShop.php";
            }
        })

    })
</script>