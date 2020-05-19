<?php require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/header.php';

//фильтр
$brandsCatalog = getTable($pdo, 'brands', '', 'name');
$categotyCatalog = getTable($pdo, 'category', '', 'name');
$priceCatalog = getPrice($pdo);

if (isset($_POST['filterSend'])){
    $post=$_POST;
    $_GET['page']=0;
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

if (isset($post['filterSend'])) {

    if (isset($post['category']) && (count($post['category']) != 0)) {
        $strFilter .= ($strFilter == "" ? "" : " AND ") .  "(`category_id` IN (";
        foreach ($post['category'] as $elem) {
            $strFilter .= "$elem, ";
        }
        $strFilter .= "))";
    }

    if (isset($post['brand']) && (count($post['brand']) != 0)) {
        $strFilter .= ($strFilter == "" ? "" : " AND ") . "(`brand` IN (";
        foreach ($post['brand'] as $elem) {
            $strFilter .= "$elem, ";
        }
        $strFilter .= "))";
    }
    $strFilter = str_replace(", ))", "))", $strFilter);

    $priceMin = $post['priceMin'];

    $priceMax = $post['priceMax'];

    $strFilter .= ($strFilter == "" ? "" : " AND ") .
        "(`price` >= $priceMin AND `price` <= $priceMax)";

     $_SESSION['post']=$post;   
}

$page = 0;
$countEl = getCountElements($pdo, "product", $strFilter);

if (isset($_GET['page'])) {
    $page = $_GET['page'];
}


$product = getTable($pdo, "product", $strFilter, "", "". ($page <0 ? 0: $page).", 12");


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