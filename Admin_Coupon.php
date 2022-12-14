<?php require './API/Connect_DataBase.php'; ?>
<?php require __DIR__ . './HTMLSetting.php'; ?>
<?php require __DIR__ . './StyleSetting/CssSetting_YU.php'; ?>
<?php require __DIR__ . '/Admin_Nav.php'; ?>


<h2 class=" fs36 setCenter txtACenter">優惠券管理</h2>
<div class="txtACenter pad10">
    <button id="createCoupon">新增優惠券</button>
</div>

<table class="setCenter" id="couponList_Admin">
    <tr>
        <th>SID</th>
        <th>優惠券名稱</th>
        <th>店家SID</th>
        <th>店家名稱</th>
        <th>折扣金額</th>
        <th>使用條件</th>
        <th>兌換紅利</th>
        <th>取得期限</th>
        <th>使用期限</th>
        <th>上架狀態</th>
        <th>是否已下架</th>
        <th>編輯</th>
        <th>刪除</th>
    </tr>

</table>







<div id="couponCreateForm" class="pad10 borderR1 couponForm">
    <h2 class="txtACenter fs30 mb20">新增優惠券</h2>
    <form name="setCoupon" class="txtACenter" action="">
        <div class="disf aic mb5">
            <label class="w40p" for="coupon_name">優惠券名稱</label><input class="w60p" name="coupon_name" id="coupon_name" type="text">
        </div>
        <div class="disf aic mb5">
            <label class="w40p" for="newCouponShopSid">店家SID</label><input class="w60p" value=101 name="newCouponShopSid" id="newCouponShopSid" min=1 type="number">
        </div>
        <div class="disf aic mb5">
            <label class="w40p" for="cutamount">折扣金額，最低10元</label><input class="w60p" name="cutamount" id="cutamount" value="10" min=10 type="number">
        </div>

        <div class="disf aic mb5">
            <label class="w40p" for="limitCost">最低消費金額</label><input class="w60p" name="limitCost" id="limitCost" value="0" min=0 type="number">
        </div>

        <div class="disf aic mb5">
            <label class="w40p" for="needPoint">兌換所需紅利</label><input class="w60p" name="needPoint" id="needPoint" value="0" min=0 type="number">
        </div>

        <div class="disf aic mb5">
            <label class="w40p" for="getLimit">獲得期限</label><input class="w60p" required name="getLimit" id="getLimit" type="date">
        </div>

        <div class="disf aic mb5">
            <label class="w40p" for="useLimit">使用期限</label><input class="w60p" required name="useLimit" id="useLimit" type="date">
        </div>
        <div class="disf aic mb5">
        </div>
    </form>
    <div class="disf f-jcC">
        <button class=" disb txtACenter setCenter" id="addCoupon">新增</button>
        <button class=" disb txtACenter setCenter" id="cancel_C">取消</button>
    </div>

</div>


<div id="couponEditForm" class="pad10 borderR1 couponForm">
    <h2 class="txtACenter fs30 mb20">優惠券修改</h2>
    <form name="setCoupon_E" class="txtACenter" action="">
        <p class="CouponEditSid mb5" id="sid_E"></p>
        <!-- <input name="sid_E" id="sid_E" type="text"><br> -->

        <div class="disf aic mb5">
            <label class="w40p" for="coupon_name_E">優惠券名稱</label><input class="w60p" name="coupon_name" id="coupon_name_E" type="text">
        </div>

        <div class="disf aic mb5">
            <label class="w40p" for="cutamount_E">折扣金額，最低10元</label><input class="w60p" name="cutamount" id="cutamount_E" value="10" min=10 type="number">
        </div>

        <div class="disf aic mb5">
            <label class="w40p" for="limitCost_E">最低消費金額</label><input class="w60p" name="limitCost" id="limitCost_E" value="0" min=0 type="number">
        </div>

        <div class="disf aic mb5">
            <label class="w40p" for="needPoint_E">兌換所需紅利</label><input class="w60p" name="needPoint" id="needPoint_E" value="0" min=0 type="number">
        </div>

        <div class="disf aic mb5">
            <label class="w40p" for="getLimit_E">獲得期限</label><input class="w60p" required name="getLimit" id="getLimit_E" type="date">
        </div>

        <div class="disf aic mb5">
            <label class="w40p" for="useLimit_E">使用期限</label><input class="w60p" required name="useLimit" id="useLimit_E" type="date">
        </div>

        <div class="disf aic mb5">
            <label class="w40p" for="couponAvail">上架狀態</label><input class="w60p" name="couponAvail" id="couponAvail" type="checkbox">
        </div>

        <div class="disf aic mb5">
            <label class="w40p" for="couponComp">是否已下架</label><input class="w60p" name="couponComp" id="couponComp" type="checkbox">
        </div>


    </form>
    <div class="disf f-jcC">
        <button class=" disb txtACenter setCenter" id="submit_E">確定</button>
        <button class=" disb txtACenter setCenter" id="cancel_E">取消</button>
    </div>
