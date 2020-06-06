<?php
require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/index.php';
require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/header.php';
resetFilterSession();

$resultMes = '';
$visitor = '';
$email = '';
$phone = '';
$message = '';

if (isset($_POST['send'])) {

    $resultMes = '';


    if (empty(trim($_POST['visitor']))) {
        $resultMes .= 'Имя не может быть пустым <br>';
    }

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $resultMes .= "E-mail указан не верно.<br>";
    }

    if (empty(trim($_POST['message']))) {
        $resultMes .= 'Сообщение не может быть пустым <br>';
    }


    if (!$resultMes) {

        if (!sentMail($_POST)) {
            $resultMes .= 'ОШИБКА отправки письма <br>';
            $_POST['dispatched'] = 0;
        } else {
            $_POST['dispatched'] = 1;
        }

        if (!insertMessage($pdo, $_POST)) {
            $resultMes .=  'ОШИБКА записи сообщения';
        }
    }

    if (empty(trim($resultMes))) {
        $resultMes = 'сообщение отправлено';
    } else {
        $visitor = $_POST['visitor'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $message = $_POST['message'];
    }

    unset($_POST);
}
?>

    <div class="row d-flex flex-row">
        <div class="col">
        <p><strong>Связаться с нами</strong></p>
            <div class="row mb-3 h5">
                <div class="col-2">
                    <i class="fa fa-phone-alt"></i>
                </div>

                <div class="col">
                    <a href="">
                        <span class="contactinfo">
                            +7 (999) 999-99-99
                        </span>
                    </a>
                </div>
            </div>

            <div class="row mb-3 h5">
                <div class="col-2">
                    <i class="fa fa-at"></i>
                </div>

                <div class="col">
                    <a href="#">
                        <span class="contactinfo">
                            apnea.info@gmail.com
                        </span>
                    </a>
                </div>
            </div>

            <div class="row mb-3 h5">
                <div class="col-2">
                    <i class="far fa-address-card"></i>
                </div>

                <div class="col">
                    <span class="contactinfo">
                        000000, Город, улица, дом
                    </span>
                </div>
            </div>

            <div class="row mt-5 mb-5">
                <div class="col d-flex justify-content-center">
                    <a href="#">
                        <span class="fab fa-facebook  social-icons-contact mr-5"></span>
                    </a>

                    <a href="#">
                        <span class="fab fa-google-plus  social-icons-contact mr-5"></span>
                    </a>

                    <a href="#">
                        <span class="fab fa-twitter  social-icons-contact mr-5"></span>
                    </a>

                    <a href="#">
                        <span class="fab fa-instagram  social-icons-contact mr-5"></span>
                    </a>

                    <a href="#">
                        <span class="fab fa-vk  social-icons-contact mr-5"></span>
                    </a>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Af12e64d2aa3d1463d4b1a77e9071866116b0523dda5256f3f6548160fad30db9&amp;height=250&amp;lang=ru_RU&amp;scroll=true"></script>
                </div>
            </div>
        </div>

        <div class="col">
            <p><strong>Задайте вопрос или оставьте сообщение и Вам ответят</strong></p>

            <form method="POST">
                <label for="name" class="h5"><i class="fas fa-user"></i> Имя</label>

                <input type="text" class="form-control" id="name" required name="visitor" value="<?= $visitor ?>">


                <label for="email" class="h5"> <i class="fa fa-at"></i> Email</label>

                <input type="email" class="form-control" id="email" required name="email" value="<?= $email ?>">

                <label for="phone" class="h5"><i class="fa fa-phone-alt"></i> Телефон</label>

                <input type="tel" class="form-control" id="phone" name="phone" value="<?= $phone ?>">


                <label for="message" class="h5 "><i class="fas fa-sticky-note"></i> Сообщение</label>

                <textarea id="message" class="form-control" rows="5" required name="message"> <?= $message ?></textarea>

                <input type="submit" id="form-submit" class="btn btn-info btn-lg float-right mt-5" name="send" value="Отправить">

                <div id="msgSubmit" class="h5 text-center hidden mt-3"><?= $resultMes ?></div>
            </form>
        </div>
    </div>

<?php require $_SERVER['DOCUMENT_ROOT'] . '/views/layouts/footer.php';