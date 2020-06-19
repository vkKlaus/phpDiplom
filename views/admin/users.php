<?php
require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/index.php';
resetFilterSession();



if (isset($_POST['setRole'])){
    setUserGroup($pdo,$_POST);
};




$users = getTable($pdo, 'users');
$groups = getTable($pdo, 'groups');
$groupUser = getTable($pdo, 'group_user');

require  $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/header.php';
?>

<h3>Пользователи</h3>
<div class="row border-bottom mb-2 mt-2 pl-5 bg-secondary">
    <div class="col-6 text-center border-right">
        <h4>пользователи</h4>
    </div>

    <div class="col-6 text-center">
        <h4>роли</h4>
    </div>
</div>
<?php
$bg = 'bg-light';
foreach ($users as $user) { ?>
    <div class="row border-bottom mb-2 mt-2  pl-5 <?php
                                                    echo ($bg);

                                                    $bg = $bg == '' ? 'bg-light' : '';

                                                    $id = $user["id"];
                                                    $userGrop = array_filter($groupUser, function ($elm) use ($id) {
                                                        return $elm['user_id'] == $id;
                                                    });

                                                    $colGroupId=array_column($userGrop,'group_id');
                                                    ?>">
        <div class="col-6 border-right">
            <div class="row">
                <div class="col-6">
                    <div><strong>id:&nbsp;&nbsp;</strong><?= $user['id'] ?></div>
                    <div><strong>имя:&nbsp;&nbsp;</strong><?= $user['user'] ?></div>
                </div>
                <div class="col-6">
                    <div><strong>email:&nbsp;&nbsp;</strong><?= $user['email'] ?></div>
                    <div><strong>телефон:&nbsp;&nbsp;</strong><?= $user['phone'] ?></div>
                </div>
            </div>
        </div>

        <div class="col-6 pl-5">
            <form method="POST" class="row">

                <div class="col-6">
                    <?php foreach ($groups as $group) { ?>
                        <div class="form-check">
                            <input class="form-check-input" name="checkBox[]" value="<?= $group['id'] ?>" type="checkbox" <?=(in_array($group['id'],$colGroupId)?'checked':'')?> >
                            <label class="form-check-label">
                                <?= $group['description'] ?>
                            </label>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-6 pt-2 text-left">
                    <button type="submit" class="btn btn-outline-primary btn-sm" name="setRole" value="set"><i class="fas fa-download"></i></button>
                    <input name="userID" value="<?= $user['id'] ?>" type="text" style="visibility: hidden; width: 0; height: 0;" />
                </div>
            </form>

        </div>
    </div>
<?php } ?>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/footer.php';
