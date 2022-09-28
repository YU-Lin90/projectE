<?php require  './API/Connect_DataBase.php'; ?>
<?php require __DIR__ . './HTMLSetting.php'; ?>
<?php require __DIR__ . './StyleSetting/CssSettingBootstrap.php'; ?>


<?php if (empty($_SESSION['admin'])) : ?>
    <?php require __DIR__ . './Store_Nav.php'; ?>
<?php else : ?>
    <?php require __DIR__ . '/Admin_Nav.php'; ?>
<?php endif; ?>

<?php
$pageName = 'edit';

$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
if (empty($sid)) {
    header('Location: Store_list.php');
    exit;
}
$sql = "SELECT * FROM shop WHERE sid=$sid";
$r = $pdo->query($sql)->fetch();
if (empty($r)) {
    header('Location: Store_list.php');
    exit;
}


?>

<div class="container">
    <div class="row"></div>
    <!-- <div class="col-lg-6"> -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">修改資料</h5>
            <form name="form1" onsubmit="checkForm(); return false;" novalidate>
                <?php if (empty($_SESSION['admin'])) : ?>
                        <input type="hidden" name="sid" value="<?= $r['sid'] ?>">
                <?php else : ?>
                    <div class="mb-3">
                        <label for="sid" class="form-label">SID</label>
                        <input type="text" name="sid" value="<?= $r['sid'] ?>" readonly>
                    </div>
                <?php endif; ?>
                <div class="mb-3">
                    <label for="name" class="form-label">店名</label>
                    <input type="text" class="form-control" id="name" name="name" required value="<?= htmlentities($r['name']) ?>">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">帳號(E-mail)</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= $r['email'] ?>">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">密碼</label>
                    <input type="text" class="form-control" id="password" name="password" value="<?= $r['password'] ?>">
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">地址</label>
                    <!-- <select id="select1" data-val="臺北市" name="address[]"></select>
                    <select id="selectArea" name="address[]"></select>
                    <select id="selectRoad" name="address[]"></select>
                    -->
                    <textarea class="form-control" name="address" id="address" cols="50" rows="3"><?= htmlentities($r['address']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">電話</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="<?= $r['phone'] ?>" pattern="/\d{10}/">
                </div>
                <div class="mb-3">
                    <label for="food_type_sid" class="form-label">種類</label>
                    <input type="text" class="form-control" id="food_type_sid" name="food_type_sid" value="<?= $r['food_type_sid'] ?>">
                </div>
                <div class="mb-3">
                    <label for="bus_start" class="form-label">開始營業時間</label>
                    <input type="text" class="form-control" id="bus_start" name="bus_start" value="<?= $r['bus_start'] ?>">
                </div>
                <div class="mb-3">
                    <label for="bus_end" class="form-label">結束營業時間</label>
                    <input type="text" class="form-control" id="bus_end" name="bus_end" value="<?= $r['bus_end'] ?>">
                </div>
                <div class="mb-3">
                    <label for="bus_day" class="form-label">營業時間(週)</label>
                    <input type="text" class="form-control" id="bus_day" name="bus_day" value="<?= $r['bus_day'] ?>">
                </div>
                <?php if (empty($_SESSION['admin'])) : ?>
                        <input type="hidden" class="form-control" id="rest_right" name="rest_right" value="<?= $r['rest_right'] ?>">
                        <input type="hidden" class="form-control" id="plat_right" name="plat_right" value="<?= $r['plat_right'] ?>">
                <?php else : ?>
                    <div class="mb-3">
                        <label for="rest_right" class="form-label">上架狀態(店家)</label>
                        <input type="text" class="form-control" id="rest_right" name="rest_right" value="<?= $r['rest_right'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="plat_right" class="form-label">上架狀態(平台)</label>
                        <input type="text" class="form-control" id="plat_right" name="plat_right" value="<?= $r['plat_right'] ?>">
                    </div>
                <?php endif; ?>
                <div class="mb-3">
                    <label for="src" class="form-label">圖檔路徑</label>
                    <input type="text" class="form-control" id="src" name="src" value="<?= $r['src'] ?>">
                </div>
                <div class="mb-3">
                    <label for="pay" class="form-label">付款方式</label>
                    <input type="text" class="form-control" id="pay" name="pay" value="<?= $r['pay'] ?>">
                </div>
                <div class="mb-3">
                    <label for="side" class="form-label">外帶/外送/內用選擇</label>
                    <input type="text" class="form-control" id="side" name="side" value="<?= $r['side'] ?>">
                </div>
                <div class="mb-3">
                    <label for="wait_time" class="form-label">預定等待時間</label>
                    <input type="text" class="form-control" id="wait_time" name="wait_time" value="<?= $r['wait_time'] ?>">
                </div>

                <button type="submit" class="btn btn-primary">修改</button>
                <button type="reset" class="btn btn-primary">重填</button>
            </form>
        </div>
    </div>
</div>
</div>
</div>


<!-- <script src="./scripts/address.js"></script> -->

<script>
    <?php $page = isset($_GET['page']) ? intval($_GET['page']) : 1; ?>

    function checkForm() {
        // document.form1.email.value
        const fd = new FormData(document.form1);

        for (let k of fd.keys()) {
            console.log(`${k}:${fd.get(k)}`);
        }
        // TODO: 檢查欄位資料

        fetch('./API/StoreData/Store_edit-api.php', {
            method: 'POST',
            body: fd
        }).then(r => r.json()).then(obj => {
            console.log(obj);
            if (!obj.success) {
                alert(obj.error);
            } else {
                alert('修改成功')
                <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
                    if ($i === $page) :
                ?>
                        location.href = 'Store_list.php?page=<?= $i ?>';
                <?php
                    endif;
                endfor; ?>
            }
        })


    }


// --------------------我是分隔線(地址用)-----------------------

    // let sel = document.querySelector("#select1");
    //     let selArea = document.querySelector("#selectArea");
    //     let selRoad = document.querySelector("#selectRoad");
        
    //     ADDRESS.forEach(element => {
    //         sel.options.add(new Option(element.CityName));
    //     });
        
    //     //這邊是開始 顯示出第一個預設按鈕
    //     let city = sel.options[sel.selectedIndex].value; //取出現在選取的值
    //     let areas = ADDRESS.filter(element=>element.CityName === city); //藉由city過濾出只要的縣市陣列
        
    //     areas[0].AreaList.forEach(element => {  //過濾後的縣市陣列 取出第一筆 然後在AreaList陣列 個別取出區(AreaName跟Zipcode)
    //         let {AreaName,Zipcode} = element
    //         selArea.options.add(new Option(AreaName,Zipcode));
    //     });

    //     //這邊是開始 顯示出第二個預設按鈕
    //     let district = selArea.options[selArea.selectedIndex].value; //抓現在selArea選取到的區的值
    //     let newareas = areas[0].AreaList.filter(element=>element.AreaName === district);
    //     newareas[0].RoadList.forEach(element=>{
    //         let {RoadName} = element;
    //         selRoad.options.add(new Option(RoadName));
    //     })

    //     sel.addEventListener("change", () => {
    //         selArea.options.length = 0; //變化時先把第二格的選項清掉
    //         let city = sel.options[sel.selectedIndex].value;
    //         let areas = ADDRESS.filter(element=>element.CityName === city);
            
    //         areas[0].AreaList.forEach(element => {
    //             let {AreaName,Zipcode} = element
    //             selArea.options.add(new Option(AreaName,Zipcode));
    //         });
            
    //         //更改第三個的值 
    //         selRoad.options.length = 0;
    //         let district = selArea.options[selArea.selectedIndex].value; //抓區的值
    //         let newareas = areas[0].AreaList.filter(value=>value.AreaName === district);//透過區來過濾出新的陣列
            
    //         newareas[0].RoadList.forEach(element=>{         //透過新的陣列取出路名添加到第三格
    //             let {RoadName} = element;
    //             selRoad.options.add(new Option(RoadName));
    //         })
    //         console.log(sel.value)
    //     });

    //     selArea.addEventListener("change", () => {
    //         selRoad.options.length = 0; //變化時先把第二格的選項清掉
    //         let city = sel.options[sel.selectedIndex].value;
    //         let areas = ADDRESS.filter(element=>element.CityName === city); //這兩行 先過濾出市之後陣列
    //         let district = selArea.options[selArea.selectedIndex].value; //抓區的值
    //         let newareas = areas[0].AreaList.filter(element=>element.AreaName === district);
    //         // console.log(newareas);
    //         newareas[0].RoadList.forEach(element=>{
    //         let {RoadName} = element;
    //         selRoad.options.add(new Option(RoadName));
    //         })
    //         console.log(sel.value,selArea.value)
    //     });

    //     selRoad.addEventListener("change", () => {
    //         console.log(sel.value,selArea.value,selRoad.value)
    //     })

    //     const cityVal = sel.getAttribute('data-val');
    //     sel.value = cityVal;
    //     sel.dispatchEvent(new Event('change'));

    //     const areaVal = selArea.getAttribute('data-val');
    //     selArea.value = areaVal;
    //     selArea.dispatchEvent(new Event('change'));

    //     const roadVal = selRoad.getAttribute('data-val');
    //     selRoad.value = roadVal;

// --------------------我是分隔線(地址用)-----------------------

</script>
<?php require __DIR__. './Footer_CDN.php' ?>
