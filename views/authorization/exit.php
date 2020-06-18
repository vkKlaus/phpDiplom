<?php

require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/index.php';

if (isset($_SESSION['user'])) {
    unset($_SESSION['user']);
}


header("Location: $host");