<?php
require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/index.php';
resetFilterSession();
$messages = getTable($pdo, "message","", "`date` DESC");
require  $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/header.php';
?>
<h3>Вопросы, отзывы, сообщения</h3>
<hr>
<?php
foreach ($messages as $message) { ?>
    <div class="pr-5">

        <div class="h5"><?= $message['date'] ?></div>

        <div class="h5"><strong><?= $message['visitor'] ?></strong></div>

        <div class="h6"><?= $message['message'] ?></div>

        <?php if ($message['response']) { ?>
            <div class="message-response h6 ml-5 mt-2"><?= $message['response']  ?></div>
        <?php } ?>
    </div>

    <hr>
<?php } ?>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/footer.php';