<div class="row">
    <div class="col">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">
                        <!-- <span>刪除</span> -->
                        <i class="fa-solid fa-trash-can"></i>
                    </th>
                    <th scope="col">#
                        <!-- <input type="button" value="降冪" class="sid_sort"></input> -->
                    </th>
                    <th scope="col">店名</th>
                    <th scope="col">帳號</th>
                    <th scope="col">密碼</th>
                    <th scope="col">地址</th>
                    <th scope="col">電話</th>
                    <th scope="col">種類</th>
                    <th scope="col">營業開始時間</th>
                    <th scope="col">營業結束時間</th>
                    <th scope="col">營業日(週)</th>
                    <th scope="col">上架狀態(店家)</th>
                    <th scope="col">上架狀態(平台)</th>
                    <th scope="col">圖片位址</th>
                    <th scope="col">付款方式</th>
                    <th scope="col">送餐方式</th>
                    <th scope="col">預定等待時間</th>
                    <th scope="col">
                        <!-- <span>編輯</span> -->
                        <i class="fa-solid fa-pen-to-square"></i>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $r) : ?>
                    <tr>
                        <td>
                            <a href="javascript: delete_it(<?= $r['sid'] ?>)">
                                <!-- <span>刪</span> -->
                                <i class="fa-solid fa-trash-can"></i>
                            </a>
                        </td>
                        <td><?= $r['sid'] ?></td>
                        <td><?= $r['name'] ?></td>
                        <td><?= $r['email'] ?></td>
                        <td><?= $r['password'] ?></td>
                        <td><?= htmlentities($r['address']) ?></td>
                        <td><?= $r['phone'] ?></td>
                        <td><?= $r['food_type_sid'] ?></td>
                        <td><?= $r['bus_start'] ?></td>
                        <td><?= $r['bus_end'] ?></td>
                        <td><?= $r['bus_day'] ?></td>
                        <td><?= $r['rest_right'] ?></td>
                        <td><?= $r['plat_right'] ?></td>
                        <td><?= $r['src'] ?></td>
                        <td><?= $r['pay'] ?></td>
                        <td><?= $r['side'] ?></td>
                        <td><?= $r['wait_time'] ?></td>
                        <td>
                            <a href="Store_edit-form.php?sid=<?= $r['sid'] ?>">
                                <!-- <span>改</span> -->
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            
        </table>
    </div>
</div>

<script>
    // document.querySelector(".sid_sort").addEventListener("click",()=>{
    //     console.log('?php ($rows) ?>');
    //     ?php ksort($rows); ?>
    // })
</script>