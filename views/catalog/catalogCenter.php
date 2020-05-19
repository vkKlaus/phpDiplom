<div class="col-9">
    <h2 class="text-center text-primary">Каталог товаров</h2>

    <?php for ($i = 0; $i < count($product); $i) {    ?>
        <div class="d-flex flex-row">
            <?php for ($j = 1; $j <= 4; $j++) { ?>
                <div class="card_container">
                    <img src="/images/products/<?= $product[$i]['id'] ?>.jpg" class="card_img" alt="...">

                    <p class="card_price"><?= $product[$i]['price'] . '$'  ?></p>

                    <form method="POST">
                        <button type="submit" class="card_btn btn btn-primary" name="inBasket" value="<?= $product[$i]['id'] ?>"><i class="fa fa-shopping-cart"></i></button>
                    </form>
   
                    <a href="/views/product/?idProduct=<?= $product[$i]['id'] ?>" class="card_name"><?= $product[$i]['name'] ?></a>
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