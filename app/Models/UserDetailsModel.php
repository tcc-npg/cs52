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
    protected $allowedFields = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'phone_number',
        'address',
        'is_enrolled',
        'is_irreg',
        'user_type',
        'updated_at'
    ];

    protected $beforeUpdate = ['touch'];

    public function getUserDetailsByUserIds(array $ids): array
    {
        return $this->whereIn('user_id', $ids)->findAll();
    }

    protected function touch(array $data): array
    {
        $data['data']['updated_at'] = date('Y-m-d H:i:s');
        return $data;
    }

}
