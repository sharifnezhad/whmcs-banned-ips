<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

add_hook('ClientAreaPage', 1, function ($vars) {

    $manage = new \ASharifnezhad\ManageIps\controllers\manage_ip();
    $manage->check_ip($vars);
});