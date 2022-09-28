<?php if (!isset($_SESSION)) {
    session_start();
}  ?>

<div class="sbar">
    <input value="<?php if(isset($_SESSION['store'])){echo $_SESSION['store']['sid'];}?>"id="IPSEARCH" class="searchbar" type="hidden">
</div>
<div class="sbar">
    <label for="">升序</label><input value="up" id="SORTUP" name="sort" type="radio" checked>
    <label for="">降序</label><input value="down" id="SORTDOWN" name="sort" type="radio">
    <button id="mae" disabled>上一頁</button>
    <button id="usiro">下一頁</button>
</div>

<div id="cardFrame">
</div>
<div id="btnFR">
</div>

<script>
    fetch("Member_SerchbodyRender_api.php", )
        .then(r => r.json())
        .then(ar => {
            // console.log(ar);
            S8MEALS = JSON.parse(JSON.stringify(ar))
            // console.log(S8MEALS)

            let pagenow = 1;
            let pageall;
            let cutAmount = 12;
            //頁數按鈕
            const FR = document.querySelector("#btnFR")

            //上下頁按鍵
            const MAE = document.querySelector("#mae");
            const USIRO = document.querySelector("#usiro");

            //輸入框
            const searchInput = document.querySelector("#IPSEARCH");

            //顯示框
            const showBox = document.querySelector("#cardFrame");

            //排序鍵
            const SUP = document.querySelector("#SORTUP");
            const SDOWN = document.querySelector("#SORTDOWN");



            let sorted = 0
            let SCHCONA = searchInput.value;

            if (SCHCONA != "") {
                Output(showBox, clipArr(arrforsort(FILT(S8MEALS, SCHCONA), sorted), cutAmount, pagenow));
            } else {
                Output(showBox, clipArr(arrforsort(S8MEALS, 0), cutAmount, pagenow));
            }



            SUP.addEventListener("click", () => {
                let SCHCON = searchInput.value;
                let sorted = 1
                if (SUP.checked) {
                    sorted = 0;
                }
                Output(showBox, clipArr(arrforsort(FILT(S8MEALS, SCHCON), sorted), cutAmount, pagenow));
            })
            SDOWN.addEventListener("click", () => {
                let SCHCON = searchInput.value;
                let sorted = 1
                if (SUP.checked) {
                    sorted = 0;
                }
                Output(showBox, clipArr(arrforsort(FILT(S8MEALS, SCHCON), sorted), cutAmount, pagenow));
            })

            USIRO.addEventListener("click", () => {
                if (pagenow == 1) {
                    MAE.disabled = false;
                }
                if (pagenow == pageall - 1) {
                    USIRO.disabled = true;
                }
                pagenow++;
                let SCHCON = searchInput.value;
                let sorted = 1
                if (SUP.checked) {
                    sorted = 0;
                }
                Output(showBox, clipArr(arrforsort(FILT(S8MEALS, SCHCON), sorted), cutAmount, pagenow));

            })
            MAE.addEventListener("click", () => {
                if (pagenow == 2) {
                    MAE.disabled = true;
                }
                if (pagenow == pageall) {
                    USIRO.disabled = false;
                }
                pagenow--;
                let SCHCON = searchInput.value;
                let sorted = 1
                if (SUP.checked) {
                    sorted = 0;
                }

                Output(showBox, clipArr(arrforsort(FILT(S8MEALS, SCHCON), sorted), cutAmount, pagenow));

            })

            //設定頁數 (按鈕外框,資料全長,切割長度)
            function SetPageButton(btnFrameOP, fullArrayLength, cutLength) {
                while (btnFrameOP.hasChildNodes()) {
                    btnFrameOP.removeChild(btnFrameOP.lastChild);
                }
                let page = Math.ceil(fullArrayLength / cutLength);

                let docFrag = document.createDocumentFragment();

                for (let i = 0; i < page; i++) {
                    let pageNumber = document.createElement("div");
                    pageNumber.classList.add("btnpage");
                    let num = document.createTextNode(`${i + 1}`);
                    pageNumber.appendChild(num)
                    docFrag.appendChild(pageNumber);
                }
                btnFrameOP.appendChild(docFrag);

                if (btnFrameOP.hasChildNodes()) {
                    btnFrameOP.childNodes[pagenow - 1].setAttribute("style", "color: red")
                }
                //&&pagenow>5&&pagenow<page-5
                // console.log(btnFrameOP.childNodes.length)
                //console.log()
                if (btnFrameOP.childNodes.length >= 10) {
                    if (pagenow >= 5 && pagenow <= page - 4) {
                        for (let i = 0; i < page; i++) {
                            if (i + 1 < pagenow - 4 || i + 1 > pagenow + 4)
                                btnFrameOP.childNodes[i].style.display = "none";
                        }
                    } else if (pagenow < 5) {
                        for (let i = 9; i < page; i++) {
                            btnFrameOP.childNodes[i].style.display = "none";
                        }
                    } else if (pagenow > page - 4) {
                        for (let i = 0; i < page - 9; i++) {
                            btnFrameOP.childNodes[i].style.display = "none";
                        }
                    }
                }
                let pages = document.querySelectorAll(".btnpage")
                for (let i = 0; i < pages.length; i++) {
                    pages[i].addEventListener("click", () => {
                        pagenow = i + 1;
                        let SCHCON = searchInput.value;
                        let sorted = 1
                        if (SUP.checked) {
                            sorted = 0;
                        }
                        Output(showBox, clipArr(arrforsort(FILT(S8MEALS, SCHCON), sorted), cutAmount, pagenow));

                    })
                }
            }


            //切割陣列(陣列,切割數量,第幾頁) 輸出陣列
            function clipArr(arrin, amount, page) {
                let START = (page - 1) * amount;
                let END = page * amount;
                let arrcliped = arrin.slice(START, END);

                pageall = Math.ceil(arrin.length / amount)
                SetPageButton(FR, arrin.length, amount);
                return arrcliped;

            }

            //搜尋 (要搜尋的文字，搜尋對象資料，輸出框，排序方式)
            function search(text, arr, frame, sort) {
                Output(frame, arrforsort(FILT(arr, text), sort));
            }
            //篩選 輸入(陣列，要篩選的文字) 回傳陣列 移用時要改篩選對象
            function FILT(arr, txt) {
                let arrout = arr.filter((value, index, array) => {
                    if (value.shop_sid == txt) {
                        return value;
                    }
                })
                return arrout;
            }
            //排序(陣列，排序方式0升序，1降序)  回傳陣列
            function arrforsort(arrin, sort) {
                let arrsorted = arrin.sort((a, b) => {
                    if (sort === 1) {
                        return b.price - a.price; //降序
                    } else {
                        return a.price - b.price; //升序
                    }
                })
                return arrsorted;
            }

            //顯示結果  (輸出框,要輸出的陣列)
            function Output(frameOP, arrayOP) {
                if (pagenow == 1) {
                    MAE.disabled = true;
                } else {
                    MAE.disabled = false;
                }
                if (pagenow == pageall) {
                    USIRO.disabled = true;
                } else {
                    USIRO.disabled = false;
                }
                while (frameOP.hasChildNodes()) {
                    frameOP.removeChild(frameOP.lastChild);
                }
                let docFrag = document.createDocumentFragment();
                arrayOP.forEach(data => {
                    let {
                        name,
                        price,
                        src,
                        SID
                    } = data;
                    let cardcol = document.createElement("div");
                    cardcol.classList.add("col");
                    let cardM = document.createElement("div");
                    cardM.classList.add("cardtest");
                    let cardH3 = document.createElement("h3");
                    let contentIn = document.createTextNode(name);
                    let cardp = document.createElement("p");
                    let contentPrize = document.createTextNode(price);
                    cardH3.appendChild(contentIn);
                    cardp.appendChild(contentPrize);
                    cardM.appendChild(cardH3);
                    if (src !== "") {
                        let ImgFR = document.createElement("div");
                        ImgFR.classList.add("imgFR");
                        let Img = document.createElement("img");
                        Img.setAttribute("src", `${src}`);
                        ImgFR.appendChild(Img);
                        cardM.appendChild(ImgFR);
                    }
                    cardM.appendChild(cardp);
                    let btnBox = document.createElement("form");
                    btnBox.setAttribute("name", `form${SID}`);
                    btnBox.classList.add("productform")
                    let input01 = document.createElement("input")
                    input01.setAttribute("value", SID);
                    input01.setAttribute("name", "sid");
                    input01.style.visibility = "hidden";
                    input01.style.display = "none";
                    btnBox.appendChild(input01);
                    cardM.appendChild(btnBox);
                    cardcol.appendChild(cardM);
                    docFrag.appendChild(cardcol);
                })
                frameOP.appendChild(docFrag);
            }
        })
</script>