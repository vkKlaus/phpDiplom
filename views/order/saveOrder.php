<?php

require  $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/header.php';

resetFilterSession();

if (isset($_POST['saveOrder'])) {
    $_SESSION['deliv'] = isset($_POST['deliv']) ? $_POST['deliv'] : -1;
    $deliv = getTable($pdo, "delivery", "`id`=" . $_POST['deliv'], '`cost`');
    $_SESSION['user']['visitor'] = isset($_POST['visitor']) ? $_POST['visitor'] : '';
    $_SESSION['user']['email'] = isset($_POST['email']) ? $_POST['email'] : '';
    $_SESSION['user']['phone'] = isset($_POST['phone']) ? $_POST['phone'] : '';
    $_SESSION['user']['message'] = isset($_POST['message']) ? $_POST['message'] : '';
}


?>

<div class="row">
    <div class="col-6">
        <p class="text-primary h3"><strong>Ваш заказ:</strong></p>
        <table class="table  table-striped">
            <thead class="thead-dark">
                <tr class="text-center">
                    <th scope="col-2">#</th>
                    <th scope="col-3">товар</th>
                    <th scope="col-1">цена</th>
                    <th scope="col-1">количество</th>
                    <th scope="col-1">сумма</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                $num = 1;
                foreach ($_SESSION['order'] as $key => $item) { ?>

                    <tr>
                        <th scope="row col">
                            <?= $num++ ?>.
                        </th>

                        <td class="col text-left">
                            <?= $item['name'] ?>
                        </td>

                        <td class="col text-right" id="<?= $item['id'] ?>_price">
                            <?= $item['price'] ?>
                        </td>

                        <td class="col text-right">
                            <?= $item['count'] ?>
                        </td>

                        <td class="col text-right sum" id="<?= $item['id'] ?>_sum">
                            <?= ($item['count'] * $item['price']) ?>
                        </td>


                    </tr>

                <?php
                    $total += $item['count'] * $item['price'];
                } ?>

                <tr class="bg-secondary">
                    <td colspan="3" class="h4 text-right">Сумма заказа</td>
                    <td class="h4 text-right "><?= $total ?> </td>
                    <td> </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-6">
        <p class="text-primary h3"><strong>Вариант доставки:</strong></p>
        <div class="h4 ml-5"><i class="fas fa-angle-right"></i>&nbsp;<?= $deliv[0]['name'] ?></div>
        <div class="h4 ml-5"><i class="fas fa-angle-right"></i>&nbsp;стоимость: <?= $deliv[0]['cost'] ?></div>
        <hr>
        <p class="text-primary h3"><strong>Адрес доставки:</strong></p>
        <div class="h4 ml-5"><i class="fas fa-angle-right"></i>&nbsp;<?= $_POST['message'] ?></div>

    </div>
</div>

<hr>

<div class="row">
    <div class="col-6">
        <p class="text-primary h3 d-flex justify-content-between">
            <strong>Общая сумма:</strong>
            <span class="h3 text-dark"><?= ($total + $deliv[0]['cost']) ?> </span>
        </p>

    </div>
    <div class="col-6">
        <p class="text-primary h3"><strong>Правильно</strong></p>
        <a class="btn btn-primary btn-lg pl-5 pr-5" href="/views/order/" role="button">Нет</a>
        <a class="btn btn-primary btn-lg active pl-5 pr-5" href="#/?save=true" role="button">Да</a>
    </div>
</div>




<?php require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/footer.php';
