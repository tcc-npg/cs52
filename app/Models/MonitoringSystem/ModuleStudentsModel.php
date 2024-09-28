<?php

namespace App\Models\MonitoringSystem;

use CodeIgniter\Model;

class ModuleStudentsModel extends Model
{
    protected $table            = 'ms_modules_enrolled_students';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
       
    public function getStudentList(int $module_id){
        return $this->select('b.student_number, c.first_name, c.last_name, b.year_level, ms_modules_enrolled_students.balance, ms_modules_enrolled_students.status')
            ->join('student_details b', 'ms_modules_enrolled_students.user_id = b.user_id')
            ->join('user_details c', 'ms_modules_enrolled_students.user_id = c.user_id')
            ->where('ms_modules_enrolled_students.module_id', $module_id)
            ->findAll();
    
    }
}
