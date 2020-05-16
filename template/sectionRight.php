<?php

$messages = getTable($pdo, "message");

?>
<div class="col-3">
    <strong>Вопросы, отзывы. мнения</strong>

    <?php
    foreach ($messages as $message) { ?>
        <div class="pr-5">
            <a href="#" data=<?= $message['id'] ?>>
                <div class="message-date"><?= $message['date'] ?></div>
              
                <div class="message-visitor"><strong><?= $message['visitor'] ?></strong></div>
              
                <div class="message-text"><?= (strlen($message['message']) <= 250 ? $message['message'] : substr($message['message'], 0, 247) . "...") ?></div>

                <?php if ($message['response']) { ?>
                    <div class="message-response ml-2 mt-2"><?= (strlen($message['response']) <= 250 ? $message['response'] : substr($message['response'], 0, 247) . "...") ?></div>
                <?php } ?>

                <hr>
            </a>
        </div>
        <br>
    <?php } ?>
</div>
</div>