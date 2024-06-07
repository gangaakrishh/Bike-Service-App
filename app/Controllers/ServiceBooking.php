<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ServiceBookingModel;
use App\Models\UserModel;
use App\Models\ServiceModel;
use App\Models\ServiceStatusModel;
use Exception;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
use stdClass;

class ServiceBooking extends BaseController
{
    use ResponseTrait;

    public function getserviceBook()
    {
        $serviceBookingModel = new ServiceBookingModel();
        $data = $serviceBookingModel->select('users.email,users.mobile_no,service_booking.*, service.id as service_id,service.name as service_name, service.description, service_status.id as status_id,service_status.name as status_name')
            ->join('services as service', 'service.id = service_booking.service_id')
            ->join('users', 'users.id = service_booking.user_id')
            ->join('service_status', 'service_status.id = service_booking.status_id')
            ->findAll();
        $structuredData = [];
        foreach ($data as $row) {
            $structuredData[] = [
                'id' => $row['id'],
                'date' => $row['date'],
                'comment' => $row['comment'],
                'user' => [
                    'email' => $row['email'],
                    'mobile_no' => $row['mobile_no'],
                ],
                'service' => [
                    'id' => $row['service_id'],
                    'service_name' => $row['service_name'],
                    'description' => $row['description'],
                ],
                'status' => [
                    'id' => $row['status_id'],
                    'status_name' => $row['status_name'],
                ]
            ];
        }
        return $this->respond(['message' => 'Data feted successfully', 'data' => $structuredData], 200);
    }
    public function serviceBook()
    {
        $key = getenv('JWT_SECRET');
        if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
            throw new Exception('Authorization header missing');
        }
        $header = new stdClass();
        $header->Authorization = $_SERVER['HTTP_AUTHORIZATION'];
        $token = explode(' ', $header->Authorization)[1];
        try {
            $decoded = JWT::decode($token, new Key($key, 'HS256'), $header);
            $email = $decoded->email;
            $user_id = $decoded->user_id;
        } catch (Exception $e) {
            echo "Error decoding JWT: " . $e->getMessage();
        }
        $service_id = $this->request->getVar('service_id');
        $date = $this->request->getVar('date');
        $comment = $this->request->getVar('comment');
        $model = new ServiceBookingModel();
        $usermodel = new UserModel();
        $servicemodel = new ServiceModel();
        $data = [
            'user_id' => $user_id,
            'service_id' => $service_id,
            'status_id' => 1,
            'date' => $date,
            'comment' => $comment,
        ];

        $user = $usermodel->where('id', $user_id)->first();
        $service = $servicemodel->where('id', $service_id)->first();
        // print_r($service);die;

        $to = $user['email'];
        $subject = "Service Booking";
        $message = "Hello John, <br> The " . $service['name'] . " has been booked on this date " . $date . ". by the your Customer. <br> Kindly check on it !!!.";

        $email = \Config\Services::email();
        $email->initialize(config('Email'));

        $email->setTo($to);
        $email->setFrom('gangagowri1610@gmail.com', 'Service Booking');
        $email->setSubject($subject);
        $email->setMessage($message);

        if ($email->send()) {
            $model->insert($data);
            return $this->respond(['message' => 'Service booked successfully'], 200);
        } else {
            $data = $email->printDebugger(['headers']);
            print_r($data);
        }
    }

    public function statusUpdate()
    {
        $model = new ServiceBookingModel();
        $status = new ServiceStatusModel();
        $usermodel = new UserModel();
        $servicemodel = new ServiceModel();
        $id = $this->request->getVar('id');
        $status_id = $this->request->getVar('status_id');
        $find = $model->where('id', $id)->first();
        if ($find) {
            $data = [
                'status_id' => $status_id
            ];
            $findStatus = $status->where('id', $status_id)->first();
            if ($findStatus['name'] === "Ready for Delivery") {
                $user = $usermodel->where('id', $find['user_id'])->first();
                $service = $servicemodel->where('id', $find['service_id'])->first();

                $to = $user['email'];
                $subject = "Service Booking";
                $message = "Hello Customer, <br> The " . $service['name'] . " has been " . $findStatus['name'] . " <br> Thanks for Reaching Us !!!";

                $email = \Config\Services::email();
                $email->initialize(config('Email'));

                $email->setTo($to);
                $email->setFrom('gangagowri1610@gmail.com', 'Service Booking');
                $email->setSubject($subject);
                $email->setMessage($message);

                if ($email->send()) {
                } else {
                    $data = $email->printDebugger(['headers']);
                    print_r($data);
                }
            }
            $model->where('id', $id)->set($data)->update();
            return $this->respond(['message' => 'Service Updated successfully'], 200);
        } else {
            return $this->respond(['message' => "Couldn't find the Booking"], 404);
        }
    }

    public function userBookings()
    {
        $key = getenv('JWT_SECRET');
        if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
            throw new Exception('Authorization header missing');
        }
        $header = new stdClass();
        $header->Authorization = $_SERVER['HTTP_AUTHORIZATION'];
        $token = explode(' ', $header->Authorization)[1];
        try {
            $decoded = JWT::decode($token, new Key($key, 'HS256'), $header);
            $email = $decoded->email;
            $user_id = $decoded->user_id;
        } catch (Exception $e) {
            echo "Error decoding JWT: " . $e->getMessage();
        }
        $serviceBookingModel = new ServiceBookingModel();
        $data = $serviceBookingModel->select('users.email,users.mobile_no,service_booking.*, service.id as service_id,service.name as service_name, service.description, service_status.id as status_id,service_status.name as status_name')
            ->join('services as service', 'service.id = service_booking.service_id')
            ->join('users', 'users.id = service_booking.user_id')
            ->join('service_status', 'service_status.id = service_booking.status_id')
            ->where('user_id', $user_id)
            ->findAll();
        $structuredData = [];
        foreach ($data as $row) {
            $structuredData[] = [
                'id' => $row['id'],
                'date' => $row['date'],
                'comment' => $row['comment'],
                'user' => [
                    'email' => $row['email'],
                    'mobile_no' => $row['mobile_no'],
                ],
                'service' => [
                    'id' => $row['service_id'],
                    'service_name' => $row['service_name'],
                    'description' => $row['description'],
                ],
                'status' => [
                    'id' => $row['status_id'],
                    'status_name' => $row['status_name'],
                ]
            ];
        }
        return $this->respond(['message' => 'Data feted successfully', 'data' => $structuredData], 200);
    }
}
