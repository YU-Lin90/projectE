<script src="./API/Log/CheckLoginScript.js"></script>
<script>
    checkLogin(0);
</script>
<?php require __DIR__ . './API/Connect_DataBase.php'; ?>
<?php require __DIR__ . './HTMLSetting.php'; ?>
<?php require __DIR__ . './StyleSetting/CssSetting_YU.php'; ?>
<?php require __DIR__ . './Member_Nav.php'; ?>






<h2 class=" fs36 mb20 setCenter txtACenter">紅利使用明細</h2>

<table class="setCenter" id="pointList_Member">
    <tr>
        <th>異動點數</th>
        <th>異動時間</th>
        <th>異動原因</th>
        <th>優惠券名稱</th>
    </tr>
</table>








<script>
    let pointList_Member = document.querySelector("#pointList_Member");

    fetch("./API/Point/Member_PointRender_api.php").then(r => r.json()).then(res => {

        // console.log(res);
        let docFrag = document.createDocumentFragment();
        res.reverse().forEach(value=>{
            let{
                coupon_name,
                point_amount,
                point_change_method,
                point_change_time
            }=value;

            let couponExport = coupon_name;
            if(!coupon_name){
                couponExport = "無";
            }

            let pointRow = document.createElement("tr");            
            createToAppendChild(pointRow,"td",null,point_amount);
            createToAppendChild(pointRow,"td",null,point_change_time);
            createToAppendChild(pointRow,"td",null,point_change_method);
            createToAppendChild(pointRow,"td",null,couponExport);
            
            docFrag.appendChild(pointRow);
        })
        pointList_Member.appendChild(docFrag);
    })

    //產生節點     (父層,Tag名,Class全部，需要字串,文字內容)  後兩項如不用則輸入null
    function createToAppendChild(parentNodeAppend,tagName,classListAll,setInnerText){
        let newNode = document.createElement(tagName);        
        if(classListAll!=null){
            newNode.classList.add(classListAll);
        }
        if(setInnerText!=null){
            let textNode = document.createTextNode(setInnerText);
            newNode.appendChild(textNode);
        }
        parentNodeAppend.appendChild(newNode);
    }






    
</script>

<?php require __DIR__ . './Footer.php' ?>