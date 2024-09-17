<?php

namespace App\Models\MonitoringSystem;

use CodeIgniter\Model;

class UniformsModel extends Model
{
    protected $table            = 'ms_uniforms';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'user_id'
    ];


    public function listStudentUniform(){
        return $this->select('b.first_name, b.last_name, c.student_number, b.gender, ms_uniforms.shirt_size, ms_uniforms.pants_size, ms_uniforms.balance, ms_uniforms.status')
            ->join('user_details b', 'ms_uniforms.user_id = b.user_id')
            ->join('student_details c', 'ms_uniforms.user_id = c.user_id')
            ->findAll();
    
    }

    // NOT YET IMPLMENTED IN THE SYSTEM
    public function addStudentInUniformList($student_number){

        return $this->insert ('user_id')
        ->select ('user_id')
        ->from('stundet_details')
        ->where('student_number', $student_number);
    
    }


 
}
