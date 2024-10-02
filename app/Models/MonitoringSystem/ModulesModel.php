<?php

namespace App\Models\MonitoringSystem;

use CodeIgniter\Model;

class ModulesModel extends Model
{
    protected $table = 'ms_modules';
    protected $primaryKey = 'module_id';
    protected $useAutoIncrement = true;

    protected $allowedFields = ['code'];
    protected $returnType = 'array';

    public function getModuleDetails()
    {


        return $this->select(' ms_modules.module_id, b.name, b.code, b.description')
            ->join('subjects b', 'ms_modules.code = b.code')
            ->findAll();
    }


}

