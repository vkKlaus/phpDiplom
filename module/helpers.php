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