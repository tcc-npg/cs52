<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class SettingsController extends BaseController
{
    protected $helpers = ['form'];

    public function index(): string
    {
        return view('settings/settings');
    }

    public function save() {
        exit($this->request->getPost('section'));
    }
}
