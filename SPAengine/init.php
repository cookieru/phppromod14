<?php
$enableInit = false;
if ($enableInit) {
    $userlist = array();
    $user = ["password" => sha1("123456"), "birthday" => strtotime("2000-03-20")];
    $userlist["cookieru"] = $user;
    $user = ["password" => sha1("234567"), "birthday" => strtotime("1990-06-12")];
    $userlist["nastya"] = $user;

    $json_out = json_encode($userlist);
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/SPAengine/data/secrets.json", $json_out);
}
