<?php

namespace App\Models;

use App\Entities\SubjectEntity;
use CodeIgniter\Model;

class SubjectModel extends Model
{
    protected $table = 'subjects';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = SubjectEntity::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'code',
        'name',
        'description',
        'year_level',
        'slug',
        'semester',
        'units'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        'units' => 'integer'
    ];

    public function getSubjectsForYearAndSemester(int $year, string $semester) {
        return $this->where('year_level', $year)
            ->where('semester', $semester)
            ->findAll();
    }

    public function getSubjectByCode(int|string $code) {
        return $this->where('code', $code)
        ->first();
    }
}
