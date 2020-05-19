<?php
require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/header.php';
resetFilterSession();
$news = getTable($pdo, "news","", "`date`"); 
?>

<h3>Новости</h3>
<hr>

<?php
    foreach ($news as $new) { ?>
        <div class="pr-5">
         
                <div class="h5"><?= $new['date'] ?></div>
              
                <div class="h4"><strong><?= $new['title'] ?></strong></div>
              
                <div class="h6"><?= $new['new']  ?></div>
              
                <hr>
         
        </div>
        <br>
    <?php } ?>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/footer.php';