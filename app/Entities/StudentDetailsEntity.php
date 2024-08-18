<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class StudentDetailsEntity extends Entity
{
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [];
}
