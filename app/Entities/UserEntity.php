<?php

namespace App\Entities;

use CodeIgniter\Shield\Entities\User;

class UserEntity extends User
{
    private ?UserDetailsEntity $userDetails = null;

    public function __construct(?array $data = null)
    {
        parent::__construct($data);
    }

    public function getUserDetails(): ?UserDetailsEntity
    {
        return $this->userDetails;
    }

    public function setUserDetails(?UserDetailsEntity $userDetails): void
    {
        $this->userDetails = $userDetails;
    }
}
