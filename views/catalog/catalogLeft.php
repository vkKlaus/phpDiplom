<div class="col-3">
    <form method="POST" class="filterCatalog">
        <h4>Категории</h4>

        <fieldset class="scroll_space">
            <?php foreach ($categotyCatalog as $category) { ?>
                <div>
                    <input type="checkbox" name="category[]" value="<?= $category['id'] ?>" <?= isset($post['category']) && in_array($category['id'], $post['category']) ? "checked" : "" ?>>

                    <?= $category['name'] ?>


                </div>
            <?php } ?>
        </fieldset>

        <hr>

        <h4>Бренды</h4>

        <fieldset class="scroll_space">
            <?php foreach ($brandsCatalog as $brand) { ?>
                <div>
                    <input type="checkbox" name="brand[]" value="<?= $brand['id'] ?>" <?= isset($post['brand']) && in_array($brand['id'], $post['brand']) ? "checked" : "" ?>> <?= $brand['name'] ?>
                </div>
            <?php } ?>
        </fieldset>

        <hr>

        <h4>Цена</h4>

        <legend>
            <span>от</span>

            <input type="number" id="price-min" min="<?= $priceCatalog[0]['min'] ?>" max="<?= $priceCatalog[0]['max'] ?>" name="priceMin" class="filterPrice" value="<?= isset($post['priceMin']) ? $post['priceMin'] : (int) $priceCatalog[0]['min'] ?>">
        </legend>

        <legend>
            <span>до</span>

            <input type="number" id="price-max" min="<?= $priceCatalog[0]['min'] ?>" max="<?= $priceCatalog[0]['max'] ?>" name="priceMax" class="filterPrice" value="<?= isset($post['priceMax']) ? $post['priceMax'] :(int) $priceCatalog[0]['max'] ?>">
        </legend>

        <input type="submit" id="filter-submit" class="btn btn-info btn-lg float-right mt-5" name="filterSend" value="Применить">
        <input type="submit" id="filter-reset" class="btn btn-info btn-lg float-right mt-5" name="filterReset" value="Очистить">
    </form>
</div>