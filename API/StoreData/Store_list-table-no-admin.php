<div class="row">
    <div class="col">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <!-- <th scope="col">#</th> -->
                    <th scope="col">店名</th>
                    <th scope="col">帳號</th>
                    <th scope="col">密碼</th>
                    <th scope="col">地址</th>
                    <th scope="col">電話</th>
                    <th scope="col">種類</th>
                    <th scope="col">營業開始時間</th>
                    <th scope="col">營業結束時間</th>
                    <th scope="col">營業日(週)</th>
                    <th scope="col">付款方式</th>
                    <th scope="col">送餐方式</th>
                    <th scope="col">預定等待時間</th>
                    <th scope="col">
                        <!-- <span>編輯</span> -->
                        <i class="fa-solid fa-pen-to-square"></i>
                    </th>
            </thead>
            <tbody>
                <?php foreach ($rows as $r) : ?>
                    <tr>
                        <!-- <td><?= $r['sid'] ?></td> -->
                        <td><?= $r['name'] ?></td>
                        <td><?= $r['email'] ?></td>
                        <td><?= $r['password'] ?></td>
                        <td><?= $r['address'] ?></td>
                        <td><?= $r['phone'] ?></td>
                        <td><?= $r['food_type_sid'] ?></td>
                        <td><?= $r['bus_start'] ?></td>
                        <td><?= $r['bus_end'] ?></td>
                        <td><?= $r['bus_day'] ?></td>
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