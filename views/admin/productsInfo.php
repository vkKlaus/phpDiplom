<?php

require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/index.php';
resetFilterSession();
$viewEl = false;

$id = '';
$name = '';
$status = 0;
$error='';


if (isset($_POST['btnEdit'])) {
    $viewEl = true;
    if ($_POST['btnEdit'] != -1) {
        $element = getTable($pdo, $table, '`id`=' . $_POST['btnEdit']);
        $id = $element[0]['id'];
        $name = $element[0]['name'];
        $status = $element[0]['status'];
    }
}

if (isset($_POST['btnStatus'])) {
    setParametr($pdo, $table, 'status', $_POST['btnStatus']);
}

if (isset($_POST['btnSave'])) {

   if (trim($_POST['name']) == ''){
       $error='пустое название?!!!!...';
       $viewEl = true;
   }else{
    saveParametr($pdo, $table,$_POST);
    $viewEl = false;
   }
}
if (isset($_POST['btnReturn'])) {
    unset($_POST);
    $viewEl = false;
}

$arrElements = getTable($pdo, $table);
require  $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/header.php';

?>

<div class="row mb-3">
    <div class="col-5">
        <h3 class="text-info"><?= $title ?></h3>
    </div>

    <div class="col-2">
        <form method="POST">
            <button type="submit" name="btnEdit" value="-1" class=" btn btn-outline-primary btn-lg" data-toggle="modal" data-target="#exampleModal">
                <i class="fas fa-plus"></i>
            </button>
        </form>
    </div>
</div>


<?php if ($viewEl) { ?>
    <h3 class="text-danger"><?= $error ?></h3>
    <form method="POST" class="row m-4 text-center">

        <div class="col-1 h4  ">
            <strong class="d-block mb-2">id:</strong>

            <hr>
            <input type="text" name="id" value="<?= $id ?>"  class="border-0 bg-white" />

           
        </div>

        <div class="col-4 h4">
            <strong class="d-block mb-2"> название: </strong>

            <hr>

            <input type="text" name="name" value="<?= $name ?>" />
        </div>

        <div class="col-4 h4">
            <strong class=" d-block mb-2">использование:</strong>

            <hr>

            <input type="radio" name="status" value="0" <?= $status == 0 ? 'checked' : '' ?> /> <strong>нет</strong>

            <input type="radio" name="status" value="1" <?= $status == 1 ? 'checked' : '' ?> /> <strong>да</strong>
        </div>
        <div class="col-3">
            <button type="submit" name="btnSave" value="-1" class=" btn btn-outline-primary btn-lg px-3" data-toggle="modal" data-target="#exampleModal">
                <i class="fas fa-sign-in-alt"></i>
            </button>

            <button type="submit" name="btnReturn" value="-1" class=" btn btn-outline-primary btn-lg px-3" data-toggle="modal" data-target="#exampleModal">
                <i class="fas fa-times"></i>
            </button>
        </div>

    </form>

<?php } else { ?>

    <div class="row text-dark ">
        <div class="col-2 bg-gradient-primary">
            <strong>id</strong>
        </div>
        <div class="col-4 bg-gradient-primary">
            <strong>название</strong>
        </div>
        <div class="col-2 bg-gradient-primary">
            <strong>использовать</strong>
        </div>
        <div class="col-2 bg-gradient-primary">
            <strong>...</strong>
        </div>
    </div>

    <?php

    foreach ($arrElements as $el) { ?>

        <div class="row text-dark my-2 ">
            <div class="col-2">
                <?= $el['id'] ?>
            </div>

            <div class="col-4">
                <?= $el['name'] ?>
            </div>

            <div class="col-2">
                <form method="POST">
                    <button type="submit" name="btnStatus" value="<?= $el['id'] ?>" class="btn btn-outline-primary btn-sm"> <?= ($el['status'] ? 'да' : 'нет') ?></button>
                </form>
            </div>

            <div class="col-2">
                <form method="POST">
                    <button type="submit" name="btnEdit" value="<?= $el['id'] ?>" class=" btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                        <i class="fas fa-pencil-alt"></i>
                    </button>
                </form>
            </div>

        </div>

<?php }
} ?>



<?php require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/footer.php';
