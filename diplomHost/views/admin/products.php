<?php
require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/index.php';
resetFilterSession();
$viewEl = false;
$fr_id = '';
$fr_name = '';
$fr_category_id = 0;
$fr_brand = '';
$fr_price = 0;
$fr_count = 0;
$fr_availability = 0;
$fr_description = '';
$fr_is_new = 1;
$fr_is_recommended = 0;
$fr_img = '/images/products/0.jpg';
$maxSizeImg = 300000;

$categorys = getTable($pdo, 'category');
$brands = getTable($pdo, 'brands');

$error = '';
$errorId = 0;

if (isset($_POST['btnEdit'])) {
    $viewEl = true;
    if ($_POST['btnEdit'] != -1) {

        $element = getTableFullProducts($pdo, "`product`.`id`=" . $_POST['btnEdit']);

        $fr_id = $element[0]['id'];
        $fr_name =  $element[0]['name'];
        $fr_category_id = $element[0]['category_id'];
        $fr_brand = $element[0]['brand'];
        $fr_price = $element[0]['price'];
        $fr_count = $element[0]['count'];
        $fr_availability = $element[0]['availability'];
        $fr_description = $element[0]['description'];
        $fr_is_new = $element[0]['is_new'];
        $fr_is_recommended = $element[0]['is_recommended'];
 
        $fr_img = getImg($element[0]['id']);
       
       
    }
}

if (isset($_POST['btnSave'])) {
    if (!isset($_POST['id'])) {
        $_POST['id'] = '';
    }

    if (!isset($_POST['fr_img'])) {
        $_POST['fr_img'] = getImg($_POST['id']);
    }


    if (trim($_POST['name']) == '') {
        $error .= 'пустое название; ';
        $viewEl = true;
    }

    if ((int) ($_POST['category']) == 0) {
        $error .= 'не выбрана категория; ';
        $viewEl = true;
    }

    if ((int) ($_POST['brand']) == 0) {
        $error .= 'не выбран бренд; ';
        $viewEl = true;
    }

    if ((int) ($_POST['price']) < 0) {
        $error .= 'цена меньше нуля; ';
        $viewEl = true;
    }

    if ((int) ($_POST['count']) < 0) {
        $error .= 'остатки меньше нуля; ';
        $viewEl = true;
    }

    if (trim($_POST['description']) == '') {
        $error .= 'нет описания; ';
        $viewEl = true;
    }


    if ($_POST['fr_img'] == '/images/products/0.jpg') {
        if (trim($_FILES['fileImg']['name']) == '' && ($_FILES['fileImg']['size'] == 0)) {
            $error .= 'нет изображения; ';
            $viewEl = true;
        } elseif (trim($_FILES['fileImg']['name']) != '' && ($_FILES['fileImg']['size'] == 0)) {
            $error .= 'превышен допустимый размер изображения (' . (int) $maxSizeImg / 1000 . 'кБ); ';
            $viewEl = true;
        }
    }

    if ($error) {
        $fr_id = $_POST['id'];
        $fr_name =  $_POST['name'];
        $fr_category_id = $_POST['category'];
        $fr_brand = $_POST['brand'];
        $fr_price = $_POST['price'];
        $fr_count = $_POST['count'];
        $fr_availability = $_POST['availability'];
        $fr_description = $_POST['description'];
        $fr_is_new = $_POST['new'];
        $fr_is_recommended = $_POST['recommended'];
    } else {
        if (saveProduct($pdo, $_POST, $_FILES)){
            $viewEl = false;
        }else{
            $error='ошибка записи элемента!';  
        }
       
    }
}
if (isset($_POST['btnReturn'])) {
    unset($_POST);
    $viewEl = false;
}

if (isset($_POST['btnSavePrice'])) {
    if ($_POST['price'] < 0) {
        $error .= 'цена меньше нуля! (' . $_POST['price'] . ') <br>';
        $errorId = $_POST['btnSavePrice'];
    }

    if ($_POST['count'] < 0) {
        $error .= 'остатки меньше нуля! (' . $_POST['count'] . ') <br>';
        $errorId = $_POST['btnSavePrice'];
    }

    if (!$error) {
        savePrice($pdo, $_POST);
    }

    unset($_POST);
}

