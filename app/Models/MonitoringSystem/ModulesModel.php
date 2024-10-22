<?php

namespace App\Models\MonitoringSystem;

use CodeIgniter\Model;

class ModulesModel extends Model
{
    protected $table = 'ms_modules';
    protected $primaryKey = 'module_id';
    protected $useAutoIncrement = true;

    protected $allowedFields = ['code', 'amount'];
    protected $returnType = 'array';

    public function getModuleDetails()
    {

        return $this->select(' ms_modules.module_id, ms_modules.amount, b.name, b.code, b.description, b.year_level')
            ->join('subjects b', 'ms_modules.code = b.code')
            ->findAll();
    }


}

