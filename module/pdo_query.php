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
