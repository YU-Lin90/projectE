<?php require './API/Connect_DataBase.php';

//一般會員個人資料頁面

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

    if (empty($_SESSION['user'])) {

        $sql = sprintf(
            "SELECT * FROM member WHERE sid=0 ORDER BY sid DESC LIMIT %s, %s",
            ($page - 1) * $perPage,
            $perPage
        );
    } else {
        $Msid =  $_SESSION['user']['sid'];
        $sql = sprintf(
            "SELECT * FROM member WHERE sid=$Msid ORDER BY sid DESC LIMIT %s, %s",
            ($page - 1) * $perPage,
            $perPage
        );
    }
    // $Msid =  $_SESSION['user']['sid'];
    // $sql = sprintf(
    //     "SELECT * FROM member WHERE sid=$Msid ORDER BY sid DESC LIMIT %s, %s",
    //     ($page - 1) * $perPage,
    //     $perPage
    // );
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
<?php require __DIR__ . './Member_Nav.php'; ?>

<div class="container">
    <div class="row">
        <div class="col">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">姓名</th>
                        <th scope="col">帳號</th>
                        <th scope="col">密碼</th>
                        <th scope="col">手機</th>
                        <th scope="col">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r) : ?>
                        <tr>
                            <td><?= $r['name'] ?></td>
                            <td><?= $r['email'] ?></td>
                            <td><?= $r['password'] ?></td>
                            <td><?= $r['phone'] ?></td>
                            <td>
                                <a href="./edit-form-user.php?sid=<?= $r['sid'] ?>">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>
    </div>
</div>


<script>
    fetch("./API/MemberData/list-user-api.php").then(r => r.json()).then(res => {
        console.log(res);
        if (res.code == 1) {
            alert(res.error);
            location.href = "Member_login.php";
        }
    })


</script>

<?php require __DIR__. './Footer_CDN.php' ?>