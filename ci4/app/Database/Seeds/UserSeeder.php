<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $model = model('UserModel');
        $model->insert([
            'username' => 'admin',
            'usermail' => 'eky@hi2.in',
            'userpassword' => password_hash('admin', PASSWORD_DEFAULT),
        ]);
    }
}
