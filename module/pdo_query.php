<?php

/**
 * функция записи сообщения посетителя
 * @param object $pdo - объект соединения с БД
 * @param array $data - массив с данными сообщения
 * @return bool - результат записи сообщения
 */

function insertMessage(object $pdo,  array $data): bool
{

    foreach ($data as $key => $value) {
        $data[$key] = htmlspecialchars($value);
    }

    $sql = 'INSERT INTO `message`
                ( 
                    `visitor`, 
                    `email`, 
                    `phone`,
                    `message`,
                    `dispatched`
                )
             VALUES 
                (
                    :visitor,
                    :email,
                    :phone, 
                    :message, 
                    :dispatched 
                )';


    $stmt = $pdo->prepare($sql);

    return ($stmt->execute(
        [
            'visitor' => $data['visitor'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'message' => $data['message'],
            'dispatched' => $data['dispatched'],
        ]
    ));
}

/**
 * функция получения полных таблиц
 * @param object $pdo - объект соединения с БД
 * @param sting $table - таблица
 * @param string $where - условие
 * @param string $sort - сортировка
 * @param string $limit - выборка
 * @return array - результат записи сообщения
 */

function getTable(object $pdo, string $table, string $where = "1", $sort = "", $limit = ""): array
{


    $sql = "SELECT * FROM `$table` 
    WHERE " . ($where == "" ? 1 : "$where")
        . ($sort == "" ? "" : " ORDER BY $sort")
        . ($limit == "" ? "" : " LIMIT $limit");

    $stmt = $pdo->prepare($sql);

    $stmt->execute();

    return $stmt->fetchAll();
}

/** 
 * функция получения количества элементов в таблице
 * @param object $pdo - объект соединения с БД
 * @param sting $table - таблица
 * @param string $where - условие
 * @return int - количество элеиментов в таблице
 */
function getCountElements(object $pdo, string $table, string $where = "1"): int
{
    $sql = "SELECT COUNT(*) as count FROM `$table` WHERE $where";


    $stmt = $pdo->prepare($sql);

    $stmt->execute();
    $arrCount = $stmt->fetchAll();
    if (count($arrCount) == 0) {
        return 0;
    }

    return $arrCount[0]['count'];
}

/** 
 * функция получения мин и макс цены
 * @param object $pdo - объект соединения с БД
 * @param string $where - условие
 * @return array - мин и макс цена
 */
function getPrice(object $pdo, string $where = "1"): array
{
    $sql = "SELECT MIN(`price`) as min, MAX(`price`) as max FROM `product` WHERE $where";

    $stmt = $pdo->prepare($sql);

    $stmt->execute();

    return $stmt->fetchAll();
}

/**
 *  @param object $pdo - объект соединения с БД
 * 
 */
function saveOrder(object $pdo)
{
    $deliv = getTable($pdo, "delivery", "`id`=" .  $_SESSION['deliv'], '`cost`');

    $sqlOrder = 'INSERT INTO `orders`
                (
                    `email`,
                    `delivery`,
                    `address`,
                    `cost_delivery`, 
                    `status_id` 
                ) 
                VALUES 
                (
                    :email,
                    :delivery,
                    :address,
                    :cost_delivery, 
                    :status_id 
                )';

    $stmtOrder = $pdo->prepare($sqlOrder);

    $stmtOrder->execute(
        [
            'email' => htmlspecialchars($_SESSION['user']['email']),
            'delivery' => $deliv[0]['id'],
            'address' => $_SESSION['user']['message'],
            'cost_delivery' => $deliv[0]['cost'],
            'status_id' => 1
        ]
    );

    $orderID = $pdo->lastInsertId('users');

    $sqlOrderList = 'INSERT INTO `order_list`
                (
                    `id`,
                    `product`, 
                    `cost`, 
                    `count`, 
                    `price`
                )
                VALUES 
                ( 
                    :id,
                    :product, 
                    :cost, 
                    :count, 
                    :price
                 )';
    $stmtOrderList = $pdo->prepare($sqlOrderList);

    foreach ($_SESSION['order'] as $value) {
        $stmtOrderList->execute(
            [
                'id' => $orderID,
                'product' => $value['id'],
                'cost' => ($value['count'] * $value['price']),
                'count' => $value['count'],
                'price' => $value['price']
            ]
        );
    }
}


/**
 * добавление пользователя
 *  @param object $pdo - объект соединения с БД
 *  
 * 
 */
function insertUser(object $pdo)
{
    foreach ($_SESSION['user'] as $key => $value) {
        $_SESSION['user'][$key] = htmlspecialchars($value);
    }

    $sql = 'INSERT INTO `users`
                ( 
                    `user`, 
                    `email`, 
                    `phone`,
                    `password`,
                    `flag_email_notification`,
                    `flag_active`,
                    `aders_dev`
                )
             VALUES 
                (
                    :user, 
                    :email, 
                    :phone,
                    :password,
                    :flag_email_notification,
                    :flag_active,
                    :aders_dev
                )';

    $stmt = $pdo->prepare($sql);

    $stmt->execute(
        [
            'user' => $_SESSION['user']['visitor'],
            'email' => $_SESSION['user']['email'],
            'phone' => $_SESSION['user']['phone'],
            'password' => isset($_SESSION['user']['password']) ? $_SESSION['user']['password'] : 'false',
            'flag_email_notification' => isset($_SESSION['user']['flag_email_notification']) ? $_SESSION['user']['flag_email_notification'] : '0',
            'flag_active' => 1,
            'aders_dev' => isset($_SESSION['user']['message']) ? $_SESSION['user']['message'] : 'false',
        ]
    );

    return $pdo->lastInsertId('users');
}

/**
 * последний id
 * @param object $pdo - объект соединения с БД
 */
function lastID(object $pdo)
{
    $sql = "SELECT LAST_INSERTED_ID()";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute();
}

/**
 * добавить новость
 * @param object $pdo - объект соединения с БД
 * @param array $new - массив с новостью
 */
function addNew(object $pdo, array $new)
{

    $sql = 'INSERT INTO  `news`
    (
        `date`, 
        `title`, 
        `new`
        ) 
        VALUES 
        (
            :date,
            :title,
            :new
        )';

    $stmt = $pdo->prepare($sql);
    return ($stmt->execute(
        [
            'date' => htmlspecialchars($new['date']),
            'title' => htmlspecialchars($new['title']),
            'new' => htmlspecialchars($new['new']),
        ]
    ));
}

/**
 * удалить данные
 * @param object $pdo - объект соединения с БД
 * @param string $table - таблица
 * @param int $id - удаляемая новость
 */
function delData(object $pdo,string $table, int $id=Null)
{
    $sql = "DELETE FROM `$table` WHERE ". ($id==Null?1:"`id`=$id");
    $stmt = $pdo->prepare($sql);
    return ($stmt->execute());
}

/**
 * изменить новость
 * @param object $pdo - объект соединения с БД
 * @param array $new - массив с новостью
 */
function updNew(object $pdo, array $new)
{

    $sql = 'UPDATE `news` 
    SET 
    `date`=:date,
    `title`=:title,
    `new`=:new 
    WHERE `id`=:id';

    $stmt = $pdo->prepare($sql);

    return ($stmt->execute(
        [
            'id' => (int) $new['idNew'],
            'date' => htmlspecialchars($new['date']),
            'title' => htmlspecialchars($new['title']),
            'new' => htmlspecialchars($new['new']),
        ]
    ));
}

/**
 * изменить сообщение
 * @param object $pdo - объект соединения с БД
 * @param array $mess - массив с сообщение
 */
function updMessage(object $pdo, array $mess)
{

    $sql = 'UPDATE `message` 
    SET 
    `dispatched`=:dispatched,
    `response`=:response
    WHERE `id`=:id';

    $stmt = $pdo->prepare($sql);

    return ($stmt->execute(
        [
            'id' => ((int) $mess['idMes']),
            'dispatched' => ((int) $mess['dispatched']),
            'response' => htmlspecialchars($mess['response']),
        ]
    ));
}
