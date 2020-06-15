<?php
require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/index.php';
resetFilterSession();
$login = '';
$name = '';
$phone = '';
$operation = 'Запросить';

if (isset($_POST['recoveryEnter'])) {
    if ($_POST['recoveryEnter'] == 'Запросить') {
        $operation = 'Изменить';
        var_dump($_POST);
    } elseif ($_POST['recoveryEnter'] == 'Изменить') {
        $operation = 'Запросить';
        var_dump('--------------');
        var_dump($_POST);
    }
}

require  $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/header.php';
?>

<h3 class="text-info">Восстановление пароля</h3>

<div class="row justify-content-center">
    <div class="col-3">
        <form method="POST">
            <div class="form-group">
                <label for="email">email</label>

                <input type="email" class="form-control" id="email" name="login" value="<?= $login ?>" aria-describedby="login-help">

                <small id="login-help" class="form-text text-muted">введите email, указанный при регистрации</small>
            </div>
            <div class="form-group">
                <label for="name">имя</label>

                <input type="text" class="form-control" id="name" name="name" value="<?= $name ?>" aria-describedby="name-help">

                <small id="login-help" class="form-text text-muted">введите имя, указанное при регистрации</small>
            </div>

            <div class="form-group">
                <label for="phone">телефон</label>

                <input type="tel" class="form-control" id="phone" name="phone" value="<?= $phone ?>" aria-describedby="tlf-help">

                <small id="login-help" class="form-text text-muted">введите телефон, указанное при регистрации</small>
            </div>

            <?php if ($operation == 'Изменить') { ?>
                <div class="form-group">
                    <label for="password-1">пароль</label>

                    <input type="password" class="form-control" id="password-1" name="password_1">
                </div>

                <div class="form-group">
                    <label for="password-2">повторите пароль</label>

                    <input type="password" class="form-control" id="password-2" name="password_2">
                </div>
            <?php } ?>
            <div class="d-flex justify-content-center">
                <button type="submit" name="recoveryEnter" value="<?= $operation ?>" class="btn bg-gradient-info btn-primary btn-block px-5"><?= $operation ?></button>
            </div>

            <hr>

        </form>
    </div>
</div>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/footer.php';
