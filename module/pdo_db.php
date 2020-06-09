<?php



function connect()
{

    static $pdo = null;

    if ($pdo === null) {

        require  $_SERVER['DOCUMENT_ROOT'] . '/config/config_db.php';

        $dsn = 'mysql:host='.HOST.';dbname='.DB.';charset='.CHARSET;

        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        $pdo = new PDO($dsn, USER, PASS, $opt);
    }

    return $pdo;
}
