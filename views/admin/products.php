<?php
require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/index.php';
resetFilterSession();

$products = getTable($pdo, 'product');

require  $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/header.php';
?>
<?php foreach ($products as $product) { ?>
    <div class="row">
        <div class="col-2">
            <img src="/images/products/<?= $product['id'] ?>.jpg" alt=""  class="card_img"  >
        </div>
        <div class="col-10">
            <
        </div>
    </div>
<?php } ?>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/footer.php';
