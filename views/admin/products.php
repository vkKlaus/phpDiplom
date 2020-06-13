<?php
require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/index.php';
resetFilterSession();


if (isset($_POST['availability'])) {
    setParametr($pdo, 'product', 'availability', $_POST['availability']);
}
if (isset($_POST['new'])) {
    setParametr($pdo, 'product', 'is_new', $_POST['new']);
}
if (isset($_POST['recommended'])) {
    setParametr($pdo, 'product', 'is_recommended', $_POST['recommended']);
}

if (isset($_POST['edit'])) {
    $product = getTableFullProducts($pdo, "`product`.`id`=" . $_POST['edit']);
    var_dump($product[0]);
}


if (!isset($_SESSION['brand'])) {
    $_SESSION['brand'] = 0;
}

if (!isset($_SESSION['category'])) {
    $_SESSION['category'] = 0;
}

if (!isset($_SESSION['new'])) {
    $_SESSION['new'] = -1;
}

if (!isset($_SESSION['recommend'])) {
    $_SESSION['recommend'] = -1;
}

if (!isset($_SESSION['availability'])) {
    $_SESSION['availability'] = -1;
}

if (isset($_POST['select'])) {
    $brand = $_SESSION['brand'] = $_POST['brand'];
    $category = $_SESSION['category'] = $_POST['category'];
    $new =  $_SESSION['new'] = $_POST['new'];
    $recommend =  $_SESSION['recommend'] = $_POST['recommend'];
    $availability =  $_SESSION['availability'] = $_POST['availability'];
} else {
    $brand = $_SESSION['brand'];
    $category = $_SESSION['category'];
    $new =  $_SESSION['new'];
    $recommend =  $_SESSION['recommend'];
    $availability =  $_SESSION['availability'];
};

$where = '';

if ($brand) {
    $where .= '`brand`=' . $brand;
}

if ($category) {
    $where .= ($where != '' ? ' AND ' : '') . '`category_id`=' . $category;
}

if ($new != -1) {
    $where .= ($where != '' ? ' AND ' : '') . '`is_new`=' . $new;
}

if ($recommend != -1) {
    $where .= ($where != '' ? ' AND ' : '') . '`is_recommended`=' . $recommend;
}

if ($availability != -1) {
    $where .= ($where != '' ? ' AND ' : '') . '`availability`=' . $availability;
}


$products = getTableFullProducts($pdo, $where);
require  $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/header.php';
?>

<div>

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#productList">Список товаров</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#product">Товар</a>
        </li>
    </ul>


    <div class="tab-content">
        <div id="productList" class="container tab-pane active">
            <h3 class="text-info">Список товаров</h3>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/views/admin/productsList.php' ?>
        </div>

        <div id="product" class="container tab-pane fade ">
            <h3 class="text-info">Товар</h3>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/views/admin/productsProduct.php' ?>
        </div>
    </div>
</div>
</div>



<?php require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/footer.php';
