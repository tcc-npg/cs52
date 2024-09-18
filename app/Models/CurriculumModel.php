<?php

namespace App\Models;

use App\Entities\CurriculumEntity;
use CodeIgniter\Model;

class CurriculumModel extends Model
{
    protected $table = 'curricula';

    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType = CurriculumEntity::class;
    protected $createdField = 'date_created';
    protected $updatedField = 'date_updated';

    protected $allowedFields = ['description', 'date_updated'];
}
