<?php

function insertMessage( $pdo,  $data)
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

function getTable( $pdo, $table, $where = "1", $sort = "", $limit = "")
{


    $sql = "SELECT * FROM `$table` 
    WHERE " . ($where == "" ? 1 : "$where")
        . ($sort == "" ? "" : " ORDER BY $sort")
        . ($limit == "" ? "" : " LIMIT $limit");

    $stmt = $pdo->prepare($sql);

    $stmt->execute();

    return $stmt->fetchAll();
}


function getTableFullProducts($pdo, $where = "1", $sort = "", $limit = "")
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


function setParametr($pdo, $table, $param, $id)
{

    $sql = "UPDATE `$table` 
            SET `$param`=NOT `$param` 
            WHERE `id`=:id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute(['id' => $id]);
}



function getOrder( $pdo, array $data)
{


    $sql = "SELECT 
                `orders`.* , 
                `delivery`.name as 'devil'
            FROM `orders`  
            LEFT JOIN
                `delivery` 
            ON 
            `orders`.delivery = `delivery`.id";

    if ($data) {
        $sql .= ' WHERE `status_id` = ' . $data['status'];
    }


    $stmt = $pdo->prepare($sql);

    $stmt->execute();

    return $stmt->fetchAll();
}


function getOrderList( $pdo)
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


function getCountElements($pdo,  $table,  $where = "1")
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


function getPrice( $pdo, $where = "1")
{
    $sql = "SELECT MIN(`price`) as min, MAX(`price`) as max FROM `product` WHERE $where";

    $stmt = $pdo->prepare($sql);

    $stmt->execute();

    return $stmt->fetchAll();
}

function saveOrder( $pdo)
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



function insertUser( $pdo)
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


function lastID($pdo)
{
    $sql = "SELECT LAST_INSERTED_ID()";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute();
}


function addNew( $pdo, $new)
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


function delData($pdo, $table, $id = Null)
{
    $sql = "DELETE FROM `$table` WHERE " . ($id == Null ? 1 : "`id`=$id");
    $stmt = $pdo->prepare($sql);
    return ($stmt->execute());
}

function updNew( $pdo,  $new)
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


function updMessage( $pdo, $mess)
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


function changeStatus($pdo,  $status)
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


function setUserGroup( $pdo, $data)
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


function saveParametr( $pdo,  $table, $data)
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


function savePrice($pdo,  $data)
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

function saveProduct( $pdo,  $data,  $img)
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
    } else {
        $sql = "UPDATE `product` 
                SET 
                    `name`=:name, 
                    `category_id`=:category_id,
                    `price`=:price, 
                    `count`=:count, 
                    `brand`=:brand, 
                    `availability`=:availability,
                    `description`=:description,
                    `is_new`=:is_new, 
                    `is_recommended`=:is_recommended
                WHERE `id`=:id";
    }

    $stmt = $pdo->prepare($sql);

    $result=$stmt->execute(
        [
            'name' => $data['name'],
            'category_id' => $data['category'],
            'price' => $data['price'],
            'count' => $data['count'],
            'brand' => $data['brand'],
            'availability' => $data['availability'],
            'description' => $data['description'],
            'is_new' => $data['new'],
            'is_recommended' => $data['recommended'],
            'id' => $data['id'],
        ]
    );

    if ($result){
        if ($img['fileImg']['size'] != 0){
            if (move_uploaded_file($img['fileImg']['tmp_name'], 
                    $_SERVER['DOCUMENT_ROOT'].'/images/products/'.$data['id'].'.jpg')) {
                    return true;    
            }
        }
    }

    return false;
}
