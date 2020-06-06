<?php

require  $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/index.php';

resetFilterSession();

if (isset($_GET['idProduct'])) {
    $products = getTable($pdo, "product", "id=" . $_GET['idProduct']);
    if (count($products) != 0) {
        $product = $products[0];
    }
}
require  $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/header.php';
?>

<div class="product-card">

    <a href="<?= $_SERVER["HTTP_REFERER"] ?>" class="product-card_close text-right"><i class="fas fa-window-close"></i></a>
  
    <img src="/images/products/<?= $product['id'] ?>.jpg" class="product-card_img" alt="<?= $product['name'] ?>">

    <h4 class="product-card_name"><?= $product['name'] ?></h4>

    <p class="product-card_description "><?= $product['description'] ?></p>

    <p class="product-card_price"><?= $product['price'] ?>$</p>

    <div class="product-card_btn text-right">
        <form method="POST">
            <button type="submit" class="btn btn-primary btn-lg product_btn" name="inBasket" value="<?= $product['id'] ?>"><i class="fa fa-shopping-cart"></i></button>
        </form>
    </div>
</div>




<?php require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/footer.php';
