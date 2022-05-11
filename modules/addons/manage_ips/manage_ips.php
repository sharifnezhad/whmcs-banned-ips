<?php

//use Illuminate\Database\Capsule\Manager as Capsule;

function manage_ips_config()
{
    return array(
        'name' => 'manage ips',
        'author' => 'a.sharifnezhad',
        'version' => '1.0',
        'fields' => [
            'iran_filter' => [
                'FriendlyName' => 'iran filter',
                'Type' => 'yesno',
            ],
        ]
    );
}

function manage_ips_activate()
{
    $table = Capsule::schema()->hasTable('manage_urls');
    if (!$table) {
        Capsule::schema()->create('manage_urls', function ($table) {
            $table->increments('id');
            $table->string('url');
            $table->timestamp('created_at')->useCurrent();
        });
    }
    $table = Capsule::schema()->hasTable('manage_ips');
    if (!$table) {
        Capsule::schema()->create('manage_ips', function ($table) {
            $table->increments('id');
            $table->string('ip');
            $table->string('status');
            $table->timestamp('created_at')->useCurrent();
        });
    }
}

function manage_ips_output($vars)
{
    $mainUrl = localAPI('GetConfigurationValue', ['setting' => 'SystemURL']);
    define('BASE_URL', $mainUrl['value'] . 'modules/addons/'. $vars['module'] . '/');
    define('MODULE_LINK', $vars['modulelink']);
    $action = $_GET['action'] ?? 'manage_ip/url';
    list($controller, $method) = explode('/', $action);

    require_once __DIR__ . DIRECTORY_SEPARATOR. 'vendor/autoload.php';
    $namespace="\\ASharifnezhad\\ManageIps\\controllers\\". $controller;
    $object = new $namespace();

    return $object->$method();
}