<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class CurriculumEntity extends Entity
{
    protected $dates = ['date_created', 'date_updated'];

    protected $attributes = ['id', 'description', 'date_created', 'date_updated'];
}
