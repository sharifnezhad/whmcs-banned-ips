<?php

namespace ASharifnezhad\ManageIps\controllers;

class mainController
{
    public function adminareaRender($theme, $data = null)
    {

        extract($data);
        require_once __DIR__ . DIRECTORY_SEPARATOR . '../../templates/adminarea/header.php';
        require_once __DIR__ . DIRECTORY_SEPARATOR . '../../templates/adminarea/' . $theme;
    }

    public function clientareaRender($theme, $data = null)
    {
        extract($data);
        require_once __DIR__ . DIRECTORY_SEPARATOR . '../../templates/clientarea/' . $theme;
    }

    public static function loadCss($file)
    {
        return "<link rel='stylesheet' href='" . BASE_URL . "templates/assets/$file'>";
    }
}