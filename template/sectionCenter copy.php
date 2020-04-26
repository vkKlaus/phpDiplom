<?php
$is_recom = getTable($pdo,"product","is_recommended"); 
$contPage = (int) (count($is_recom) / 3);
if ((count($is_recom) % 3) != 0) {
    $contPage++;
}

?>

<div class="section-center bg-light">
    <h2 class="text-center bg-light">Rекомендуем</h2>
    <div id="carouselExampleIndicators" class="carousel slide carousel-fade bg-white" data-ride="carousel" data-interval="1000">
        <ol class="carousel-indicators mb-0">
            <?php for ($i = 0; $i < $contPage; $i++) { ?>
                <li data-target="#carouselExampleIndicators" data-slide-to="<?= $i ?>" class="bg-dark <?= $i == 0 ? 'active' : '' ?>"></li>
            <?php } ?>
        </ol>

        <div class="carousel-inner">
            <?php for ($i = 0; $i < $contPage; $i++) { ?>
                <div class="carousel-item <?= $i == 0 ? 'active' : '' ?> mr-5">
                    <div class="d-flex justify-content-center flex-wrap row">
                        <?php for ($j = 0; $j < 3; $j++) {
                             if (isset($is_recom[$i * 3 + $j]['id'])) {?>

                            <div class="col-3 mr-1 ml-1 card card-recom">
                             
                                   <img src="/images/products/<?= $is_recom[$i * 3 + $j]['id'] ?>.jpg" class="card-img-top img__product_small mt-1" alt="...">

                                   <!--   <div class="card-body card-body-new">
                                        <p class="card-title"><?= $is_recom[$i * 3 + $j]['name'] ?></p>

                                        <a href="#" class="btn btn-primary">купить</a>
                                    </div> -->
                              
                            </div>
                        <?php }} ?>
                    </div>
                </div>
            <?php } ?>
        </div>

        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="text-dark mr-5" aria-hidden="true"><i class="far fa-arrow-alt-circle-left fa-3x"></i></span>
            <span class="sr-only text-dark">Previous</span>
        </a>

        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="text-dark ml-5" aria-hidden="true"><i class="far fa-arrow-alt-circle-right fa-3x"></i></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>