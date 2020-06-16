<?php
require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/index.php';
resetFilterSession();

$status = getTable($pdo, 'status');

if (!isset($_SESSION['idStatusSelect'])){
    $_SESSION['idStatusSelect']=-1;
}


if (isset($_POST['btnSelect'])) {
    $_SESSION['idStatusSelect']=(int)$_POST['selectStatus'];

}

if (isset($_POST['chnOrder'])){
    changeStatus($pdo, $_POST);
}

$orders = getOrder($pdo,  $_SESSION['idStatusSelect']);

$orderList = getOrderList($pdo);




require  $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/header.php';
?>
<div class="row">
    <div class="col-2">
        <h3>Заказы</h3>
    </div>
    <div class="col-10">
        <form method="POST">
            <div class="row">
                <div class="col-3 text-right form-control border-0">
                    <label for="selectStatus">Отобрать по статусу заказа: </label>
                </div>

                <div class="col-7">

                    <select class="form-control" id="selectStatus" name="selectStatus">
                        <option value="-1">все</option>
                        <?php
                        foreach ($status as $stat) { ?>
                            <option value="<?= $stat['id'] ?>" 
                            <?= (isset( $_SESSION['idStatusSelect']) && ( $_SESSION['idStatusSelect'] == $stat['id'])) ? 'selected':'' ;?>><?= $stat['name'] ?></option>
                        <?php } ?>
                    </select>

                </div>

                <div class="col-2 ">
                    <input type="submit" class="btn btn-info" name="btnSelect" value="Отобрать">
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="accordion" id="accordionExample">
            <?php
            foreach ($orders as $order) {
            ?>
                <div class="card border-dark">
                    <div class="card-header" id="heading<?= $order['id'] ?>">
                        <div class="row mb-0">
                            <div class="col-8">
                                <div class="row">
                                    <div class="col-2 text-right border-bottom border-secondary">#:</div>
                                    <div class="col text-left border-bottom border-secondary"><?= $order['id'] ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-2  text-right border-bottom border-secondary">дата:</div>
                                    <div class="col text-left border-bottom border-secondary"><?= $order['date'] ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-2 text-right border-bottom border-secondary">имя:</div>
                                    <div class="col text-left border-bottom border-secondary"><?= $order['user'] ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-2 text-right border-bottom border-secondary">ст. заказа:</div>
                                    <div class="col text-left border-bottom border-secondary"><?= $order['cost_product'] ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-2  text-right border-bottom border-secondary">email:</div>
                                    <div class="col text-left border-bottom border-secondary"><?= $order['email'] ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-2  text-right border-bottom border-secondary">способ доставки:</div>
                                    <div class="col text-left border-bottom border-secondary"><?= $order['devil'] ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-2  text-right border-bottom border-secondary">ст. доставки:</div>
                                    <div class="col text-left border-bottom border-secondary"><?= $order['cost_delivery'] ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-2  text-right  border-bottom border-secondary">адрес:</div>
                                    <div class="col text-left border-bottom border-secondary"><?= $order['address'] ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-2 text-right border-bottom border-secondary">итоговая ст.:</div>
                                    <div class="col text-left border-bottom border-secondary"><?= $order['cost_total'] ?></div>
                                </div>
                            </div>


                            <div class="col-3">
                                <form method="POST">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Статус заказа</label>
                                        <select class="form-control" id="exampleFormControlSelect1" name="status">
                                            <?php
                                            foreach ($status as $stat) { ?>
                                                <option value="<?= $stat['id'] ?>" <?= $stat['id'] == $order['status_id'] ? 'selected' : '' ?>><?= $stat['name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <p>дата изменения статуса:</p>
                                    <p><?= $order['date_status'] ?></p>
                                    <input type="submit" class="btn btn-info mt-5" name="chnOrder" value="Записать">
                                    <input type="text" name="orderID" value="<?= $order['id'] ?>" style="visibility: hidden" />
                                </form>
                            </div>

                            <button class="col-1 btn btn-link btn-show" type="button" data-toggle="collapse" data-target="#collapse<?= $order['id'] ?>" aria-expanded="true" aria-controls="collapse<?= $order['id'] ?> ">
                                <i class="fas fa-info border border-primary rounded-lg p-3"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div id="collapse<?= $order['id'] ?>" class="collapse" aria-labelledby="heading<?= $order['id'] ?>" data-parent="#accordionExample">
                    <div class="card-body bg-light">
                        <div class="row border-dark border-bottom bg-secondary">
                            <div class="col-9">товар</div>
                            <div class="col-1">цена</div>
                            <div class="col-1">количество</div>
                            <div class="col-1">сумма</div>
                        </div>
                        <?php
                        $ordId = $order['id'];
                        $ordList = array_filter($orderList, function ($el) use ($ordId) {
                            return $el['id'] == $ordId;
                        });

                        foreach ($ordList as $el) {
                        ?>
                            <div class="row">
                                <div class="col-9"><?= $el['product_name'] ?></div>
                                <div class="col-1"><?= $el['price'] ?></div>
                                <div class="col-1"><?= $el['count'] ?></div>
                                <div class="col-1"><?= $el['cost'] ?></div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/footer.php';
