<?php

namespace App\Entities;


use CodeIgniter\Entity\Entity;

class UserDetailsEntity extends Entity
{
    protected $casts = [
        'user_id' => '?integer'
    ];
}
