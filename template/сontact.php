<?php require $_SERVER['DOCUMENT_ROOT'] . '/template/header.php' ?>

<div class="container-fluid">
    <h2 class="mt-3">КОНТАКТЫ</h2>

    <div class="row d-flex flex-row justify-content-between ml-5 mr-5 mt-3 ">
        <div class="col-4">

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
                        <span class="fab fa-facebook  social-icons-contact"></span>
                    </a>

                    <a href="#">
                        <span class="fab fa-google-plus  social-icons-contact"></span>
                    </a>

                    <a href="#">
                        <span class="fab fa-twitter  social-icons-contact"></span>
                    </a>

                    <a href="#">
                        <span class="fab fa-instagram  social-icons-contact"></span>
                    </a>

                    <a href="#">
                        <span class="fab fa-vk  social-icons-contact"></span>
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
            <h4>Оставьте сообщение и Вам ответят</h4>

            <div class="form-group col">
                <label for="name" class="h5">Имя</label>

                <input type="text" class="form-control" id="name" placeholder="&#128100;" required>
            </div>

            <div class="form-group col">
                <label for="email" class="h5">Email</label>

                <input type="email" class="form-control" id="email" placeholder="&#128231;" required>
            </div>

            <div class="form-group col">
                <label for="message" class="h5 ">Сообщение</label>

                <textarea id="message" class="form-control" rows="5" placeholder="&#128221;" required></textarea>
            </div>

            <button type="submit" id="form-submit" class="btn btn-info btn-lg pull-right ">Отправить</button>

            <div id="msgSubmit" class="h4 text-center hidden">Сообщение отправлено!</div>
        </div>
    </div>

    <?php require $_SERVER['DOCUMENT_ROOT'] . '/template/footer.php' ?>