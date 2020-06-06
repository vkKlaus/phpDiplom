<?php 
require  $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/index.php';

resetFilterSession();

//левая секция
$news = getTable($pdo, "news","", "`date` DESC"); 
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
$messages = getTable($pdo, "message","`dispatched`=1", "`date` DESC");
require  $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/header.php';
?>

<div class="row">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/views/main/sectionLeft.php' ?>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/views/main/sectionCenter.php' ?>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/views/main/sectionRight.php' ?>
</div>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/footer.php';