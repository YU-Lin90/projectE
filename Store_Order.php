<?php require './API/Connect_DataBase.php'; ?>
<?php require __DIR__ . './HTMLSetting.php'; ?>
<?php require __DIR__ . './StyleSetting/CssSetting_YU.php'; ?>
<?php require __DIR__ . './Store_Nav.php'; ?>

<h2 class="txtACenter orderTitleh2 mb20">等待時間設定</h2>
<div class="txtACenter orderTitleh2 mb20">
    <input value="20" id="storeWaitBar" min="10" max="80" step="5" type="range">
</div>
<h3 class="mb20" id="storeWaitTxt"></h3>
<h2 class="txtACenter orderTitleh2 mb20">未確認訂單</h2>
<div id="orderUnCheck" class="orderAllFrame mb20">
    <p>無未確認訂單</p>
</div>
<h2 class="txtACenter orderTitleh2 mb20">等待中訂單</h2>
<div id="orderChecked" class="orderAllFrame mb20">
    <p>無等待中訂單</p>
</div>
<h2 class="txtACenter orderTitleh2 mb20">已完成訂單</h2>
<div id="orderComplete" class="orderAllFrame mb20">
    <p>無已完成訂單</p>
</div>
<h2 class="txtACenter orderTitleh2 mb20">已取消訂單</h2>
<div id="orderCanceled" class="orderAllFrame mb20">
    <p>無已取消訂單</p>
</div>

<div id="cancelOrder" class="txtACenter couponForm borderR1 pad10">
    <h2 class="orderTitleh2 mb20">取消訂單</h2>
    <div class="disf aic mb5">
        <label class="w40p" for="cancelReason">取消原因：</label><input class="w60p" id="cancelReason" type="text">
    </div>
    <input type="hidden" id="hiddenSid">
    <input type="hidden" id="hiddenCouponSid">
    <div class="disf f-jcC mb5">
        <button class=" disb txtACenter setCenter" id="submit_cancelOrder">確定</button>
        <button class=" disb txtACenter setCenter" id="cancel_cancelOrder">取消</button>
    </div>
</div>
<div id="grayBack" class="grayBack"></div>

