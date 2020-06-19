<?php
require $_SERVER['DOCUMENT_ROOT'] . '/module/pdo_db.php';
require $_SERVER['DOCUMENT_ROOT'] . '/module/pdo_query.php';
require $_SERVER['DOCUMENT_ROOT'] . '/module/helpers.php';


ini_set('session.gc_maxlifetime', 3600);
ini_set('session.cookie_lifetime', 3600);

session_start();

$pdo = connect();
$pages=[];
$requestUri=$_SERVER['REQUEST_URI'];
if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = [];
}

if (!isset($_SESSION['pages'])) {
    $_SESSION['pages'] = [];
}

if (isset($_SERVER['HTTP_REFERER'])) {
    $host = $_SERVER['HTTP_REFERER'];
    $pos = strpos($host, 'views');

    if ($pos != false) {
        $host = substr($host, 0, $pos - 1);
    }
} else {
    $host = $_SERVER['HTTP_HOST'] . ':85';
}

if (isset($_POST['inBasket'])) {
    inBasket($_POST['inBasket']);
}

if (isset($_SESSION['basket'])) {
    $inBasket = count($_SESSION['basket']);
} else {
    $inBasket = 0;
}




if (strpos($requestUri, 'admin')) {
;
    if (!$_SESSION['user']) {
        header("Location: /");
    } else {
        $pages = getPages($pdo, $_SESSION['user']);
        if (!$pages) {
            header("Location: /");
        } else {
    
            $rezStr = str_replace('/views/admin/', "", $requestUri);
            $rezStr = str_replace('.php', "", $rezStr);

            if (! in_array($rezStr, $pages)){
                header("Location: /");
            }
  
        }
    }
}
