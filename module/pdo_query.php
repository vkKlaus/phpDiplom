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
 * @return array - результат  сообщения
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
 * получение полной информации по продуку для вывода
 *  @param object $pdo - объект соединения с БД
 * @param string $where - условие
 * @param string $sort - сортировка
 * @param string $limit - выборка
 * @return array - результат  сообщения
 */
function getTableFullProducts(object $pdo, string $where = "1", $sort = "", $limit = ""): array
{


    $sql = "SELECT `product`.*, 
                    `brands`.name as 'brandName', 
                    `category`.name as 'categoryName'
            FROM `product` 
            LEFT JOIN `brands` 
            ON `product`.`brand` = `brands`.`id`
            LEFT JOIN `category` 
            ON `product`.`category_id` = `category`.`id` 
            WHERE " . ($where == "" ? 1 : "$where")
        . ($sort == "" ? "" : " ORDER BY $sort")
        . ($limit == "" ? "" : " LIMIT $limit");

    $stmt = $pdo->prepare($sql);

    $stmt->execute();

    return $stmt->fetchAll();
}

/**
 * установка параметра продукта
 */
function setParametr($pdo, $table, $param, $id)
{

    $sql = "UPDATE `$table` 
            SET `$param`=NOT `$param` 
            WHERE `id`=:id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute(['id' => $id]);
}

/**
 * функция получения  таблицы заказов
 * @param object $pdo - объект соединения с БД
 * @param int $idStatus - массив с данными
 * @return array - результат  сообщения
 */

function getOrder(object $pdo, int $idStatus): array
{


    $sql = "SELECT 
                `orders`.* , 
                `delivery`.name as 'devil'
            FROM `orders`  
            LEFT JOIN
                `delivery` 
            ON 
            `orders`.delivery = `delivery`.id";

    if ($idStatus != -1) {
        $sql .= ' WHERE `status_id` = ' . $idStatus;
    }


    $stmt = $pdo->prepare($sql);

    $stmt->execute();

    return $stmt->fetchAll();
}

/**
 * функция получения  таблицы заказов
 * @param object $pdo - объект соединения с БД
 * @return array - результат  сообщения
 */

