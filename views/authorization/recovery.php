<?php
require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/index.php';
resetFilterSession();
$login = '';
$email = '';
$phone = '';
$operation = 'Запросить';
$error = '';
$readOnly = '';
$title = '';
if (isset($_POST['recoveryEnter'])) {
    if ($_POST['recoveryEnter'] == 'Запросить') {
        $user = getUser($pdo, $_POST['login'], 'user');
        if (!$user) {
            $error .= 'Пользователь с именем ' . $_POST['login'] . ' не обнаружен!';
        } else if ($user['email'] == $_POST['email'] && $user['phone'] == $_POST['phone']) {
            $operation = 'Изменить';
            $readOnly = 'readonly';
            $login =  $user['user'];
            $email = $user['email'];
            $phone = $user['phone'];
        } else {
            $error .= 'Пользователь с такими данными не обнаружен';
        }
    } elseif ($_POST['recoveryEnter'] == 'Изменить') {

        if (!valid_password($_POST['password_1'])) {
            $error .= 'нарушены требования пароля  <br>';
        }

        if (($_POST['password_1'] <> $_POST['password_2'])) {
            $error .= 'разные пароли <br>';
        }

        if ($error) {
            $login =  $_POST['login'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $operation = 'Изменить';
            $readOnly = 'readonly';
        }else{
          
            if (updatePassword($pdo, $_POST)){
                $operation = 'Запросить';
                $readOnly = ''; 
                $title = 'Пароль успешно обновлен! Можете войти с использованием обновленного пароля.';
            }else{
                $login =  $_POST['login'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $operation = 'Изменить';
                $readOnly = 'readonly'; 
                $error .= 'ошибка записи  <br>';
            }
        }

  
        var_dump($_POST);
    }
}

require  $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/header.php';
?>

<h3 class="text-info">Восстановление пароля</h3>
<?php if ($title) { ?>
    <h3 class="text-success"><?= $title ?></h3>
<?php  } else { ?>
    <h4 class="text-danger"><?= $error ?></h4>
    <div class="row justify-content-center">
        <div class="col-3">
            <form method="POST">
                <div class="form-group">
                    <label for="name">имя</label>

                    <input type="text" class="form-control" id="name" name="login" value="<?= $login ?>" aria-describedby="name-help" <?= $readOnly ?>>

                    <small id="login-help" class="form-text text-muted">введите имя, указанное при регистрации</small>
                </div>

                <div class="form-group">
                    <label for="email">email</label>

                    <input type="email" class="form-control" id="email" name="email" value="<?= $email ?>" aria-describedby="login-help" <?= $readOnly ?>>

                    <small id="login-help" class="form-text text-muted">введите email, указанный при регистрации</small>
                </div>



                <div class="form-group">
                    <label for="phone">телефон</label>

                    <input type="tel" class="form-control" id="phone" name="phone" value="<?= $phone ?>" aria-describedby="tlf-help" <?= $readOnly ?>>

                    <small id="login-help" class="form-text text-muted">введите телефон, указанный при регистрации</small>
                </div>

                <?php if ($operation == 'Изменить') { ?>
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
                <?php } ?>
                <div class="d-flex justify-content-center">
                    <button type="submit" name="recoveryEnter" value="<?= $operation ?>" class="btn bg-gradient-info btn-primary btn-block px-5"><?= $operation ?></button>
                </div>

                <hr>

            </form>
        </div>
    </div>
<?php } ?>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/footer.php';
