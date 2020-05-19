<?php 
require  $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/header.php';

resetFilterSession();

if (isset($_POST['inBasket'])){
    inBasket($_POST['inBasket']);
}
//левая секция
$news = getTable($pdo, "news","", "`date`"); 
//центральная секция


$is_recom = getTable($pdo, "product", "`is_recommended`");

$page = 0;
$countEl = getCountElements($pdo, "product", "`is_new`");


if (isset($_GET['page'])) {
    $page = $_GET['page'];
}

$is_new = getTable($pdo, "product", "is_new", "", "$page, 6");


$prevPage = $page - 6;
if ($prevPage < 0) {
    $prevPage = 0;
}

$nextPage = $page + 6;

if ($nextPage > $countEl - 6) {
    $nextPage = $countEl - 6;
}
//правая секция
$messages = getTable($pdo, "message");
?>

<div class="row">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/views/main/sectionLeft.php' ?>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/views/main/sectionCenter.php' ?>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/views/main/sectionRight.php' ?>
</div>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/footer.php' ?>