<?php require __DIR__ . './API/Connect_DataBase.php'; ?>
<?php require __DIR__ . './HTMLSetting.php'; ?>
<?php require __DIR__ . './StyleSetting/CssSettingBootstrap.php'; ?>


<?php if (empty($_SESSION['admin'])) : ?>
    <?php require __DIR__ . './Store_Nav.php'; ?>
<?php else : ?>
    <?php require __DIR__ . '/Admin_Nav.php'; ?>
<?php endif; ?>


<?php
$pageName = 'list';

$perPage = 20; //一頁有幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// 算總筆數
$t_sql = "SELECT COUNT(1) FROM shop ";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
$number_sql = $t_sql;
// $pdo->query($t_sql);
//抓到的總頁數
//FETCH_NUM將抓到的總頁數轉成陣列

$totalPages = ceil($totalRows / $perPage); //把總頁數除以設定的一頁5筆

//如果有資料，頁數小於1則跳轉到第一頁，如果大於總頁數則跳到最後一頁
if ($totalPages) {
    if ($page < 1) {
        header('Location: ?page=1');
        exit;
    }
    if ($page > $totalPages) {
        header('Location: ?page=' . $totalPages);
        exit;
    }

    //IF 是管理者帳密的話顯示全部店家列表，一般店家帳密則只顯示自己
    if (empty($_SESSION['admin']) and empty($_SESSION['store'])) {
        $sql = sprintf(
            "SELECT * FROM shop WHERE `sid`= 0 ORDER BY sid ASC LIMIT %s,%s",
            ($page - 1) * $perPage,
            $perPage
        );
        $rows = $pdo->query($sql)->fetchAll();
    } elseif (empty($_SESSION['admin'])) {
        $sid = $_SESSION['store']['sid'];
        $sql = sprintf(
            "SELECT * FROM shop WHERE `sid`= %s ORDER BY sid ASC LIMIT %s,%s",
            $sid,
            ($page - 1) * $perPage,
            $perPage
        );
        $rows = $pdo->query($sql)->fetchAll();
    } else {
        $sql = sprintf(
            "SELECT * FROM shop ORDER BY sid ASC LIMIT %s,%s",
            ($page - 1) * $perPage,
            $perPage
        );
        $rows = $pdo->query($sql)->fetchAll();
    }
}


$output = [
    'totalRows' => $totalRows,
    'totalPages' => $totalPages,
    'page' => $page,
    'rows' => $rows,
    'perPage' => $perPage,
];

//echo json_encode($output); exit;
?>


<div class="container">
    <div class="row">
        <div class="col">
            <?php
            if (isset($_SESSION['admin'])) :
            ?>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item <?= 1 == $page ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= 1 ?>">
                                <span>第一頁</span>
                            </a>
                        </li>
                        <li class="page-item <?= 1 == $page ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page - 1 ?>">
                                <!-- <span>上一頁</span> -->
                                <i class="fa-solid fa-circle-left"></i>
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
                                <!-- <span>下一頁</span> -->
                                <i class="fa-solid fa-circle-right"></i>
                            </a>
                        </li>
                        <li class="page-item <?= $totalPages == $page ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $totalPages ?>">
                                <span>最後頁</span>
                            </a>
                        </li>
                    </ul>
                    <span>
                        一共找到了 <?= $totalRows ?> 筆店家資料，共 <?= $totalPages ?> 頁
                    </span>
                </nav>
            <?php endif; ?>
        </div>
    </div>

    <?php
    if (empty($_SESSION['admin'])) {
        include  './API/StoreData//Store_list-table-no-admin.php';
    } else {
        include  './API/StoreData//Store_list-table-admin.php';
    }
    ?>

<?php
            if (isset($_SESSION['admin'])) :
            ?>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item <?= 1 == $page ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= 1 ?>">
                                <span>第一頁</span>
                            </a>
                        </li>
                        <li class="page-item <?= 1 == $page ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page - 1 ?>">
                                <!-- <span>上一頁</span> -->
                                <i class="fa-solid fa-circle-left"></i>
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
                                <!-- <span>下一頁</span> -->
                                <i class="fa-solid fa-circle-right"></i>
                            </a>
                        </li>
                        <li class="page-item <?= $totalPages == $page ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $totalPages ?>">
                                <span>最後頁</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>





    <!-- <div class="row">
        <div class="col">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">
                            <i class="fa-solid fa-trash-can"></i>
                        </th>
                        <th scope="col">#</th>
                        <th scope="col">姓名</th>
                        <th scope="col">email</th>
                        <th scope="col">手機</th>
                        <th scope="col">生日</th>
                        <th scope="col">地址</th>
                        <th scope="col">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r) : ?>
                        <tr>
                            <td>
                            <a href="javascript: delete_it(<?= $r['sid'] ?>">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </td>
                            <td><?= $r['sid'] ?></td>
                            <td><?= $r['name'] ?></td>
                            <td><?= $r['email'] ?></td>
                            <td><?= $r['mobile'] ?></td>
                            <td><?= $r['birthday'] ?></td>
                            <td><?= strip_tags($r['address']) ?></td>
                            <td><?= htmlentities($r['address']) ?></td>
                            XSS防範
                            <td>
                                <a href="edit-form.php?sid=<?= $r['sid'] ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div> -->


    <script>
        const table = document.querySelector('table');

        function delete_it(sid) {
            if (confirm(`確定要刪除編號為 ${sid} 的資料嗎?`)) {
                location.href = `./API/StoreData/Store_delete.php?sid=${sid}`;
            }
        }
        // table.addEventListener('click', function(event) {
        //     const t = event.target;
        //     console.log(event.target);
        //     if (t.classList.contains('fa-trash-can')) {
        //         t.closest('tr').remove();
        //     };
        //     if (t.classList.contains('fa-pen-to-square')) {
        //         // console.log(t.closest('tr').querySelectorAll('td'));
        //         console.log(t.closest('tr').querySelectorAll('td')[2].innerHTML);
        //     };
        // });
    </script>

<?php require __DIR__. './Footer_CDN.php' ?>