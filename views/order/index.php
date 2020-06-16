<?php

require  $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/index.php';


resetFilterSession();


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


    if (isset($_GET['add'])) {
        foreach ($_SESSION['order'] as $key => $value) {

            if ($_SESSION['order'][$key]['id'] == $_GET['add']) {
                $_SESSION['order'][$key]['count'] += 1;
                break;
            }
        }
    } elseif (isset($_GET['sub'])) {
        foreach ($_SESSION['order'] as $key => $value) {
            if ($_SESSION['order'][$key]['id']  == $_GET['sub']) {
                $_SESSION['order'][$key]['count'] -= 1;
                $_SESSION['order'][$key]['count'] = $_SESSION['order'][$key]['count'] < 0 ? 0 : $_SESSION['order'][$key]['count'];
                break;
            }
        }
    }
}

require  $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/header.php';
?>


<h2 class="text-left text-primary">Коpзина</h2>
<br>

<?php if(isset ($_SESSION['order']) && $_SESSION['order']) {?>
<form method="POST" class="container" action="<?= '/views/order/adres.php' ?>">
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
                        <th scope="col-1">-/+</th>
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

                            <td>
                                <input type="number" class="text-right count" id="<?= $item['id'] ?>" name="<?= $item['id'] ?>_count" value="<?= $item['count'] ?>" readonly>
                            </td>

                            <td class="col text-right sum" id="<?= $item['id'] ?>_sum">
                                <?= ($item['count'] * $item['price']) ?>
                            </td>

                            <td class="col d-flex">
                                <a href="/views/order/?sub=<?= $item['id'] ?>"><i class="fas fa-minus-circle"></i></a>
                                &nbsp;
                                <a href="/views/order/?add=<?= $item['id'] ?>"><i class="fas fa-plus-circle"></i></a>
                            </td>
                        </tr>

                    <?php
                        $total += $item['count'] * $item['price'];
                    } ?>

                    <tr class="bg-secondary">
                        <td colspan="4" class="h4 text-right">Сумма заказа</td>
                        <td class="h4 text-right " id="total"><?= $total ?> </td>
                        <td> </td>
                    </tr>
                </tbody>
            </table>
            <div class="d-flex justify-content-between">
                <div class="row mt-5">
                    <div class="col d-flex justify-content-end">
                        <a  href="/views/catalog/?basket=del" class="btn btn-info">Очистить</a>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col d-flex justify-content-end">
                        <input type="submit" name="submit" class="btn btn-info" value="Оформить заказ">
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
                <?php } else { ?>
<h3 class="text-center text-info">КОРЗИНА ПУСТА</h3> 
               <? } ?>




<?php require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/footer.php';
