<div class="col-3">
    <strong>Новости</strong>

    <?php
    foreach ($news as $new) { ?>
        <div class="pr-5">
            <a href="#" data=<?= $new['id'] ?>>
                <div class="new-date"><?= $new['date'] ?></div>
              
                <div class="new-title"><strong><?= $new['title'] ?></strong></div>
              
                <div class="new-text"><?= (strlen($new['new']) <= 250 ? $new['new'] : substr($new['new'], 0, 247) . "...") ?></div>
              
                <hr>
            </a>
        </div>
        <br>
    <?php } ?>
</div>