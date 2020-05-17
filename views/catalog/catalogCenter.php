<?php

$strFilter = "availability";

if (isset($_POST['filertSend'])) {

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
}

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

<div class="col-9">
    <h2 class="text-center text-primary">Каталог товаров</h2>

    <?php for ($i = 0; $i < count($product); $i) {    ?>
        <div class="d-flex flex-row">
            <?php for ($j = 1; $j <= 4; $j++) { ?>
                <div class="card_container">
                    <img src="/images/products/<?= $product[$i]['id'] ?>.jpg" class="card_img" alt="...">

                    <p class="card_price"><?= $product[$i]['price'] . '$'  ?></p>

                    <a href="#" class="btn btn-primary card_btn"><i class="fa fa-shopping-cart"></i></a>

                    <p class="card_name"><?= $product[$i]['name'] ?></p>

                </div>
            <?php
                $i++;
                if ($i >= count($product)) {

                    break;
                } else {
                }
            } ?>
        </div>

    <?php } ?>



    <nav aria-label="Page navigation ">
        <ul class="pagination justify-content-center pagination-lg">
            <li class="page-item">
                <a class="page-link" href="/views/catalog/?page=<?= $prevPage ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            <li class="page-item">
                <a class="page-link" href="/views/catalog/?page=<?= $nextPage ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>

</div>