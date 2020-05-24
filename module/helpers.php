<?php

/**
 * функция отправки сообщения на почту
 * @param array - $data массив с данными
 * @return bool - результат отправки сообщения
 */
function sentMail(array $data): bool
{
    $name = $data["visitor"];
    $email = $data["email"];
    $message = $data["message"];

    $EmailTo = "emailaddress@test.com";
    $Subject = "New Message Received";

    $Body  = "Name: ";
    $Body .= $name;
    $Body .= "n";

    $Body .= "Email: ";
    $Body .= $email;
    $Body .= "n";

    $Body .= "Message: ";
    $Body .= $message;
    $Body .= "n";

    //  return = mail($EmailTo, $Subject, $Body, "From:" . $email);

    return true;
}

/**Очистка сессии-фильтр
 * 
 */
function resetFilterSession()
{
    if (isset($_SESSION['post'])) {
        unset($_SESSION['post']);
    }

    if (isset($_SESSION['sort'])) {
        $_SESSION['sort']['name']='ASC';
        $_SESSION['sort']['cost']='';
    }
}

/**Поместить в корзину
 * @param int - идентификатор товара
 */

 function inBasket(int $id){
    if (isset($_SESSION['basket']) && in_array($id,$_SESSION['basket'])){
        return false;
    }
    $_SESSION['basket'][]=$id;
 }