function getOrderList(object $pdo): array
{


    $sql = "SELECT 
                `order_list`.* , 
                `product`.name as 'product_name'
            FROM 
                `order_list`  
            LEFT JOIN
                `product` 
            ON 
                `order_list`.product = `product`.id";


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
    $sql = "SELECT COUNT(*) as count FROM `$table` WHERE " . ($where == "" ? 1 : "$where");

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

/** сохраняем заказ
 * 
 *  @param object $pdo - объект соединения с БД
 */
function saveOrder(object $pdo)
{
    $deliv = getTable($pdo, "delivery", "`id`=" .  $_SESSION['deliv'], '`cost`');

    $cost_product = 0;
    foreach ($_SESSION['order'] as $value) {
        $cost_product += ($value['count'] * $value['price']);
    };

    $sqlOrder = 'INSERT INTO `orders`
                (
                    `user`,
                    `email`,
                    `delivery`,
                    `address`,
                    `cost_delivery`, 
                    `cost_product`, 
                    `cost_total`, 
                    `status_id` 
                ) 
                VALUES 
                (
                    :user,
                    :email,
                    :delivery,
                    :address,
                    :cost_delivery, 
                    :cost_product, 
                    :cost_total, 
                    :status_id 
                )';

    $stmtOrder = $pdo->prepare($sqlOrder);

    $result = $stmtOrder->execute(
        [
            'user' => htmlspecialchars($_SESSION['user']['visitor']),
            'email' => htmlspecialchars($_SESSION['user']['email']),
            'delivery' => $deliv[0]['id'],
            'address' => $_SESSION['user']['message'],
            'cost_delivery' => $deliv[0]['cost'],
            'cost_product' => $cost_product,
            'cost_total' => ($deliv[0]['cost'] + $cost_product),
            'status_id' => 1
        ]
    );

    if (!$result) {
        return 'ошибка записи заказа';
    }
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
        $result = $stmtOrderList->execute(
            [
                'id' => $orderID,
                'product' => $value['id'],
                'cost' => ($value['count'] * $value['price']),
                'count' => $value['count'],
                'price' => $value['price']
            ]
        );

        if (!$result) {
            return 'ошибка записи листа товаров';
        }
    }

    return $orderID;
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
function delData(object $pdo, string $table, int $id = Null)
{
    $sql = "DELETE FROM `$table` WHERE " . ($id == Null ? 1 : "`id`=$id");
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

/** изменить статус
 * @param object $pdo - объект соединения с БД
 * @param array $status - массив с сообщение
 */
function changeStatus(object $pdo, array $status)
{
    $sql = 'UPDATE `orders` 
    SET 
    `status_id`=:status_id
    WHERE `id`=:id';

    $stmt = $pdo->prepare($sql);

    return ($stmt->execute(
        [
            'id' => ((int) $status['orderID']),
            'status_id' => ((int) $status['status']),
        ]
    ));
}

/** добавляем пользователя в группу 
 *  @param object $pdo подключение
 *  @param array $data данные
 */

function setUserGroup(object $pdo, array $data)
{

    $sql = 'DELETE
     FROM `group_user`
    WHERE `user_id`=:id';

    $stmt = $pdo->prepare($sql);

    $stmt->execute(
        [
            'id' => ((int) $data['userID']),
        ]
    );

    $sql = 'INSERT 
                INTO `group_user`
                    (`user_id`, 
                    `group_id`)
                VALUES (:user_id,
                        :group_id)';

    $stmt = $pdo->prepare($sql);

    foreach ($data['checkBox'] as $role) {

        $stmt->execute(
            [
                'user_id' => ((int) $data['userID']),
                'group_id' => ((int) $role),
            ]
        );
    }
}

/** добавляем / обновляем данные
 *  @param object $pdo подключение
 *  @param string $table таблица
 *  @param array $data данные
 */
function saveParametr(object $pdo, string $table, array $data)
{

    if ($data['id'] == '') {
        $sql = "SELECT MAX(`id`) as maxID FROM `$table`";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $data['id'] = $result[0]['maxID'] + 1;

        $sql = "INSERT 
        INTO `$table`
            ( 
                `id`, 
                `name`, 
                `status`
            )
        VALUES 
            (
                :id,
                :name,
                :status
            )";
    } else {
        $sql = "UPDATE `$table` 
                SET 
                    `name`=:name,
                    `status`=:status 
                WHERE `id`=:id";
    }


    $stmt = $pdo->prepare($sql);
    $stmt->execute(
        [
            'name' => $data['name'],
            'status' => $data['status'],
            'id' => $data['id']

        ]
    );
}

/** добавляем / обновляем данные
 *  @param object $pdo подключение

 *  @param array $data данные
 */
function savePrice(object $pdo, array $data)
{


    $sql = "UPDATE `product` 
                SET 
                    `price`=:price,
                    `count`=:count 
                WHERE `id`=:id";



    $stmt = $pdo->prepare($sql);
    $stmt->execute(
        [
            'price' => $data['price'],
            'count' => $data['count'],
            'id' => $data['btnSavePrice']

        ]
    );
}

/** добавляем / обновляем данные
 *  @param object $pdo подключение
 *  @param array $data данные
 *  @param array $img данные изображения
 */
function saveProduct(object $pdo, array $data, array $img)
{


    if ($data['id'] == '') {
        $sql = "SELECT MAX(`id`) as maxID FROM `product`";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $data['id'] = $result[0]['maxID'] + 1;
        $sql = "INSERT 
            INTO `product`
                ( 
                    `id`, 
                    `name`, 
                    `category_id`,
                    `price`, 
                    `count`, 
                    `brand`, 
                    `availability`,
                    `description`,
                    `is_new`, 
                    `is_recommended`
                        )
            VALUES 
                (
                    :id, 
                    :name, 
                    :category_id,
                    :price, 
                    :count, 
                    :brand, 
                    :availability,
                    :description,
                    :is_new, 
                    :is_recommended
                )";


        $parametrs =  [
            'name' => $data['name'],
            'category_id' => $data['category'],
            'price' => $data['price'],
            'count' => $data['count'],
            'brand' => $data['brand'],
            'availability' =>  $data['availability'],
            'description' => $data['description'],
            'new' => $data['new'],
            'recommended' => $data['recommended'],
            'id' => $data['id'],
        ];
    } else {
        $sql = "SELECT `availability`,`is_new`, `is_recommended` FROM `product` WHERE `id` = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' =>  $data['id'],]);
        $result = $stmt->fetchAll();

        $availability = $result[0]['availability'] != $data['availability'] ? 'NOT' : '';
        $new = $result[0]['is_new'] != $data['new'] ? 'NOT' : '';
        $recommended = $result[0]['is_recommended'] != $data['recommended'] ? 'NOT' : '';


        $sql = "UPDATE `product` 
                SET 
                    `name`=:name, 
                    `category_id`=:category_id,
                    `price`=:price, 
                    `count`=:count, 
                    `brand`=:brand,
                    `description`=:description,
                    `availability`= $availability `availability`,
                    `is_new`= $new  `is_new`,
                    `is_recommended`= $recommended  `is_recommended`
            WHERE `id`=:id";

        $parametrs =  [
            'name' => $data['name'],
            'category_id' => $data['category'],
            'price' => $data['price'],
            'count' => $data['count'],
            'brand' => $data['brand'],
            'description' => $data['description'],
            'id' => $data['id'],
        ];
    }

    $stmt = $pdo->prepare($sql);

    $result = $stmt->execute($parametrs);

    if ($result) {
        if ($img['fileImg']['size'] != 0) {
            if (move_uploaded_file(
                $img['fileImg']['tmp_name'],
                $_SERVER['DOCUMENT_ROOT'] . '/images/products/' . $data['id'] . '.jpg'
            )) {
                return true;
            }
        }
    }

    return false;
}

/** получаем пользователя
 *  @param object $pdo подключение
 *  @param ыекштп $data данные пользователя
 *  @return array user
 */
function getUser($pdo,  $login, $field)
{
    $login =  htmlspecialchars($login, ENT_QUOTES);

    $sql = "SELECT * FROM `users` WHERE `$field`=:login LIMIT 1";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        'login' => $login
    ]);

    $users = $stmt->fetchAll();

    if (count($users) == 0) {
        return [];
    }

    return $users[0];
}


