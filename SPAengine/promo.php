<?php

include_once $_SERVER["DOCUMENT_ROOT"] . "/SPAengine/authMethods.php";

$service_handlers["birthday_promo"] = [
    "update" => function () {
        if (getCurrentUser() != null) {
            $promolist = loadPromo();

            
            //$promolist["birthday_promo"][getCurrentUser()]
        }
    },
    "display" => function () {
        if (getCurrentUser() != null) {
            $title = "Скидка на день рождения";
            displayPromo($title);
            return true;
        }
        return false;
    }
];

function displayAvailablePromo()
{
    $promoCount = 0;

    foreach ($GLOBALS["service_handlers"] as $service_handler) {
        if ($service_handler["display"]()) $promoCount++;

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
        //require_once "init.php";
        //return getUserList();

        throw new Exception("Не удалось загрузить данные акций");
    }
}