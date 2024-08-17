<?php

namespace App\Models;

use App\Entities\UserDetailsEntity;
use CodeIgniter\Model;

class UserDetailsModel extends Model
{
    protected $table = 'user_details';
    protected $primaryKey = 'user_id';
    protected $useAutoIncrement = false;
    protected $returnType = UserDetailsEntity::class;
    protected $allowedFields = ['first_name', 'middle_name', 'last_name', 'user_type', 'gender', 'phone_number', 'address'];

    public function getUserDetails(int $id): array|object
    {
        return $this->where('user_id', $id)->first();
    }
}
