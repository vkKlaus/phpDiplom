<?php
require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/index.php';
resetFilterSession();
$visitor = '';
$email = '';
$phone = '';
$mess = '';
$date = '';
$dispatched = '';
$response = '';
$operation = 'Записать';

if (isset($_POST['updMessage'])) {

    $_POST['idMes'] = isset($_SESSION['idMes']) ? $_SESSION['idMes'] : Null;

    $result = updMessage($pdo, $_POST);

    if ($result) {
        unset($_GET);

        unset($_SESSION['idMes']);
    }
};

if (isset($_GET['del'])) {
    delData($pdo, 'message', $_GET['del']);
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $_SESSION['idMes'] = $id;
    $message = getTable($pdo, "message", "`id`=$id", "`date` DESC");

    $visitor = $message[0]['visitor'];
    $email = $message[0]['email'];
    $phone = $message[0]['phone'];
    $mess = $message[0]['message'];
    $date =  $message[0]['date'];

    $dispatched = $message[0]['dispatched'];
    $response = $message[0]['response'];
}



$messages = getTable($pdo, "message", "", "`date` DESC");

require  $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/header.php';
?>

<div class="row mt-3">
    <div class="col-2">
        <div class="mb-2 text-right">автор: </div>

        <div class="mb-2 text-right">email: </div>

        <div class="mb-2 text-right">телефон</div>

        <div class="mb-2 text-right">сообщение: </div>

        <div class="mb-2 text-right">дата: </div>
    </div>

    <div class="col-9">
        <div class="mb-2"><?= $visitor ?></div>

        <div class="mb-2"><?= $email ?></div>

        <div class="mb-2"><?= $phone  ?></div>

        <div class="mb-2"><?= $mess ?></div>

        <div class="mb-2"><?= $date ?></div>
    </div>
</div>
<hr>
<form method="POST" class="enter-form  col">
    <div class="form-group">
        <label class="enter-label">показывать </label>
        <div class="d-flex justify-content-start">
            <input type="radio" name="dispatched" value=0 class="mess-radio m-2" <?= $dispatched == 0 ? 'checked' : '' ?>><span class="mr-2">нет</span>

            <input type="radio" name="dispatched" value=1 class="mess-radio m-2 " <?= $dispatched == 1 ? 'checked' : '' ?>><span>да</span>
        </div>

    </div>

    <div class="form-group">
        <label class="enter-label" for="response-id">ответ</label>

        <textarea rows="3" name="response" id="response-id" class="enter-field form-control"><?= $response ?></textarea>
    </div>

    <input type="submit" value="<?= $operation ?>" name="updMessage" class="enter-button btn btn-primary" />

</form>

<hr>

<h3>Сообщения</h3>
<hr>

<?php
foreach ($messages as $message) { ?>
    <div class="row mt-3 border-bottom border-info">
        <div class="col-2">
            <div class="mb-2 text-right">автор: </div>

            <div class="mb-2 text-right">email: </div>

            <div class="mb-2 text-right">телефон</div>

            <div class="mb-2 text-right">сообщение: </div>

            <div class="mb-2 text-right">дата: </div>

            <div class="mb-2 text-right">показывать: </div>

            <div class="mb-2 text-right">ответ: </div>
        </div>
        <div class="col-9">
            <div class="mb-2"><?= $message['visitor'] ?></div>

            <div class="mb-2"><?= $message['email'] ?></div>

            <div class="mb-2"><?= $message['phone']  ?></div>

            <div class="mb-2"><?= $message['message']  ?></div>

            <div class="mb-2"><?= $message['date']  ?></div>

            <div class="mb-2"><?= $message['dispatched'] ? 'да' : 'нет'  ?></div>

            <div class="mb-2"><?= $message['response']  ?></div>
        </div>
        <div class="col d-flex">
            <a href="/views/admin/messages.php ? edit=<?= $message['id'] ?>"><i class="fas fa-edit h4"></i></a>
            &nbsp;&nbsp;
            <a href="/views/admin/messages.php ? del=<?= $message['id'] ?>"><i class="far fa-minus-square h3"></i></a>
        </div>
    </div>

<?php } ?>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/footer.php';
