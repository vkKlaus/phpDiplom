<?php

require  $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/header.php';

resetFilterSession();

$deliv = getTable($pdo, "delivery", "", '`cost`');

$visitor = '';
$email = '';
$phone = '';
$message = '';

if (isset($_POST['submit'])) {
    $cntElements = 0;
    $cntPosition = 0;
    $totalCost = 0;
    $delivUser = isset($_SESSION['deliv']) ? (int)$_SESSION['deliv'] : -1;
    if (isset($_SESSION['user'])) {
        $visitor = isset($_SESSION['user']['visitor']) ? $_SESSION['user']['visitor'] : '';
        $email = isset($_SESSION['user']['email']) ? $_SESSION['user']['email'] : '';
        $phone = isset($_SESSION['user']['phone']) ? $_SESSION['user']['phone'] : '';
        $message = isset($_SESSION['user']['message']) ? $_SESSION['user']['message'] : '';
    }

    foreach ($_SESSION['order'] as $key => $elmOrder) {
        $count = (int) $_POST[$_SESSION['order'][$key]['id'] . '_count'];

        if ($count == 0) {
            unset($_SESSION['order'][$key]);

            continue;
        }

        $_SESSION['order'][$key]['count'] = $count;

        $cntElements += $count;

        $cntPosition += 1;

        $totalCost += $_SESSION['order'][$key]['count'] * $_SESSION['order'][$key]['price'];
    }
}

?>
<div class="container">
    <form method="POST" action="/views/order/saveOrder.php">
        <div class="row">
            <div class="col-3">
                <div>
                    <p class="text-primary h3"><strong>Ваш заказ:</strong></p>

                    <p class="ml-5 h4">позиций: <?= $cntPosition ?></p>

                    <p class="ml-5 h4">мест: <?= $cntElements ?></p>

                    <hr>

                    <p class="text-primary h4">Cумма: <?= $totalCost ?></p>
                </div>
            </div>

            <div class="col-5">
                <p class="text-primary h3"><strong>Варианты и стоимость доставка</strong></p>

                <table class="table  table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>

                            <th scope="col">доставка</th>

                            <th scope="col">цена</th>
                        </tr>
                    </thead>
                    <?php
                    $i = true;
                    foreach ($deliv as $key => $element) { ?>
                        <tr>
                            <th scope="row">
                                <input type="radio" id="<?= $element['id'] ?>" class="deliv" name="deliv" value="<?= $element['id'] ?>" data="<?= $element['cost'] ?>" required <?= $element['id'] == $delivUser ? 'checked' : '' ?>>
                            </th>

                            <td><?= $element['name'] ?></td>

                            <td><?= $element['cost'] ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>

            <div class="col-4">
                <p class="text-primary h3"><strong>Адрес доставки</strong></p>

                <label for="name" class="h5"><i class="fas fa-user"></i> Имя</label>

                <input type="text" class="form-control" id="name" required name="visitor" value="<?= $visitor ?>">


                <label for="email" class="h5"> <i class="fa fa-at"></i> Email</label>

                <input type="email" class="form-control" id="email" required name="email" value="<?= $email ?>">

                <label for="phone" class="h5"><i class="fa fa-phone-alt"></i> Телефон</label>

                <input type="tel" class="form-control" id="phone" name="phone" value="<?= $phone ?>">


                <label for="message" class="h5 "><i class="fas fa-map-marked-alt"></i> Адрес достаки</label>

                <textarea id="message" class="form-control" rows="5" required name="message"> <?= $message ?></textarea>

                <input type="submit" class="btn btn-info mt-5" name="saveOrder" value="Продолжить">

            </div>

        </div>

    </form>
</div>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/footer.php';
