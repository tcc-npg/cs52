<?php

namespace App\Models\MonitoringSystem;

use CodeIgniter\Model;

class ModulesModel extends Model
{
    protected $table = 'ms_modules';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    public function getModuleDetails($code)
    {


        return $this->select('ms_modules.prof_id, ms_modules.module_id, b.name, b.code, b.description')
            ->join('subjects b', 'ms_modules.code = b.code')
            ->where('ms_modules.code', $code)
            ->findAll();
    }


}

