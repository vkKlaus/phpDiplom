<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=A, initial-scale=1.0">
    <title>Apnea shop</title>
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/all.min.css">

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

            <div class="col-sm-6">
                <ul class="nav navbar-pills text-right float-right">
                    <li class="mr-1">
                        <a href="#">
                            <i class="fab fa-facebook contactinfo social-icons"></i>
                        </a>
                    </li>

                    <li class="mr-1">
                        <a href="#">
                            <i class="fab fa-google-plus contactinfo social-icons"></i>
                        </a>
                    </li>

                    <li class="mr-1">
                        <a href="#">
                            <i class="fab fa-twitter contactinfo social-icons"></i>
                        </a>
                    </li>

                    <li class="mr-1">
                        <a href="#">
                            <i class="fab fa-instagram contactinfo social-icons"></i>
                        </a>
                    </li>

                    <li class="mr-1">
                        <a href="#">
                            <i class="fab fa-vk contactinfo social-icons"></i>
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

                <h2 class="text-left text-white">APNEAshop - ВСЕ ДЛЯ ФРИДАЙВИНГА И ФРИДАЙВЕРОВ</h2>
            </div>
        </div>

        <div class="header-menu d-flex justify-content-around">
            <nav class="row navbar navbar-expand-lg navbar-light pt-0 pb-0">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-start" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item mr-3">
                            <a class="nav-link" href="/">
                                <span class="item-menu active">
                                    Главная <span class="sr-only">(current)</span>
                                </span>
                            </a>
                        </li>

                        <li class="nav-item dropdown mr-3">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="item-menu">
                                    Магазин
                                </span>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="#">
                                    <span class="item-submenu">
                                        Каталог товара
                                    </span>
                                </a>

                                <a class="dropdown-item" href="#">
                                    <span class="item-submenu">
                                        Корзина
                                    </span>
                                </a>
                            </div>
                        </li>

                        <li class="nav-item dropdown mr-3">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="item-menu">
                                    О магазине
                                </span>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="#">
                                    <span class="item-submenu">
                                        Доставка и оплата
                                    </span>
                                </a>

                                <a class="dropdown-item" href="#">
                                    <span class="item-submenu">
                                        О магазине
                                    </span>
                                </a>
                            </div>
                        </li>

                        <li class="nav-item mr-3">
                            <a class="nav-link" href="/template/сontact.php">
                                <span class="item-menu">
                                    Контакты
                                </span>
                            </a>
                        </li>

                        <li class="nav-item mr-3">
                            <a class="nav-link" href="#">
                                <span class="item-menu">
                                    Заказы
                                </span>
                            </a>
                        </li>

                        <li class="nav-item dropdown mr-3">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="item-menu">
                                    Управление
                                </span>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="#">
                                    <span class="item-submenu">
                                        Товары
                                    </span>
                                </a>

                                <a class="dropdown-item" href="#">
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
                    <li class="mr-5"><a href="/cart">
                            <span class="header-enter">
                                <i class="fa fa-shopping-cart"></i>
                                Корзина(<span id="cart-count">0</span>)
                            </span>
                        </a>
                    </li>

                    <li>
                        <a href="/user/login/">
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