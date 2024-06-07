<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ServiceModel;
use App\Models\ServiceStatusModel;

class Services extends BaseController
{
    use ResponseTrait;

    public function getService()
    {
        $serviceModel = new ServiceModel();
        $data = $serviceModel->findAll();
        return $this->respond(['message' => 'Service Fetched Successfully', 'data' => $data], 200);
    }
    public function addService()
    {
        $model = new ServiceModel();
        $id = $this->request->getVar('id');
        $data = [
            'name' => $this->request->getVar('name'),
            'description' => $this->request->getVar('description'),
            'price' => $this->request->getVar('price'),
        ];

        if ($id) {
            $model->update($id, $data);
            return $this->respond(['message' => 'Service Updated Successfully'], 200);
        } else {
            $model->save($data);
            return $this->respond(['message' => 'Service Added Successfully'], 200);
        }
    }

    public function deleteService($id)
    {
        print_r($id,"iddd");
        $model = new ServiceModel();
        $find = $model->find($id);
        if ($find) {
            $model->where('id', $id)->delete();
            return $this->respond(['message' => 'Service deleted Successfully'], 200);
        } else {
            return $this->respond(['message' => "Couldn't find the Service"], 404);
        }
    }
    public function getServiceStatus()
    {
        $Model = new ServiceStatusModel();
        $data = $Model->findAll();
        return $this->respond(['message' => 'Status Fetched Successfully', 'data' => $data], 200);
    }
    public function addServiceStatus()
    {
        $model = new ServiceStatusModel();
        $id = $this->request->getVar('id');
        $data = [
            'name' => $this->request->getVar('name'),
        ];

        if ($id) {
            $model->update($id, $data);
            return $this->respond(['message' => 'Status Updated Successfully'], 200);
        } else {
            $model->save($data);
            return $this->respond(['message' => 'Status Added Successfully'], 200);
        }
    }

    public function deleteServiceStatus($id)
    {
        $model = new ServiceStatusModel();
        $find = $model->find($id);
        if ($find) {
            $model->where('id', $id)->delete();
            return $this->respond(['message' => 'Status deleted Successfully'], 200);
        } else {
            return $this->respond(['message' => "Couldn't find the Status"], 404);
        }
    }
}
