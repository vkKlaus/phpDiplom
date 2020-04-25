<?php
require $_SERVER['DOCUMENT_ROOT'] . '/template/header.php';

$deliv = getTable($pdo,"delivery");
?>
<div class="row d-flex flex-row">
    <div class="col ml-5 mr-5">
        <p><strong>Варианты и стоимость доставка</strong></p>

        <table class="table table-sm">
            <thead>
                <tr class="table-dark">
                    <th scope="col"></th>

                    <th scope="col">доставка</th>

                    <th scope="col">цена</th>
                </tr>
            </thead>
            <?php
            foreach ($deliv as $key => $element) { ?>
                <tr>
                    <th scope="row"><?= $key ?></th>

                    <td><?= $element['name'] ?></td>
                    
                    <td><?= $element['cost'] ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <div class="col">
        <p><strong>Возможные способы оплаты</strong></p>
        <ul class="ml-2 list-payment">
            <li class="list-item-payment mb-1">Оплата курьеру наличными при получении товара (только для Москвы и Подмосковья). К оплате мы принимаем только рубли. </li>

            <li class="list-item-payment mb-1">Оплата банковской картой курьеру при получении заказа ( выбирайте в Личном кабинете способ оплаты "Банковская карта").</li>
            <li class="list-item-payment mb-1">Наложенный платеж (оплата за товар при получении в Вашем городе. Но прибавится комиссия 3% за услугу!!!</li>

            <li class="list-item-payment mb-1">Оплата на нашем сайте через Яндекс-деньги (масса способов оплаты внутри сервиса)</li>

            <li class="list-item-payment mb-1">Безналичный расчёт - для организаций и клиентов (оплата на наш расчетный счет)</li>

            <li class="list-item-payment mb-1">Товар отгружается в течение 2-5 дней после поступления денег на расчётный счёт.</li>
        </ul>
        <p><strong>К оплате принимается</strong></p>
        <div class="d-flex flex-row justify-content-around">
            <div><i class="fas fa-money-bill-wave-alt fa-4x"></i></div>

            <div><i class="fab fa-cc-visa fa-4x"></i></div>
            
            <div><i class="fab fa-cc-mastercard fa-4x"></i></div>
           
            <div><i class="fab fa-cc-amex fa-4x"></i></div>

            <div><i class="fab fa-cc-apple-pay fa-4x"></i></div>
        </div>

    </div>

</div>





<?php require $_SERVER['DOCUMENT_ROOT'] . '/template/footer.php' ?>