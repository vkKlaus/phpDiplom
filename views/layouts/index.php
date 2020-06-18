<?php
require $_SERVER['DOCUMENT_ROOT'] . '/module/pdo_db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/module/pdo_query.php';
require $_SERVER['DOCUMENT_ROOT'] . '/module/helpers.php';

$requestUri = $_SERVER['REQUEST_URI'];

session_start();

$pdo = connect();

if (isset($_SERVER['HTTP_REFERER'])) {
    $host = $_SERVER['HTTP_REFERER'];
    $pos = strpos($host, 'views');

    if ($pos != false) {
        $host = substr($host, 0, $pos - 1);
    }
}
else{
    $host = '';
}


if (isset($_POST['inBasket'])) {
    inBasket($_POST['inBasket']);
}

if (isset($_SESSION['basket'])) {
    $inBasket = count($_SESSION['basket']);
} else {
    $inBasket = 0;
}

if (!isset($_SESSION['user'])){
    $_SESSION['user']=[];
}

if (!isset($_SESSION['pages'])){
    $_SESSION['pages']=[];
}
?>
