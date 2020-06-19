<?php

require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/index.php';

if (isset($_SESSION['user'])) {
   $_SESSION['user']=[];
}
if (isset($_SESSION['pages'])) {
   $_SESSION['pages']=[];
}


header("Location: $host");
