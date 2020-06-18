<?php
require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/index.php';
resetFilterSession();

$login = '';
$phone = '';
$email = '';

$error = '';
$title = '';
$user = 'ссс';

if (isset($_POST['registrationEnter'])) {

    if (getUser($pdo, $_POST['login'], 'user')) {
        $error .= 'по данному имени пользователь уже зарегистрирован <br>';
    } else {

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $error .= 'не корректный email <br>';
        }

        if (!valid_phone($_POST['phone'])) {
            $error .= 'не корректный телефон <br>';
        }

        if (!valid_password($_POST['password_1'])) {
            $error .= 'нарушены требования пароля  <br>';
        }

        if (($_POST['password_1'] <> $_POST['password_2'])) {
            $error .= 'разные пароли <br>';
        }

        if ($error) {
            $login = $_POST['login'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
        } else {
            $title = 'Введенные данные соответствуют требованиям для регистрации. ';

            $user = addUser($pdo, $_POST);

            if ($user) {
                $title .= 'Пользователь зарегистрирован. Можете выполнить вход.';
            } else {
                $title = '';
                $error = 'ошибка записи! <br>';
                $login = $_POST['login'];
                $phone = $_POST['phone'];
                $email = $_POST['email'];
            }
        }
    }
}

require  $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/header.php';
?>
<h3 class="text-info">Регистрация</h3>

<?php if ($title) { ?>
    <h3 class="text-success"><?= $title ?></h3>
<?php } else { ?>
    <h4 class="text-danger"><?= $error ?></h4>
    <div class="row justify-content-center">
        <div class="col-3">
            <form method="POST">
                <div class="form-group">
                    <label for="name">имя</label>

                    <input type="text" class="form-control" id="name" name="login" value="<?= $login ?>" aria-describedby="login-help">

                    <small id="login-help" class="form-text text-muted">будет использоваться при входе в систему</small>
                </div>

                <div class="form-group">
                    <label for="email">email</label>

                    <input type="email" class="form-control" id="email" name="email" value="<?= $email ?>" aria-describedby="email-help">

                    <small id="email-help" class="form-text text-muted">запомните, будет использоваться при восстановлении пароля</small>
                </div>

                <div class="form-group">
                    <label for="phone">телефон</label>

                    <input type="tel" class="form-control" id="phone" name="phone" value="<?= $phone ?>" aria-describedby="tlf-help">

                    <small id="login-help" class="form-text text-muted">запомните, будет использоваться при восстановлении пароля</small>
                </div>

                <div class="form-group">
                    <label for="password-1">пароль</label>

                    <input type="password" class="form-control" id="password-1" name="password_1" aria-describedby="pas1-help">

                    <small id="pas1-help" class="form-text text-muted">пароль - от 6 до 15 символов, латинская раскладка, обязательны цифры и строчные буквы</small>
                </div>

                <div class="form-group">
                    <label for="password-2">повторите пароль</label>

                    <input type="password" class="form-control" id="password-2" name="password_2" aria-describedby="pas2-help">

                    <small id="pas2-help" class="form-text text-muted">значение поля должно быть равно полю "пароль"</small>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" name="registrationEnter" class="btn bg-gradient-info btn-primary btn-block px-5">Зарегистрироваться</button>
                </div>

                <hr>

            </form>
        </div>
    </div>
<?php } ?>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/footer.php';
