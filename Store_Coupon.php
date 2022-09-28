<?php require './API/Connect_DataBase.php'; ?>
<?php require __DIR__ . './HTMLSetting.php'; ?>
<?php require __DIR__ . './StyleSetting/CssSetting_YU.php'; ?>
<?php require __DIR__ . './Store_Nav.php'; ?>


<h2 class="txtACenter fs30 mb20">上架中優惠券</h2>
<div id="couponContent" class="disf fw-w f-jcC mb20">
    無上架中優惠券
    <!-- <div class="w300 pad10 borderR1">
        <div class="disf">
            <p class="w50p txtACenter">折扣50元</p>
            <p class="w50p txtACenter">領取期限</p>
        </div>
        <h3 class="fs36 txtACenter">50</h3>
        <div class="disf">
            <p class="w50p txtACenter">使用期限</p>
            <p class="w50p txtACenter">店名</p>
        </div>
        <input type="hidden" value="sid">
    </div> -->
</div>

<h2 class="txtACenter fs30 mb20">未上架優惠券</h2>
<div id="couponUnShowContent" class="disf fw-w f-jcC mb20">
    無未上架優惠券
</div>


<h2 class="txtACenter fs30 mb20">已結束或下架優惠券</h2>
<div id="couponCompleteContent" class="disf fw-w f-jcC mb20">
    無已結束或下架優惠券
</div>


<div class="txtACenter pad10">
    <button id="createCoupon">新增優惠券</button>
</div>


<div class="disf aic mb5">

</div>


<div id="couponCreateForm" class="pad10 borderR1 couponForm">
    <h2 class="txtACenter fs30 mb20">新增優惠券</h2>
    <form name="setCoupon" class="txtACenter" action="">

        <div class="disf aic mb5">
            <label class="w40p" for="">優惠券名稱</label><input class="w60p" name="coupon_name" id="coupon_name" type="text">
        </div>

        <div class="disf aic mb5">
            <label class="w40p" for="">折扣金額，最低10元</label><input class="w60p" name="cutamount" id="cutamount" value="10" min=10 type="number">
        </div>

        <div class="disf aic mb5">
            <label class="w40p" for="">最低消費金額</label><input class="w60p" name="limitCost" id="limitCost" value="0" min=0 type="number">
        </div>

        <div class="disf aic mb5">
            <label class="w40p" for="">獲得期限</label><input class="w60p" required name="getLimit" id="getLimit" type="date">
        </div>

        <div class="disf aic mb5">
            <label class="w40p" for="">使用期限</label><input class="w60p" required name="useLimit" id="useLimit" type="date">
        </div>

        <input name="needPoint" id="needPoint" value="0" min=0 type="hidden">
    </form>
    <div class="disf f-jcC">
        <button class=" disb txtACenter setCenter" id="addCoupon">新增</button>
        <button class=" disb txtACenter setCenter" id="cancel_C">取消</button>
    </div>

</div>
<div class="disf aic mb5">

</div>