</div>
<div id="grayBack" class="grayBack"></div>

<script src="./API/Log/CheckLoginScript.js"></script>

<script>
    checkLogin(2);

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
    //上架狀態
    let couponAvail = document.querySelector("#couponAvail");
    //是否已下架
    let couponComp = document.querySelector("#couponComp");



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


    //列表TABLE
    let couponList_Admin = document.querySelector("#couponList_Admin");




    //讀出資料  Read
    fetch("./API/Coupon/Admin_CouponRender_api.php").then(r => r.json()).then(res => {
        // console.log(res);

        //優惠券
        let docFrag = document.createDocumentFragment();
        //tr>td
        res.reverse().forEach(value => {
            let {
                sid, //優惠券SID
                coupon_name, //名稱
                shop_sid, //商店SID
                shop_name, //商店名稱
                sale_detail, //折扣金額
                use_range, //使用條件
                need_point, //兌換紅利
                get_limit_time, //取得期限
                expire, //使用期限
                coupon_available, //可見狀態
                coupon_complete //過期
            } = value;

            let getLimit = get_limit_time.substr(0, 10);
            // console.log(getLimit);
            let useLimit = expire.substr(0, 10);
            // console.log(useLimit);

            //tr  
            let couponShowRow = document.createElement("tr");
            //sid
            let td01 = document.createElement("td");
            tdTxt01 = document.createTextNode(sid);
            td01.appendChild(tdTxt01);
            //名稱
            let td02 = document.createElement("td");
            tdTxt02 = document.createTextNode(coupon_name);
            td02.appendChild(tdTxt02);
            //商店SID
            let td03 = document.createElement("td");
            tdTxt03 = document.createTextNode(shop_sid);
            td03.appendChild(tdTxt03);
            //商店名稱
            let tdex = document.createElement("td");
            tdTxtex = document.createTextNode(shop_name);
            tdex.appendChild(tdTxtex);
            //折扣金額
            let td04 = document.createElement("td");
            tdTxt04 = document.createTextNode(sale_detail);
            td04.appendChild(tdTxt04);
            //使用條件
            let td05 = document.createElement("td");
            tdTxt05 = document.createTextNode(use_range);
            td05.appendChild(tdTxt05);
            //兌換紅利
            let td06 = document.createElement("td");
            tdTxt06 = document.createTextNode(need_point);
            td06.appendChild(tdTxt06);
            //取得期限
            let td07 = document.createElement("td");
            tdTxt07 = document.createTextNode(getLimit);
            td07.appendChild(tdTxt07);
            //使用期限
            let td08 = document.createElement("td");
            tdTxt08 = document.createTextNode(useLimit);
            td08.appendChild(tdTxt08);
            //可見狀態
            let td09 = document.createElement("td");
            tdTxt09 = document.createTextNode(coupon_available);
            td09.appendChild(tdTxt09);
            //過期
            let td10 = document.createElement("td");
            tdTxt10 = document.createTextNode(coupon_complete);
            td10.appendChild(tdTxt10);
            //修改
            let td11 = document.createElement("td");
            let editButton = document.createElement("button");
            let editButtonTxt = document.createTextNode("編輯");
            editButton.appendChild(editButtonTxt);
            td11.appendChild(editButton);

            //刪除
            let td12 = document.createElement("td");
            let deleteButton = document.createElement("button");
            let deleteButtonTxt = document.createTextNode("刪除");
            deleteButton.appendChild(deleteButtonTxt);
            td12.appendChild(deleteButton);

            //※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※
            couponShowRow.appendChild(td01);
            couponShowRow.appendChild(td02);
            couponShowRow.appendChild(td03);
            couponShowRow.appendChild(tdex);
            couponShowRow.appendChild(td04);
            couponShowRow.appendChild(td05);
            couponShowRow.appendChild(td06);
            couponShowRow.appendChild(td07);
            couponShowRow.appendChild(td08);
            couponShowRow.appendChild(td09);
            couponShowRow.appendChild(td10);
            couponShowRow.appendChild(td11);
            couponShowRow.appendChild(td12);

            //※※※※※※※※※※※※※※※※
            //修改按鈕
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
                sid_E.innerText = sid;
                if (coupon_available == 1) {
                    couponAvail.checked = true;
                }
                if (coupon_complete == 1) {
                    couponComp.checked = true;
                }


            })
            //※※※※※※※※※※※※※※※※

            //※※※※※※※※※※※※※※※※
            //刪除按鈕
            deleteButton.addEventListener("click", () => {
                let FD = new FormData();
                FD.append('state', 4)
                FD.append('sid', sid)
                if (confirm(`是否確定要刪除${sid}號優惠券?`)) {
                    fetch("./API/Coupon/Admin_CouponEdit_api.php", {
                        method: "POST",
                        body: FD
                    }).then(r => r.json()).then(res => {
                        if (res == 1) {
                            alert("刪除成功");
                            // clearEditForm();
                            location.reload();
                        } else {
                            alert("刪除失敗");
                        }
                    })
                }

            })
            //※※※※※※※※※※※※※※※※

            docFrag.appendChild(couponShowRow);
        })
        couponList_Admin.appendChild(docFrag);

    })
    //※※※※※※※※※※※※※※※※
    //確定修改按鈕
    submit_E.addEventListener("click", () => {
        let sid = sid_E.innerText.trim();
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
            FD.append("sid", sid)
            fetch("./API/Coupon/Admin_CouponEdit_api.php", {
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
    //※※※※※※※※※※※※※※※※

    //※※※※※※※※※※※※※※※※
    //取消修改按鈕
    cancel_E.addEventListener("click", () => {
        clearEditForm();
    })
    //※※※※※※※※※※※※※※※※

    //※※※※※※※※※※※※※※※※
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
        couponAvail.checked = false;
        couponComp.checked = false;
    }
    //※※※※※※※※※※※※※※※※


    let addCouponBTN = document.querySelector("#addCoupon");
    let coupon_name = document.querySelector("#coupon_name");
    let cutamount = document.querySelector("#cutamount");
    let limitCost = document.querySelector("#limitCost");
    let needPoint = document.querySelector("#needPoint");
    let newCouponShopSid = document.querySelector("#newCouponShopSid");


    //※※※※※※※※※※※※※※※※
    //新增優惠券
    let couponCreateForm = document.querySelector("#couponCreateForm");
    //取消按鈕
    let cancel_C = document.querySelector("#cancel_C");
    //新增優惠券按鈕
    createCoupon.addEventListener("click", () => {
        //新增框
        couponCreateForm.style.display = "block";
        //灰背
        grayBack.style.display = "block";
    })
    //取消按鈕
    cancel_C.addEventListener("click", () => {
        //新增框
        couponCreateForm.style.display = "none";
        //灰背
        grayBack.style.display = "none";

        coupon_name.value = "";

        cutamount.value = 10;

        limitCost.value = 0;

        needPoint.value = 0;

        newCouponShopSid.value = 101;

        getLimit.value = dnow;
        useLimit.value = dnow;
    })

    //新增確定按鈕
    addCouponBTN.addEventListener("click", () => {
        let char = coupon_name.value.trim();
        let Gtime = getLimit.value;
        let Utime = useLimit.value;
        if (char == "" || cutamount.value == "" || getLimit.value == "" || useLimit.value == "" || needPoint.value == "" || limitCost.value == "" || newCouponShopSid.value == "") {
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
            fetch("./API/Coupon/Admin_CouponEdit_api.php", {
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
    //※※※※※※※※※※※※※※※※
</script>

<?php require __DIR__ . './Footer.php' ?>