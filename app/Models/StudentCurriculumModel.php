<?php

namespace App\Models;

use App\Entities\StudentDetailsEntity;
use App\Entities\SubjectEntity;
use CodeIgniter\Model;

class StudentCurriculumModel extends Model implements StudentSubjectsInterface
{
    protected $table = 'student_curriculum';
    protected $primaryKey = ['user_id', 'curriculum_id'];
    protected $returnType = 'array';

    public function getEnrolledSubjects(StudentDetailsEntity $studentDetailsEntity, int $curriculumId, int $semester): object|array|null
    {
        return $this->select('c.*')
            ->where([
                'user_id' => $studentDetailsEntity->user_id,
                'student_curriculum.curriculum_id' => $curriculumId
            ])
            ->join('curricula b', 'b.id = student_curriculum.curriculum_id')
            ->join('subjects c', 'c.curriculum_id = b.id and c.year_level = ' . $studentDetailsEntity->year_level . ' and c.semester = ' . $semester)
            ->asObject(SubjectEntity::class)
            ->findAll();
    }
}
