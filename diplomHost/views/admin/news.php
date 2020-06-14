<?php
require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/index.php';
resetFilterSession();
$date = '';
$title = '';
$new = '';
$error = '';
$operation = 'Добавить';

if (isset($_POST['addNew'])) {
    if (trim($_POST['new']) && trim($_POST['title']) ) {
        if ($_POST['addNew'] == 'Добавить') {
            $result = addNew($pdo, $_POST);

            if ($result) {
                unset($_POST['addNew']);

                $operation = 'Добавить';
            }
        } elseif ($_POST['addNew'] == 'Изменить') {
            $_POST['id'] = isset($_SESSION['idNew']) ? $_SESSION['idNew'] : Null;

            $result = updNew($pdo, $_POST);

            if ($result) {
                unset($_GET);

                unset($_SESSION['idNew']);

                $operation = 'Добавить';
            }
        }
    }else{
        $error='Обнаружены не заполненные поля. Данные не записаны.';
    }
};

if (isset($_GET['del'])) {
    delData($pdo, 'news', $_GET['del']);
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $_SESSION['idNew'] = $id;
    $new = getTable($pdo, "news", "`id`=$id", "`date` DESC");
    $date = $new[0]['date'];
    $title = $new[0]['title'];
    $new = $new[0]['new'];
    $operation = 'Изменить';
}



$news = getTable($pdo, "news", "", "`date` DESC");

require  $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/header.php';
?>

<h4 class="text-danger"><?= $error ?></h4>

<form method="POST" class="enter-form  col">
    <div class="form-group">
        <label class="enter-label" for="date-id">Дата</label>

        <input type="date" name="date" value="<?= $date ?>" id="date-id" class="enter-field form-control" required>
    </div>

    <div class="form-group">
        <label class="enter-label" for="title-id">Заголовок</label>

        <input type="text" name="title" value="<?= $title ?>" id="title-id" class="enter-field form-control" required>
    </div>

    <div class="form-group">
        <label class="enter-label" for="new-id">Текст новости</label>

        <textarea rows="3" name="new" id="new-id" class="enter-field form-control" required><?= $new ?> </textarea>
    </div>

    <input type="submit" value="<?= $operation ?>" name="addNew" class="enter-button btn btn-primary" />

</form>

<hr>

<h3>Новости</h3>
<hr>

<?php
foreach ($news as $new) { ?>
    <div class="row mb-3 border-bottom border-info">
        <div class="col-2">
            <div class="mb-2 text-right">дата: </div>

            <div class="mb-2 text-right">заголовок: </div>

            <div class="mb-2 text-right">новость: </div>
        </div>
        <div class="col-9">
            <div class="mb-2"><?= $new['date'] ?></div>

            <div class="mb-2"><?= $new['title'] ?></div>

            <div class="mb-2"><?= $new['new']  ?></div>
        </div>

        <div class="col d-flex">
            <a href="/views/admin/news.php ? edit=<?= $new['id'] ?>"><i class="fas fa-edit h4"></i></a>
            &nbsp;&nbsp;
            <a href="/views/admin/news.php ? del=<?= $new['id'] ?>"><i class="far fa-minus-square h3"></i></a>
        </div>
    </div>

<?php } ?>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/footer.php';
