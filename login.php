<?php
$title = "НАЗВАНИЕ САЙТА";
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
    <div class="container mt-5">
        <div class="row justify-content-md-center">
            <div class="col-md-6 col-sm-9">
                <a href="/index.php" class="btn btn-link mt-3">
                    < На главную</a>
                        <?php
                        if (isset($_GET["registration"])) {
                            ?>
                            <form action="/login.php" method="post">
                                <input type="hidden" name="action" value="registration">
                                <h1>Регистрация</h1>
                                <div class="form-group">
                                    <label for="login">Логин</label>
                                    <input type="text" class="form-control" id="login" placeholder="Введите ваш логин">
                                </div>
                                <div class="form-group">
                                    <label for="birthday">Дата рождения</label>
                                    <input type="date" class="form-control" id="birthday">
                                </div>
                                <div class="form-group">
                                    <label for="password">Пароль</label>
                                    <input type="password" class="form-control" id="password"
                                        placeholder="Введите ваш пароль">
                                    <label for="password-check">Повторите пароль</label>
                                    <input type="password" class="form-control" id="password-check"
                                        placeholder="Проверка пароля">
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">Зарегистрироваться</button>
                                <a href="/login.php" class="btn btn-link mt-3">Войти</button>
                            </form>
                            <?php
                        } else {
                            ?>
                            <form action="/login.php" method="post">
                                <input type="hidden" name="action" value="login">
                                <h1>Аутентификация</h1>
                                <div class="form-group">
                                    <label for="login">Логин</label>
                                    <input type="text" class="form-control" id="login" placeholder="Введите ваш логин">
                                </div>
                                <div class="form-group">
                                    <label for="password">Пароль</label>
                                    <input type="password" class="form-control" id="password"
                                        placeholder="Введите ваш пароль">
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">Войти</button>
                                <a href="/login.php?registration" class="btn btn-link mt-3">Зарегистрироваться</button>
                            </form>
                            <?php
                        }
                        ?>
            </div>
        </div>
    </div>

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