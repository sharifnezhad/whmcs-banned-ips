<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class ip_model
{
    private $table = 'manage_ips';

    public function get()
    {
        return Capsule::table($this->table)->get();
    }

    public function create($data)
    {
        return Capsule::table($this->table)
            ->updateOrInsert([
                'ip' => $data['ip']
            ], [
                'status' => $data['status']
            ]);
    }

    public function remove($id)
    {
        return Capsule::table($this->table)->delete([
            'id' => $id
        ]);
    }
}