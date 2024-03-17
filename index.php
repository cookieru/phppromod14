<?php
$title = "НАЗВАНИЕ САЙТА";
include_once "SPAengine/authMethods.php";
include_once "SPAengine/services.php";
include_once "SPAengine/promo.php";

session_start();

$current_user = getCurrentUser();

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title ?>
    </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="style/index.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">
            <?= $title ?>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <?php
                if ($current_user === null) { ?>
                    <li class="nav-item ml-1">
                        <span class="align-middle">Гость</span class="align-middle">
                    </li>
                    <li class="nav-item ml-1">
                        <a href="/login.php" class="align-middle btn-link">Войти</a>
                    </li>
                    <li class="nav-item ml-1">
                        <a href="/login.php?registration" class="align-middle btn-link">Зарегистрироваться</a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item ml-1">
                        <span class="align-middle">
                            <?= $current_user ?>
                        </span class="align-middle">
                    </li>
                    <li class="nav-item ml-1">
                        (<a href="/login.php?logout" class="align-middle btn-link">Выйти</a>)
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Добро пожаловать в наш спа-салон!</h1>
        <p>Мы предлагаем широкий спектр услуг для вашего релакса и красоты.</p>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-12 order-lg-last">
                <h2>Акции</h2>
                <?php displayAvailablePromo() ?>

            </div>
            <div class="col-lg-7 col-12">
                <h2>Услуги</h2>
                <?php displayAvailableServices() ?>
            </div>
        </div>
    </div>

    <footer class="container">
        <h3>Контакты</h1>
            <div class="row">
                <div class="col-md-4 col-12 text-center">
                    <p>Адрес: ул. Примерная, 1</p>
                </div>
                <div class="col-md-4 col-12 text-center">
                    <p>Телефон: <a href="tel:123-456-789">123-456-789</a></p>
                </div>
                <div class="col-md-4 col-12 text-center">
                    <p>Email: <a href="mailto:info@spa-salon.ru">info@spa-salon.ru</a></p>
                </div>
            </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"
        integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+"
        crossorigin="anonymous"></script>
</body>

</html>