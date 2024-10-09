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
        'payment'
    ];
       
    public function getStudentList(int $module_id){
        return $this->select('b.user_id, b.student_number, c.first_name, c.last_name, b.year_level, ms_module_students.payment, ms_module_students.status')
            ->join('student_details b', 'ms_module_students.user_id = b.user_id')
            ->join('user_details c', 'ms_module_students.user_id = c.user_id')
            ->where('ms_module_students.module_id', $module_id)
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