<div id="couponEditForm" class="pad10 borderR1 couponForm">
    <h2 class="txtACenter fs30 mb20">優惠券修改</h2>
    <form name="setCoupon_E" class="txtACenter" action="">

        <div class="disf aic mb5">
            <label class="w40p" for="">優惠券名稱</label><input class="w60p" name="coupon_name" id="coupon_name_E" type="text">
        </div>

        <div class="disf aic mb5">
            <label class="w40p" for="">折扣金額，最低10元</label><input class="w60p" name="cutamount" id="cutamount_E" value="10" min=10 type="number">
        </div>

        <div class="disf aic mb5">
            <label class="w40p" for="">最低消費金額</label><input class="w60p" name="limitCost" id="limitCost_E" value="0" min=0 type="number">
        </div>

        <div class="disf aic mb5">
            <label class="w40p" for="">獲得期限</label><input class="w60p" required name="getLimit" id="getLimit_E" type="date">
        </div>

        <div class="disf aic mb5">
            <label class="w40p" for="">使用期限</label><input class="w60p" required name="useLimit" id="useLimit_E" type="date">
        </div>
        <input hidden name="needPoint" id="needPoint_E" value="0" min=0 type="number">
        <input class="w40p" type="hidden" name="sid_E" id="sid_E">
    </form>
    <div class="disf f-jcC">
        <button class=" disb txtACenter setCenter" id="submit_E">確定</button>
        <button class=" disb txtACenter setCenter" id="cancel_E">取消</button>
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


    //修改框
    let couponEditForm = document.querySelector("#couponEditForm");
    //灰背
    let grayBack = document.querySelector("#grayBack");
    //優惠券名稱
    let coupon_name_E = document.querySelector("#coupon_name_E");
    //折扣金額
    let cutamount_E = document.querySelector("#cutamount_E");
    //最低消費金額
    let limitCost_E = document.querySelector("#limitCost_E");
    //兌換所需紅利
    let needPoint_E = document.querySelector("#needPoint_E");
    //獲得期限
    let getLimit_E = document.querySelector("#getLimit_E");
    //使用期限
    let useLimit_E = document.querySelector("#useLimit_E");
    //SID
    let sid_E = document.querySelector("#sid_E");
    //確定
    let submit_E = document.querySelector("#submit_E");
    //取消
    let cancel_E = document.querySelector("#cancel_E");

    //設定時間最小值
    let getLimit = document.querySelector("#getLimit");
    let useLimit = document.querySelector("#useLimit");

    let YY = new Date().getFullYear();
    let MO = new Date().getMonth() + 1;
    let DO = new Date().getDate();
    let MM, DD;
    if (MO < 10) {
        MM = '0' + MO;
    } else {
        MM = MO;
    }
    if (DO < 10) {
        DD = '0' + DO;
    } else {
        DD = DO;
    }
    let dnow = `${YY}-${MM}-${DD}`;
    // console.log(dnow)
    getLimit.setAttribute("min", dnow);
    useLimit.setAttribute("min", dnow);
    getLimit_E.setAttribute("min", dnow);
    useLimit_E.setAttribute("min", dnow);
    getLimit.value = dnow;
    useLimit.value = dnow;
    //優惠券顯示框
    let couponContent = document.querySelector("#couponContent");
    //未上架顯示框
    let couponUnShowContent = document.querySelector("#couponUnShowContent");
    //已下架顯示框
    let couponCompleteContent = document.querySelector("#couponCompleteContent");

    let couponCreateForm = document.querySelector("#couponCreateForm");

    let cancel_C = document.querySelector("#cancel_C");




    //新增視窗
    createCoupon.addEventListener("click", () => {

        //新增框
        couponCreateForm.style.display = "block";
        //灰背
        grayBack.style.display = "block";
    })
    cancel_C.addEventListener("click", () => {
        //新增框
        couponCreateForm.style.display = "none";
        //灰背
        grayBack.style.display = "none";
    })



    //讀出資料  Read
    fetch("./API/Coupon/Store_CouponRender_api.php").then(r => r.json()).then(res => {
        // console.log(res);

        //優惠券
        let docFragContent = document.createDocumentFragment();
        //未上架
        let docFragUnShow = document.createDocumentFragment();
        //已下架
        let docFragComplete = document.createDocumentFragment();
        res.reverse().forEach(value => {
            let {
                coupon_available, //可見狀態
                coupon_name, //名稱
                expire, //使用期限
                get_limit_time, //取得期限
                need_point, //兌換紅利
                sale_detail, //折扣金額
                shop_sid, //商店SID
                sid, //優惠券SID
                use_range, //使用條件
                coupon_complete //過期
            } = value;

            let getLimit = get_limit_time.substr(0, 10);
            // console.log(getLimit);
            let useLimit = expire.substr(0, 10);
            // console.log(useLimit);

            let today = new Date(dnow);
            let getL = new Date(get_limit_time);

            // console.log(today);
            // console.log(getL);
            //過期判定
            let expiredStatus = false;
            if (getL - today < 0) {
                expiredStatus = true;
            }


            let avail, btnTxt;
            if (coupon_available == 0) {
                avail = "未上架";
                btnTxt = "上架";
            } else if (coupon_available == 1) {
                avail = "上架中";
                btnTxt = "下架";
            }
            // else if



            //優惠券外框  couponTicket
            let couponTicket = document.createElement("div");

            let iro = "";
            if (sale_detail < 50) {
                iro = "coupon10";
            }
            // sale_detail
            else if (sale_detail >= 50 && sale_detail < 100) {
                iro = "coupon50";
            } else if (sale_detail >= 100 && sale_detail < 200) {
                iro = "coupon100";
            } else if (sale_detail >= 200 && sale_detail < 500) {
                iro = "coupon200";
            } else if (sale_detail >= 500 && sale_detail < 1000) {
                iro = "coupon500";
            } else if (sale_detail >= 1000 && sale_detail < 2000) {
                iro = "coupon1000";
            } else if (sale_detail >= 2000) {
                iro = "coupon2000";
            }

            couponTicket.classList.add( "pad10", "borderR1", iro);

            //上半   couponTop
            let couponTop = document.createElement("div");
            couponTop.classList.add("disf");

            //名稱   couponName
            let couponName = document.createElement("p");
            couponName.classList.add("w50p", "txtACenter");
            couponNameTxt = document.createTextNode(coupon_name);
            couponName.appendChild(couponNameTxt);
            couponTop.appendChild(couponName);
            //領取期限  couponLimitTime
            let couponLimitTime = document.createElement("p");
            couponLimitTime.classList.add("w50p", "txtACenter");
            couponLimitTimeTxt = document.createTextNode(`領取期限:${getLimit}`);
            couponLimitTime.appendChild(couponLimitTimeTxt);
            couponTop.appendChild(couponLimitTime);

            couponTicket.appendChild(couponTop);
            //折扣金額   
            let couponPrice = document.createElement("h3");
            couponPrice.classList.add("fs36", "txtACenter");
            let couponPriceTxt = document.createTextNode(sale_detail);
            couponPrice.appendChild(couponPriceTxt);
            couponTicket.appendChild(couponPrice);
            //下半   couponBot
            let couponBot = document.createElement("div");
            couponBot.classList.add("disf");

            //使用期限  useLimitTime
            let useLimitTime = document.createElement("p");
            useLimitTime.classList.add("w50p", "txtACenter");
            useLimitTimeTxt = document.createTextNode(`使用期限:${useLimit}`);

            useLimitTime.appendChild(useLimitTimeTxt);
            couponBot.appendChild(useLimitTime);

            //按鈕.狀態 框
            let availStatus = document.createElement("p");
            availStatus.classList.add("w50p", "txtACenter");
            //狀態
            // let availStatusTxt = document.createTextNode(avail);
            // availStatus.appendChild(availStatusTxt);
            //隱藏SID
            let hiddenSid = document.createElement("input");
            hiddenSid.setAttribute("value", sid);
            hiddenSid.setAttribute("name", "sid");
            hiddenSid.style.visibility = "hidden";
            hiddenSid.style.display = "none";
            availStatus.appendChild(hiddenSid);
            //上下架按鈕
            let setButton = document.createElement("button");
            let setButtonTxt = document.createTextNode(btnTxt);
            setButton.appendChild(setButtonTxt);
            availStatus.appendChild(setButton);
            if (shop_sid != 101 && coupon_available == 1) {
                setButton.setAttribute("hidden", true);
            }
            if (expiredStatus && shop_sid != 101) {
                setButton.setAttribute("hidden", true);
            }

            setButton.addEventListener("click", (evt) => {
                if (confirm(`是否確定${btnTxt}?`)) {
                    let cSid = evt.target.previousSibling.value;
                    let status;
                    if (coupon_available == 0) {
                        status = 1
                    } else if (coupon_available == 1) {
                        status = 2
                    }
                    let FD = new FormData();
                    FD.append("sid", cSid);
                    FD.append("state", status);

                    fetch("./API/Coupon/Store_CouponEdit_api.php", {
                        method: "POST",
                        body: FD
                    }).then(r => r.json()).then(res => {
                        // console.log(res)
                        if (res == 1) {
                            alert(`${btnTxt}成功`);
                            location.reload();
                        } else {
                            alert(`${btnTxt}失敗`);
                        }
                    })
                }
            })
            if (coupon_available == 0) {
                //修改按鈕
                let editButton = document.createElement("button");
                let editButtonTxt = document.createTextNode("修改");
                editButton.appendChild(editButtonTxt);
                availStatus.appendChild(editButton);

                if (expiredStatus && shop_sid != 101) {
                    editButton.setAttribute("hidden", true);
                }

                editButton.addEventListener("click", (e) => {
                    // console.log(e.target)

                    //修改框
                    couponEditForm.style.display = "block";
                    //灰背
                    grayBack.style.display = "block";
                    //優惠券名稱
                    coupon_name_E.value = coupon_name;
                    //折扣金額
                    cutamount_E.value = sale_detail;
                    //最低消費金額
                    limitCost_E.value = use_range;
                    //兌換所需紅利
                    needPoint_E.value = need_point;
                    //獲得期限
                    getLimit_E.value = getLimit;
                    //使用期限
                    useLimit_E.value = useLimit;
                    //SID
                    sid_E.value = sid;
                    // if (shop_sid == 101) {
                    //     getLimit_E.disabled = false;
                    //     useLimit_E.disabled = false;
                    // }
                })
            }
            //放入框架
            couponBot.appendChild(availStatus);
            couponTicket.appendChild(couponBot);


            let framePad = document.createElement("div");
            framePad.classList.add("w25p", "pad10");
            framePad.appendChild(couponTicket);

            if (coupon_available == 0 && coupon_complete == 0 && !expiredStatus) {
                docFragUnShow.appendChild(framePad);
                while (couponUnShowContent.hasChildNodes()) {
                    couponUnShowContent.removeChild(couponUnShowContent.lastChild);
                }
            } else if (coupon_available == 1 && !expiredStatus) {
                docFragContent.appendChild(framePad);
                while (couponContent.hasChildNodes()) {
                    couponContent.removeChild(couponContent.lastChild);
                }
            } else if (expiredStatus || coupon_complete == 1) {
                docFragComplete.appendChild(framePad);
                while (couponCompleteContent.hasChildNodes()) {
                    couponCompleteContent.removeChild(couponCompleteContent.lastChild);
                }
            }

        })
        couponContent.appendChild(docFragContent);
        couponUnShowContent.appendChild(docFragUnShow);
        couponCompleteContent.appendChild(docFragComplete);
    })

    //確定修改按鈕
    submit_E.addEventListener("click", () => {
        let char = coupon_name_E.value.trim();
        let Gtime = getLimit_E.value;
        let Utime = useLimit_E.value;
        if (char == "" || cutamount_E.value == "" || getLimit_E.value == "" || useLimit_E.value == "" || needPoint_E.value == "" || limitCost_E.value == "") {
            alert("數值不得為空或數值有誤，請重新修改");
        } else if (cutamount_E.value < 10 && cutamount_E.value >= 0) {
            alert("折扣金額不得低於10元，請重新修改");
        } else if (cutamount_E.value < 0 || needPoint_E.value < 0 || limitCost_E < 0) {
            alert("金額不得為負數，請重新修改");
        } else if (Gtime > Utime) {
            alert("時間設定有誤，請重新填寫");
        } else if (confirm("是否確定修改?")) {
            let FD = new FormData(setCoupon_E);
            FD.append("state", 3);
            FD.append("Cname", char);
            fetch("./API/Coupon/Store_CouponEdit_api.php", {
                method: "POST",
                body: FD
            }).then(r => r.json()).then(res => {
                // console.log(res)
                if (res == 1) {
                    alert("修改成功");
                    // clearEditForm();
                    location.reload();
                } else {
                    alert("修改失敗");
                }
            })
        }
    })

    //取消修改按鈕
    cancel_E.addEventListener("click", () => {
        clearEditForm();
    })
    //修改框重置
    function clearEditForm() {
        //修改框
        couponEditForm.style.display = "none";
        //灰背
        grayBack.style.display = "none";
        //優惠券名稱
        coupon_name_E.value = "";
        //折扣金額
        cutamount_E.value = "";
        //最低消費金額
        limitCost_E.value = "";
        //兌換所需紅利
        needPoint_E.value = "";
        //獲得期限
        getLimit_E.value = "";
        //使用期限
        useLimit_E.value = "";
        //SID
        sid_E.value = "";
    }

    let addCouponBTN = document.querySelector("#addCoupon");
    let coupon_name = document.querySelector("#coupon_name");
    let cutamount = document.querySelector("#cutamount");
    let limitCost = document.querySelector("#limitCost");
    let needPoint = document.querySelector("#needPoint");

    //寫入資料 Create
    addCouponBTN.addEventListener("click", () => {
        let char = coupon_name.value.trim();
        let Gtime = getLimit.value;
        let Utime = useLimit.value;

        if (char == "" || cutamount.value == "" || getLimit.value == "" || useLimit.value == "" || needPoint.value == "" || limitCost.value == "") {
            alert("數值不得為空或數值有誤，請重新修改");
        } else if (cutamount.value < 10 && cutamount.value >= 0) {
            alert("折扣金額不得低於10元，請重新修改");
        } else if (cutamount.value < 0 || needPoint.value < 0 || limitCost < 0) {
            alert("金額不得為負數，請重新修改");
        } else if (Gtime > Utime) {
            alert("使用時間設定有誤，請重新填寫");
        } else if (confirm("是否確定新增?")) {
            //傳送資料
            let FM = document.forms.setCoupon;
            let FD = new FormData(FM);
            FD.append("state", 0); //寫為0
            fetch("./API/Coupon/Store_CouponEdit_api.php", {
                method: "POST",
                body: FD
            }).then(r => r.json()).then(res => {
                // console.log(res)
                if (res == 1) {
                    alert("新增成功");
                    location.reload();
                } else {
                    alert("新增失敗");
                }
            })
        }
    })
</script>

<?php require __DIR__ . './Footer.php' ?>