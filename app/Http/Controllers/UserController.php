<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function all()
    {
        return User::all();
    }

    public function create()
    {
        $userModel = new User();
        $userModel->user_type_id = '1';
        $userModel->name     = 'Daniel Ventura Costa';
        $userModel->cpf      = '40128298820';
        $userModel->cnpj     = '';
        $userModel->email    = 'danielventura.90@gmail.com';
        $userModel->password = '123456';
        $userModel->save();
    }
}