if (isset($_POST['availability'])) {
    setParametr($pdo, 'product', 'availability', $_POST['availability']);
}
if (isset($_POST['new'])) {
    setParametr($pdo, 'product', 'is_new', $_POST['new']);
}
if (isset($_POST['recommended'])) {
    setParametr($pdo, 'product', 'is_recommended', $_POST['recommended']);
}


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

<div class="row">
    <div class="col-12 d-flex">
        <h3 class="text-info mr-3">Товары</h3>

        <form method="POST">
            <button type="submit" name="btnEdit" value="-1" class=" btn btn-outline-primary btn-lg">
                <i class="fas fa-plus"></i>
            </button>
        </form>
    </div>
</div>

<hr class="my-2">

<?php if ($viewEl) { ?>

    <h6 class="text-danger"><?= $error ?></h6>

    <form method="POST" enctype="multipart/form-data">
        <button type="submit" name="btnReturn" value="-1" class=" btn btn-outline-primary btn-lg my-2">
            <i class="fas fa-reply"></i>
        </button>

        <div class="row">
            <div class="col-3">

                <img src="<?= $fr_img ?>" alt="imgProduct" style="width: 70%" />

                <input type="hidden" name="MAX_FILE_SIZE" value="<?= $maxSizeImg ?>" />
                <div class="form-group">
                    <label for="id-file"></label>
                    <input type="file" name="fileImg" class="form-control-file" id="id-file" accept="image/jpg,image/jpeg">
                </div>
            </div>

            <div class="col-9">
                <div class="row">
                    <div class="col-6">
                        <div class="row form-group">
                            <label for="id-id" class="col-3">id:</label>

                            <input type="text" id="id-id" name="id" value="<?= $fr_id ?>" class="col-7 form-control mx-3" readonly>
                        </div>

                        <div class="row form-group">
                            <label class="col-3 " for="id-name">название:</label>

                            <div class="col-9">
                                <textarea cols="35" rows="2" name="name" id="id-name" class="form-control"><?= $fr_name ?></textarea>
                            </div>
                        </div>


                        <div class="row form-group">
                            <label for="id-category" class="col-3">категория:</label>

                            <div class="col-9">
                                <select class="form-control" id="id-category" name="category">
                                    <option value=0></option>
                                    <?php foreach ($categorys as $value) { ?>
                                        <option value=<?= $value['id'] ?> <?= $value['id'] == $fr_category_id ? 'selected' : '' ?>><?= $value['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label for="id-brand" class="col-3">бренд:</label>

                            <div class="col-9">
                                <select class="form-control" id="id-brand" name="brand">
                                    <option value=0></option>
                                    <?php foreach ($brands as $value) { ?>
                                        <option value=<?= $value['id'] ?> <?= $value['id'] == $fr_brand ? 'selected' : '' ?>><?= $value['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="col-6">
                        <div class="row form-group">
                            <label class="col-3">цена ($):</label>

                            <input type="number" name="price" value="<?= $fr_price ?>" class="col-4 form-control" />
                        </div>

                        <div class="row form-group">
                            <label class="col-3">остаток:</label>

                            <input type="number" name="count" value="<?= $fr_count ?>" class="col-4 form-control" />
                        </div>

                        <hr>

                        <div class="row mb-3">
                            <div class="col-3">использовать:</div>
                            <div class="col-9 form-check d-flex justify-content-around">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="availability" id="id-availability-1" value="1" <?= $fr_availability == 1 ? 'checked' : '' ?>>

                                    <label class="form-check-label ml-2" for="id-availability-1">
                                        да
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="availability" id="id-availability-0" value="0" <?= $fr_availability == 0 ? 'checked' : '' ?>>

                                    <label class="form-check-label ml-2" for="id-availability-0">
                                        нет
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-3">новый:</div>
                            <div class="col-9 form-check d-flex justify-content-around">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="new" id="id-new-1" value="1" <?= $fr_is_new == 1 ? 'checked' : '' ?>>

                                    <label class="form-check-label ml-2" for="id-new-1">
                                        да
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="new" id="id-new-0" value="0" <?= $fr_is_new == 0 ? 'checked' : '' ?>>

                                    <label class="form-check-label ml-2" for="id-new-0">
                                        нет
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-3">рекомендованно:</div>
                            <div class="col-9 form-check d-flex justify-content-around">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="recommended" id="id-recommended-1" value="1" <?= $fr_is_recommended == 1 ? 'checked' : '' ?>>

                                    <label class="form-check-label ml-2" for="id-recommended-1">
                                        да
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="recommended" id="id-recommended-0" value="0" <?= $fr_is_recommended == 0 ? 'checked' : '' ?>>

                                    <label class="form-check-label ml-2" for="id-recommended-0">
                                        нет
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-11">
                <hr>

                <label for="id-description">Описание:</label></label>

                <textarea class="form-control" name="description" id="id-description" rows="4"><?= $fr_description ?></textarea>
            </div>

            <div class="col-1 mt-5">
                <button type="submit" name="btnSave" value="-1" class=" btn btn-outline-primary btn-lg px-3">
                    <i class="fas fa-download"></i>
                </button>
            </div>
        </div>
    </form>

<?php } else { ?>

    <form method="POST" class="row bg-gradient-primary mb-3 text-dark ">

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

            <input type="submit" name="select" value="Отобрать" class="btn btn-info text-dark btn-select ml-4 bg-gradient-info">
        </div>
    </form>

    <hr>

    <div class="row ">
        <div class="col">

            <?php foreach ($products as $product) { ?>
                <div class="row text-dark">
                    <div class="col-2  border border-info border-bottom-0 text-center py-3">
                        <img src="<?= getImg($product['id']) ?>" alt="" class="card_img ">
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

                            <div class="col-3 border border-info border-bottom-0  border-left-0">
                                <div class="row py-2">
                                    <div class="col-4 text-right"><strong>катег.:</strong> </div>

                                    <div class="col-8 text-left"><?= $product['categoryName'] ?></div>
                                </div>
                                <form method="POST" class="border">
                                    <div class="text-center text-danger"><?= ($errorId == $product['id']) ? $error : '' ?></div>

                                    <div class="row py-2">
                                        <div class="col-4 text-right"><strong>цена:</strong> </div>

                                        <input type="number" name="price" value="<?= $product['price'] ?>" class="col-5 text-left mr-2">$</input>
                                    </div>

                                    <div class="row py-2">
                                        <div class="col-4 text-right"><strong>остат.:</strong> </div>

                                        <input type="number" name="count" value="<?= $product['count'] ?>" class="col-5 text-left mr-2" />

                                        <button type="submit" name="btnSavePrice" value="<?= $product['id'] ?>" class=" btn btn-outline-primary btn-sm "><i class="fas fa-download"></i></button>
                                    </div>
                                </form>
                            </div>

                            <div class="col-4 border border-info border-bottom-0  border-left-0">
                                <div class="row py-2">
                                    <div class="col-4 text-right"><strong>в прод.:</strong> </div>

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
                                    <div class="col-4 text-right"><strong>реком.:</strong> </div>

                                    <div class="col-8 text-left">
                                        <form method="POST">
                                            <button type="submit" name="recommended" value="<?= $product['id'] ?>" class="btn btn-outline-primary btn-sm"> <?= ($product['is_recommended'] ? 'да' : 'нет') ?></button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="col-1 border border-info border-bottom-0  border-left-0">
                                <div class="row my-2">
                                    <div class="col">
                                        <form method="POST">
                                            <button type="submit" name="btnEdit" value="<?= $product['id'] ?>" class="btn btn-outline-primary btn-sm"><i class="fas fa-pencil-alt"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row border border-info px-2 py-1 text-dark">
                    <strong class="col-1">описание:</strong>

                    <div class="col">
                        <?= $product['description'] ?>
                    </div>
                </div>
                <hr>

            <?php } ?>
        </div>
    </div>
<?php } ?>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/footer.php';
