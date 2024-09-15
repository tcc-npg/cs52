<?php

namespace App\Models;

use App\Entities\SchoolYearEntity;
use CodeIgniter\Model;

class SchoolYearModel extends Model
{
    protected $table = 'school_years';

    protected $returnType = SchoolYearEntity::class;

    protected $allowedFields = [
        'name', 'start_date', 'end_date', 'updated_at'
    ];
}
