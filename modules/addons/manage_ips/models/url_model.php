<?php
use Illuminate\Database\Capsule\Manager as Capsule;

class url_model
{
    private $table='manage_urls';

    public function get()
    {
        return Capsule::table($this->table)->get();
    }

    public function create($url)
    {
        return Capsule::table($this->table)
            ->updateOrInsert([
                'url' => $url
            ]);
    }

    public function remove($id)
    {
        return Capsule::table($this->table)->delete([
            'id' => $id
        ]);
    }
}