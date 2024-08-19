<?php

namespace App\Entities;

use CodeIgniter\Shield\Entities\User;

class UserEntity extends User
{
    private ?UserDetailsEntity $userDetails = null;

    private ?StudentDetailsEntity $studentDetails = null;

    public function getUserDetails(): ?UserDetailsEntity
    {
        return $this->userDetails;
    }

    public function getStudentDetails(): ?StudentDetailsEntity
    {
        return $this->studentDetails;
    }

    public function isProfileComplete(): bool
    {
        return !is_null($this->userDetails);
    }

    public function setUserDetails(?UserDetailsEntity $userDetails): void
    {
        $this->userDetails = $userDetails;
    }

    public function setStudentDetails(?StudentDetailsEntity $studentDetails): void
    {
        $this->studentDetails = $studentDetails;
    }
}
