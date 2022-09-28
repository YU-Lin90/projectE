<?php require  './API/Connect_DataBase.php';
    $perPage = 5;  //每頁標題數

    $a_sql = "SELECT * FROM `chat` JOIN member on `chat`.`author`=`member`.`sid`";

    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    // 算總筆數 
    $li_sql = "SELECT COUNT(`sid_title`) FROM `chat`";  //列表發表總數 **
    $totalRows = $pdo->query($li_sql)->fetch(PDO::FETCH_NUM)[0];

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
    // "SELECT * FROM chat ORDER BY sid DESC LIMIT %s, %s"
    // SELECT `title`,`content`,`time`,`member`.`name` FROM `chat` JOIN member on `chat`.`author`=`member`.`sid` WHERE `sid_title`=1
    // SELECT `title`,`content`,`time`,`member`.`name` FROM `chat` JOIN member on `chat`.`author`=`member`.`sid` WHERE `sid_title`=1 ORDER BY time DESC LIMIT 0, 5
        $sql = sprintf(   
            "SELECT `chat`,`title`,`author`,`content`,`time`,`member`.`name` FROM `chat` JOIN member on `chat`.`author`=`member`.`sid` WHERE `sid_title`=1 ORDER BY time DESC LIMIT %s, %s",
            ($page - 1) * $perPage,
            $perPage
        );  //資料只取5筆

        $rows = $pdo->query($sql)->fetchAll();
        // echo json_encode($rows, JSON_UNESCAPED_UNICODE);
    }
    // $output = [
    //     'totalRows' => $totalRows,
    //     'totalPages' => $totalPages,
    //     'page' => $page,
    //     'rows' => $rows,
    //     'perPage' => $perPage,
    // ];
    
?>

<?php require __DIR__ . './HTMLSetting.php'; ?>
<?php require __DIR__ . './StyleSetting/CssSettingBootstrap.php'; ?>
<?php require __DIR__ . './Member_Nav.php'; ?>

<div class="container">
    <div class="row">
        <div class="col">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item <?= 1 == $page ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page - 1 ?>">
                            &laquo;
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
                            &raquo;
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        發文
    </button>
    <?php require './API/Chat/insert.php' ?>
    <?php 
        if(empty($_SESSION['user'])){
            include './API/Chat/chat_no_table.php';
        } else {
            include './API/Chat/chat_table.php';
        }   
    ?>
</div>
<script>
    const table = document.querySelector('table');

</script>
<?php require __DIR__. './Footer_CDN.php' ?>