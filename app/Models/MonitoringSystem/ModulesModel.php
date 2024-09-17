<?php

namespace App\Models\MonitoringSystem;

use CodeIgniter\Model;

class ModulesModel extends Model
{
    protected $table            = 'ms_modules';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

}
