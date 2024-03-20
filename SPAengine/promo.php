<?php

include_once $_SERVER["DOCUMENT_ROOT"] . "/SPAengine/authMethods.php";

$service_handlers["birthday_promo"] = [
    "display" => function () {
        if (getCurrentUser() != null) {
            $title = "Скидка на день рождения";

            function birthdayCountdown($birthdate)
            {
                $currenttime = time();
                $func = "date";
                $today = strtotime("{$func('Y-m-d', $currenttime)}");
                $birthday = strtotime("{$func('Y', $today)}-{$func('m-d', $birthdate)}");

                if ($today === $birthday) {
                    return <<<MESS
                    С днем рождения!<br>Сегдня для вас полный комплект спа-процедур всего за 21 000 Р.
                    MESS;
                }

                if ($birthday < $today) {
                    $nextYear = date('Y', $today) + 1;
                    $birthday = strtotime("{$nextYear}-{$func('m-d', $birthdate)}");
                    ;
                }

                $diff = ($birthday - $today) / 86400;

                return "Приходите за вашим подарком через $diff дней";
            }

            displayPromo($title, birthdayCountdown($_SESSION["current_user_data"]["birthday"]), "/assets/party-with-confetti-balloons-yellow.jpg");
            return true;
        }
        return false;
    }
];

$service_handlers["login_promo"] = [
    "onlogin" => function () {
        $GLOBALS["promo_data"]["login_promo"][getCurrentUser()] = time();
        $json_out = json_encode($GLOBALS["promo_data"]);
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/SPAengine/data/promo.json", $json_out);

    },
    "display" => function () {
        if (getCurrentUser() != null) {
            if (time() <= $GLOBALS["promo_data"]["login_promo"][getCurrentUser()] + 86400) {

                $title = "Персональная скидка для вас!";

                $timeLeft = $GLOBALS["promo_data"]["login_promo"][getCurrentUser()] + 86400 - time();
                $timeLeftText = str_pad(intdiv($timeLeft, 3600), 2, "0", STR_PAD_LEFT) . ":" .
                    str_pad(fmod(intdiv($timeLeft, 60), 60), 2, "0", STR_PAD_LEFT) . ":" .
                    str_pad(fmod($timeLeft, 60), 2, "0", STR_PAD_LEFT);

                $description = <<<MESS
                Ваша скидка 5% действительна еще:&nbsp<b id="login_promo_time">{$timeLeftText}</b>
                <script src="/script/login_promo_timer.js"></script>
                <script>
                    timerStart($timeLeft);
                </script>
                MESS;

                displayPromo($title, $description, "/assets/SL-022323-56120-02.jpg");
                return true;
            }
        }

        return false;
    },
    "price_multiplier" => function () {
        if (getCurrentUser() != null) {
            if (time() <= $GLOBALS["promo_data"]["login_promo"][getCurrentUser()] + 86400) {
                return 0.95;
            }
        }
        return 1;
    }
];

function displayAvailablePromo()
{
    $promoCount = 0;
    $GLOBALS["promo_data"] = loadPromo();

    foreach ($GLOBALS["service_handlers"] as $service_handler) {
        if ($service_handler["display"]())
            $promoCount++;

    }

    if ($promoCount === 0) {
        ?>
        <div class="row">
            <p>Пока у нас нету акций для гостей. Зарегистрируйтесь или войдите в личный кабинет чтобы получить персональные
                предложения!</p>
        </div>
        <?php
    }
}

function displayPromo($title, $description = null, $background_image = null)
{
    ?>
    <div class="row promo-item">
        <div class="promo-cover" style="background-image: url('<?= $background_image ?>');"></div>
        <div class="promo-content">
            <h5 class="promo-title">
                <?= $title ?>
            </h5>
            <p class="promo-text">
                <?= $description ?>
            </p>
        </div>
    </div>
    <?php
}

function loadPromo()
{
    $json_promolist = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/SPAengine/data/promo.json");
    if ($json_promolist) {
        return json_decode($json_promolist, true);
    } else {
        throw new Exception("Не удалось загрузить данные акций");
    }
}