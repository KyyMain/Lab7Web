<?php
namespace App\Controllers;
use App\Models\UserModel;

class User extends BaseController
{
    public function index()
    {
        $title = 'User';
        $model = new UserModel();
        $user = $model->findAll();
        return view('user/index', compact('user', 'title'));
    }

    public function login()
    {
        helper('form');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        if (!$email) {
            return view('user/login');
        }

        $session = session();
        $model = new UserModel();
        $login = $model->where('usermail', $email)->first();
        if ($login) {
            $pass = $login['userpassword'];
            if (password_verify($password, $pass)) {
                $login_data = [
                    'userid' => $login['id'],
                    'username' => $login['username'],
                    'email' => $login['usermail'],
                    'logged_in' => TRUE
                ];
                $session->set($login_data);
                return redirect()->to('admin/artikel');
            } else {
                $session->setFlashdata('error', 'Password Salah');
                return redirect()->to('/user/login');
            }
        } else {
            $session->setFlashdata('error', 'Email tidak ditemukan');
            return redirect()->to('/user/login');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/user/login');
    }

}