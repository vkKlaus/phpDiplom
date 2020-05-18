<?php require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/header.php';

//фильтр
$brandsCatalog = getTable($pdo, 'brands', '', 'name');
$categotyCatalog = getTable($pdo, 'category', '', 'name');
$priceCatalog = getPrice($pdo);

if (isset($_POST['filterSend'])){
    $post=$_POST;
}elseif(isset($_POST['filterReset'])){
    $post=[];
    unset($_SESSION['post']);
}elseif(isset($_SESSION['post'])){
    $post=$_SESSION['post'];
}else{
    $post=[];
    unset($_SESSION['post']);
}


//каталог
$strFilter = "availability";

if (isset($_POST['filterSend'])) {

    if (isset($_POST['category']) && (count($_POST['category']) != 0)) {
        $strFilter .= ($strFilter == "" ? "" : " AND ") .  "(`category_id` IN (";
        foreach ($_POST['category'] as $elem) {
            $strFilter .= "$elem, ";
        }
        $strFilter .= "))";
    }

    if (isset($_POST['brand']) && (count($_POST['brand']) != 0)) {
        $strFilter .= ($strFilter == "" ? "" : " AND ") . "(`brand` IN (";
        foreach ($_POST['brand'] as $elem) {
            $strFilter .= "$elem, ";
        }
        $strFilter .= "))";
    }
    $strFilter = str_replace(", ))", "))", $strFilter);

    $priceMin = $_POST['priceMin'];

    $priceMax = $_POST['priceMax'];

    $strFilter .= ($strFilter == "" ? "" : " AND ") .
        "(`price` >= $priceMin AND `price` <= $priceMax)";

     $_SESSION['post']=$_POST;   
}

var_dump($strFilter);

$page = 0;
$countEl = getCountElements($pdo, "product", "availability");

if (isset($_GET['page'])) {
    $page = $_GET['page'];
}


$product = getTable($pdo, "product", $strFilter, "", "$page, 12");


$prevPage = $page - 12;
if ($prevPage < 0) {
    $prevPage = 0;
}

$nextPage = $page + 12;

if ($nextPage > $countEl - 12) {
    $nextPage = $countEl - 12;
}
?>

<div class="row">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/views/catalog/catalogLeft.php' ?>
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/views/catalog/catalogCenter.php' ?>

</div>


<?php require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/footer.php' ?>