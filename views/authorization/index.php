<?php
require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/index.php';
resetFilterSession();
$login = '';
$error='';
$title='';

$_SESSION['pages']=[];

if (isset($_POST['registration'])) {
    header('Location: ' . $host . '/views/authorization/registration.php');
} elseif (isset($_POST['recovery'])) {
    header('Location: ' . $host . '/views/authorization/recovery.php');
} elseif (isset($_POST['enter'])) {
    $user = getUser($pdo, $_POST['login'], 'user');
    if (!password_verify($_POST['password'], $user['password'])) {
        $error .=  'ошибка авторизации';
    }else{
        $title = 'Вы вошли в систему.';
        $_SESSION['user']=$user;
        $_SESSION['pages']=getPages($pdo,$_SESSION['user']['id']);
    }
}


require  $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/header.php';
?>
<h3 class="text-info">Вход</h3>
<?php if ($title) { ?>
    <h3 class="text-success"><?= $title ?></h3>
<?php  } else { ?>
    <h4 class="text-danger"><?= $error ?></h4>
    <div class="row justify-content-center">
        <div class="col-3">
            <form method="POST">
                <div class="form-group">
                    <label for="email">имя</label>

                    <input type="text" class="form-control" id="login" name="login" value="<?= $login ?>" aria-describedby="login-help">

                    <small id="login-help" class="form-text text-muted">введите имя, указанное при регистрации</small>
                </div>

                <div class="form-group">
                    <label for="password">пароль</label>

                    <input type="password" class="form-control" id="password" name="password">
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" name="enter" class="btn bg-gradient-info btn-primary btn-block px-5">Войти</button>
                </div>

                <hr>

                <div class="d-flex justify-content-between mt-5">
                    <button type="submit" name="registration" class="btn btn-outline-info px-1 ml-3"><small>Зарегистрироваться</small></button>
                    <button type="submit" name="recovery" class="btn btn-outline-info px-3  mr-3"><small>Вспомнить пароль</small></button>
                </div>
            </form>
        </div>
    </div>
<?php } ?>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/footer.php';
