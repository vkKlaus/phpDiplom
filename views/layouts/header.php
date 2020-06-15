<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apnea shop</title>

    <link rel="stylesheet" href="/css/reset.css">

    <link rel="stylesheet" href="/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="/css/all.min.css">
    <!-- <link rel="stylesheet" href="/css/bootstrap-change.css"> -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">


    <link rel="stylesheet" href="/css/style.css">


</head>

<body>
    <header class="container-fluid header">
        <div class="row d-flex ml-5 mr-5 header-contact-info">
            <ul class="nav nav-pill col-sm-6">
                <li class="mr-3 ">
                    <a href="#">
                        <span class="contactinfo">
                            <i class="fa fa-phone-alt"></i> +7 (999) 999-99-99
                        </span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="contactinfo">
                            <i class="fa fa-envelope"></i> apnea.info@gmail.com
                        </span>
                    </a>
                </li>
            </ul>

            <div class="col">
                <ul class="nav navbar-pills text-right float-right">
                    <li>
                        <a href="#">
                            <i class="fab fa-facebook  social-icons mr-4"></i>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <i class="fab fa-google-plus  social-icons mr-4"></i>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <i class="fab fa-twitter  social-icons mr-4"></i>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <i class="fab fa-instagram  social-icons mr-4"></i>
                        </a>
                    </li>

                    <li">
                        <a href="#">
                            <i class="fab fa-vk  social-icons"></i>
                        </a>
                        </li>
                </ul>
            </div>
        </div>

        <div class="row d-flex justify-content-between header-logo pt-3 pb-3">
            <div class="col-sm-2">
                <div class="logo ml-5">
                    <a href="/"><img src="/images/logo.png" alt="" /></a>
                </div>
            </div>

            <div class="col">
                <div class="text-right slogan-shop mr-5">Dum Spiro, Spero!!! </div>

                <h2 class="text-left text-white">APNEA <sup> shop </sup> - ВСЕ ДЛЯ ФРИДАЙВИНГА И ФРИДАЙВЕРОВ</h2>
            </div>
        </div>

        <div class="header-menu d-flex justify-content-around">
            <nav class="row navbar navbar-expand-lg navbar-light pt-0 pb-0">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-start" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="/">
                                <span class="item-menu <?= ($requestUri == '/' ? 'active' : '') ?>">
                                    Главная <span class="sr-only">(current)</span>
                                </span>
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="item-menu <?= ($requestUri == '/views/service/delivery.php' || $requestUri == '/views/catalog/' ? 'active' : '') ?>">
                                    Магазин
                                </span>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="/views/catalog/">
                                    <span class="item-submenu  <?= ($requestUri == '/views/catalog/' ? 'active' : '') ?>">
                                        Каталог товара
                                    </span>
                                </a>

                                <a class="dropdown-item" href="/views/service/delivery.php">
                                    <span class="item-submenu  <?= ($requestUri == '/views/service/delivery.php'  ? 'active' : '') ?>">
                                        Доставка и оплата
                                    </span>
                                </a>

                                <a class="dropdown-item" href="/views/order/">
                                    <span class="item-submenu">
                                        Корзина
                                    </span>
                                </a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="item-menu <?= ($requestUri == '/views/service/about.php' ||  $requestUri == '/views/service/news.php' || $requestUri == '/views/service/messages.php' ? 'active' : '') ?>">
                                    Информация
                                </span>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="/views/service/news.php">
                                    <span class="item-submenu <?= ($requestUri == '/views/service/news.php' ? 'active' : '') ?>">
                                        Новости
                                    </span>
                                </a>

                                <a class="dropdown-item" href="/views/service/messages.php">
                                    <span class="item-submenu <?= ($requestUri == '/views/service/messages.php' ? 'active' : '') ?>">
                                        Вопросы, отзывы, сообщения
                                    </span>
                                </a>

                                <a class="dropdown-item" href="/views/service/about.php">
                                    <span class="item-menu <?= ($requestUri == '/views/service/about.php' ? 'active' : '') ?>">
                                        О магазине
                                    </span>
                                </a>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="/views/service/contact.php">
                                <span class="item-menu <?= ($requestUri == '/views/service/contact.php' ? 'active' : '') ?>">
                                    Контакты
                                </span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="/views/admin/orders.php">
                                <span class="item-menu">
                                    Заказы
                                </span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="/views/admin/news.php">
                                <span class="item-menu">
                                    Новости
                                </span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="/views/admin/messages.php">
                                <span class="item-menu">
                                    Сообщения
                                </span>
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="item-menu">
                                    Управление
                                </span>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="/views/admin/products.php">
                                    <span class="item-submenu">
                                        Товары
                                    </span>
                                </a>


                                <a class="dropdown-item" href="/views/admin/productsCategory.php">
                                    <span class="item-submenu">
                                        Категории
                                    </span>
                                </a>

                                <a class="dropdown-item" href="/views/admin/productsBrand.php">
                                    <span class="item-submenu">
                                        Бренды
                                    </span>

                                    <a class="dropdown-item" href="/views/admin/users.php">
                                        <span class="item-submenu">
                                            Пользователи
                                        </span>
                                    </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="col-sm-4 align-self-center">
                <ul class="nav navbar-nav float-right d-flex flex-row">
                    <li class="mr-5">
                        <a href="/views/order/">
                            <span class="header-enter">
                                <i class="fa fa-shopping-cart"></i>
                                Корзина(<span id="cart-count"><?= $inBasket ?></span>)
                            </span>
                        </a>
                    </li>

                    <li>
                        <a href="/views/authorization/">
                            <span class="header-enter">
                                <i class="fa fa-lock"></i>
                                Вход
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <hr class="hr-horizontal-gradient mt-0 mb-0">
    </header>

    <main class="container-fluid main-container">