<?php

namespace App\Models;

use App\Entities\StudentDetailsEntity;

interface StudentSubjectsInterface
{
    public function getEnrolledSubjects(StudentDetailsEntity $studentDetailsEntity, int $curriculumId, int $semester);
}