<?php

namespace ASharifnezhad\ManageIps\controllers;

use ASharifnezhad\ManageIps\models\ip_model;
use ASharifnezhad\ManageIps\models\url_model;
use Illuminate\Database\Capsule\Manager as Capsule;


class manage_ip
{
    private $ip_model;
    private $url_model;
    private $mainController;
    private $output;

    public function __construct()
    {
        $this->ip_model = new ip_model();
        $this->url_model = new url_model();
        $this->mainController = new mainController();
        $this->output = new output();
    }

    public function url()
    {
        if ($_POST['url']) {
            $this->url_model->create($_POST['url']);
        } elseif ($_POST['removes']) {
            foreach ($_POST['removes'] as $url_id) {
                $this->url_model->remove((int)$url_id);
            }
        }
        $urls = $this->url_model->get();

        $this->mainController->adminareaRender('index_url.php', ['urls' => $urls]);
    }

    public function ip()
    {
        if ($_POST['ip']) {
            $data = [
                'ip' => $_POST['ip'],
                'status' => $_POST['status']
            ];
            $this->ip_model->create($data);
        } elseif ($_POST['removes']) {
            foreach ($_POST['removes'] as $url_id) {
                $this->ip_model->remove((int)$url_id);
            }
        }
        $ips = $this->ip_model->get();
        $this->mainController->adminareaRender('index_ip.php', ['ips' => $ips]);
    }

    public function check_ip($vars)
    {

        $blocked_ip = $this->checked_blocked_ip($vars['client']['ip']);
        if (!$blocked_ip) {
            $iranian_ip = $this->checked_iranian_ips($vars['client']['ip']);
        }
        if ($blocked_ip->status == 'blocked' || $iranian_ip) {
            $this->mainController->clientareaRender('403.tpl');
            die();
        }
    }

    private function checked_blocked_ip($client_ip)
    {
        $ips = $this->ip_model->get();
        return collect($ips)->first(function ($data) use ($client_ip) {
            if ($client_ip == $data->ip && $data->status == 'blocked') {

                return $data;
            } elseif ($client_ip == $data->ip && $data->status == 'open') {

                return $data;
            }
        });
    }

    private function checked_iranian_ips($ip)
    {
        $urls = $this->url_model->get();
        $iran_filter = Capsule::table('tbladdonmodules')
            ->where('module', 'manage_ips')
            ->where('setting', 'iran_filter')
            ->first();
        if ($iran_filter->value == 'on') {
            collect($urls)->each(function ($url) use ($ip, &$result) {
                if ($url->url == $_SERVER['REQUEST_URI'] && !$this->check_location($ip)) {
                    $result = true;
                    return false;
                }
            });
            if ($result) {

                return true;
            }
        }

        return false;
    }

    public function import_ip()
    {

        header("HTTP/1.1 200 OK");
        echo $this->output->import_ip($_FILES['file']);
        die();
    }

    public function import_url()
    {
        header("HTTP/1.1 200 OK");
        echo $this->output->import_url($_FILES['file']);
        die();
    }

    private function check_location($ip)
    {
        $api = curl_init('http://ipwho.is/' . $ip);
        curl_setopt($api, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($api);
        $response = json_decode($response);
        curl_close($api);
        if ($response->country == 'Iran') {

            return true;
        }

        return false;
    }

}