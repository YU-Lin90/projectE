<?php require './API/Connect_DataBase.php';
$perPage = 20; // 一頁有幾筆
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// 算總筆數
$t_sql = "SELECT COUNT(1) FROM member ";
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
        "SELECT * FROM member ORDER BY sid DESC LIMIT %s, %s",
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

<?php require __DIR__ . './HTMLSetting.php'; ?>
<?php require __DIR__ . './StyleSetting/CssSettingBootstrap.php'; ?>


<?php if (empty($_SESSION['admin'])) : ?>
    <?php require __DIR__ . './Member_Nav.php'; ?>
<?php else : ?>
    <?php require __DIR__ . '/Admin_Nav.php'; ?>
<?php endif; ?>




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

    

    <?php
    if (empty($_SESSION['admin'])) {
        include './API/MemberData/list-table-no-admin.php';
    } else {
        include './API/MemberData/list-table-admin.php';
    }
    ?>

    <script>
        fetch("./API/Admin/list-api.php").then(r => r.json()).then(res => {
            console.log(res);
            if (res.code == 1) {
                alert(res.error);
                location.href = "Store_login.php";
            }
        })


        const table = document.querySelector('table');

        function delete_it(sid) {
            if (confirm(`確定要刪除編號為 ${sid} 的資料嗎?`)) {
                location.href = `./API/Admin/delete-from.php?sid=${sid}`;
            }
        }
    </script>

    <?php require __DIR__. './Footer_CDN.php' ?>