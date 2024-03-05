<?php
$title = "НАЗВАНИЕ САЙТА";
include_once "SPAengine/methods.php";
session_start();

$login_error_nologin = false;
$login_error_nopassword = false;
$login_error_incorrect = false;

$registration_error_nologin = false;
$registration_error_nopassword = false;
$registration_error_nobirthday = false;
$registration_error_loginhasbusy = false;
$registration_error_passwordcheck = false;
$registration_error_birthdayinvalid = false;

$login_invalid = false;

if (isset($_POST["action"])) {
    function loginValidation($login)
    {
        $pattern = "#^[\w\.\-]*$#s";

        return !!preg_match($pattern, $login);
    }

    switch ($_POST["action"]) {
        case 'login':
            $login_error_nologin = trim($_POST["login"]) == "";
            $login_error_nopassword = trim($_POST["password"]) == "";
            $can_continue = !($login_error_nologin || $login_error_nopassword);

            if ($can_continue) {
                $login = trim($_POST["login"]);
                $password = trim($_POST["password"]);

                $login_invalid = !loginValidation($login);

                if (!$login_invalid) {
                    if (checkPassword($login, $password)) {
                        $_SESSION["current_user"] = $login;
                    } else
                        $login_error_incorrect = true;
                }
            }
            break;

        case 'registration':
            $registration_error_nologin = trim($_POST["login"]) == "";
            $registration_error_nopassword = trim($_POST["password"]) == "";
            $registration_error_nobirthday = trim($_POST["birthday"]) == "";
            $can_continue = !(
                $registration_error_nologin || $registration_error_nopassword ||
                $registration_error_passwordcheck || $registration_error_nobirthday
            );

            if ($can_continue) {
                $login = trim($_POST["login"]);
                $birthday = trim($_POST["birthday"]);
                $password = trim($_POST["password"]);
                $password_check = $_POST["password-check"];

                $login_invalid = !loginValidation($login);
                var_dump($login_invalid);
                $registration_error_loginhasbusy = existsUser($login);
                $registration_error_invalidbirthday = !strtotime($birthday);
                $registration_error_passwordcheck = $password !== $password_check;

                $can_continue = !(
                    $login_invalid || $registration_error_loginhasbusy ||
                    $registration_error_invalidbirthday || $registration_error_passwordcheck
                );

                if ($can_continue) {
                    addUser($login, $password, $birthday);
                    $_SESSION["current_user"] = $login;
                }
            }
            break;
    }
}

if (isset($_GET['logout'])) {
    unset($_SESSION["current_user"]);
    header("Location: /" . ($_GET["ref_link"]) ?? "");
}

if (true)
    if (getCurrentUser() != null) {
        header("Location: /");
        return;
    }
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
                        if (isset($_GET["registration"])) { ?>
                            <form action="/login.php?registration" method="post">
                                <input type="hidden" name="action" value="registration">
                                <h1>Регистрация</h1>
                                <div class="form-group">
                                    <label for="login">Логин</label>
                                    <input type="text" class="form-control" name="login" placeholder="Введите ваш логин"
                                        value="<?= $_POST["login"] ?? "" ?>">
                                    <?php //Вывод сообщение об ошибке: отсутствует логин
                                        if ($registration_error_nologin) { ?>
                                        <div class=" form-group">
                                            <span class="badge badge-warning ml-3">Требуется заполнить.</span>
                                        </div>
                                    <?php } ?>
                                    <?php //Вывод сообщение об ошибке: некорректный логин
                                        if ($login_error_incorrect) { ?>
                                        <div class="form-group">
                                            <span class="badge badge-warning">Логин содержит недопустимые символы. Разрешенные
                                                символы:
                                                <br>Латинские строчные и прописные буквы, цифры, символы ".", "-" и "_".</span>
                                        </div>
                                    <?php } ?>
                                    <?php //Вывод сообщение об ошибке: логин уже занят
                                        if ($registration_error_loginhasbusy) { ?>
                                        <div class="form-group">
                                            <span class="badge badge-warning">Такой логин уже занят.</span>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label for="birthday">Дата рождения</label>
                                    <input type="date" class="form-control" name="birthday"
                                        value="<?= $_POST["birthday"] ?? "" ?>">
                                    <?php //Вывод сообщение об ошибке: отсутствует день рождения
                                        if ($registration_error_nobirthday) { ?>
                                        <div class=" form-group">
                                            <span class="badge badge-warning ml-3">Требуется заполнить.</span>
                                        </div>
                                    <?php } ?>
                                    <?php //Вывод сообщение об ошибке: некорректный день рождения
                                        if ($registration_error_birthdayinvalid) { ?>
                                        <div class="form-group">
                                            <span class="badge badge-warning ml-3">Ошибка.</span>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label for="password">Пароль</label>
                                    <input type="password" class="form-control" name="password"
                                        placeholder="Введите ваш пароль">
                                    <?php //Вывод сообщение об ошибке: отсутствует пароль
                                        if ($registration_error_nopassword) { ?>
                                        <div class="form-group">
                                            <span class="badge badge-warning ml-3">Требуется заполнить.</span>
                                        </div>
                                    <?php } ?>
                                    <label for="password-check">Повторите пароль</label>
                                    <input type="password" class="form-control" name="password-check"
                                        placeholder="Проверка пароля">
                                    <?php //Вывод сообщение об ошибке: пароли не совпадают
                                        if ($registration_error_passwordcheck) { ?>
                                        <div class="form-group">
                                            <span class="badge badge-warning ml-3">Пароли не совпадают.</span>
                                        </div>
                                    <?php } ?>
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
                                    <input type="text" class="form-control" name="login" placeholder="Введите ваш логин"
                                        value="<?= $_POST["login"] ?? "" ?>">
                                    <?php //Вывод сообщение об ошибке: отсутствует логин
                                        if ($login_error_nologin) { ?>
                                        <div class="form-group">
                                            <span class="badge badge-warning ml-3">Требуется заполнить.</span>
                                        </div>
                                    <?php } ?>
                                    <?php //Вывод сообщение об ошибке: некорректный логин
                                        if ($login_invalid) { ?>
                                        <div class="form-group">
                                            <span class="badge badge-warning">Логин содержит недопустимые символы. Разрешенные
                                                символы:
                                                <br>Латинские строчные и прописные буквы, цифры, символы ".", "-" и "_"</span>
                                        </div>
                                    <?php } ?>
                                </div>

                                <div class="form-group">
                                    <label for="password">Пароль</label>
                                    <input type="password" class="form-control" name="password"
                                        placeholder="Введите ваш пароль">
                                    <?php //Вывод сообщение об ошибке: отсутствует пароль
                                        if ($login_error_nopassword) { ?>
                                        <div class="form-group">
                                            <span class="badge badge-warning ml-3">Требуется заполнить.</span>
                                        </div>
                                    <?php } ?>
                                </div>
                                <?php //Вывод сообщение об ошибке: пара логин-пароль не найдена
                                    if ($login_error_incorrect) { ?>
                                    <div class="form-group">
                                        <span class="badge badge-warning">Пользователь с таким логином и паролем не
                                            найден.</span>
                                    </div>
                                <?php } ?>
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