/** обновляем пароль
 *  @param object $pdo подключение
 *  @param array $data данные пользователя
 *  @return bool результат 
 */
function addUser($pdo, $data)
{

    $login = htmlspecialchars($data['login'], ENT_QUOTES);

    $email = htmlspecialchars($data['email'], ENT_QUOTES);

    $phone = htmlspecialchars($data['phone'], ENT_QUOTES);

    $password = password_hash($data['password_1'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO `users` 
    (
        `email`,
        `phone`,
        `password`,
        `user`
      
    ) 
    values 
    (
        '$email',
        '$phone', 
        '$password',
        '$login'      
        )";

    $stmt = $pdo->prepare($sql);

    $result = $stmt->execute();

    if ($result) {
        return getUser($pdo, $login, 'user');
    } else {
        return [];
    }
};

/** обновляем пароль
 *  @param object $pdo подключение
 *  @param array $data данные пользователя
 *  @return bool результат обновления
 */

function updatePassword($pdo, $data)
{
    $password = password_hash($data['password_1'], PASSWORD_BCRYPT);

    $sql = " UPDATE `users`
     SET `password`=:pass
     WHERE `user`=:user";

    $stmt = $pdo->prepare($sql);

    return ($stmt->execute([
        'user' => $data['login'],
        'pass' => $password,
    ]));
}

/** получаем список страниц
 *  @param object $pdo подключение
 *  @param array $data данные пользователя
 *  @return array доступные странницы
 */
function getPages($pdo, $data)
{
    if (!$data) {
        return [];
    }
    $sql = 'SELECT DISTINCT  `pages`.`page` 
                FROM `group_user`
                LEFT JOIN `group_page` 
                    ON `group_user`.`group_id`=`group_page`.`group_id` 
                LEFT JOIN `pages` 
                    ON `group_page`.`page_id`=`pages`.`id` 
                WHERE `group_user`.`user_id`=:id';

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        'id' => $data['id'],
    ]);

    return (array_column($stmt->fetchAll(), 'page'));
}
