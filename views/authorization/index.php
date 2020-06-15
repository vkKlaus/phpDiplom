<?php
require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/index.php';
resetFilterSession();
$login = '';
if (isset($_POST['enter'])){
    var_dump($_POST);
}elseif (isset($_POST['registration'])){
    header('Location: '.$host.'/views/authorization/registration.php');
}elseif (isset($_POST['recovery'])){
    header('Location: '.$host.'/views/authorization/recovery.php');
}

require  $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/header.php';
?>
<h3 class="text-info">Вход</h3>
<div class="row justify-content-center">
    <div class="col-3">
        <form method="POST">
            <div class="form-group">
                <label for="email">email</label>

                <input type="email" class="form-control" id="email" name="login" value="<?= $login ?>" aria-describedby="login-help">

                <small id="login-help" class="form-text text-muted">введите email, указанный при регистрации</small>
            </div>

            <div class="form-group">
                <label for="password">пароль</label>

                <input type="password" class="form-control" id="password" name="password">
            </div>

            <div class="d-flex justify-content-center">
                <button type="submit" name="enter" class="btn bg-gradient-info btn-primary btn-block px-5">Войти</button>
            </div>

            <hr>

            <div class="d-flex justify-content-between">
                <button type="submit" name="registration" class="btn btn-outline-info ">Зарегистрироваться</button>
                <button type="submit" name="recovery" class="btn btn-outline-info ">Вспомнить пароль</button>
            </div>
        </form>
    </div>
</div>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/footer.php';
