<?php require __DIR__ . './API/Connect_DataBase.php'; ?>
<?php require __DIR__ . './HTMLSetting.php'; ?>
<?php require __DIR__ . './StyleSetting/CssSetting_YU.php'; ?>
<?php require __DIR__ . './Member_Nav.php'; ?>



<h2 class="choosePTotal txtACenter"></h2>

<div id="CartChooseFrame" class="w80p setCenter disf fw-w">


</div>


<script>
    //顯示框
    let CartChooseFrame = document.querySelector("#CartChooseFrame");
    //總數顯示框
    let choosePTotal = document.querySelector(".choosePTotal");

    let startFD = new FormData();
    startFD.append("state", 0)

    fetch("./API/Shopping/CartChooseShop_api.php", {
        method: "POST",
        body: startFD
    }).then(r => r.json()).then(res => {
        // console.log(res);

        choosePTotal.innerText = res.cartTotal;

        let docFrag = document.createDocumentFragment();
        res.shopList.forEach(value => {

            let {
                shopTotal, //商店內商品總數
                shop_name, //商店名
                shop_sid //商店SID
            } = value;


            //橫幅
            let cartinfoCol = document.createElement("div");
            cartinfoCol.classList.add("pad10","w25p");
            let cartinfo = document.createElement("div");
            cartinfo.classList.add("orderframe","cursor_pointer","h80","aic","disf","fd-c","f-jcsa");
            cartinfo.style.backgroundColor = "#0C5";

            cartinfo.addEventListener("click", () => {

                let goNextPage = new FormData();
                goNextPage.append("state", 1)
                goNextPage.append("choosed_sid", shop_sid)

                fetch("./API/Shopping/CartChooseShop_api.php", {
                    method: "POST",
                    body: goNextPage
                }).then(r => r.json()).then(res => {
                    if(res==1){
                    location.href = "CartPage.php";}
                })
            })


            //店家SID隱藏框
            let input02 = document.createElement("input")
            input02.setAttribute("value", shop_sid);
            input02.setAttribute("name", "shop_sid");
            input02.style.visibility = "hidden";
            input02.style.display = "none";
            cartinfo.appendChild(input02)

            //商店名稱
            let shopName = document.createElement("p");
            shopName.classList.add("shopName");
            let shopNameIntxt = document.createTextNode(shop_name);
            shopName.appendChild(shopNameIntxt);
            cartinfo.appendChild(shopName);

            //商品總數
            let totalAmount = document.createElement("p");
            totalAmount.classList.add("choosePTotal");
            let totalAmountIntxt = document.createTextNode(shopTotal);
            totalAmount.appendChild(totalAmountIntxt);
            cartinfo.appendChild(totalAmount);
            cartinfoCol.appendChild(cartinfo);

            docFrag.appendChild(cartinfoCol);

        })
        CartChooseFrame.appendChild(docFrag);


    })
</script>

<?php require __DIR__. './Footer.php' ?>