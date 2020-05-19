<div class="col-6">
    <h2 class="text-center text-primary">Nовые поступления</h2>

    <?php for ($i = 0; $i < count($is_new); $i) {    ?>
        <div class="d-flex flex-row">
            <?php for ($j = 1; $j <= 3; $j++) { ?>
                <div class="card_container">
                    <img src="/images/products/<?= $is_new[$i]['id'] ?>.jpg" class="card_img" alt="...">

                    <p class="card_price"><?= $is_new[$i]['price'] . '$'  ?></p>

                    <form method="POST">
                        <button type="submit" class="card_btn btn btn-primary" name="inBasket" value="<?= $is_new[$i]['id'] ?>"><i class="fa fa-shopping-cart"></i></button>
                    </form>

                    <a href="/views/product/?idProduct=<?= $is_new[$i]['id'] ?>" class="card_name"><?= $is_new[$i]['name'] ?></a>

                </div>
            <?php
                $i++;
                if ($i >= count($is_new)) {

                    break;
                } else {
                }
            } ?>
        </div>
    <?php } ?>



    <nav aria-label="Page navigation ">
        <ul class="pagination justify-content-center pagination-lg">
            <li class="page-item">
                <a class="page-link" href="/?page=<?= $prevPage ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            <li class="page-item">
                <a class="page-link" href="/?page=<?= $nextPage ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>

    <br>
    <hr>

    <h2 class="text-center text-primary">Rекомендуем</h2>
    <div class="owl-carousel owl-theme">
        <?php foreach ($is_recom as $item_recom) { ?>
            <div class="item-recom">

                <img src="/images/products/<?= $item_recom['id'] ?>.jpg" alt="<?= $item_recom['name'] ?>" class="img-recom">

                <a href="/views/product/?idProduct=<?= $item_recom['id'] ?>&type=view" class="name-recom"><?= $item_recom['name'] ?></a>

                <div class="price-recom"><?= $item_recom['price'] ?>$</div>

                <form method="POST">
                    <button type="submit" class="card_btn btn btn-primary" name="inBasket" value="<?= $item_recom['id'] ?>"><i class="fa fa-shopping-cart"></i></button>
                </form>

            </div>
        <? } ?>
    </div>
</div>