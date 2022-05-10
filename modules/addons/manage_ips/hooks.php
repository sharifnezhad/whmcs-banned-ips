<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'controllers/manage_ip.php';

add_hook('ClientAreaPage', 1, function ($vars) {

    $manage = new manage_ip();
    $manage->check_ip($vars);
});