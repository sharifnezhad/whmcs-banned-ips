<?php
include __DIR__ . DIRECTORY_SEPARATOR . "../vendor/autoload.php";
use Rap2hpoutre\FastExcel\FastExcel;

class output
{
    private ip_model $ip_model;
    private url_model $url_model;

    public function __construct()
    {
        $this->ip_model = new ip_model();
        $this->url_model = new url_model();
    }

    public function import_ip($file)
    {
        $baseDirectoryFile = __DIR__ . DIRECTORY_SEPARATOR . '../storages/';
        $newPathUploadFile = $baseDirectoryFile . basename($_FILES['file']['name']);
        move_uploaded_file($_FILES['file']['tmp_name'], $newPathUploadFile);
        $importedTickets = (new FastExcel)->import($newPathUploadFile);
        collect($importedTickets)->each(function ($data) {
            $this->ip_model->create($data);
        });
        unlink($newPathUploadFile);
        
        return true;
    }
    public function import_url($file)
    {
        $baseDirectoryFile = __DIR__ . DIRECTORY_SEPARATOR . '../storages/';
        $newPathUploadFile = $baseDirectoryFile . basename($_FILES['file']['name']);
        move_uploaded_file($_FILES['file']['tmp_name'], $newPathUploadFile);
        $importedTickets = (new FastExcel)->import($newPathUploadFile);
        collect($importedTickets)->each(function ($data) {
            $this->url_model->create($data);
        });
        unlink($newPathUploadFile);

        return true;
    }

    public function export()
    {

    }
}