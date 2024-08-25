<?php

namespace App\Models;

use App\Entities\StudentDetailsEntity;
use App\Entities\SubjectEntity;
use CodeIgniter\Model;

class IrregStudentSubjectsModel extends Model implements StudentSubjectsInterface
{
    protected $table = 'irreg_student_subjects';
    protected $primaryKey = ['user_id', 'subject_id'];
    protected $useAutoIncrement = false;
    protected $returnType = 'array';

    public function getEnrolledSubjects(StudentDetailsEntity $studentDetailsEntity, int $curriculumId, int $semester): object|array|null
    {
        return $this->select('b.*')
            ->where('user_id', $studentDetailsEntity->user_id)
            ->join('subjects b', 'b.id = subject_id and b.year_level = ' . $studentDetailsEntity->year_level . ' and b.semester = ' . $semester)
            ->asObject(SubjectEntity::class)
            ->findAll();
    }
}
