<?php

    $pattern = "#^[\w\.\-]*$#s";

    $result = preg_match($pattern, "cookie.ru24-dymfood");

    echo $result;