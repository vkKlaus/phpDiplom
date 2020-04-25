<?php
require $_SERVER['DOCUMENT_ROOT'] . '/module/helpers.php';

/**
 * функция записи сообщения посетителя
 * @param object $pdo - объект соединения с БД
 * @param array $data - массив с данными сообщения
 * @return bool - результат записи сообщения
 */

function insertMessage(object $pdo,  array $data): bool
{

    foreach ($data as $key=>$value){
        $data[$key]=htmlspecialchars($value);  
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
                'visitor'=>$data['visitor'],
                'email'=>$data['email'],
                'phone'=>$data['phone'],
                'message'=>$data['message'],
                'dispatched'=>$data['dispatched'],
            ]
            )
        );
}

/**
 * функция получения полных таблиц
 * @param object $pdo - объект соединения с БД
 * @param sting $table - таблица
 * @param string $where - условие
 * @return array - результат записи сообщения
 */

function getTable(object $pdo, string $table, string $where="1"): array
{
    $sql = "SELECT * FROM `$table` WHERE $where";
                
    $stmt = $pdo->prepare($sql);

    $stmt->execute();
   
    return $stmt->fetchAll();
}
