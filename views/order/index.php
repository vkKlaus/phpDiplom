<?php

require  $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/header.php';

resetFilterSession();

$deliv = getTable($pdo, "delivery", "", '`cost`');

if (isset($_SESSION['order'])) {
    $order = $_SESSION['order'];
} else {
    $order = [];
}

if (!isset($_SESSION['order'])) {
    $_SESSION['order'] = [];
}

if (isset($_SESSION['basket'])) {

    $strFilter = '';

    foreach ($_SESSION['basket'] as $baskElement) {
        $inOrder = false;
        foreach ($_SESSION['order'] as $orderElement) {
            if ($baskElement == $orderElement['id']) {
                $inOrder = true;
                break;
            }
        }
        if ($inOrder) {
            continue;
        }

        $strFilter .= $baskElement . ',';
    }

    if ($strFilter != '') {
        $strFilter = '`id` in (' . $strFilter . ')';
        $strFilter = str_replace(",)", ")", $strFilter);

        $newBasket = getTable($pdo, "product", $strFilter);
        foreach ($newBasket as $item) {
            array_push($_SESSION['order'], ['id' => $item['id'], 'name' => $item['name'], 'price' => $item['price'], 'count' => 1]);
        }
    }
}

?>

<div>
    <h2 class="text-left text-primary">Коpзина</h2>
    <br>

    <form method="POST" class="container">
        <div class="row">
            <div class="col-8">
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
                        foreach ($_SESSION['order'] as $key => $item) { ?>

                            <tr>
                                <th scope="row col"><?= $key + 1 ?>.</th>

                                <td class="col text-left"><?= $item['name'] ?></td>

                                <td class="col text-right"><?= $item['price'] ?></td>

                                <td><input type="number" class="text-right" value="<?= $item['count'] ?>"></td>

                                <td class="col text-right"><?= ($item['count'] * $item['price']) ?></td>
                            </tr>

                        <?php
                            $total += $item['count'] * $item['price'];
                        } ?>

                        <tr class="bg-secondary">
                            <td colspan="4" class="h4 text-right">Сумма заказа</td>
                            <td class="h4 text-right "><?= $total ?> </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-4">
                <p><strong>Варианты и стоимость доставка</strong></p>

                <table class="table  table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>

                            <th scope="col">доставка</th>

                            <th scope="col">цена</th>
                        </tr>
                    </thead>
                    <?php
                    foreach ($deliv as $key => $element) { ?>
                        <tr>
                            <th scope="row"><input type="radio" name="deliv" value="<?= $element['id'] ?>"></th>

                            <td><?= $element['name'] ?></td>

                            <td><?= $element['cost'] ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col d-flex justify-content-end">
                <button type="submit" class="btn btn-info">
                    Оформить заказ
                </button>
            </div>
        </div>

    </form>





    <?php require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/footer.php';
