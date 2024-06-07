<?php
namespace App\Models;

use CodeIgniter\Model;

class ServiceBookingModel extends Model
{
    protected $table = 'service_booking';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'user_id', 'service_id', 'status_id', 'date', 'comment', 'created_at', 'updated_at'];
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