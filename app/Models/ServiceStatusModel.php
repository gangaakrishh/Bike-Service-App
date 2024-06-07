<?php
namespace App\Models;

use CodeIgniter\Model;

class ServiceStatusModel extends Model
{
    protected $table = 'service_status';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'name', 'created_at', 'updated_at'];
    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];

    protected function beforeInsert(array $data)
    {
        $data['data']['created_at'] = date('Y-m-d H:i:s');
        return $data;
    }
    protected function beforeUpdate(array $data)
    {
        $data['data']['updated_at'] = date('Y-m-d H:i:s');
        return $data;
    }
}