<?php

namespace App\Controllers;

use App\Entities\UserEntity;
use App\Models\UserModel;

class Home extends BaseController
{
    public function index(): string
    {
        return view('index');
    }
}
