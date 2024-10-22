<?php

namespace App\Models\MonitoringSystem;

use CodeIgniter\Model;

class ModuleStudentsModel extends Model
{
    protected $table            = 'ms_module_students';
    protected $primaryKey       = 'user_id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'status',
        'user_id',
        'module_id',
        'payment',
        'payment_date'
    ];
       
    public function getStudentList(int $module_id){
        return $this->select('b.user_id, b.student_number, c.first_name, c.last_name, b.year_level, ms_module_students.payment, ms_module_students.status, ms_module_students.payment_date')
            ->join('student_details b', 'ms_module_students.user_id = b.user_id')
            ->join('user_details c', 'ms_module_students.user_id = c.user_id')
            ->where('ms_module_students.module_id', $module_id)
            ->findAll();
    
    }

    public function getStudentData(){
        return $this->select('ms_module_students.status, b.amount, c.name, c.year_level')
        ->join('ms_modules   b', 'ms_module_students.module_id = b.module_id')
        ->join('subjects c', 'b.code = c.code')
        ->findAll();
    }

    public function insertStudentInModule (int $module_id, $user_id){
        $data = ['user_id' => $user_id,'module_id'=> $module_id];

        return $this->db->table($this->table)
                            ->where('user_id', $data['user_id'])
                            ->where('module_id', $data['module_id'])
                            ->insert($data);
    }
}
