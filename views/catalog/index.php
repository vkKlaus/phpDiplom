<?php require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/index.php';

if (isset($_GET['basket']) && ($_GET['basket'] == 'del')) {
    if (isset($_SESSION['order'])) {
        unset($_SESSION['order']);
    }
    if (isset($_SESSION['basket'])) {
        unset($_SESSION['basket']);
        $inBasket = 0;
    }
}

//фильтр
$brandsCatalog = getTable($pdo, 'brands', '`status`=1', 'name');
$brandList = '~';
foreach ($brandsCatalog as $el) {
    $brandList .= ',' . $el['id'];
}

$brandList = str_replace('~,', '', $brandList);

if ($brandList == '~') {
    $brandList = ' `brand` IN (-1)';
} else {
    $brandList = ' `brand` IN (' . $brandList . ')';
}

$categoryCatalog = getTable($pdo, 'category', '`status`=1', 'name');
$categoryList = '~';
foreach ($categoryCatalog  as $el) {
    $categoryList .= ',' . $el['id'];
}

$categoryList = str_replace('~,', '', $categoryList);

if ($categoryList == '~') {
    $categoryList = ' `category_id` IN (-1)';
} else {
    $categoryList = ' `category_id` IN (' . $categoryList . ')';
}


$priceCatalog = getPrice($pdo);

if (isset($_POST['filterSend'])) {
    $post = $_POST;

    $_GET['page'] = 0;
} elseif (isset($_POST['filterReset'])) {
    $post = [];

    unset($_SESSION['post']);
} elseif (isset($_SESSION['post'])) {
    $post = $_SESSION['post'];
} else {
    $post = [];

    unset($_SESSION['post']);
}

if (!isset($_SESSION['sort']['name'])) {
    $_SESSION['sort']['name'] = '';
}

if (!isset($_SESSION['sort']['cost'])) {
    $_SESSION['sort']['cost'] = '';
}


if (isset($_GET['name']) || isset($_GET['cost'])) {
    if (isset($_GET['name'])) {
        $sortName = $_GET['name'] == 'ASC' ? 'DESC' : 'ASC';

        $sortCost = '';
    } else {
        $sortName = '';
    }

    if (isset($_GET['cost'])) {
        $sortCost = $_GET['cost'] == 'ASC' ? 'DESC' : 'ASC';

        $sortName = '';
    } else {
        $sortCost = '';
    }

    $_SESSION['sort']['name'] = $sortName;

    $_SESSION['sort']['cost'] = $sortCost;
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

    $_SESSION['post'] = $post;
}

$page = 0;
$countEl = getCountElements($pdo, "product", $strFilter);

if (isset($_GET['page'])) {
    $page = $_GET['page'];
}

$sortName = $_SESSION['sort']['name'];

$sortCost = $_SESSION['sort']['cost'];


$strFilter .= ($strFilter == "" ? "" : " AND ") . "$brandList AND $categoryList";


$product = getTable(
    $pdo,
    "product",
    $strFilter,

    ($sortName == '' ? '' : "`name` " . $sortName) .
        ($sortCost == '' ? '' : "`price` " . $sortCost),
    "" . ($page < 0 ? 0 : $page) . ", 12"
);

$prevPage = $page - 12;

if ($prevPage < 0) {
    $prevPage = 0;
}

$nextPage = $page + 12;

if ($nextPage > $countEl - 12) {
    $nextPage = $countEl - 12;
}

require  $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/header.php';
?>

<div class="row">
    <?php require $_SERVER['DOCUMENT_ROOT'] . '/views/catalog/catalogLeft.php' ?>

    <?php require $_SERVER['DOCUMENT_ROOT'] . '/views/catalog/catalogCenter.php' ?>
</div>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/footer.php';
