<?php require './API/Connect_DataBase.php'; ?>
<?php require __DIR__ . './HTMLSetting.php'; ?>
<?php require __DIR__ . './StyleSetting/CssSettingBootstrap.php'; ?>
<?php if (empty($_SESSION['admin'])) : ?>
    <?php require __DIR__ . './Member_Nav.php'; ?>
<?php else : ?>
    <?php require __DIR__ . '/Admin_Nav.php'; ?>
<?php endif; ?>

<script src="./API/Log/CheckLoginScript.js"></script>
<script>
    checkLogin(2);
</script>

<?php
//管理者論壇管理

$perPage = 20; // 一頁有幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// 算總筆數
$t_sql = "SELECT COUNT(1) FROM chat ";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

$totalPages = ceil($totalRows / $perPage);

$rows = [];
// 如果有資料
if ($totalRows) {
    if ($page < 1) {
        header('Location: ?page=1');
        exit;
    }
    if ($page > $totalPages) {
        header('Location: ?page=' . $totalPages);
        exit;
    }

    $sql = sprintf(
        "SELECT * FROM chat ORDER BY chat DESC LIMIT %s, %s",
        ($page - 1) * $perPage,
        $perPage
    );
    $rows = $pdo->query($sql)->fetchAll();
}

$output = [
    'totalRows' => $totalRows,
    'totalPages' => $totalPages,
    'page' => $page,
    'rows' => $rows,
    'perPage' => $perPage,
];
?>

<!-- ※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※ -->
<style>
    #adminEditChatContent {
        /* border: red 1px solid; */
        padding: 5px;
        position: fixed;
        /* width: 400px; */
        /* height: 200px; */
        background-color: #FFF;
        left: 50%;
        top: 20%;
        translate: -50%;
        z-index: 150;
        min-width: 400px;
        min-height: 250px;
        display: none;
        border-radius: 10px;
    }

    .grayBack {
        background-color: #5555;
        width: 200%;
        position: fixed;
        height: 100vh;
        z-index: 149;
        top: 0;
        left: -50%;
        display: none;
        padding: 0;
        margin: 0;
    }

    .editButtonsp {
        padding: 0;
        margin: 0;
    }
</style>
<!-- ※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※ -->



<div class="container">
    <div class="row">
        <div class="col">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item <?= 1 == $page ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page - 1 ?>">
                            <i class="fa-solid fa-circle-arrow-left"></i>
                        </a>
                    </li>

                    <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
                        if ($i >= 1 and $i <= $totalPages) :
                    ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                    <?php
                        endif;
                    endfor; ?>

                    <li class="page-item <?= $totalPages == $page ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page + 1 ?>">
                            <i class="fa-solid fa-circle-arrow-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>


    <div class="row">
        <div class="col">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">
                            <i class="fa-solid fa-trash-can"></i>
                        </th>
                        <th scope="col">#</th>
                        <th scope="col">作者</th>
                        <th scope="col">時間</th>
                        <th scope="col">標題</th>
                        <th scope="col">內文</th>
                        <th scope="col">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r) : ?>
                        <tr>
                            <td>
                                <a href="javascript: delete_it(<?= $r['chat'] ?>)">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </td>
                            <td><?= $r['chat'] ?></td>
                            <td><?= $r['author'] ?></td>
                            <td><?= $r['time'] ?></td>
                            <td><?= htmlentities($r['title']) ?></td>
                            <td><?= htmlentities($r['content']) ?></td>
                            <td>
                                <p class="editButtonsp">
                                    <a class="editButtons" href="#">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                </p>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>
    </div>



    <!-- ※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※ -->
    <!-- 修改框 -->
    <div id="adminEditChatContent">
        <div id="exampleModal1">
            <!-- class="modal " -->
            <div class="modal-dialog">
                <div id="formEdit" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">修改標題內文</h5>
                        <!-- 這個是X按鈕 -->
                        <button id="adminEditCancel2" type="button" class="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- sid -->
                        <input type="hidden" id="adminEditHiddenSid">
                        <h5 class="card-title">標題文字</h5>
                        <input type="text" id="adminEditChatTitle" class="form-control me-auto">
                        <h5 class="card-title">標題內容</h5>
                        <textarea id="adminEditChatText" class="form-control me-auto"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button id="adminEditConfirm" class="btn btn-primary">確認</button>
                        <button id="adminEditCancel" class="btn btn-secondary">取消</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="grayBack"></div>
    <!-- ※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※ -->


    <script>
        //※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※
        //外框   adminEditChatContent
        let adminEditChatContent = document.querySelector("#adminEditChatContent");

        //灰背
        let grayBack = document.querySelector(".grayBack");
        //隱藏SID
        let adminEditHiddenSid = document.querySelector("#adminEditHiddenSid");

        //標題  adminEditChatTitle
        let adminEditChatTitle = document.querySelector("#adminEditChatTitle");

        //內文  adminEditChatText
        let adminEditChatText = document.querySelector("#adminEditChatText");



        //修改按鈕群
        let EditBTNs = document.querySelectorAll(".editButtons");

        // console.log(EditBTNs.length);
        //修改按鈕叫出資料
        for (let i = 0; i < EditBTNs.length; i++) {
            EditBTNs[i].addEventListener("click", (e) => {
                let chooseSid = e.currentTarget.parentNode.parentNode.parentNode.childNodes[3].innerText.trim();

                let choosetitle = e.currentTarget.parentNode.parentNode.parentNode.childNodes[9].innerText;

                let chooseContent = e.currentTarget.parentNode.parentNode.parentNode.childNodes[11].innerText;

                adminEditHiddenSid.value = chooseSid;

                adminEditChatTitle.value = choosetitle;

                adminEditChatText.value = chooseContent;

                adminEditChatContent.style.display = "block";
                grayBack.style.display = "block";
            })
        }
        //修改確認
        let adminEditConfirm = document.querySelector("#adminEditConfirm");
        //修改取消
        let adminEditCancel = document.querySelector("#adminEditCancel");
        //修改X按鈕
        let adminEditCancel2 = document.querySelector("#adminEditCancel2");

        adminEditCancel.addEventListener("click", () => {
            closeAdminChatEditFrame();
        })
        adminEditCancel2.addEventListener("click", () => {
            closeAdminChatEditFrame();
        })

        function closeAdminChatEditFrame() {
            adminEditHiddenSid.value = "";
            adminEditChatTitle.value = "";
            adminEditChatText.value = "";
            adminEditChatContent.style.display = "none";
            grayBack.style.display = "none";
        }

        adminEditConfirm.addEventListener("click", () => {
            let sidE = adminEditHiddenSid.value
            let titleE = adminEditChatTitle.value;
            let textE = adminEditChatText.value;

            let FD = new FormData();
            FD.append('sid', sidE);
            FD.append('title', titleE);
            FD.append('content', textE);
            fetch("./API/Admin/Admin_ChatEdit_api.php", {
                method: "POST",
                body: FD
            }).then(r => r.json()).then(res => {
                if (res == 1) {
                    alert("修改成功");
                    location.reload();
                } else {
                    alert("修改失敗");
                }
            })
        })

        //※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※※



        const table = document.querySelector('table');

        function delete_it(sid) {
            if (confirm(`確定要刪除編號為 ${sid} 的資料嗎?`)) {
                location.href = `./API/Admin/Admin_ChatDelete_api.php?sid=${sid}`;
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    </body>

    </html>