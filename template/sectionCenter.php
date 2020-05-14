<?php
$is_new = getTable($pdo, "product", "is_new");
$is_recom = getTable($pdo, "product", "is_recommended");
?>

<div class="col-6 bg-white">
    <h2 class="text-center text-primary">Nовые поступления</h2>
    <?php foreach($is_new as $item_new){?>
        

    <?php } ?>
    <h2 class="text-center text-primary">Rекомендуем</h2>
    <div class="owl-carousel owl-theme">
        <?php foreach ($is_recom as $item_recom) { ?>
            <div class="item">
                <a href="#" data="<?= $item_recom['id']?>">
                    <img src="/images/products/<?= $item_recom['id']?>.jpg" alt="<?= $item_recom['name']?>" class="img-recom">
                    <p class="mt-3 text-primary"><?= $item_recom['name']?></p>
                </a>
            </div>
        <? } ?>
    </div>
</div>