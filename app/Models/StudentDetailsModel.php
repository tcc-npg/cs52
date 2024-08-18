<?php

namespace App\Models;

use App\Entities\StudentDetailsEntity;
use CodeIgniter\Model;

class StudentDetailsModel extends Model
{
    protected $table = 'student_details';
    protected $primaryKey = 'user_id';
    protected $useAutoIncrement = true;

    protected $returnType = StudentDetailsEntity::class;
    protected $allowedFields = [
        'user_id',
        'student_number',
        'year_level',
        'program_code',
    ];
}
