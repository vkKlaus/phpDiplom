<?php

function sentMail($data)
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


 function inBasket($id){
    if (isset($_SESSION['basket']) && in_array($id,$_SESSION['basket'])){
        return false;
    }
    $_SESSION['basket'][]=$id;
 }

function getImg($element){
   
    if (file_exists($_SERVER['DOCUMENT_ROOT'].'/images/products/'.$element.'.jpg')){
        return '/images/products/'.$element.'.jpg';
    }

    return  '/images/products/0.jpg';
 }