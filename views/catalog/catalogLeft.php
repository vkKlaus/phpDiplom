<?php
$brandsCatalog = getTable($pdo, 'brands', '', 'name');
$categotyCatalog = getTable($pdo, 'category', '', 'name');
$priceCatalog = getPrice($pdo);
?>

<div class="col-3">
    <form method="POST" class="filterCatalog">
        <h4>Категории</h4>

        <fieldset class="scroll_space">
            <?php foreach ($categotyCatalog as $category) { ?>
                <div>
                    <input type="checkbox" name="category[]" value="<?= $category['id'] ?>" <?= isset($_POST['category']) && in_array($category['id'], $_POST['category']) ? "checked" : "" ?>>

                    <?= $category['name'] ?>


                </div>
            <?php } ?>
        </fieldset>

        <hr>

        <h4>Бренды</h4>

        <fieldset class="scroll_space">
            <?php foreach ($brandsCatalog as $brand) { ?>
                <div>
                    <input type="checkbox" name="brand[]" value="<?= $brand['id'] ?>" <?= isset($_POST['brand']) && in_array($brand['id'], $_POST['brand']) ? "checked" : "" ?>> <?= $brand['name'] ?>
                </div>
            <?php } ?>
        </fieldset>

        <hr>

        <h4>Цена</h4>

        <legend>
            <span>от</span>

            <input type="number" id="price-min" min="<?= $priceCatalog[0]['min'] ?>" max="<?= $priceCatalog[0]['max'] ?>" name="priceMin" class="filterPrice" value="<?= isset($_POST['priceMin']) ? $_POST['priceMin'] : (int) $priceCatalog[0]['min'] ?>">
        </legend>

        <legend>
            <span>до</span>

            <input type="number" id="price-max" min="<?= $priceCatalog[0]['min'] ?>" max="<?= $priceCatalog[0]['max'] ?>" name="priceMax" class="filterPrice" value="<?= isset($_POST['priceMax']) ? $_POST['priceMax'] :(int) $priceCatalog[0]['max'] ?>">
        </legend>

        <input type="submit" id="filter-submit" class="btn btn-info btn-lg float-right mt-5" name="filertSend" value="Применить">
    </form>
</div>