<?php

require  $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/header.php';

resetFilterSession();
$deliv = getTable($pdo, "delivery", "", '`cost`');


if (isset($_POST['submit'])){
    $order=[];
    foreach ($_SESSION['order'] as $elOrder){
       $count=(int)$_POST[$elOrder['id'].'_count'];
       $elOrder['count']=$count; 
       $order[]=$elOrder;
    }

    $_SESSION['order'] = $order;
    var_dump($_SESSION['order'] 
);
}

?>
  <div class="col-4">
                <p><strong>Варианты и стоимость доставка</strong></p>

                <table class="table  table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>

                            <th scope="col">доставка</th>

                            <th scope="col">цена</th>
                        </tr>
                    </thead>
                    <?php
                    foreach ($deliv as $key => $element) { ?>
                        <tr>
                            <th scope="row"><input type="radio" id="<?= $element['id'] ?>" class="deliv" name="deliv" value="<?= $element['id'] ?>" data="<?=$element['cost'] ?>"></th>

                            <td><?= $element['name'] ?></td>

                            <td><?= $element['cost'] ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/footer.php';