<?php
require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/index.php';
resetFilterSession();


if (isset($_POST['availability'])) {
    setProductParametr($pdo, 'availability', $_POST['availability']);
}
if (isset($_POST['new'])) {
    setProductParametr($pdo, 'is_new', $_POST['new']);
}
if (isset($_POST['recommended'])) {
    setProductParametr($pdo, 'is_recommended', $_POST['recommended']);
}



$brands = getTable($pdo, 'brands');

$categorys = getTable($pdo, 'category');



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

<form method="POST" class="row bg-secondary mb-3">

    <div class="col d-flex  align-items-center pt-2">
        <div class="col-4 d-flex flex-column  pt-2">
            <label class="title-select text-left ">категория:&nbsp;
                <select class=" m-1 list-select" id="category" name="category">
                    <option value=0>Все</option>

                    <?php foreach ($categorys as $value) { ?>
                        <option value=<?= $value['id'] ?> <?= $value['id'] == $category ? 'selected' : '' ?>><?= $value['name'] ?></option>
                    <?php } ?>
                </select>
            </label>

            <label class="title-select   text-left ">бренд:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <select class=" m-1 list-select" id="brand" name='brand'>>
                    <option value=0>Все</option>

                    <?php foreach ($brands as $value) { ?>
                        <option value=<?= $value['id'] ?> <?= $value['id'] == $brand ? 'selected' : '' ?>><?= $value['name'] ?></option>
                    <?php } ?>
                </select>
            </label>
        </div>

        <label class="ml-5" for="new">
            <div> <input type="radio" name="new" value="-1" <?= $new == -1 ? 'checked' : '' ?>> все (абсолютно)</div>

            <div><input type="radio" name="new" value="0" <?= $new == 0 ? 'checked' : '' ?>> не новые</div>

            <div><input type="radio" name="new" value="1" <?= $new == 1 ? 'checked' : '' ?>> новые</div>
        </label>

        <label class="ml-4 mr-2 " for="recommend">
            <div> <input type="radio" name="recommend" value="-1" <?= $recommend == -1 ? 'checked' : '' ?>> все (абсолютно)</div>

            <div><input type="radio" name="recommend" value="0" <?= $recommend == 0 ? 'checked' : '' ?>> не рекомендованные</div>

            <div><input type="radio" name="recommend" value="1" <?= $recommend == 1 ? 'checked' : '' ?>> рекомендованные</div>
        </label>

        <label class="ml-4 " for="availability">
            <div> <input type="radio" name="availability" value="-1" <?= $availability == -1 ? 'checked' : '' ?>> все (абсолютно)</div>

            <div><input type="radio" name="availability" value="0" <?= $availability == 0 ? 'checked' : '' ?>> не продаже</div>

            <div><input type="radio" name="availability" value="1" <?= $availability == 1 ? 'checked' : '' ?>> в продаже</div>
        </label>

        <input type="submit" name="select" value="Отобрать" class="btn btn-info text-dark btn-select ml-4">
    </div>

</form>
<?php foreach ($products as $product) { ?>
    <div class="row">
        <div class="col-2  border border-info border-bottom-0 text-center py-3">
            <img src="/images/products/<?= $product['id'] ?>.jpg" alt="" class="card_img ">
        </div>

        <div class="col-10">
            <div class="row">
                <div class="col-4 border border-info border-bottom-0  border-left-0">
                    <div class="row py-2">
                        <div class="col-4 text-right"><strong>id:</strong> </div>
                        <div class="col-8 text-left"><?= $product['id'] ?></div>
                    </div>

                    <div class="row py-2">
                        <div class="col-4 text-right"><strong>название:</strong> </div>
                        <div class="col-8 text-left"><?= $product['name'] ?></div>
                    </div>

                    <div class="row py-2">
                        <div class="col-4 text-right"><strong>бренд:</strong> </div>
                        <div class="col-8 text-left"><?= $product['brandName'] ?></div>
                    </div>
                </div>

                <div class="col-4 border border-info border-bottom-0  border-left-0">
                    <div class="row py-2">
                        <div class="col-4 text-right"><strong>категория:</strong> </div>
                        <div class="col-8 text-left"><?= $product['categoryName'] ?></div>
                    </div>

                    <div class="row py-2">
                        <div class="col-4 text-right"><strong>цена:</strong> </div>
                        <div class="col-8 text-left"><?= $product['price'] ?>$</div>
                    </div>

                    <div class="row py-2">
                        <div class="col-4 text-right"><strong>на складе:</strong> </div>
                        <div class="col-8 text-left"><?= $product['count'] ?></div>
                    </div>
                </div>

                <div class="col-4 border border-info border-bottom-0  border-left-0">
                    <div class="row py-2">
                        <div class="col-4 text-right"><strong>в продаже:</strong> </div>
                        <div class="col-8 text-left ">
                            <form method="POST">
                                <button type="submit" name="availability" value="<?= $product['id'] ?>" class="btn btn-outline-primary  btn-sm"> <?= ($product['availability'] ? 'да' : 'нет') ?></button>
                            </form>
                        </div>
                    </div>

                    <div class="row py-2">
                        <div class="col-4 text-right"><strong>новый:</strong> </div>
                        <div class="col-8 text-left">
                            <form method="POST">
                                <button type="submit" name="new" value="<?= $product['id'] ?>" class="btn btn-outline-primary  btn-sm"> <?= ($product['is_new'] ? 'да' : 'нет') ?></button>
                            </form>
                        </div>
                    </div>

                    <div class="row py-2">
                        <div class="col-4 text-right"><strong>рекомендов.:</strong> </div>
                        <div class="col-8 text-left">
                            <form method="POST">
                                <button type="submit" name="recommended" value="<?= $product['id'] ?>" class="btn btn-outline-primary btn-sm"> <?= ($product['is_recommended'] ? 'да' : 'нет') ?></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row border border-info px-2 py-1">
        <strong class="col-1">описание:</strong>
        <div class="col">
            <?= $product['description'] ?>
        </div>
    </div>
    <hr>
<?php } ?>


<?php require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/footer.php';
