<?php

include_once $_SERVER["DOCUMENT_ROOT"] . "/SPAengine/authMethods.php";

function getAllServices()
{
    $json_services = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/SPAengine/data/services.json");
    if ($json_services) {
        return json_decode($json_services, true);
    } else {
        throw new Exception("Не удалось загрузить услуги");
    }
}

function displayAvailableServices()
{
    $services = getAllServices();
    $curentUser = getCurrentUser();

    foreach ($services as $service) {
        ?>
        <div class="row service-item">
            <div class="service-cover" style="background-image: url('<?= $service["imageUrl"] ?>');"></div>
            <div class="service-content">
                <h5 class="service-title">
                    <?= $service["title"] ?>
                </h5>
                <p class="service-text">
                    <?= $service["description"] ?>
                </p>
                <p class="service-price text-right">
                    <?= $service["price"] ?>
                </p>
            </div>
        </div>
        <?php
    }
}