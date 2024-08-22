<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class StudentDetailsEntity extends Entity
{
    protected $casts = [
        'user_id' => '?integer',
        'year_level' => 'integer'
    ];
}
