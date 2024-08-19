<?php

namespace App\Models;

use App\Entities\StudentDetailsEntity;
use CodeIgniter\Model;

class StudentDetailsModel extends Model
{
    protected $table = 'student_details';
    protected $primaryKey = 'user_id';
    protected $useAutoIncrement = false;

    protected $returnType = StudentDetailsEntity::class;
    protected $allowedFields = [
        'user_id',
        'student_number',
        'year_level',
        'program_code',
        'updated_at'
    ];

    protected $beforeUpdate = ['touch'];

    public function getStudentDetailsByUserIds(array $ids): array
    {
        return $this->whereIn('user_id', $ids)->findAll();
    }

    protected function touch(array $data): array
    {
        $data['data']['updated_at'] = date('Y-m-d H:i:s');
        return $data;
    }
}
