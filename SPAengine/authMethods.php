<?php

include_once $_SERVER["DOCUMENT_ROOT"] . "/SPAengine/promo.php";

//функция getUsersList() возвращает массив всех пользователей и хэшей их паролей;
function getUserList()
{
    $json_userlist = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/SPAengine/data/secrets.json");
    if ($json_userlist) {
        return json_decode($json_userlist, true);
    } else {
        //require_once "init.php";
        //return getUserList();

        throw new Exception("Не удалось загрузить данные пользователей");
    }
}

//функция existsUser($login) проверяет, существует ли пользователь с указанным логином;
function existsUser($login)
{
    $userlist = getUserList();

    if (isset($userlist[$login]))
        return true;

    return false;
}

//функция checkPassword($login, $password) пусть возвращает true тогда, когда существует 
//пользователь с указанным логином и введенный им пароль прошел проверку, иначе — false;
function checkPassword($login, $password)
{
    $userlist = getUserList();

    if (isset($userlist[$login])) {
        $pass_hash = sha1($password);
        return($pass_hash === $userlist[$login]["password"]);
    }

    return false;
}

//функция getCurrentUser() которая возвращает либо имя вошедшего на сайт пользователя, либо null.
function getCurrentUser()
{
    if (isset($_SESSION["current_user"]))
        return $_SESSION["current_user"];

    return null;
}

// Регистрация новых клиентов
function addUser($login, $password, $birthday)
{
    $userList = getUserList();
    
    $user = ["password" => sha1($password), "birthday" => strtotime($birthday)];
    $userList[$login] = $user;

    $json_out = json_encode($userList);
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/SPAengine/data/secrets.json", $json_out);
}

function setCurrentUser($login)
{
    if (isset($login))
    {
        $_SESSION["current_user"] = $login;
        $_SESSION["current_user_data"] = getUserList()[$login];

        foreach ($GLOBALS["service_handlers"] as $service_handler)
        {
            if (isset($service_handler["onlogin"])) $service_handler["onlogin"]();
        }
    }
    else
    {
        $_SESSION = array();
    }
}