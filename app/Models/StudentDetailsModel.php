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

    public function getStudentsByYear(int|string $year): array
    {
        if ($year === 'all') {
            return $this->join('user_details', 'user_details.user_id = student_details.user_id')
                ->orderBy('year_level', 'ASC')
                ->orderBy('student_number', 'ASC')
                ->findAll();
        }
        return $this->where('year_level', $year)
            ->join('user_details', 'user_details.user_id = student_details.user_id')
            ->findAll();
    }
    public function getStudentsByStudentId(int|string $studentId): array|object|null
    {
        return $this->where('student_number', $studentId)
            ->first();
    }

    protected function touch(array $data): array
    {
        $data['data']['updated_at'] = date('Y-m-d H:i:s');
        return $data;
    }
}
