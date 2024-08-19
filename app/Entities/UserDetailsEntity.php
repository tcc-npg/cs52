<?php

namespace App\Entities;


use CodeIgniter\Entity\Entity;

class UserDetailsEntity extends Entity
{
    protected $casts = [
        'user_id' => '?integer'
    ];

    protected $attributes = [
        'user_id' => null,
        'first_name' => null,
        'middle_name' => null,
        'last_name' => null,
        'gender' => null,
        'phone_number' => null,
        'address' => null,
        'user_type' => null,
        'created_at' => null,
        'updated_at' => null,
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function isProfileComplete(): bool {
        return !is_null($this->attributes['user_id']);
    }
}