<script>
    fetch("./API/Log/Store_islogin_api.php").then(r => r.json()).then(res => {
        if (res == 0) {
            alert("請先登入");
            location.href = "Store_login.php";
        }
    })
    //未接單
    let unCheckOrderFrame = document.querySelector("#orderUnCheck")
    //已接單未完成
    let checkedOrderFrame = document.querySelector("#orderChecked")
    //已完成訂單
    let completeOrderFrame = document.querySelector("#orderComplete")
    //已取消訂單
    let canceledOrderFrame = document.querySelector("#orderCanceled")
    //取消輸入框
    let cancelOrder = document.querySelector("#cancelOrder");
    //灰背
    let grayBack = document.querySelector("#grayBack");
    //取消訂單確定按鈕
    let submit_cancelOrder = document.querySelector("#submit_cancelOrder");
    //取消訂單取消按鈕
    let cancel_cancelOrder = document.querySelector("#cancel_cancelOrder");
    //取消訂單SID隱藏框
    let hiddenSid = document.querySelector("#hiddenSid");
    //取消訂單優惠券ID
    let hiddenCouponSid = document.querySelector("#hiddenCouponSid");

    submit_cancelOrder.addEventListener("click", () => {

        let outputSid = hiddenSid.value;
        // console.log(outputSid)
        let reason = cancelReason.value;
        // console.log(reason)
        let couponSid = hiddenCouponSid.value;
        if (confirm("是否確定取消訂單?")) {
            let FD = new FormData()
            FD.append("order_sid", outputSid);
            FD.append("confirm", 0);
            FD.append("whoCanceled", 1);
            FD.append("canceledReason", reason);
            FD.append("coupon_sid", couponSid);
            fetch("./API/Order/Store_ConfirmOrder_api.php", {
                method: 'POST',
                body: FD,
            }).then(r => r.json()).then(res => {
                // alert(res)
                alert("取消成功")
                location.reload();
            })
        } else return;
    })

    cancel_cancelOrder.addEventListener("click", () => {

        cancelReason.value = "";
        hiddenSid.value = "";
        //取消輸入框
        cancelOrder.style.display = "none";
        //灰背
        grayBack.style.display = "none";

    })


    loadPage();

    function loadPage(state) {
        fetch("./API/Order/Store_OrderRender_api.php").then(r => r.json()).then(res => {
            // console.log(res);
            //未接單袋
            let docFragForUnCheck = document.createDocumentFragment();
            //已接單未完成袋
            let docFragForChecked = document.createDocumentFragment();
            //已完成袋
            let docFragForCompleted = document.createDocumentFragment();
            //已取消袋
            let docFragForCanceled = document.createDocumentFragment();

            //-1不動  正數互換 0 不動
            //order_time     recept_time    complete_time
            res.reverse().sort((a, b) => {
                let A = new Date(a.recept_time)
                let B = new Date(b.recept_time)

                if (b.recept_time == null) {
                    return 1;
                } else {
                    return B - A;
                }
            })

            res.sort((a, b) => {
                let A = new Date(a.recept_time)
                let B = new Date(b.recept_time)
                let C = new Date(a.complete_time)
                let D = new Date(b.complete_time)

                if (b.complete_time == null) {
                    return B - A;
                } else {
                    return D - C;
                }
            })

            // console.log(b.complete_time)
            // console.log(a.complete_time)
            // let A = new Date(a.complete_time)
            // let B =  new Date(b.complete_time)
            // console.log(A)
            // console.log(B)
            // console.log(A-B)
            // console.log(B-A)


            res.forEach((element, index) => {
                let {
                    SID,
                    complete_time,
                    coupon_sid,
                    memo,
                    order_finish,
                    order_time,
                    order_total,
                    recept_time,
                    review,
                    sale,
                    shop_order_status,
                    name,
                    cartList,
                    member_name,
                    phone,
                    coupon_name,
                    canceled_reason,
                    who_canceled
                } = element;

                //訂單最外框
                let orderframe = document.createElement("div");
                orderframe.classList.add("orderframe");
                //上半
                let orderInfo = document.createElement("div");
                orderInfo.classList.add("orderInfo");

                if (shop_order_status == 0 && order_finish == 0) {
                    orderInfo.style.backgroundColor = "#CC0";
                } else if (shop_order_status == 1 && order_finish == 0) {
                    orderInfo.style.backgroundColor = "#F05";
                } else if (shop_order_status == 1 && order_finish == 1) {
                    orderInfo.style.backgroundColor = "#0C5";
                }


                //下訂時間
                let orderdate = document.createElement("div");
                orderdate.classList.add("orderdate");
                let orderdateh4 = document.createElement("h4");
                let orderdateh4Intxt;
                let orderdatepIntxt;

                if (shop_order_status == 0 && order_finish == 0) {
                    orderdateh4Intxt = document.createTextNode("下訂時間");
                    orderdatepIntxt = document.createTextNode(order_time);
                } else if (shop_order_status == 1 && order_finish == 0) {
                    orderdateh4Intxt = document.createTextNode("接單時間");
                    orderdatepIntxt = document.createTextNode(recept_time);
                } else if (shop_order_status == 1 && order_finish == 1) {
                    orderdateh4Intxt = document.createTextNode("完成時間");
                    orderdatepIntxt = document.createTextNode(complete_time);
                } else if (shop_order_status == 0 && order_finish == 1) {
                    orderdateh4Intxt = document.createTextNode("取消時間");
                    orderdatepIntxt = document.createTextNode(complete_time);
                }
                orderdateh4.appendChild(orderdateh4Intxt);
                let orderdatep = document.createElement("p");
                orderdatep.appendChild(orderdatepIntxt);
                orderdate.appendChild(orderdateh4);
                orderdate.appendChild(orderdatep);
                orderInfo.appendChild(orderdate);

                //合計金額
                let totalPrice = document.createElement("div");
                totalPrice.classList.add("totalPrice");
                let totalPriceh4 = document.createElement("h4");
                let totalPriceh4Intxt = document.createTextNode("合計金額");
                totalPriceh4.appendChild(totalPriceh4Intxt);
                let totalPricep = document.createElement("p");
                let totalPricepIntxt = document.createTextNode(sale);
                totalPricep.appendChild(totalPricepIntxt);
                totalPrice.appendChild(totalPriceh4);
                totalPrice.appendChild(totalPricep);
                orderInfo.appendChild(totalPrice);
                //顧客名
                let shopName = document.createElement("p");
                shopName.classList.add("shopName");
                let shopNameIntxt = document.createTextNode(member_name);
                shopName.appendChild(shopNameIntxt);
                orderInfo.appendChild(shopName);
                //評價   已完成的顯示評價   未完成的顯示經過時間
                let reviewPoint = document.createElement("p");
                let reviewPointIntxt = document.createTextNode(phone);
                reviewPoint.appendChild(reviewPointIntxt);
                orderInfo.appendChild(reviewPoint);
                //訂單詳細
                let kuwasii = document.createElement("p");
                kuwasii.classList.add("orderD");
                let kuwasiiIntxt = document.createTextNode("訂單詳細");
                kuwasii.appendChild(kuwasiiIntxt);
                orderInfo.appendChild(kuwasii); {
                    let status;
                    if (index == 0 && state == 1) {
                        status = 1 ;
                        console.log("i:" + index)
                        console.log("ST:"+status)
                    }else{
                        status = 0;
                    }
                    kuwasii.addEventListener("click", (evt) => {
                        let downSide = evt.target.parentNode.nextSibling;
                        console.log(status)
                        if (status == 0) {
                            downSide.style.display = "flex";
                            status = 1;
                        } else {
                            downSide.style.display = "none";
                            status = 0;
                        }
                    })
                }


                //上半放入大框
                orderframe.appendChild(orderInfo);
                //下半
                let orderdetail = document.createElement("div");
                orderdetail.classList.add("orderdetail");
                //下半左半
                let orderProductFrame = document.createElement("div");
                orderProductFrame.classList.add("orderProductFrame");
                //資料袋
                let docFragForOrderProduct = document.createDocumentFragment();
                //商品詳細資料
                cartList.forEach(element => {
                    let {
                        amount,
                        product_name,
                        src,
                        product_price,
                        product_sid
                    } = element;
                    //商品總框
                    let orderProduct = document.createElement("div");
                    orderProduct.classList.add("orderProduct", "disf");
                    //商品圖框
                    let productImg = document.createElement("div");
                    productImg.classList.add("productImg", "w15p");
                    //商品圖
                    let pic = document.createElement("img");
                    pic.setAttribute("src", `${src}`);
                    productImg.appendChild(pic);
                    orderProduct.appendChild(productImg);
                    //產品名
                    let productName = document.createElement("h3");
                    productName.classList.add("w40p");
                    let productNameIntxt = document.createTextNode(product_name);
                    productName.appendChild(productNameIntxt);
                    orderProduct.appendChild(productName);
                    //單價
                    let orderPPrice = document.createElement("div");
                    orderPPrice.classList.add("orderPPrice", "w15p");
                    //單價內容
                    //標題
                    let orderPPricep1 = document.createElement("p");
                    let orderPPricep1txt = document.createTextNode("價格");
                    orderPPricep1.appendChild(orderPPricep1txt);
                    //內文
                    let orderPPricep2 = document.createElement("p");
                    let orderPPricep2txt = document.createTextNode(product_price);
                    orderPPricep2.appendChild(orderPPricep2txt);
                    orderPPrice.appendChild(orderPPricep1);
                    orderPPrice.appendChild(orderPPricep2);
                    orderProduct.appendChild(orderPPrice);
                    //數量
                    let orderPAmount = document.createElement("div");
                    orderPAmount.classList.add("orderPAmount", "w15p");
                    //數量內容
                    //標題
                    let orderPAmountp1 = document.createElement("p");
                    let orderPAmountp1txt = document.createTextNode("數量");
                    orderPAmountp1.appendChild(orderPAmountp1txt);
                    //內文
                    let orderPAmountp2 = document.createElement("p")
                    let orderPAmountp2txt = document.createTextNode(amount);
                    orderPAmountp2.appendChild(orderPAmountp2txt);
                    orderPAmount.appendChild(orderPAmountp1);
                    orderPAmount.appendChild(orderPAmountp2);
                    orderProduct.appendChild(orderPAmount);
                    //總價
                    let orderPTotalprice = document.createElement("div");
                    orderPTotalprice.classList.add("orderPTotalprice", "w15p");
                    //總價內容
                    //標題
                    let orderPTotalpricep1 = document.createElement("p");
                    let orderPTotalpricep1txt = document.createTextNode("總價");
                    orderPTotalpricep1.appendChild(orderPTotalpricep1txt);
                    //內文
                    let orderPTotalpricep2 = document.createElement("p");
                    let orderPTotalpricep2txt = document.createTextNode(amount * product_price);
                    orderPTotalpricep2.appendChild(orderPTotalpricep2txt);
                    orderPTotalprice.appendChild(orderPTotalpricep1);
                    orderPTotalprice.appendChild(orderPTotalpricep2);
                    orderProduct.appendChild(orderPTotalprice);
                    docFragForOrderProduct.appendChild(orderProduct);
                });
                //商品明細放入
                orderProductFrame.appendChild(docFragForOrderProduct);
                //下左半放入下半
                orderdetail.appendChild(orderProductFrame);
                //右半外框
                let orderProductInfo = document.createElement("div");
                orderProductInfo.classList.add("orderProductInfo");
                //下訂時間
                let infoChild01 = document.createElement("div");
                infoChild01.classList.add("opinfotxt");
                let IC01p1 = document.createElement("p");
                let IC01p1Txt = document.createTextNode("下訂時間");
                IC01p1.appendChild(IC01p1Txt);
                let IC01p2 = document.createElement("p");
                let IC01p2Txt = document.createTextNode(order_time);
                IC01p2.appendChild(IC01p2Txt);
                infoChild01.appendChild(IC01p1);
                infoChild01.appendChild(IC01p2);
                orderProductInfo.appendChild(infoChild01);
                //接單時間
                if (shop_order_status == 1) {
                    let infoChild02 = document.createElement("div");
                    infoChild02.classList.add("opinfotxt");
                    let IC02p1 = document.createElement("p");
                    let IC02p1Txt = document.createTextNode("接單時間");
                    IC02p1.appendChild(IC02p1Txt);
                    let IC02p2 = document.createElement("p");
                    let IC02p2Txt = document.createTextNode(recept_time);
                    IC02p2.appendChild(IC02p2Txt);
                    infoChild02.appendChild(IC02p1);
                    infoChild02.appendChild(IC02p2);
                    orderProductInfo.appendChild(infoChild02);
                }
                //完成時間
                if (order_finish == 1) {
                    let infoChild03 = document.createElement("div");
                    infoChild03.classList.add("opinfotxt");
                    let IC03p1 = document.createElement("p");
                    let IC03p1Tx
                    if (shop_order_status == 0) {
                        IC03p1Txt = document.createTextNode("取消時間");
                    } else if (shop_order_status == 1) {
                        IC03p1Txt = document.createTextNode("完成時間");
                    }
                    IC03p1.appendChild(IC03p1Txt);
                    let IC03p2 = document.createElement("p");
                    let IC03p2Txt = document.createTextNode(complete_time);
                    IC03p2.appendChild(IC03p2Txt);
                    infoChild03.appendChild(IC03p1);
                    infoChild03.appendChild(IC03p2);
                    orderProductInfo.appendChild(infoChild03);
                }
                if (coupon_name != null) {
                    //使用優惠            
                    let infoChild04 = document.createElement("div");
                    infoChild04.classList.add("opinfotxt");
                    let IC04p1 = document.createElement("p");
                    let IC04p1Txt = document.createTextNode("使用優惠");
                    IC04p1.appendChild(IC04p1Txt);
                    let IC04p2 = document.createElement("p");
                    let IC04p2Txt = document.createTextNode(coupon_name);
                    IC04p2.appendChild(IC04p2Txt);
                    infoChild04.appendChild(IC04p1);
                    infoChild04.appendChild(IC04p2);
                    orderProductInfo.appendChild(infoChild04);
                }
                //備註
                let infoChild05 = document.createElement("div");
                infoChild05.classList.add("opinfotxt");
                let IC05p1 = document.createElement("p");
                let IC05p1Txt = document.createTextNode("備註");
                IC05p1.appendChild(IC05p1Txt);
                let IC05p2 = document.createElement("p");
                IC05p2.classList.add("orderPS")
                let IC05p2Txt = document.createTextNode(memo);
                IC05p2.appendChild(IC05p2Txt);
                infoChild05.appendChild(IC05p1);
                infoChild05.appendChild(IC05p2);
                orderProductInfo.appendChild(infoChild05);

                //取消原因、取消者
                if (shop_order_status == 0 && order_finish == 1) {
                    let infoChild06 = document.createElement("div");
                    infoChild06.classList.add("opinfotxt");
                    let IC06p1 = document.createElement("p");
                    let IC06p1Txt = document.createTextNode("取消原因");
                    IC06p1.appendChild(IC06p1Txt);

                    let cancelTxt = "";
                    if (who_canceled == 1) {
                        cancelTxt = "店家方取消";
                    } else if (who_canceled == 0) {
                        cancelTxt = "顧客方取消";
                    }

                    let IC06p3 = document.createElement("p");
                    IC06p3.classList.add("opinfotxt")
                    let IC06p3Txt = document.createTextNode(cancelTxt);
                    IC06p3.appendChild(IC06p3Txt);

                    let IC06p2 = document.createElement("p");
                    IC06p2.classList.add("orderPS")
                    let IC06p2Txt = document.createTextNode(canceled_reason);
                    IC06p2.appendChild(IC06p2Txt);

                    infoChild06.appendChild(IC06p3);
                    infoChild06.appendChild(IC06p1);
                    infoChild06.appendChild(IC06p2);

                    orderProductInfo.appendChild(infoChild06);
                }

                //接單/取消 按鈕(未確認訂單)
                if (shop_order_status == 0 && order_finish == 0) {
                    //接單
                    let orderToConfirm = document.createElement("button");
                    orderToConfirm.classList.add("storeControlOrderBTN");
                    let orderToConfirmTxt = document.createTextNode("接受訂單");
                    orderToConfirm.appendChild(orderToConfirmTxt);
                    orderProductInfo.appendChild(orderToConfirm);

                    orderToConfirm.addEventListener("click", () => {
                        if (confirm("是否確定接受訂單?")) {
                            let FD = new FormData()
                            FD.append("order_sid", SID);
                            FD.append("confirm", 1);
                            fetch("./API/Order/Store_ConfirmOrder_api.php", {
                                method: 'POST',
                                body: FD,
                            }).then(r => r.json()).then(res => {
                                // console.log(res)
                                alert("接單成功")
                                location.reload();
                            })

                        } else {
                            return
                        }
                    })
                    //取消
                    let orderToCancel = document.createElement("button");
                    orderToCancel.classList.add("storeControlOrderBTN");
                    let orderToCancelTxt = document.createTextNode("取消訂單");
                    orderToCancel.appendChild(orderToCancelTxt);
                    orderProductInfo.appendChild(orderToCancel);

                    orderToCancel.addEventListener("click", () => {
                        //取消輸入框
                        cancelOrder.style.display = "block";
                        //灰背
                        grayBack.style.display = "block";

                        hiddenSid.value = SID;

                        hiddenCouponSid.value = coupon_sid;
                    })

                }
                //完成/取消按鈕(等待中訂單)
                else if (shop_order_status == 1 && order_finish == 0) {
                    //完成
                    let orderToConfirm = document.createElement("button");
                    orderToConfirm.classList.add("storeControlOrderBTN");
                    let orderToConfirmTxt = document.createTextNode("完成訂單");
                    orderToConfirm.appendChild(orderToConfirmTxt);
                    orderProductInfo.appendChild(orderToConfirm);

                    orderToConfirm.addEventListener("click", () => {
                        if (confirm("是否確定完成訂單?")) {
                            let FD = new FormData()
                            FD.append("order_sid", SID);
                            FD.append("confirm", 2);
                            fetch("./API/Order/Store_ConfirmOrder_api.php", {
                                method: 'POST',
                                body: FD,
                            }).then().then(res => {
                                alert("訂單完成")
                                location.reload();
                            })

                        } else {
                            return
                        }
                    })
                    //取消
                    let orderToCancel = document.createElement("button");
                    orderToCancel.classList.add("storeControlOrderBTN");
                    let orderToCancelTxt = document.createTextNode("取消訂單");
                    orderToCancel.appendChild(orderToCancelTxt);
                    orderProductInfo.appendChild(orderToCancel);

                    orderToCancel.addEventListener("click", () => {
                        //取消輸入框
                        cancelOrder.style.display = "block";
                        //灰背
                        grayBack.style.display = "block";

                        hiddenSid.value = SID;

                        hiddenCouponSid.value = coupon_sid;

                    })

                }
                //下右半放入下半
                orderdetail.appendChild(orderProductInfo);
                //下半放入大框
                orderframe.appendChild(orderdetail);
                //           shop_order_status	   order_finish
                //             店家接單狀態	         訂單完成狀態
                // 未接單           0                   0
                // unCheckOrderFrame|||||||||||||docFragForUnCheck
                // 已接單未完成      1                  0
                // checkedOrderFrame|||||||||||||docFragForChecked
                // 已完成訂單       1                   1
                // completeOrderFrame|||||||||||||docFragForCompleted
                // 已取消訂單       0                   1
                // canceledOrderFrame|||||||||||||docFragForCanceled
                //      框                              袋


                //大框放入資料袋  篩選
                if (shop_order_status == 0 && order_finish == 0) {
                    docFragForUnCheck.appendChild(orderframe)
                }
                if (shop_order_status == 1 && order_finish == 0) {
                    docFragForChecked.appendChild(orderframe)
                }
                if (shop_order_status == 1 && order_finish == 1) {
                    docFragForCompleted.appendChild(orderframe)
                }
                if (shop_order_status == 0 && order_finish == 1) {
                    docFragForCanceled.appendChild(orderframe)
                }
            });
            //資料袋放入顯示框
            if (docFragForUnCheck.hasChildNodes()) {
                while (unCheckOrderFrame.hasChildNodes()) {
                    unCheckOrderFrame.removeChild(unCheckOrderFrame.lastChild);
                }
                unCheckOrderFrame.appendChild(docFragForUnCheck);
            }

            if (docFragForChecked.hasChildNodes()) {
                while (checkedOrderFrame.hasChildNodes()) {
                    checkedOrderFrame.removeChild(checkedOrderFrame.lastChild);
                }
                checkedOrderFrame.appendChild(docFragForChecked);
            }

            if (docFragForCompleted.hasChildNodes()) {
                while (completeOrderFrame.hasChildNodes()) {
                    completeOrderFrame.removeChild(completeOrderFrame.lastChild);
                }
                completeOrderFrame.appendChild(docFragForCompleted);
            }

            if (docFragForCanceled.hasChildNodes()) {
                while (canceledOrderFrame.hasChildNodes()) {
                    canceledOrderFrame.removeChild(canceledOrderFrame.lastChild);
                }
                canceledOrderFrame.appendChild(docFragForCanceled);
            }
            // 
            if (state == 1) {
                unCheckOrderFrame.childNodes[0].childNodes[1].style.display = "flex";
                // console.log(unCheckOrderFrame.childNodes[0].childNodes)
            }
        })
    }

    //拉條
    let storeWaitBar = document.querySelector("#storeWaitBar");

    let storeWaitTxt = document.querySelector("#storeWaitTxt");

    //開場叫資料
    let FD1st = new FormData();
    FD1st.append("state", 0);
    fetch("./API/Order/Store_SetWaitingTime.php", {
        method: "POST",
        body: FD1st
    }).then(r => r.json()).then(res => {
        // console.log(res.wait_time);
        let timeO = res.wait_time;
        storeWaitBar.value = timeO;
        storeWaitTxt.innerText = timeO;
    })

    //滑動改資料
    storeWaitBar.addEventListener("change", (e) => {

        let changedTime = e.currentTarget.value;

        storeWaitTxt.innerText = changedTime;

        let FDChange = new FormData();
        FDChange.append("state", 1);
        FDChange.append("time", changedTime);
        fetch("./API/Order/Store_SetWaitingTime.php", {
            method: "POST",
            body: FDChange
        })
        // .then(r => r.json()).then(res => {
        //     console.log(res.wait_time);

        // })


    })

    function checkTotalOrder() {
        let FD = new FormData();
        FD.append("state", 0)
        fetch("./API/Shopping/Store_NewOrderCheck_api.php", {
            method: "POST",
            body: FD
        }).then(r => r.json()).then(res => {
            // console.log(res)
        })
    }
    checkTotalOrder();

    function checkNewOrder() {
        let FD = new FormData();
        FD.append("state", 1)
        fetch("./API/Shopping/Store_NewOrderCheck_api.php", {
            method: "POST",
            body: FD
        }).then(r => r.json()).then(res => {
            // console.log(res)
            if (res == 1) {
                loadPage(1);
                // alert("你有新訂單！！");
                // location.reload();
            }
        })
    }

    window.setInterval(checkNewOrder, 1000)
</script>

<?php require __DIR__ . './Footer.php' ?>