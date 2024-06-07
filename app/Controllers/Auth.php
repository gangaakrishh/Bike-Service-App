<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use App\Models\AdminModel;
use \Firebase\JWT\JWT;

class Auth extends BaseController
{
    use ResponseTrait;

    public function login()
    {
        $userModel = new UserModel();

        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $user = $userModel->where('email', $email)->first();
        if ($user === '') {
            return $this->respond(['error' => 'Invalid username or password.'], 401);
        } else {
            if (password_verify($this->request->getVar('password'), $user['password'])) {
                return $this->respond(['error' => 'Incorrect Password'], 0);
            } else {
                $key = getenv('JWT_SECRET');
                $payload = array(
                    "user_id" => $user['id'],
                    "email" => $user['email']
                );
                $token = JWT::encode($payload, $key, 'HS256');
                $response = [
                    'message' => 'Login Succesful',
                    'token' => $token
                ];
                return $this->respond($response, 200);
            }
        }
    }

    public function Register()
    {
        $rules = [
            'email' => ['rules' => 'required|min_length[4]|max_length[255]|valid_email|is_unique[users.email]'],
            'mobile_no' => ['rules' => 'required|is_unique[users.mobile_no]'],
            'password' => ['rules' => 'required|min_length[8]|max_length[255]'],
            'confirm_password' => ['label' => 'confirm password', 'rules' => 'matches[password]']
        ];

        if ($this->validate($rules)) {
            $model = new UserModel();
            $data = [
                'email' => $this->request->getVar('email'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                'mobile_no' => $this->request->getVar('mobile_no'),
            ];
            $model->save($data);
            return $this->respond(['message' => 'Registered Successfully'], 200);
        } else {
            $response = [
                'errors' => $this->validator->getErrors(),
                'message' => 'Invalid Inputs'
            ];
            return $this->fail($response, 404);
        }
    }

    public function Adminlogin()
    {
        $Admin = new AdminModel();

        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $admin = $Admin->where('email', $email)->first();
        if ($admin === '') {
            return $this->respond(['error' => 'Invalid username or password.'], 401);
        } else {
            if (password_verify($this->request->getVar('password'), $admin['password'])) {
                return $this->respond(['error' => 'Incorrect Password'], 0);
            } else {
                $key = getenv('JWT_SECRET');
                $payload = array(
                    "admin_id" => $admin['id'],
                );
                $token = JWT::encode($payload, $key, 'HS256');
                $response = [
                    'message' => 'Login Succesful',
                    'token' => $token
                ];
                return $this->respond($response, 200);
            }
        }
    }
}